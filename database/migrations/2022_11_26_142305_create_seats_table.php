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
        Schema::create('seats', function (Blueprint $table) {
            $table->string('IdChuyen', 10);
            $table->string('IdXe', 10);
            $table->string('TenChoNgoi', 10);
            // $table->string('TrangThai', 50);
            $table->timestamps();

            // primary key
            $table->primary(['IdChuyen', 'IdXe', 'TenChoNgoi']);

            // foreign key
            $table->foreign('IdChuyen')->references('IdChuyen')->on('trips')->onDelete('cascade');
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
        Schema::dropIfExists('seats');
    }
};
