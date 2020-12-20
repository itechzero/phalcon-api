<?php

use Phalcon\Migrations\Migrations;

class CreateUsersTable extends Migrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->default('')->comment('name');
            $table->string('email')->unique()->default('')->comment('email');
            $table->string('password')->default('')->comment('password');
            $table->tinyInteger('status')->default(0)->comment('status');
            $table->unsignedInteger('created_at')->default(0)->comment('created_at');
            $table->unsignedInteger('updated_at')->default(0)->comment('updated_at');
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
    }
}
