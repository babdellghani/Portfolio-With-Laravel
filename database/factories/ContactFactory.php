<?php
namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            'Hello! I am interested in your web development services. Could you provide more details about your pricing?',
            'I saw your portfolio and I\'m impressed. Would you be available for a project discussion?',
            'We need a website for our startup. Are you available for a consultation?',
            'I\'m looking for a developer to build an e-commerce site. Can we schedule a call?',
            'Your work looks amazing! I have a project that might be perfect for you.',
            'Hi, I need help with a Laravel application. Do you offer maintenance services?',
            'We are redesigning our company website. Would you be interested in this project?',
            'I need a mobile-responsive website. Can you help with that?',
            'Looking for a full-stack developer for a long-term project. Are you available?',
            'We need API integration for our existing website. Is this something you can do?',
        ];

        return [
            'name'        => $this->faker->name(),
            'email'       => $this->faker->unique()->safeEmail(),
            'phone'       => $this->faker->optional(0.7)->phoneNumber(),
            'message'     => $this->faker->randomElement($messages) . ' ' . $this->faker->sentence(),
            'user_id'     => $this->faker->optional(0.6)->randomElement(User::where('role', 'user')->pluck('id')->toArray()), // 60% chance of having a user_id
            'is_read'     => $this->faker->boolean(30),                                                                       // 30% chance of being read
            'is_replied'  => false,
            'admin_reply' => null,
            'replied_at'  => null,
        ];
    }

    /**
     * Create a read contact message
     */
    public function read(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => true,
        ]);
    }

    /**
     * Create a replied contact message
     */
    public function replied(): static
    {
        $replies = [
            'Thank you for your interest! I\'d be happy to discuss your project further.',
            'Thanks for reaching out! I have availability next week for a consultation.',
            'I appreciate your message. Let me know when you\'d like to schedule a call.',
            'Thank you for considering me for your project. I\'ll send you a detailed proposal.',
            'I\'m interested in your project! Let\'s set up a meeting to discuss the details.',
        ];

        return $this->state(fn(array $attributes) => [
            'is_read'     => true,
            'is_replied'  => true,
            'admin_reply' => $this->faker->randomElement($replies) . ' ' . $this->faker->sentence(),
            'replied_at'  => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create an unread contact message
     */
    public function unread(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read'     => false,
            'is_replied'  => false,
            'admin_reply' => null,
            'replied_at'  => null,
        ]);
    }
}
