<?php namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\TableRow;
use \DB;
use \Request;
use \Validator;
use \Input;
use \App\Utils;
use \Session;
use \Schema;

class SettingsController extends Controller
{
    protected $table;

    function __construct()
    {
        $this->beforeFilter('table_settings', array('except' => array('settings')));
        $this->beforeFilter('table_needle', array('except' => array('settings')));

        $segments = Request::segments();
        $this->table = DB::table('crud_table')->where('table_name', $segments[1])->first();
        $this->settings = DB::table('crud_settings')->first();

    }

    public function settings($table)
    {
        if (!Schema::hasTable($table)) {
            Session::flash('error_msg', 'Specified table not found');
            return view('tables.settings', $this->data);
        }

        $columns_count = count(Schema::getColumnListing($table));

        if ( $columns_count != TableRow::where('table_name', $table)->count()) {
            Table::where('table_name', $table)->first()->initialRows();
        }

        $columns = TableRow::where('table_name', $table)->get();

        foreach ($columns as $column) {

            if ($column->type == "radio") {
                $radios = DB::table("crud_table_pairs")->where("crud_table_id", $column->id)->get();
                $column->radios = $radios;
            }

            if ($column->type == "checkbox") {
                $checkboxes = DB::table("crud_table_pairs")->where("crud_table_id", $column->id)->get();
                $column->checkboxes = $checkboxes;
            }

            if ($column->type == "range") {
                $range = DB::table("crud_table_pairs")->where("crud_table_id", $column->id)->first();
                $column->range_from = $range->key;
                $column->range_to = $range->value;
            }

            if ($column->type == "select") {
                $selects = DB::table("crud_table_pairs")->where("crud_table_id", $column->id)->get();
                $column->selects = $selects;
            }
        }

        return view('tables.settings', compact('columns', 'table'));
    }

    public function postSettings($table)
    {
        //delete old columns and populate new ones
//        if (DB::table('crud_table_rows')->where('table_name', $this->table->table_name)->count() > 0) {
//            Utils::removeTableMeta($this->table);
//        }

        $columns = Input::get("columns");


        foreach ($columns as $column) {
            //helper function. get request params.
//            $input = function($key) use ($column){
//                return Request::get($column. '_' . $key);
//            };

            dd(Request::all());
//            TableRow::where('table_name', $table)->first()->update([
//                'table_name' => $table,
//                'column_name'=> $column,
//                'type'       => $input('type'),
//                'create_rule'=> $input('validator'),
//                'edit_rule'  => $input('edit_validator'),
//                'creatable'  => $input('creatable'),
//                'editable'   => $input('editable'),
//                'listable'   => $input('listable'),
//            ]);
//            $insert_id = DB::table('crud_table_rows')->insertGetId(
//                ['table_name' => $this->table->table_name,
//                    'column_name'=> $column,
//                    'type'       => Input::get($column . "_type"),
//                    'create_rule'=> Input::get($column . "_create_validator"),
//                    'edit_rule'  => Input::get($column . "_edit_validator"),
//                    'creatable'  => Input::get($column . "_creatable"),
//                    'editable'   => Input::get($column . "_editable"),
//                    'listable'   => Input::get($column . "_listable"),
//                    'created_at' => Utils::timestamp(),
//                    'updated_at' => Utils::timestamp()
//                ]);

            if (Input::get($column . "_type") == "radio") {

                $radionames = Input::get($column . "_radioname");
                $radiovalues = Input::get($column . "_radioval");

                for ($i = 0; $i < sizeOf($radionames); $i++) {
                    DB::table("crud_table_pairs")->insert([
                        'crud_table_id'=> $insert_id,
                        'key'          => $radionames[$i],
                        'value'        => $radiovalues[$i]
                    ]);
                }
            }

            if (Input::get($column . "_type") == "range") {
                $range_from= Input::get($column . "_range_from");
                $range_to  = Input::get($column . "_range_to");

                DB::table("crud_table_pairs")->insert([
                    'crud_table_id'=> $insert_id,
                    'key'          => $range_from,
                    'value'        => $range_to
                ]);

            }

            if (Input::get($column . "_type") == "checkbox") {
                $checkboxnames = Input::get($column . "_checkboxname");
                $checkboxvalues= Input::get($column . "_checkboxval");

                for ($i = 0; $i < sizeOf($checkboxnames); $i++) {

                    DB::table("crud_table_pairs")->insert([
                        'crud_table_id'=> $insert_id,
                        'key'          => $checkboxnames[$i],
                        'value'        => $checkboxvalues[$i]
                    ]);

                }
            }

            if (Input::get($column . "_type") == "select") {

                $selectnames = Input::get($column . "_selectname");
                $selectvalues= Input::get($column . "_selectval");

                for ($i = 0; $i < sizeOf($selectnames); $i++) {

                    DB::table("crud_table_pairs")->insert([
                        'crud_table_id'=> $insert_id,
                        'key'          => $selectnames[$i],
                        'value'        => $selectvalues[$i]
                    ]);
                }
            }

        }

        Session::flash('success_msg', 'Table metadata has been updated');

        return redirect("/table/{$this->table->table_name}/list");
    }

}
