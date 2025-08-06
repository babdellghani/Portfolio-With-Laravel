<?php
namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user (should already exist from UserSeeder)
        $adminUser = User::where('role', 'admin')->first();

        if (! $adminUser) {
            throw new \Exception('Admin user not found. Make sure UserSeeder runs before ContactSeeder.');
        }

        // Get specific users for contact messages (should already exist from UserSeeder)
        $johnSmith      = User::where('email', 'john.smith@example.com')->first();
        $sarahJohnson   = User::where('email', 'sarah.johnson@company.com')->first();
        $emilyRodriguez = User::where('email', 'emily.r@designstudio.com')->first();

        // Get some random regular users as fallback
        $regularUsers = User::where('role', 'user')->take(3)->get();

        // Manual contact data with specific scenarios
        $contacts = [
            [
                'name'       => 'John Smith',
                'email'      => 'john.smith@example.com',
                'phone'      => '+1 (555) 123-4567',
                'message'    => 'Hi! I am interested in your web development services. Could you please provide more information about your pricing and timeline for a new e-commerce website?',
                'user_id'    => $johnSmith ? $johnSmith->id : $regularUsers->get(0)?->id,
                'is_read'    => false,
                'is_replied' => false,
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'name'        => 'Sarah Johnson',
                'email'       => 'sarah.johnson@company.com',
                'phone'       => '+1 (555) 987-6543',
                'message'     => 'Hello, I saw your portfolio and I\'m very impressed with your work. We have a project coming up that might be a good fit. Would you be available for a consultation call next week?',
                'user_id'     => $sarahJohnson ? $sarahJohnson->id : $regularUsers->get(1)?->id,
                'is_read'     => true,
                'is_replied'  => true,
                'admin_reply' => 'Thank you for your interest! I\'d be happy to discuss your project. I have availability next Tuesday and Wednesday afternoon. Please let me know what time works best for you.',
                'replied_at'  => Carbon::now()->subHour(),
                'created_at'  => Carbon::now()->subDays(1),
                'updated_at'  => Carbon::now()->subHour(),
            ],
            [
                'name'       => 'Michael Chen',
                'email'      => 'michael.chen@startup.io',
                'phone'      => null,
                'message'    => 'We are a startup looking for a developer to help build our MVP. The project involves React frontend and Laravel backend. Are you available for a 3-month contract?',
                'user_id'    => null, // Guest message
                'is_read'    => false,
                'is_replied' => false,
                'created_at' => Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
            [
                'name'       => 'Emily Rodriguez',
                'email'      => 'emily.r@designstudio.com',
                'phone'      => '+1 (555) 456-7890',
                'message'    => 'Hi there! I\'m a designer looking for a reliable developer to partner with. I have several client projects that need development work. Would you be interested in discussing a long-term collaboration?',
                'user_id'    => $emilyRodriguez ? $emilyRodriguez->id : $regularUsers->get(2)?->id,
                'is_read'    => true,
                'is_replied' => false,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'name'       => 'David Wilson',
                'email'      => 'david@localrestaurant.com',
                'phone'      => '+1 (555) 321-0987',
                'message'    => 'I own a restaurant and need a website with online ordering. I love the design of your portfolio site. Can you create something similar for my business?',
                'user_id'    => null, // Guest message
                'is_read'    => false,
                'is_replied' => false,
                'created_at' => Carbon::now()->subMinutes(15),
                'updated_at' => Carbon::now()->subMinutes(15),
            ],
        ];

        // Create manual contacts
        foreach ($contacts as $contactData) {
            $contact = Contact::create($contactData);

            // Create contact replies for contacts that have replies
            if ($contact->name === 'Sarah Johnson') {
                ContactReply::create([
                    'contact_id' => $contact->id,
                    'admin_id'   => $adminUser->id,
                    'message'    => 'Thank you for your interest! I\'d be happy to discuss your project. I have availability next Tuesday and Wednesday afternoon. Please let me know what time works best for you.',
                    'created_at' => Carbon::now()->subHour(),
                    'updated_at' => Carbon::now()->subHour(),
                ]);

                ContactReply::create([
                    'contact_id' => $contact->id,
                    'admin_id'   => $adminUser->id,
                    'message'    => 'Also, I\'ve attached some examples of similar projects I\'ve worked on. Please let me know if you have any questions!',
                    'created_at' => Carbon::now()->subMinutes(30),
                    'updated_at' => Carbon::now()->subMinutes(30),
                ]);
            }
        }

        // Generate additional contacts using factory
        Contact::factory(15)->create();
        Contact::factory(5)->read()->create();
        Contact::factory(3)->replied()->create();

        // Create contact replies for factory-generated replied contacts
        $repliedContacts = Contact::where('is_replied', true)->whereNull('user_id')->orWhereNotNull('user_id')->get();

        foreach ($repliedContacts as $contact) {
            if ($contact->replies()->count() === 0) { // Only create if no replies exist
                ContactReply::create([
                    'contact_id' => $contact->id,
                    'admin_id'   => $adminUser->id,
                    'message'    => $contact->admin_reply ?? 'Thank you for your message! I\'ll get back to you soon.',
                    'created_at' => $contact->replied_at ?? $contact->updated_at,
                    'updated_at' => $contact->replied_at ?? $contact->updated_at,
                ]);
            }
        }
    }
}
