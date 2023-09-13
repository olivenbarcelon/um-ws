<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository {
    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @param array $data
     * @return User
     */
    public function save(array $data): User {
        return $this->user->create($data);
    }

    /**
     * @param string $uuid
     * @param array $data
     * @return User
     */
    public function saveByUuid(string $uuid, array $data): User {
        $model = $this->findByUuid($uuid);
        $model->update($data);
        return $model;
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection {
        return $this->user->all();
    }

    /**
     * @param string $uuid
     * @return User
     */
    public function findByUuid(string $uuid): User {
        return $this->user->whereUuid($uuid)->first();
    }

    /**
     * @param string $uuid
     * @return void
     */
    public function delete(string $uuid): void {
        $model = $this->findByUuid($uuid);
        $model->delete();
    }
}
