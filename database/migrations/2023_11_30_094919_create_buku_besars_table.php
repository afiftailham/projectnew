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
        Schema::create('buku_besar', function (Blueprint $table) {
            $table->id();
            $table->Integer('idtrans');
            $table->string('notran', 10);
            $table->string('catatan', 255);
            $table->double('jmldb')->nullable();
            $table->double('jmlcr')->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku_besars');
    }
};
