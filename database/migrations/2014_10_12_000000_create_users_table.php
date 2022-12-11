<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('sdt')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('IdNX', 10)->nullable();
            $table->rememberToken();
            $table->timestamps();

            // foreign key
            $table->foreign('IdNX')->references('IdNX')->on('bus_companies');
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
};
