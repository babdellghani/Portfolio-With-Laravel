<?php
namespace Database\Factories;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactReply>
 */
class ContactReplyFactory extends Factory
{
    protected $model = ContactReply::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $replies = [
            'Thank you for your interest! I\'d be happy to discuss your project further. Let me know when you\'re available for a call.',
            'Thanks for reaching out! I have availability next week for a consultation. What time works best for you?',
            'I appreciate your message. Your project sounds interesting! I\'ll send you a detailed proposal within 24 hours.',
            'Thank you for considering me for your project. I have experience with similar work and would love to help.',
            'I\'m interested in your project! Let\'s set up a meeting to discuss the details and timeline.',
            'Thanks for your inquiry! I\'ll review your requirements and get back to you with a quote.',
            'Your project sounds exciting! I have availability and would be happy to take this on.',
            'Thank you for your message. I\'ve worked on similar projects before and can definitely help you out.',
            'I appreciate you reaching out! Let me know if you have any specific questions about my services.',
            'Thanks for your interest! I\'ll prepare some examples of similar work to show you.',
        ];

        return [
            'contact_id' => Contact::factory(),
            'admin_id'   => User::where('role', 'admin')->first()?->id ?? User::factory()->create(['role' => 'admin'])->id,
            'message'    => $this->faker->randomElement($replies) . ' ' . $this->faker->sentence(),
        ];
    }

    /**
     * Create a reply for a specific contact
     */
    public function forContact(Contact $contact): static
    {
        return $this->state(fn(array $attributes) => [
            'contact_id' => $contact->id,
        ]);
    }

    /**
     * Create a reply from a specific admin
     */
    public function fromAdmin(User $admin): static
    {
        return $this->state(fn(array $attributes) => [
            'admin_id' => $admin->id,
        ]);
    }

    /**
     * Create a follow-up reply
     */
    public function followUp(): static
    {
        $followUpMessages = [
            'Just following up on my previous message. Do you have any questions?',
            'I wanted to add that I can also provide ongoing maintenance for your project.',
            'Also, I forgot to mention that I offer a 30-day warranty on all my work.',
            'Let me know if you need any references from my previous clients.',
            'I can provide a more detailed timeline once we discuss your specific requirements.',
        ];

        return $this->state(fn(array $attributes) => [
            'message' => $this->faker->randomElement($followUpMessages) . ' ' . $this->faker->sentence(),
        ]);
    }
}
