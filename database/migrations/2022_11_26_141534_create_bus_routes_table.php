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
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->string('IdTuyen', 10)->primary();
            $table->string('TenTuyen', 50)->unique();
            $table->string('DiaDiemDi', 50);
            $table->string('DiaDiemDen', 50);
            $table->timestamps();

            //foreign key
            $table->foreign('DiaDiemDi')->references('TenDiaDiem')->on('locations');
            $table->foreign('DiaDiemDen')->references('TenDiaDiem')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_routes');
    }
};
