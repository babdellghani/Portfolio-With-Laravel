<?php
namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Mail\ContactReplyMail;
use App\Models\Contact;
use App\Models\WebsiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages (Admin)
     */
    public function index()
    {
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

        // Store in database
        $contact = Contact::create($validated);

        // Send email notification to admin
        $websiteInfo = WebsiteInfo::getActive();
        $adminEmail  = $websiteInfo && $websiteInfo->email ? $websiteInfo->email : config('mail.from.address');

        try {
            Mail::to($adminEmail)->send(new ContactFormMail($contact));
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
     * Display the specified contact message
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewed
        $contact->markAsRead();

        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Send reply to contact message
     */
    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);

        // Send reply email
        try {
            Mail::to($contact->email)->send(new ContactReplyMail($contact, $validated['admin_reply']));

            // Mark as replied in database
            $contact->markAsReplied($validated['admin_reply']);

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
     * Mark message as read
     */
    public function markAsRead(Contact $contact, Request $request)
    {
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
     * Remove the specified contact message
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with([
            'message'    => 'Contact message deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Get notifications for header (AJAX)
     */
    public function getNotifications()
    {
        $unreadCount  = Contact::getUnreadCount();
        $recentUnread = Contact::getRecentUnread(5);

        return response()->json([
            'unread_count'    => $unreadCount,
            'recent_messages' => $recentUnread,
        ]);
    }
}
