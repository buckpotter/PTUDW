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
        Schema::create('stops', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('Ten', 50);
            $table->longText('DiaChi');
            $table->string('DiaDiemDi', 50);
            $table->timestamps();

            //foreign key
            $table->foreign('DiaDiemDi')->references('TenDiaDiem')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stops');
    }
};
