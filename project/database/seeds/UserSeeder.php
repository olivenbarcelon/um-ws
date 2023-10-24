<?php

use Carbon\Carbon;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Helpers\GeneralHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     * @return void
     */
    public function run() {
        User::create([
            'uuid' => Uuid::uuid4()->toString(),
            'id_number' => GeneralHelper::generateId(),
            'email' => 'olivenbarcelon@gmail.com',
            'password' => Hash::make('olivenbarcelon'),
            'mobile_number' => '639069208033',
            'role' => 'super_admin',
            'last_name' => 'Barcelon',
            'first_name' => 'Oliven',
            'middle_name' => 'Barcelon',
            'created_at' => Carbon::now()
        ]);
    }
}
