<?php namespace App\Http\FormComponents;

use App\Models\TableRow;

interface ComponentInterface
{
    public function create(TableRow $row, Array $pairs);
}
