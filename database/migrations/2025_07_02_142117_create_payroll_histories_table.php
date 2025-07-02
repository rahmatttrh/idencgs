<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('pokok');
            $table->integer('tunj_jabatan');
            $table->integer('tunj_ops');
            $table->integer('tunj_fungsional');
            $table->integer('insentif');
            $table->integer('tunj_kinerja');
            $table->integer('total');
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
        Schema::dropIfExists('payroll_histories');
    }
}
