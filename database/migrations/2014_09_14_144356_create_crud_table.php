<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('crud_table',function($table){
            $table->increments('id');
            $table->string('crud_name');
            $table->string('table_name');
            $table->string('slug');
            $table->boolean('creatable');
            $table->boolean('editable');
            $table->boolean('listable');
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
        Schema::dropIfExists("crud_table");
	}

}
