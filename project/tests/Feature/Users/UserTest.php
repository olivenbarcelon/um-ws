<?php

namespace Tests\Feature\Users;

use App\Jobs\UserCsvProcess;
use Tests\TestCase;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

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
            'password' => $email,
            'role' => 'user',
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName()
        ];
        $this->post(route('api.users.store'), $data, $this->auth())
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson(['data' => collect($data)->except('password')->toArray()]);
        $this->assertDatabaseHas(User::RESOURCE_KEY, collect($data)->except('password')->toArray());
    }

    /**
     * @test
     * @testdox It should create users validate by email
     * @return void
     */
    public function storeValidateByEmail(): void {
        $data = ['email' => 'invalid_email'];
        $this->post(route('api.users.store'), $data, $this->auth())
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email' => 'Email format is invalid']);
    }

    /**
     * @test
     * @testdox It should list users
     * @return void
     */
    public function index(): void {
        $user = factory(User::class)->create();

        $this->get(route('api.users.index'), $this->auth($user))
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
        $this->get(route('api.users.show', $params), $this->auth())
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
        $this->get(route('api.users.show', $params), $this->auth())
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
        $this->put(route('api.users.update', $params), $data, $this->auth())
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
        $this->put(route('api.users.update', $params), [], $this->auth())
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
        $this->delete(route('api.users.destroy', $params), [], $this->auth())
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
        $this->delete(route('api.users.destroy', $params), [], $this->auth())
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['uuid' => 'UUID does not exist']);
    }

    /**
     * @test
     * @testdox It should upload users
     * @return void
     */
    public function upload(): void {
        Queue::fake();
        Storage::fake('uploads');

        $header = 'email,mobile_number,password,role,last_name,first_name,middle_name';
        $row1 = 'Kelton85@hotmail.com,639069208033,P@ssw0rd,admin,Mertz,Geoffrey,';
        $content = implode("\n", [$header, $row1]);
        $filePath = '/tmp/users.csv';
        file_put_contents($filePath, $content);

        $payload = [
            'file' => new UploadedFile($filePath, 'users.csv', null, null, true)
        ];
        $this->post(route('api.users.upload'), $payload, $this->auth())
            ->assertOk()
            ->assertJson([
                'message' => 'Users has successfully uploaded'
            ]);

        Queue::assertPushed(UserCsvProcess::class, function ($job) {
            $job->handle();
            return true;
        });
    }

    /**
     * @test
     * @testdox It should upload users not acceptable
     * @return void
     */
    public function uploadNotAcceptable(): void {
        $this->post(route('api.users.upload'), [], $this->auth())
            ->assertStatus(JsonResponse::HTTP_NOT_ACCEPTABLE)
            ->assertJson([
                'message' => 'No file uploaded or invalid file type'
            ]);
    }

    /**
     * @test
     * @testdox It should login users
     * @return void
     */
    public function login(): void {
        $email = $this->faker->unique()->safeEmail;
        $password = $this->faker->regexify('[A-Z]{5}[0-4]{3}');
        factory(User::class)->create([
            'email' => $email,
            'password' => $password
        ]);

        $data = [
            'email' => $email,
            'password' => $password
        ];
        $this->post(route('api.users.login'), $data)
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'token'
            ])
            ->assertJson(['data' => collect($data)->except('password')->toArray()]);
    }

    /**
     * @test
     * @testdox It should login users validate by email
     * @return void
     */
    public function loginValidateByEmail(): void {
        $data = [
            'password' => $this->faker->regexify('[A-Z]{5}[0-4]{3}')
        ];
        $this->post(route('api.users.login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email' => 'Email is required']);
    }

    /**
     * @test
     * @testdox It should login users unauthorized
     * @return void
     */
    public function loginUnauthorized(): void {
        $email = factory(User::class)->create()->email;

        $data = [
            'email' => $email,
            'password' => $this->faker->regexify('[A-Z]{5}[0-4]{3}')
        ];
        $this->post(route('api.users.login'), $data)
            ->assertUnauthorized()
            ->assertJsonStructure([
                'code',
                'error',
                'message',
                'description'
            ]);
    }

    /**
     * @test
     * @testdox It should logout users
     * @return void
     */
    public function logout(): void {
        $this->post(route('api.users.logout'), [], $this->auth())
            ->assertOk()
            ->assertJson(['message' => 'User has successfully logged out']);
    }
}
