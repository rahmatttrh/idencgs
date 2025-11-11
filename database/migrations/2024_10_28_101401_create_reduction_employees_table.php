<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReductionEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reduction_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('reduction_id');
            $table->integer('employee_id');
            $table->integer('location_id')->nullable();
            $table->integer('status')->nullable();
            $table->string('type')->nullable();
            $table->integer('employee_value');
            $table->integer('employee_value_real');
            $table->integer('company_value');
            $table->integer('company_value_real');
            $table->string('description')->nullable();
            $table->integer('total_deduction')->nullable();
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
        Schema::dropIfExists('reduction_employees');
    }
}
