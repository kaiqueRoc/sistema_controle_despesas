<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DespesaServiceTest extends TestCase
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
        
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(201);
    }

    public function test_find_by_id(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->getJson('/api/despesas/1', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(200);
    }
    
    public function test_find_all(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/despesas',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesas = $this->getJson('/api/despesas', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesas->assertStatus(200);
    }

    public function test_update(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "Teste despesa 1",
            "data" => "2023-04-02",
            "valor" => 1000
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(201);
    }

    public function test_delete(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->deleteJson('/api/despesas/1',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(200);
    }

    public function test_find_by_id_action_is_unauthorized(): void
    {
        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste 2',
            'email' => 'teste2@example.com',
            'password' => 12345678
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste2@example.com',
            'password' => 12345678
        ]);

        $despesa = $this->getJson('/api/despesas/1', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(403);
    }

    public function test_update_action_is_unauthorized(): void
    {
        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste 2',
            'email' => 'teste2@example.com',
            'password' => 12345678
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste2@example.com',
            'password' => 12345678
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "Teste despesa 1",
            "data" => "2023-04-02",
            "valor" => 1000
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(403);
    }

    public function test_delete_action_is_unauthorized(): void
    {
        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $this->postJson('/api/users', [
            'id' => 1,
            'name' => 'Teste 2',
            'email' => 'teste2@example.com',
            'password' => 12345678
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste@example.com',
            'password' => 12345678
        ]);

        $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $auth = $this->postJson('/api/login', [
            'email' => 'teste2@example.com',
            'password' => 12345678
        ]);

        $despesa = $this->deleteJson('/api/despesas/1',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa->assertStatus(403);
    }

    public function test_route_create_unauthorized(): void
    {
        $despesa = $this->postJson('/api/despesas',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ]);

        $despesa->assertUnauthorized();
    }

    public function test_route_find_by_id_unauthorized(): void
    {
        $despesa = $this->getJson('/api/despesas/1');

        $despesa->assertUnauthorized();
    }

    public function test_route_find_all_unauthorized(): void
    {
        $despesa = $this->getJson('/api/despesas');

        $despesa->assertUnauthorized();
    }

    public function test_route_update_unauthorized(): void
    {
        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ]);

        $despesa->assertUnauthorized();
    }

    public function test_route_delete_unauthorized(): void
    {
        $despesa = $this->deleteJson('/api/despesas/1',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ]);

        $despesa->assertUnauthorized();
    }

    public function test_validate_on_create_expense_description_not_up_to_191_characters(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "asihdiuahsduhasuiodhaushduiashdiuashduiashduiahsdiuhasuidhuiashduiahsduihasuidhuiashduiahsduihasuidhauishduiashduiashdiuhasuidhauisdhuiahsduiashduihasuidhasuidhiuashduiahsdiuhaisduhasiudhuiashdiuas",
            "data" => "2023-04-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "descricao" => [
                    "The descricao field must not be greater than 191 characters."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_create_expense_user_id_not_exists(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "user_id" => 2,
            "descricao" => "teste descricao",
            "data" => "2023-04-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "user_id" => [
                    "The selected user id is invalid."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_create_expense_invalid_date(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste descricao",
            "data" => "2023-04-022",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "data" => [
                    "The data field must be a valid date."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_create_expense_future_date(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste descricao",
            "data" => "2999-04-22",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "data" => [
                    "The data field must be a date before or equal to today."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_create_expense_value_not_numeric(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste descricao",
            "data" => "2023-04-02",
            "valor" => "teste"
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "valor" => [
                    "The valor field must be a number.",
			        "The valor field format is invalid."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_create_expense_negative_value(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste descricao",
            "data" => "2023-04-02",
            "valor" => -1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "valor" => [
			        "The valor field format is invalid."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_create_expense_required(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "",
            "data" => "",
            "valor" => ""
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "descricao" => [
                    "The descricao field is required."
                ],
                "data" => [
                    "The data field is required."
                ],
                "valor" => [
                    "The valor field is required."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_description_not_up_to_191_characters(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "asihdiuahsduhasuiodhaushduiashdiuashduiashduiahsdiuhasuidhuiashduiahsduihasuidhuiashduiahsduihasuidhauishduiashduiashdiuhasuidhauisdhuiahsduiashduihasuidhasuidhiuashduiahsdiuhaisduhasiudhuiashdiuas",
            "data" => "2023-02-22",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "descricao" => [
                    "The descricao field must not be greater than 191 characters."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_user_id_not_exists(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "user_id" => 2,
            "descricao" => "teste",
            "data" => "2023-02-22",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "user_id" => [
                    "The selected user id is invalid."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_invalid_date(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "teste",
            "data" => "2023-02-022",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "data" => [
                    "The data field must be a valid date."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_future_date(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "teste",
            "data" => "2999-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "data" => [
                    "The data field must be a date before or equal to today."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_value_not_numeric(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => "teste"
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "valor" => [
                    "The valor field must be a number.",
			        "The valor field format is invalid."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_negative_value(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => -1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "valor" => [
			        "The valor field format is invalid."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }

    public function test_validate_on_update_expense_required(): void
    {
        $auth = $this->Authenticate();

        $despesa = $this->postJson('/api/despesas',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $despesa = $this->putJson('/api/despesas/1',
        [
            "descricao" => "",
            "data" => "",
            "valor" => ""
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expected = [
            "errors" => [
                "descricao" => [
                    "The descricao field is required."
                ],
                "data" => [
                    "The data field is required."
                ],
                "valor" => [
                    "The valor field is required."
                ]
            ]
        ];

        $this->assertEquals($expected, json_decode($despesa->getContent(), true));
        $despesa->assertStatus(422);
    }
}
