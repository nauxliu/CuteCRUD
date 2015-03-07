<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudTableRows extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('crud_table_rows',function($table){
            $table->increments('id');
            $table->string('table_name');
            $table->string('column_name');
            $table->string('type');
            $table->string('create_rule');
            $table->string('edit_rule');
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
        Schema::dropIfExists("crud_table_rows");
	}

}
