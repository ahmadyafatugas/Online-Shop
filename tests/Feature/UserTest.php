<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testregister()
    {
        $this->post('/api/daftar', [
            'name' => 'Bunga',
            'email' => 'bunga@gmail.com',
            'password' => "12345"
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    'name' => 'Bunga',
                    'email' => 'bunga@gmail.com',
                ]
            ]);
    }

    public function testRegisterAlready()
    {
        $this->testregister();
        $this->post('/api/daftar', [
            'name' => 'Bunga',
            'email' => 'bunga@gmail.com',
            'password' => "test"
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'email' => [
                        'email already registered'
                    ]
                ]
            ]);
    }


    public function testFailedRegister()
    {
        $this->post('/daftar', [
            'name' => '',
            'email' => '',
            'password' => ""
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'name' => [
                        "The name field is required."
                    ],
                    'email' => [
                        "The email field is required."
                    ],
                    'password' => [
                        "The password field is required."
                    ],
                ]
            ]);
    }

    public function testLogin()
    {
        // $this->seed([UserSeed::class]);
        $this->post("/api/login", [
            'email' => 'test@gmail.com',
            'password' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'email' => 'test@gmail.com',
                    'name' => 'test',
                    'role' => 'admin',
                ]
            ]);

    }

    public function testLoginFailed()
    {
        // $this->seed([UserSeed::class]);
        $this->post("/api/login", [
            'email' => 'test@gmail.com',
            'password' => '1111'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'email or password wrong'
                    ]
                ]
            ]);

    }

    public function testlogout()
    {
        // $this->seed([UserSeed::class]);
        $this->post("/logout")
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Success Logout'
            ]);
    }
}
