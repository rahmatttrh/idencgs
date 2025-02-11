<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->integer('absence_id')->nullable();
            $table->integer('employee_id');
            $table->integer('type');
            $table->string('type_desc')->nullable();
            $table->date('date');
            $table->text('desc')->nullable();
            $table->string('transport')->nullable();
            $table->string('destination')->nullable();
            $table->string('from')->nullable();
            $table->string('transit')->nullable();
            $table->string('duration')->nullable();
            $table->datetime('departure')->nullable();
            $table->datetime('return')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('absence_employees');
    }
}
