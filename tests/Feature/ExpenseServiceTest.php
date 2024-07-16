<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseServiceTest extends TestCase
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

        $expense = $this->postJson('/api/expense',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(201);
    }

    public function test_find_by_id(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->getJson('/api/expense/1', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(200);
    }

    public function test_find_all(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/expense',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->getJson('/api/expense', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(200);
    }

    public function test_update(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
        [
            "descricao" => "Teste despesa 1",
            "data" => "2023-04-02",
            "valor" => 1000
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(201);
    }

    public function test_delete(): void
    {
        $auth = $this->Authenticate();

        $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->deleteJson('/api/expense/1',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(200);
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

        $this->postJson('/api/expense',
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

        $expense = $this->getJson('/api/expense/1', [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(403);
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

        $this->postJson('/api/expense',
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

        $expense = $this->putJson('/api/expense/1',
        [
            "descricao" => "Teste despesa 1",
            "data" => "2023-04-02",
            "valor" => 1000
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(403);
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

        $this->postJson('/api/expense',
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

        $expense = $this->deleteJson('/api/expense/1',
        [
            "id" => 1,
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense->assertStatus(403);
    }

    public function test_route_create_unauthorized(): void
    {
        $expense = $this->postJson('/api/expense',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ]);

        $expense->assertUnauthorized();
    }

    public function test_route_find_by_id_unauthorized(): void
    {
        $expense = $this->getJson('/api/expense/1');

        $expense->assertUnauthorized();
    }

    public function test_route_find_all_unauthorized(): void
    {
        $expense = $this->getJson('/api/expense');

        $expense->assertUnauthorized();
    }

    public function test_route_update_unauthorized(): void
    {
        $expense = $this->putJson('/api/expense/1',
        [
            "descricao" => "Teste expense",
            "data" => "2023-04-06",
            "valor" => 1200
        ]);

        $expense->assertUnauthorized();
    }

    public function test_route_delete_unauthorized(): void
    {
        $expense = $this->deleteJson('/api/expense/1',
        [
            "descricao" => "Teste despesa",
            "data" => "2023-04-06",
            "valor" => 1200
        ]);

        $expense->assertUnauthorized();
    }

    public function test_validate_on_create_expense_description_not_up_to_191_characters(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_create_expense_user_id_not_exists(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_create_expense_invalid_date(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_create_expense_future_date(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_create_expense_value_not_numeric(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_create_expense_negative_value(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_create_expense_required(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_description_not_up_to_191_characters(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_user_id_not_exists(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_invalid_date(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_future_date(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_value_not_numeric(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_negative_value(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }

    public function test_validate_on_update_expense_required(): void
    {
        $auth = $this->Authenticate();

        $expense = $this->postJson('/api/expense',
        [
            "id" => 1,
            "descricao" => "teste",
            "data" => "2023-02-02",
            "valor" => 1500
        ],
        [
            'Authorization' => 'Bearer' . $auth['access_token']
        ]);

        $expense = $this->putJson('/api/expense/1',
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

        $this->assertEquals($expected, json_decode($expense->getContent(), true));
        $expense->assertStatus(422);
    }
}
