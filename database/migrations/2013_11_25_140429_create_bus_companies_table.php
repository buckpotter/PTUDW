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
        Schema::create('bus_companies', function (Blueprint $table) {
            $table->string('IdNX', 10)->primary();
            $table->string('Ten_NX', 50)->unique();
            $table->string('sdt', 10)->unique();
            $table->string('email')->unique();
            $table->longText('DichVu');
            // $table->string('IdRate', 10);
            $table->timestamps();

            // foreign key
            // $table->foreign('IdRate')->references('IdRate')->on('rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_companies');
    }
};
