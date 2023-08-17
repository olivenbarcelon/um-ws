<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
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
            ->assertJson(['data' => collect($data)->toArray()]);
        $this->assertDatabaseHas(User::RESOURCE_KEY, collect($data)->toArray());
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
            ->assertJsonValidationErrors(['email' => 'Email format is invalid']);
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

    /**
     * @test
     * @testdox It should show users
     * @return void
     */
    public function show(): void {
        $user = factory(User::class)->create();
        factory(User::class)->create();

        $params = [
            'uuid' => $user->uuid
        ];
        $this->get(route('api.users.show', $params))
            ->assertOk()
            ->assertJson(['data' => collect($params)->toArray()]);
    }

    /**
     * @test
     * @testdox It should show users validate by uuid
     * @return void
     */
    public function showValidateByUuid(): void {
        $params = [
            'uuid' => Uuid::uuid4()
        ];
        $this->get(route('api.users.show', $params))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['uuid' => 'UUID does not exist']);
    }

    /**
     * @test
     * @testdox It should update users
     * @return void
     */
    public function update(): void {
        $user = factory(User::class)->create();

        $params = [
            'uuid' => $user->uuid
        ];
        $data  = [
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName()
        ];
        $this->put(route('api.users.update', $params), $data)
            ->assertOk()
            ->assertJson(['data' => collect($params)->merge($data)->toArray()]);
        $this->assertDatabaseHas(User::RESOURCE_KEY, collect($data)->toArray());
    }

    /**
     * @test
     * @testdox It should update users validate by uuid
     * @return void
     */
    public function updateValidateByUuid(): void {
        $params = [
            'uuid' => Uuid::uuid4()
        ];
        $this->put(route('api.users.update', $params))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['uuid' => 'UUID does not exist']);
    }

    /**
     * @test
     * @testdox It should delete users
     * @return void
     */
    public function destroy(): void {
        $user = factory(User::class)->create();

        $params = [
            'uuid' => $user->uuid
        ];
        $this->delete(route('api.users.destroy', $params))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing(User::RESOURCE_KEY, collect($params)->merge(['deleted_at' => null])->toArray());
    }

    /**
     * @test
     * @testdox It should delete users validate by uuid
     * @return void
     */
    public function destroyValidateByUuid(): void {
        $params = [
            'uuid' => Uuid::uuid4()
        ];
        $this->delete(route('api.users.destroy', $params))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['uuid' => 'UUID does not exist']);
    }
}
