<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipReportProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslip_report_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_transaction_id');
            $table->integer('payslip_report_id');
            $table->integer('location_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('pokok');
            $table->integer('jabatan');
            $table->integer('ops');
            $table->integer('kinerja');
            $table->integer('fungsional');
            $table->integer('total');
            $table->integer('lain');
            $table->integer('lembur');
            $table->integer('bruto');
            $table->integer('bpjstk');
            $table->integer('bpjsks');
            $table->integer('jp');
            $table->integer('absen');
            $table->integer('terlambat');
            $table->integer('gaji_bersih');
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
        Schema::dropIfExists('payslip_report_projects');
    }
}
