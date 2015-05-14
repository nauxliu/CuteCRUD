<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration {
    private $table_name;

    function __construct()
    {
        $this->table_name = env('TABLE_PREFIX') . 'models';
    }

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->table_name, function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 10);
            $table->string('table', 100);
            $table->string('creatable', 100);
            $table->string('editable', 100);
            $table->string('listable', 100);
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
        Schema::drop($this->table_name);
	}

}
