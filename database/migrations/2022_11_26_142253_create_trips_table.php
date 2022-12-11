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
        Schema::create('trips', function (Blueprint $table) {
            $table->string('IdChuyen', 10)->primary();
            $table->string('IdTuyen', 10);
            $table->date('NgayDi');
            $table->time('GioDi');
            $table->date('NgayDen');
            $table->time('GioDen');
            $table->string('IdXe', 10);
            $table->integer('GiaVe');
            $table->timestamps();

            // foreign key
            $table->foreign('IdTuyen')->references('IdTuyen')->on('bus_routes')->onDelete('cascade');
            $table->foreign('IdXe')->references('IdXe')->on('buses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
};
