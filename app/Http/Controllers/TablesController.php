<?php namespace App\Http\Controllers;

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

    public function create()
    {

        $datetimepickers = [];
        $timepickers = [];

        $columns = DB::table('crud_table_rows')->where('table_name', $this->table->table_name)->get();

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

        $this->data['columns'] = $columns;
        $this->data['datetimepickers'] = $datetimepickers;
        $this->data['timepickers'] = $timepickers;
        $this->data['table'] = $this->table;

        return view('tables.create', $this->data);
    }

    public function edit($table_name, $needle)
    {
        $datetimepickers = [];
        $timepickers = [];

        $columns = DB::table('crud_table_rows')->where('table_name', $this->table->table_name)->get();

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

    public function update($table_name, $needle)
    {
        $inputs = Input::except(['_token']);

        $arr = [];

        foreach ($inputs as $column => $value) {
            if (Schema::hasColumn($this->table->table_name, $column)) {
                $arr[$column] = $value;
            }
        }

        $columns = DB::table('crud_table_rows')->where("table_name", $this->table->table_name)->get();
        $rules = [];
        $data = $inputs;

        for ($i = 0; $i < sizeOf($columns); $i++) {

            if (!empty($columns[$i]->edit_rule) && isset($data[$columns[$i]->column_name]))
                $rules[$columns[$i]->column_name] = $columns[$i]->edit_rule;
        }

        $v = Validator::make($data, $rules);

        if ($v->fails()) {
            Session::flash('error_msg', Utils::buildMessages($v->errors()->all()));
            return redirect("/table/" . $this->table->table_name . "/list");
        }

        DB::table($this->table->table_name)->where($this->table->needle, $needle)->update($arr);

        Session::flash('success_msg', 'Entry updated successfully');

        return redirect("/table/{$this->table->table_name}/list");

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

    public function all()
    {
        $headers = [];
        $visible_columns_names = DB::table('crud_table_rows')->where('table_name', $this->table->table_name)->where('listable', 1)->lists('column_name');
        $columns = DB::table($this->table->table_name)->select($visible_columns_names)->get();

        $ids = DB::table($this->table->table_name)->lists($this->table->needle);

        if (sizeOf($columns) > 0) {
            $headers = array_keys((array)$columns[0]);
        }

        $this->data['headers'] = $headers;
        $this->data['rows'] = Utils::object_to_array($columns);
        $this->data['table'] = $this->table;
        $this->data['ids'] = $ids;

        return view('tables.list', $this->data);
    }

    public function delete($table_name, $needle)
    {
        $cols = DB::table('crud_table_rows')->where('table_name', $this->table->table_name)->get();

        DB::table($this->table->table_name)->where($this->table->needle, $needle)->delete();

        Session::flash('success_msg', 'Entry deleted successfully');

        return redirect("/table/{$this->table->table_name}/list");
    }

}
