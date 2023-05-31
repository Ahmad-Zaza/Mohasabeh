<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('keywords_en')->nullable();
            $table->text('keywords_ar')->nullable();
            $table->text('author_en')->nullable();
            $table->text('author_ar')->nullable();
            $table->text('title_ar')->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('title_en')->nullable();
            $table->text('image')->nullable();
            $table->integer('active')->default(1);
            $table->integer('sorting')->nullable();
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
        Schema::dropIfExists('seo');
    }
}
