<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'crud_relationships';

    public function row(){
        return $this->belongsTo('App\Models\TableRow', 'row_id');
    }
}
