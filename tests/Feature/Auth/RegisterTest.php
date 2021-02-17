<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_success()
    {
        $password = 'password';

        $response = $this->post(route('register'), [
            'nickname' => $this->faker->userName,
            'email' => $this->faker->email,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(200);
    }

    public function test_failed_register()
    {
        $nickname = 'testnickname';
        $email = 'test@test.com';

        User::factory()->create([
            'email' => $email,
            'nickname' => $nickname
        ]);

        $response = $this->post(route('register'), [
            'nickname' => $nickname,
            'email' => $email,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(400);
    }
}
