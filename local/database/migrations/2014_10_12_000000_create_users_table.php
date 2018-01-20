<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('email');
            $table->string('password');
            $table->string('provider_id');
            $table->string('provider');
            $table->string('avatar_url');
            $table->enum('type', ['user', 'admin']);
            $table->rememberToken();
            $table->timestamps();

            $table->primary(['email', 'provider']);
            $table->index('email');
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
