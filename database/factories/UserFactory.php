<?php

namespace Database\Factories;

use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $inviterId = null;

        if (rand(0, 1)) {
            $user = User::first();
            if ($user) {
                $inviterId = $user->id;
            }
        }

        return [
            'inviter_id' => $inviterId,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'nickname' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $currencies = Currency::whereIsEnabled(true)->get();
            foreach ($currencies as $currency) {
                $amount = null;
                if ($currency->is_fiat) {
                    $amount = 500000;
                } else {
                    $amount = 2;
                }
                Balance::factory()->create([
                    'user_id' => $user->id,
                    'currency_id' => $currency->id,
                    'address' => !$currency->is_fiat ? Str::random(40) : null,
                    'amount' => $amount
                ]);
            }
        });
    }
}
