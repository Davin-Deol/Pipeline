<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->string('interestedPartyId', 63)->references('users')->on('userId');
            $table->string('creatorId', 63)->references('users')->on('userId');
            $table->string('approvedBy', 63)->references('users')->on('userId');
            $table->string('status', 63);
            $table->string('listingId', 63)->references('listingID')->on('listings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connections');
    }
}
