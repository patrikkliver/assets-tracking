<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    public function test_unauthenticated_user_redirects_to_register_page(): void
    {
        $response = $this->get('/user/home');

        $response->assertStatus(302);
        $response->assertRedirect('register');
    }

    public function test_unferified_user_redirects_to_verify_page() : void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johnd@example.com',
            'email_verified_at' => null
        ]);

        $response = $this->actingAs($user)->get('/user/home');

        $response->assertStatus(302);
        $response->assertRedirect('/email/verify');
    }

    public function test_user_login_successfull_redirects_to_url_user_home() : void
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johnd@example.com',
        ]);

        $response = $this->post('/login', [
            'email' => 'johnd@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/user/home');
    }

    public function test_admin_login_successfull_redirects_to_url_admin_home() : void
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johnd@example.com',
            'is_admin' => true
        ]);

        $response = $this->post('/login', [
            'email' => 'johnd@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/home');
    }

    public function test_admin_can_access_route_for_admin() : void
    {
        $response = $this->actingAs($this->admin)->get('/admin/home');

        $response->assertStatus(200);
        $response->assertSee(__('You are logged in!'));
    }

    public function test_non_admin_cannot_access_route_for_admin() : void
    {
        $response = $this->actingAs($this->user)->get('/admin/home');

        $response->assertStatus(403);
        $response->assertDontSee(__('You are loggen in!'));
    }

    private function createUser(bool $isAdmin = false) : User
    {
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}
