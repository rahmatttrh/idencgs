<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->integer('overtime_id')->nullable();
            
            $table->integer('spkl_id')->nullable();
            $table->date('date');
            $table->decimal('hours', 6,1);
            $table->decimal('hours_final', 6,1)->nullable();
            $table->string('month');
            $table->integer('year');
            $table->integer('hour_type')->nullable();
            $table->decimal('type', 6,1)->nullable();
            $table->integer('holiday_type')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('description')->nullable();
            $table->string('doc')->nullable();
            $table->integer('rate');

            $table->integer('employee_id');
            $table->datetime('release_employee_date')->nullable();
            $table->integer('leader_id')->nullable();
            $table->datetime('approve_leader_date')->nullable();
            $table->integer('manager_id')->nullable();
            $table->datetime('approve_manager_date')->nullable();
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
        Schema::dropIfExists('overtime_employees');
    }
}
