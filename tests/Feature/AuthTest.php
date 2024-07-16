<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login(): void
    {
        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $auth->assertStatus(200);
    }

    public function test_login_unauthorized(): void
    {
        $auth = $this->postJson('/api/login', [
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $auth->assertUnauthorized();
    }
}
