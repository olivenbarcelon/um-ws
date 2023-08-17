<?php

namespace Tests;

use App\Models\User;
use Faker\Factory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;
    protected $faker;

    /**
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();

        $this->faker = Factory::create();

        $this->artisan('migrate');
        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * @param User|null $user
     * @return array
     */
    protected function auth(User $user = null): array {
        if(is_null($user)) {
            $user = factory(User::class)->create();
        }

        $payload = JWTFactory::sub(1)
            ->email($user->email)
            ->make();
        $token = JWTAuth::encode($payload);

        return [
            'Authorization' => 'Bearer ' . $token,
        ];
    }
}
