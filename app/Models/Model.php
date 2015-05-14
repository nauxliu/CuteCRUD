<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as ParentModel;

class Model extends ParentModel {
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table = env('TABLE_PREFIX').'models';
    }


}
