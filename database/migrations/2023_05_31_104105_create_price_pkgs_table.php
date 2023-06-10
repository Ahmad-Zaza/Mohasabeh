<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricePkgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_ar')->nullable();
            $table->string('description_en')->nullable();
            $table->text('content_ar')->nullable();
            $table->text('content_en')->nullable();
            $table->string('price')->nullable();
            $table->float('monthly_price')->nullable();
            $table->float('six_month_price')->nullable();
            $table->float('year_price')->nullable();
            $table->string('image')->nullable();
            $table->integer('users_count')->nullable();
            $table->integer('warehouses_count')->nullable();
            $table->integer('currencies_count')->nullable();
            $table->integer('attached_size')->nullable();
            $table->integer('show_in_home')->nullable();
            $table->integer('sorting')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('packages');
    }
}
