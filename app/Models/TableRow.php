<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TableRow extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'crud_table_rows';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = array([]);

    /**
     * The form components namespace
     *
     * @var string
     */
    private $namespace = 'App\\Http\\FormComponents\\';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function pairs()
    {
        return $this->hasMany('App\Models\TablePair', 'crud_table_id');
    }

    public function updateRow($row_data)
    {
        $type = array_get($row_data, 'type', 'text');

        //delete old pair
        $this->pairs()->delete();
        //Form Component class name
        $component_name = $this->namespace.studly_case($type);

        if(class_exists($component_name)){
            $component = App::make($component_name);
            $component->create($this, $row_data);
        }

        $this->update(array_only($row_data, [
            'type', 'create_rule', 'edit_rule', 'creatable', 'editable', 'listable'
        ]));
    }

}
