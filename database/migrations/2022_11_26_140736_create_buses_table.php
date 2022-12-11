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
        Schema::create('buses', function (Blueprint $table) {
            // $table->id();
            $table->string('IdXe', 10)->primary();
            $table->string('So_xe', 10)->unique();
            $table->string('IdNX', 10);
            $table->integer('Doi_xe');
            $table->string('Loai_xe', 50);
            $table->integer('So_Cho_Ngoi');
            // $table->longText('Url')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('IdNX')->references('IdNX')->on('bus_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
};
