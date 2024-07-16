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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->string('no_beli', 14);
            $table->string('kd_brg', 5);
            $table->integer('qty_beli');
            $table->integer('sub_beli');
            
            $table->primary(['no_beli', 'kd_brg']);
            $table->foreign('no_beli')->references('no_beli')->on('Pembelian');
            // Assuming 'kd_brg' references another table
            // $table->foreign('kd_brg')->references('kd_brg')->on('another_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
