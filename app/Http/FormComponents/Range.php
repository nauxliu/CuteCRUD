<?php  namespace App\Http\FormComponents;

use App\Models\TablePair;
use App\Models\TableRow;

class Range implements ComponentInterface{

    public function create(TableRow $row, Array $range)
    {
        $pair = new TablePair([
            'key'   =>  $range['from'],
            'value' =>  $range['to'],
        ]);
        $row->pairs()->save($pair);
    }
}