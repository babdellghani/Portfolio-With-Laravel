<?php
namespace Database\Seeders;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name'       => 'John Smith',
                'email'      => 'john.smith@example.com',
                'phone'      => '+1 (555) 123-4567',
                'message'    => 'Hi! I am interested in your web development services. Could you please provide more information about your pricing and timeline for a new e-commerce website?',
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
                'is_read'    => false,
                'is_replied' => false,
                'created_at' => Carbon::now()->subMinutes(15),
                'updated_at' => Carbon::now()->subMinutes(15),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
