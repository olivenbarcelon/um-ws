<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Helpers\GeneralHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
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
}
