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
        Schema::create('detail_retur', function (Blueprint $table) {
            $table->string('no_retur', 14);
            $table->string('kd_brg', 5);
            $table->integer('qty_retur');
            $table->integer('sub_retur');
            
            $table->primary(['no_retur', 'kd_brg']);
            $table->foreign('no_retur')->references('no_retur')->on('retur_beli');
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
