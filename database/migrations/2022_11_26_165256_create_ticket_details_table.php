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
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->string('IdCTBV', 10)->primary();
            $table->string('IdBanVe', 10);
            $table->string('TenChoNgoi', 10);
            $table->string('TinhTrangVe', 50);
            // $table->date('NgayBan');
            // $table->time('GioBan');
            $table->string('pttt', 50);
            $table->timestamps();

            // Foreign key
            $table->foreign('IdBanVe')->references('IdBanVe')->on('tickets')->onDelete('cascade');
            // $table->primary(['IdBanVe', 'TenChoNgoi']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_details');
    }
};
