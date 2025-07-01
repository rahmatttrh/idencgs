<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->string('type')->nullable();
            $table->integer('employee_id');
            $table->integer('training_id');
            $table->string('desc')->nullable();
            $table->string('periode')->nullable();
            // $table->date('start')->nullable();
            // $table->date('end')->nullable();
            $table->date('expired')->nullable();
            $table->string('vendor')->nullable();
            $table->string('doc')->nullable();
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
        Schema::dropIfExists('training_histories');
    }
}
