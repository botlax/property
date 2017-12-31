<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prop_user', function (Blueprint $table) {
            $table->integer('property_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['property_id', 'user_id']);
        });

        Schema::create('furnitures', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
        });

        Schema::create('prop_fur', function (Blueprint $table) {
            $table->integer('property_id')->unsigned();
            $table->integer('furniture_id')->unsigned();
            $table->integer('num')->unsigned();
            $table->primary(['property_id', 'furniture_id']);
        });

        Schema::create('renter', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',100);
            $table->string('contract',200)->nullable();
            $table->string('cr',200)->nullable();
            $table->string('permit',200)->nullable();
            $table->string('qid',200)->nullable();
            $table->string('email',50)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('address',255)->nullable();
            $table->string('company',30)->nullable();
            $table->string('co_address',100)->nullable();
            $table->string('co_contact',15)->nullable();
            $table->string('co_person',50)->nullable();
            $table->string('co_mobile',15)->nullable();
            $table->string('prev',5)->nullable();
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('drawings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('drawing',255);
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('paydate')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('invoice',200)->nullable();
            $table->string('cheque',200)->nullable();
            $table->integer('renter_id')->unsigned()->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('desc',255);
            $table->string('complainer',100)->nullable();
            $table->string('mobile',15)->nullable();
            $table->datetime('log_date');
            $table->datetime('close_date')->nullable();
            $table->decimal('cost',10,2)->nullable();
            $table->enum('status', ['open', 'close'])->default('open');
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('log_invoice', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('desc',255);
            $table->string('invoice',200)->nullable();
            $table->integer('log_id')->unsigned()->nullable();
            $table->foreign('log_id')
                  ->references('id')->on('logs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('progress', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('desc',255);
            $table->datetime('log_date');
            $table->integer('log_id')->unsigned()->nullable();
            $table->foreign('log_id')
                  ->references('id')->on('logs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('guarantees', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('from');
            $table->date('to');
            $table->string('file',200)->nullable();
            $table->string('desc',255);
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('file',200)->nullable();
            $table->string('desc',255);
            $table->date('date');
            $table->decimal('cost',10,2)->nullable();
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('from');
            $table->date('to');
            $table->enum('status', ['year', 'month', 'custom'])->default('year');
            $table->integer('months')->unsigned();
        });

        Schema::create('act', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamp('date');
            $table->string('desc',255);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
        Schema::dropIfExists('payment');
        Schema::dropIfExists('drawings');
        Schema::dropIfExists('renter');
        Schema::dropIfExists('prop_fur');
        Schema::dropIfExists('furnitures');
    }
}
