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
        Schema::create('rates', function (Blueprint $table) {
            $table->string('IdRate', 10)->primary();
            $table->string('IdNX', 10);
            $table->string('IdUser', 10);
            // $table->integer('DanhGia');
            $table->longText('BinhLuan');
            // $table->date('NgayDanhGia');
            $table->timestamps();

            // foreign key
            $table->foreign('IdNX')->references('IdNX')->on('bus_companies')->onDelete('cascade');
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
        Schema::dropIfExists('rates');
    }
};
