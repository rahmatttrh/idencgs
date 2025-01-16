<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('tahunan')->nullable();
            $table->integer('masa_kerja')->nullable();
            $table->integer('extend')->nullable();
            $table->date('expired')->nullable();
            $table->integer('total')->nullable();
            $table->integer('used')->nullable();
            $table->integer('sisa')->nullable();
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
        Schema::dropIfExists('cutis');
    }
}
