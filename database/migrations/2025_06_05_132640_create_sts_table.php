<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable();
            $table->string('status', 3)->default('0');
            $table->integer('employee_id');
            $table->integer('department_id');
            $table->integer('by_id');
            $table->string('desc');
            $table->string('rule')->nullable();
            $table->dateTime('release_at')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            
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
        Schema::dropIfExists('sts');
    }
}
