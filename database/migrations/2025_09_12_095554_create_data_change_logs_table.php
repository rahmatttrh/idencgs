<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_change_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('table_name');
            $table->string('record_id');
            $table->json('old_value')->nullable();     
            $table->json('new_value')->nullable(); 
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
        Schema::dropIfExists('data_change_logs');
    }
}
