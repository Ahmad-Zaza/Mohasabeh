<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_report', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('bills_count')->nullable();
            $table->integer('vouchers_count')->nullable();
            $table->string('allowed_users_count')->nullable();
            $table->integer('used_users_count')->nullable();
            $table->string('allowed_inventories_count')->nullable();
            $table->integer('used_inventories_count')->nullable();
            $table->string('allowed_currencies_count')->nullable();
            $table->integer('used_currencies_count')->nullable();
            $table->string('allowed_clients_count')->nullable();
            $table->integer('used_clients_count')->nullable();
            $table->float('allowed_attachs_size')->default(1);
            $table->float('used_attachs_size')->nullable();
            $table->string('subscription_type')->nullable();
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_report');
    }
}
