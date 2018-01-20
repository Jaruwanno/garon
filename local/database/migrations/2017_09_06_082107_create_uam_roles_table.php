<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUamRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uam_roles', function (Blueprint $table) {
            $table->string('email');
            $table->string('provider');
            $table->string('access_name');

            $table->foreign(['email', 'provider'])->references(['email', 'provider'])->on('users');
            $table->primary(['email', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uam_roles');
    }
}
