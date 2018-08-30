<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->string('listingID', 63)->primary();
            $table->string('category', 63);
            $table->string('subCategory', 31)->references('interest')->on('interests');
            $table->string('name', 127);
            $table->string('introduction', 511);
            $table->string('jurisdiction', 85)->references('jurisdiction')->on('jurisdiction');
            $table->string('investmentType', 31)->references('investmentType')->on('investmentType');
            $table->string('typeOfCurrency', 10)->references('currency')->on('currency');
            $table->decimal('priceBracketMin', 11, 2);
            $table->decimal('priceBracketMax', 11, 2);
            $table->string('additionalDetails', 4095);
            $table->string('status', 63);
            $table->dateTime('whenAdded');
            $table->string('userId', 63)->references('userId')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
