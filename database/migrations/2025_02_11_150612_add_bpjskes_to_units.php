<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBpjskesToUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('kode')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('va')->nullable();
            $table->string('bank')->nullable();
            $table->string('npp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
         $table->dropColumn('kode');
         $table->dropColumn('alamat');
         $table->dropColumn('telp');
         $table->dropColumn('va');
         $table->dropColumn('bank');
         $table->dropColumn('npp');
        });
    }
}
