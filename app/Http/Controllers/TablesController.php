<?php namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\TableRow;
use App\Models\TempModel;
use \DB;
use \Request;
use \Validator;
use \Input;
use \App\Utils;
use \Session;
use \Schema;

class TablesController extends Controller
{
    protected $table;

    function __construct()
    {
        $this->beforeFilter('table_settings');
        $this->beforeFilter('table_needle');

        $segments      = Request::segments();
        $this->table   = DB::table('crud_table')->where('table_name', $segments[1])->first();
        $this->settings= DB::table('crud_settings')->first();

    }

    public function uploadFeaturedImage($file)
    {

        $timestamp = time();
        $ext = $file->guessClientExtension();
        $name = $timestamp . "_file." . $ext;

        // move uploaded file from temp to uploads directory
        if ($file->move(public_path() . $this->settings->upload_path , $name)) {
            return $this->settings->upload_path . $name;
        } else {
            return false;
        }
    }

    public function create($table)
    {

        $datetimepickers = [];
        $timepickers = [];
        $columns = TableRow::where('table_name', $table)->get();



        foreach ($columns as $column) {

            if ($column->type == "datetime") {
                $datetimepickers[] = $column->column_name;
            }

            if ($column->type == "time") {
                $timepickers[] = $column->column_name;
            }

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
        return view('tables.create', compact('columns', 'datetimepickers', 'timepickers', 'table'));
    }

    public function edit($table, $needle)
    {
        $datetimepickers = [];
        $timepickers = [];

//        $columns = DB::table('crud_table_rows')->where('table_name', $table)->get();
        $columns = TableRow::where('table_name', $table)->get();

        foreach ($columns as $column) {

            if ($column->type == "datetime") {
                $datetimepickers[] = $column->column_name;
            }

            if ($column->type == "time") {
                $timepickers[] = $column->column_name;
            }

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

        $cols = DB::table($this->table->table_name)->where($this->table->needle, $needle)->first();

        $this->data['cols'] = (array)$cols;
        $this->data['columns'] = $columns;
        $this->data['datetimepickers'] = $datetimepickers;
        $this->data['timepickers'] = $timepickers;
        $this->data['table'] = $this->table;
        $this->data['needle'] = $needle;

        return view('tables.edit', $this->data);
    }

    public function update($table, $needle)
    {
        $inputs = Input::except(['_token']);

        $arr = [];

        foreach ($inputs as $column => $value) {
            if (Schema::hasColumn($table, $column)) {
                $arr[$column] = $value;
            }
        }

        $columns = DB::table('crud_table_rows')->where("table_name", $table)->get();
        $rules = [];
        $data = $inputs;

        for ($i = 0; $i < sizeOf($columns); $i++) {

            if (!empty($columns[$i]->edit_rule) && isset($data[$columns[$i]->column_name]))
                $rules[$columns[$i]->column_name] = $columns[$i]->edit_rule;
        }

        $v = Validator::make($data, $rules);

        if ($v->fails()) {
            Session::flash('error_msg', Utils::buildMessages($v->errors()->all()));
            return redirect("/table/" . $table . "/list");
        }

        DB::table($table)->where($this->table->needle, $needle)->update($arr);

        Session::flash('success_msg', 'Entry updated successfully');

        return redirect("/table/{$table}/list");

    }

    public function store()
    {

        $inputs = Input::except('_token');

        $columns = DB::table('crud_table_rows')->where("table_name", $this->table->table_name)->get();
        $rules = [];
        $data = $inputs;

        for ($i = 0; $i < sizeOf($columns); $i++) {

            if (!empty($columns[$i]->create_rule) && isset($data[$columns[$i]->column_name]))
                $rules[$columns[$i]->column_name] = $columns[$i]->create_rule;
        }

        $v = Validator::make($data, $rules);

        if ($v->fails()) {
            Session::flash('error_msg', Utils::buildMessages($v->errors()->all()));
            return Redirect::back()->withErrors($v)->withInput();
        }

        $arr = [];

        foreach ($inputs as $column => $value) {
            if (Schema::hasColumn($this->table->table_name, $column)) {

                if(is_file($value)){
                    $arr[$column] = $this->uploadFeaturedImage($value);
                }else{
                    $arr[$column] = $value;
                }
            }
        }

        DB::table($this->table->table_name)->insert($arr);

        Session::flash('success_msg', 'Entry created successfully');

        return redirect("/table/{$this->table->table_name}/list");

    }

    public function all($table_name)
    {
        $table = Table::where('table_name', $table_name)->first();
        $columns_names = TableRow::where('table_name', $table_name)->where('listable', 1)->lists('column_name');
        $columns = DB::table($table_name)->select($columns_names)->paginate(15);
        $ids = DB::table($table_name)->select('id')->paginate(15)->lists('id');

        return view('tables.list', compact('columns_names', 'table', 'columns', 'ids'));
    }

    public function delete($table, $id)
    {
        DB::table($table)->where('id', $id)->delete();

        Session::flash('success_msg', 'Entry deleted successfully');

        return redirect("/table/{$table}/list");
    }

}
