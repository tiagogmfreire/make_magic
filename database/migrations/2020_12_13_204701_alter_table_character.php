<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCharacter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->text('patronus')->nullable()->change();
            $table->text('hair_color')->nullable();
            $table->text('eye_color')->nullable();
            $table->text('gender')->nullable();
            $table->boolean('dead')->nullable();
            $table->date('birthday')->nullable();
            $table->date('death_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->text('patronus')->change();
            $table->dropColumn('hair_color');
            $table->dropColumn('eye_color');
            $table->dropColumn('gender');
            $table->dropColumn('dead');
            $table->dropColumn('birthday');
            $table->dropColumn('death_date');
        });
    }
}
