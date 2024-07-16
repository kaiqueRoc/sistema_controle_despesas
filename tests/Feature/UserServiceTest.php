<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function Authenticate()
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

        return $auth;
    }

    public function test_create(): void
    {
        $user = $this->postJson('/api/users',
        [
            "id" => 1,
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ]);

        $user->assertStatus(201);
    }

    public function test_find_by_id(): void
    {

        $auth = $this->Authenticate();

        $this->postJson('/api/users',
        [
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ]);

        $user = $this->getJson('/api/users/1', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $user->assertStatus(200);
    }

    public function test_find_all(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/users',
        [
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ]);

        $users = $this->getJson('/api/users', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $users->assertStatus(200);
    }

    public function test_update(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/users',
        [
            "id" => 1,
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ]);

        $user = $this->putJson('/api/users/1',
        [
            "name" => "Teste nome 2",
            "email" => "teste2@example.com",
            "password" => 12345678
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $user->assertStatus(201);
    }

    public function test_delete(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/users',
        [
            "id" => 1,
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ]);

        $user = $this->deleteJson('/api/users/1',
        [
            "id" => 1,
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $user->assertStatus(200);
    }

    public function test_route_find_by_id_unauthorized(): void
    {
        $user = $this->getJson('/api/users/1');
        $user->assertUnauthorized();
    }

    public function test_route_find_all_unauthorized(): void
    {
        $user = $this->getJson('/api/users');
        $user->assertUnauthorized();
    }

    public function test_route_update_unauthorized(): void
    {
        $user = $this->putJson('/api/users/1',
        [
            "name" => "Teste nome 2",
            "email" => "teste2@example.com",
            "password" => 12345678
        ]);

        $user->assertUnauthorized();
    }

    public function test_route_delete_unauthorized(): void
    {
        $user = $this->deleteJson('/api/users/1',
        [
            "id" => 1,
            "name" => "Teste nome",
            "email" => "teste@example.com",
            "password" => 12345678
        ]);

        $user->assertUnauthorized();
    }

    public function test_validate_on_create_user(): void
    {
        $user = $this->postJson('/api/users',
        [
            "id" => 1,
            "name" => "",
            "email" => "teste",
            "password" => ""
        ]);

        $expected = [
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
                "email" => [
                    "The email field must be a valid email address."
                ],
                "password" => [
                    "The password field is required."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($user->getContent(), true));
        $user->assertStatus(422);
    }

    public function test_validate_on_update_user(): void
    {
        $auth = $this->Authenticate();

        $user = $this->putJson('/api/users/1',
        [
            "name" => "",
            "email" => "teste2",
            "password" => ""
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
                "email" => [
                    "The email field must be a valid email address."
                ],
                "password" => [
                    "The password field is required."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($user->getContent(), true));
        $user->assertStatus(422);
    }

}
