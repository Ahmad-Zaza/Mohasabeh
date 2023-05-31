<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('email');
            $table->integer('package_id')->nullable();
            $table->tinyInteger('is_free_trial')->default(0);
            $table->date('free_trial_start_date')->nullable();
            $table->date('free_trial_end_date')->nullable();
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_end_date')->nullable();
            $table->date('last_renewal_date')->nullable();
            $table->text('website')->nullable();
            $table->text('host_link')->nullable();
            $table->integer('users_count')->nullable();
            $table->text('sys_lang')->nullable();
            $table->text('subscription_type')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->integer('sorting')->nullable();
            $table->text('notes')->nullable();
            $table->text('custom_token')->nullable();
            $table->text('logo_path')->nullable();
            $table->text('color')->nullable();
            $table->text('folder_location')->nullable();
            $table->text('database_name')->nullable();
            $table->text('database_password')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
