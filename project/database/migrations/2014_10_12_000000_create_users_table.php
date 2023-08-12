<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->index();
            $table->string('id_number')->index();
            $table->string('email')->unique()->index();
            $table->string('password')->index();
            $table->string('mobile_number')->index();
            $table->string('role')->index();
            $table->string('last_name')->index();
            $table->string('first_name')->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('created_by')->index();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'updated_at', 'deleted_at']);
            
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
