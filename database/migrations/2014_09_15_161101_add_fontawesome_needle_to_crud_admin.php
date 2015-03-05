<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFontawesomeNeedleToCrudAdmin extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('crud_table',function($table){
            $table->string('fontawesome_class');
            $table->string('needle');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('crud_table',function($table){
            $table->dropColumn('fontawesome_class');
            $table->dropColumn('needle');
        });
	}

}
