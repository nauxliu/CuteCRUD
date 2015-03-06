<?php  namespace App\Http\FormComponents; 

use App\Models\TablePair;
use App\Models\TableRow;

class Checkbox implements ComponentInterface {

    public function create(TableRow $row, Array $input)
    {
        $type = array_get($input, 'type');
        $pairs = array_get($input, $type);

        foreach($pairs['names'] as $key => $value){
            $pair = new TablePair([
                'key'   => $pairs['names'][$key],
                'value' => $pairs['values'] [$key],
            ]);
            $row->pairs()->save($pair);
        }
    }

}