<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_option', function (Blueprint $table) {
            $table->id();
            $table->text('code')->nullable();
            $table->text('value')->nullable();
            $table->text('name_en')->nullable();
            $table->text('name_ar')->nullable();
            $table->double('month_price')->nullable();
            $table->double('six_month_price')->nullable();
            $table->double('year_price')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->integer('sorting')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('price_option');
    }
}
