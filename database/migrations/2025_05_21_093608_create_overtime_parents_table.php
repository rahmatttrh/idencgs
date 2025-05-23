<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_parents', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id');
            $table->date('date');
            $table->decimal('hours', 6,1);
            $table->decimal('hours_final', 6,1)->nullable();
            $table->integer('rate')->nullable();
            $table->string('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('hour_type')->nullable();
            $table->integer('type')->nullable();
            $table->string('doc')->nullable();
            $table->integer('holiday_type')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('overtime_parents');
    }
}
