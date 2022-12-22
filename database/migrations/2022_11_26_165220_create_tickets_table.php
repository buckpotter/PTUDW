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
        Schema::create('tickets', function (Blueprint $table) {
            $table->string('IdBanVe', 10)->primary();
            $table->string('IdChuyen', 10);
            $table->string('IdUser', 10);
            $table->longText('note')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('IdChuyen')->references('IdChuyen')->on('trips')->ondDelete('cascade');
            $table->foreign('IdUser')->references('IdUser')->on('normal_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
