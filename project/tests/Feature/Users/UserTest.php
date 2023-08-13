<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class UserTest extends TestCase {
    /**
     * @test
     * @testdox It should create users
     * @return void
     */
    public function store(): void {
        $email = 'test@test.com';

        $data = [
            'email' => $email,
            'mobile_number' => '639123456789',
            'role' => 'user',
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName()
        ];
        $this->post(route('api.users.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    'email' => $email
                ]
            ]);
    }

    /**
     * @test
     * @testdox It should create users validate by email
     * @return void
     */
    public function storeValidateByEmail(): void {
        $data = ['email' => 'invalid_email'];
        $this->post(route('api.users.store'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment([
                'errors' => [
                    'email' => ['Email format is invalid']
                ]
            ]);
    }

    /**
     * @test
     * @testdox It should list users
     * @return void
     */
    public function index(): void {
        factory(User::class)->create();

        $this->get(route('api.users.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }
}
