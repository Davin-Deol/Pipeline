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
            $table->string('userId', 63)->primary()->unique();
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('fullName', 255);
            $table->string('type', 31)->default("user");
            $table->string('profileImage', 127);
            $table->string('NDA', 127);
            $table->string('NDAStatus', 16);
            $table->string('location', 127);
            $table->string('bio', 2047);
            $table->dateTime('birthday');
            $table->string('individualOrOrganization', 15);
            $table->string('phoneNumber', 15);
            $table->string('linkedInURL', 127);
            $table->string('remember_token', 127);
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
