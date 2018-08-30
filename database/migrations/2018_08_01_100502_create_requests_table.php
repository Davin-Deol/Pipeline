<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->string('requestID', 63)->primary();
            $table->string('email', 255);
            $table->string('fullName', 255);
            $table->string('linkedInURL', 255)->default("");
            $table->string('individualOrOrganization', 15);
            $table->string('type', 127);
            $table->dateTime('whenSent');
            $table->char('readStatus', 0)->nullable();
            $table->char('inviteSent', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
