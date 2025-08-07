<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_systems', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('modul');
            $table->integer('status')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('target_id')->nullable();
            $table->text('desc');
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
        Schema::dropIfExists('log_systems');
    }
}
