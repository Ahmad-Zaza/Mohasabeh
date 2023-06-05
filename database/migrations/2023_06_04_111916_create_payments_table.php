<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('buyer_id');
            $table->string('buyer_email');
            $table->float('amount', 10, 2);
            $table->string('currency');
            $table->string('status');
            $table->string('error_name')->nullable();
            $table->text('error_message')->nullable();
            $table->string('debug_id')->nullable();
            $table->longText('error_details')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
