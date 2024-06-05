<?php

namespace Modules\AuthAdmin\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthAdminControllerTest extends TestCase
{
    /** @test */
    public function it_should_authenticate_admin_with_correct_credentials()
    {
        $response = $this->postJson('/admin/auth', [
            'login' => 'admin',
            'password' => 'admin',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Authentication successful',
                 ]);
    }

    /** @test */
    public function it_should_fail_authentication_with_incorrect_credentials()
    {
        $response = $this->postJson('/admin/auth', [
            'login' => 'admin',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Authentication failed',
                 ]);
    }
}
