<?php  namespace App\Http\FormComponents;

use App\Models\Relationship;
use App\Models\TableRow;
use Illuminate\Support\Facades\Validator;

class HasOne implements ComponentInterface {

    protected $rule = [
        'table'       =>    'required',
        'foreign_key' =>    'required',
        'show_column' =>    'required',
    ];

    public function create(TableRow $row, Array $input)
    {
        $v = Validator::make($input, $this->rule);
        if($v->fails()){
            $exception = new ValidationFailException('Valid failed.');
            $exception->setValidator($v);
            throw $exception;
        }
        $input['local_key'] = $row->column_name;

        $row->relationship()->save(new Relationship($input));
    }

}