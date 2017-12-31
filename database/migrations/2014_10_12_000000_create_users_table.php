<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',100);
            $table->string('desc',200)->nullable();
            $table->decimal('fee',10,2)->nullable();
            $table->decimal('p_area',10,2)->nullable();
            $table->decimal('b_area',10,2)->nullable();
            $table->integer('elec')->nullable();
            $table->integer('water')->nullable();
            $table->string('bldg_permit',200)->nullable();
            $table->string('completion',200)->nullable();
            $table->string('deed',200)->nullable();
            $table->string('layout',200)->nullable();
            $table->string('floor',200)->nullable();
            $table->string('loc_long',100)->nullable();
            $table->string('loc_lat',100)->nullable();
            $table->string('location',255)->nullable();
            $table->enum('for_rent', ['yes', 'no'])->default('yes');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email',50)->unique();
            $table->string('password');
            $table->string('qid',200)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('address',255)->nullable();
            $table->string('job',30)->nullable();
            $table->string('company',30)->nullable();
            $table->string('co_address',100)->nullable();
            $table->string('co_contact',15)->nullable();
            $table->string('prev',5)->nullable();
            $table->enum('admin', ['yes', 'no', 'admin'])->default('no');
            $table->enum('role', ['spec', 'admin', 'power'])->nullable();
            $table->integer('prop_id')->unsigned()->nullable();
            $table->foreign('prop_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->integer('property_id')->unsigned()->nullable();
            $table->foreign('property_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('properties');
    }
}
