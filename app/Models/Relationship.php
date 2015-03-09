<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'crud_relationships';

    protected $fillable = [
        'table', 'foreign_key', 'local_key', 'show_column',
    ];

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    public function row(){
        return $this->belongsTo('App\Models\TableRow', 'row_id');
    }
}
