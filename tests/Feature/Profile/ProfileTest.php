<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get(route('profile.index'));

        $response->assertStatus(200);
    }

    public function test_unauthorized_profile()
    {
        $response = $this->get(route('profile.index'));

        $response->assertStatus(401);
    }
}
