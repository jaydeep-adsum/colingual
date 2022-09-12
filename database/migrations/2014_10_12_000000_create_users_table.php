<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country_code')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('role',[0,1])->default(0);
            $table->enum('colingual',[0,1]);
            $table->enum('video',[0,1]);
            $table->enum('audio',[0,1]);
            $table->enum('chat',[0,1]);
            $table->enum('login_by',[0,1,2,3,4]);
            $table->integer('primary_language')->nullable();
            $table->string('languages')->nullable();
            $table->string('card_number')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('cvv')->nullable();
            $table->string('country')->nullable();
            $table->string('nickname')->nullable();
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
