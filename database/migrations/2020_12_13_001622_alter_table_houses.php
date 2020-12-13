<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableHouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->text('api_id')->unique()->change();
            $table->text('head')->nullable()->change();
            $table->text('school')->nullable()->change();
            $table->text('mascot')->nullable()->change();
            $table->text('ghost')->nullable()->change();
            $table->text('founder')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->text('api_id')->change();
            $table->text('head')->change();
            $table->text('school')->change();
            $table->text('mascot')->change();
            $table->text('ghost')->change();
            $table->text('founder')->change();
        });
    }
}
