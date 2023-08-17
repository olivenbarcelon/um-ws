<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Helpers\GeneralHelper;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject {
    use Notifiable, SoftDeletes;

    public const RESOURCE_KEY = 'users';

    public const ROLE = [
        'USER' => 'user'
    ];

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return void
     */
    protected static function boot() {
        parent::boot();

        self::creating(
            function ($model) {
                $model->uuid = Uuid::uuid4()->toString();
                $model->id_number = GeneralHelper::generateId();
            }
        );
    }

    /**
     * @return void
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array {
        return [
            'email' => $this->email
        ];
    }

    /**
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void {
        $this->attributes['password'] = Hash::make($value);
    }
}
