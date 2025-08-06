<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name     = fake()->name();
        $username = fake()->unique()->userName();

        return [
            'name'              => $name,
            'username'          => $username,
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'role'              => 'user',   // Default role
            'status'            => 'active', // Default status
            'avatar'            => null,     // No avatar by default
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role'              => 'admin',
            'status'            => 'active',
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Create an inactive user.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Create a user with avatar.
     */
    public function withAvatar(): static
    {
        $avatars = [
            'avatars/avatar1.jpg',
            'avatars/avatar2.jpg',
            'avatars/avatar3.jpg',
            'avatars/avatar4.jpg',
            'avatars/avatar5.jpg',
        ];

        return $this->state(fn(array $attributes) => [
            'avatar' => fake()->randomElement($avatars),
        ]);
    }
}
