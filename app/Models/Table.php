<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
    protected $fillable = ['crud_name', 'table_name', 'slug', 'creatable', 'editable', 'listable',
        'fontawesome_class', 'needle'];

    /**
     * Validator Rules
     *
     * @var array
     */
    public static $rules = [
        'crud_name'  => 'required',
        'table_name' => 'required|unique:crud_table,table_name',
        'needle'     => 'required',
    ];

    public static $update_rules = [
        'crud_name'  => 'required',
        'table_name' => 'required',
        'needle'     => 'required',
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

    public function rows()
    {
        return $this->hasMany('App\Models\TableRow', 'table_name', 'table_name');
    }

}
