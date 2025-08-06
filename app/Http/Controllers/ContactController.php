<?php
namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Mail\ContactReplyMail;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use App\Models\WebsiteInfo;
use App\Notifications\AdminRepliedToContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $contacts    = Contact::latest()->get();
        $unreadCount = Contact::getUnreadCount();
        return view('admin.contact.index', compact('contacts', 'unreadCount'));
    }

    /**
     * Store a newly created contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        // Add user_id if user is logged in
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        // Store in database
        $contact = Contact::create($validated);

                                             // Send email notification to admin
        $websiteInfo = WebsiteInfo::first(); // Get the first website info record
        $adminEmail  = $websiteInfo && $websiteInfo->email ? $websiteInfo->email : config('mail.from.address');

        try {
            Mail::to($adminEmail)->send(new ContactFormMail($contact));
            Log::info('Contact form email sent successfully to: ' . $adminEmail);
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return back()->with([
            'message'    => 'Thank you for your message! We will get back to you soon.',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified contact message (Admin only)
     */
    public function show(Contact $contact)
    {
        $this->requireAdmin();

        // Mark as read when viewed
        $contact->markAsRead();

        // Load replies with admin information
        $contact->load(['replies.admin']);

        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Send reply to contact message (Admin only)
     */
    public function reply(Request $request, Contact $contact)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);

        // Create a new reply record
        $reply = ContactReply::create([
            'contact_id' => $contact->id,
            'admin_id'   => Auth::id(),
            'message'    => $validated['admin_reply'],
        ]);

        // Send reply email
        try {
            Mail::to($contact->email)->send(new ContactReplyMail($contact, $validated['admin_reply']));

            // Mark contact as replied if this is the first reply
            if (! $contact->is_replied) {
                $contact->update([
                    'is_replied' => true,
                    'replied_at' => now(),
                    'is_read'    => true,
                ]);
            }

            // Send notification to user if they are registered and have account
            if ($contact->user_id) {
                $user = User::find($contact->user_id);
                if ($user) {
                    $user->notify(new AdminRepliedToContact($contact));
                }
            }

            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reply sent successfully!',
                ]);
            }

            return back()->with([
                'success' => 'Reply sent successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send reply email: ' . $e->getMessage());

            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send reply. Please try again.',
                ], 500);
            }

            return back()->with([
                'error' => 'Failed to send reply. Please try again.',
            ])->withInput();
        }
    }

    /**
     * Mark message as read (Admin only)
     */
    public function markAsRead(Contact $contact, Request $request)
    {
        $this->requireAdmin();

        $contact->markAsRead();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success'      => true,
                'message'      => 'Message marked as read',
                'unread_count' => Contact::getUnreadCount(),
            ]);
        }

        // Handle regular requests
        return redirect()->back()->with([
            'message'    => 'Message marked as read',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified contact message (Admin only)
     */
    public function destroy(Contact $contact)
    {
        $this->requireAdmin();

        $contact->delete();

        return back()->with([
            'message'    => 'Contact message deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Get notifications for header (Admin only - AJAX)
     */
    public function getNotifications()
    {
        $this->requireAdmin();

        $unreadCount  = Contact::getUnreadCount();
        $recentUnread = Contact::getRecentUnread(5);

        return response()->json([
            'unread_count'    => $unreadCount,
            'recent_messages' => $recentUnread,
        ]);
    }

    /**
     * Display user's own contact messages (User only)
     */
    public function userMessages()
    {
        $this->requireActiveUser();

        $contacts = Contact::where('user_id', Auth::id())
            ->with(['replies'])
            ->latest()
            ->paginate(10);

        return view('admin.contact.user-messages', compact('contacts'));
    }

    /**
     * Display user's specific contact message (User only)
     */
    public function userMessageShow(Contact $contact)
    {
        $this->requireActiveUser();

        // Ensure user can only see their own messages
        if ($contact->user_id !== Auth::id()) {
            abort(404);
        }

        // Mark notifications related to this contact as read for the current user
        Auth::user()->unreadNotifications()
            ->where('data->contact_id', $contact->id)
            ->update(['read_at' => now()]);

        // Load replies with admin information
        $contact->load(['replies.admin']);

        return view('admin.contact.user-message-show', compact('contact'));
    }
}
