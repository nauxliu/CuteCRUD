<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Schema;

class Table extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'crud_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'crud_name', 'table_name', 'needle', 'fontawesome_class', 'creatable', 'editable', 'listable', 'slug'
    ];

    /**
     * Create Validation Rules
     *
     * @var array
     */
    public static $rules = [
        'crud_name'  => 'required',
        'table_name' => 'required|unique:crud_table,table_name',
    ];

    /**
     * Edit Validation Rules
     *
     * @var array
     */
    public static $edit_rules = [
        'crud_name'  => 'required',
        'table_name' => 'required',
    ];

    /**
     * Construct
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->registerEvents();
        parent::__construct($attributes);
    }

    /*
     * Register Model Events
     */
    protected function registerEvents()
    {
        static::deleted(function($user){
            $user->rows()->delete();
        });
    }

    /*
     * Initial Table's rows
     */
    public function initialRows()
    {
        $table = $this->table_name;
        $columns = Schema::getColumnListing($table);

        foreach($columns as $column){
            if(0 != TableRow::where(['column_name' => $column])->count()){
                continue;
            }
            TableRow::create([
                'table_name' => $table,
                'column_name'=> $column,
                'type'       => 'text',
                'creatable'  => true,
                'editable'   => true,
                'listable'   => true,
            ]);
        }
        //Delete unused columns
        TableRow::whereNotIn('column_name', $columns)->delete;
    }

    public function rows()
    {
        return $this->hasMany('App\Models\TableRow', 'table_name', 'table_name');
    }

}
