<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('crud_relationships', function(Blueprint $table){
            $table->increments('id');
            $table->string('table');
            $table->string('local_key');
            $table->string('foreign_key');
            $table->string('show_column');
            $table->unsignedInteger('row_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('crud_relationships');
	}

}
