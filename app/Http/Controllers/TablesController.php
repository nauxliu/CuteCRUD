<?php namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\TableRow;
use App\Models\TempModel;
use \DB;
use Laracasts\Flash\Flash;
use \Validator;
use \Input;
use \App\Utils;
use \Session;

class TablesController extends Controller
{
    /**
     * Show Create Page
     *
     * @Get("table/{table_name}/create", as="table.create")
     */
    public function create($table)
    {
        $columns = TableRow::where('table_name', $table)->where('creatable', 1)->get();
        $cols = [];
        return view('tables.create', compact('columns', 'table', 'cols'));
    }

    /**
     * Show edit page
     *
     * @Get("table/{table_name}/edit/{id}", as="table.edit")
     */
    public function edit($table, $needle)
    {

        $columns = TableRow::where('table_name', $table)->where('editable', 1)->get();

        $cols = DB::table($table)->where($this->getNeedle($table), $needle)->first();
        $cols = Utils::object_to_array($cols);

        return view('tables.edit', compact('table', 'needle', 'columns', 'cols'));
    }

    /**
     * Update a row
     *
     * @Post("table/{table_name}/update/{id}", as="table.update")
     */
    public function update($table, $needle)
    {
        $columns = TableRow::where('table_name', $table)->where('editable', 1)->get();

        $rules = [];
        foreach ($columns as $column) {
            $rules[$column->column_name] = $column->edit_rule;
        }

        $v = Validator::make(Input::all(), $rules);

        if ($v->fails()) {
            $msg = Utils::buildMessages($v->errors()->all());
            Flash::error($msg);
            return redirect()->back();
        }

        $input = Input::only(array_keys($rules));
        DB::table($table)->where($this->getNeedle($table), $needle)->update($input);

        Flash::success('Entry updated successfully.');
        return redirect()->route('table.show', $table);
    }

    /**
     * Store Row
     *
     * @Post("table/{table_name}/create", as="table.store")
     */
    public function store($table)
    {
        $columns = TableRow::where('table_name', $table)->where('creatable', 1)->get();

        $rules = [];
        foreach ($columns as $column) {
            $rules[$column->column_name] = $column->create_rule;
        }

        $v = Validator::make(Input::all(), $rules);

        if ($v->fails()) {
            $msg = Utils::buildMessages($v->errors()->all());
            Flash::error($msg);
            return redirect()->back()->withErrors($v)->withInput();
        }

        DB::table($table)->insertGetId(Input::except(['_token']));

        Flash::success('Entry created successfully.');
        return redirect()->route('table.show', $table);
    }

    /**
     * Show table's rows list
     *
     * @Get("table/{table_name}/list", as="table.show")
     */
    public function all($table_name)
    {
        $table = Table::where('table_name', $table_name)->first();
        $columns_names = TableRow::where('table_name', $table_name)->where('listable', 1)->lists('column_name');
        $columns = DB::table($table_name)->select($columns_names)->paginate(15);
        $needles = DB::table($table_name)->paginate(15)->lists($table->needle);

        return view('tables.list', compact('columns_names', 'table', 'columns', 'needles'));
    }

    /**
     * Delete a row
     *
     * @Get("table/{table_name}/delete/{id}", as="table.delete")
     */
    public function delete($table, $needle)
    {
        DB::table($table)->where($this->getNeedle($table), $needle)->delete();

        Flash::success('Entry deleted successfully.');
        return redirect()->route('table.show', $table);
    }

    /**
     * Delete rows
     *
     * @Delete("table/{table_name}", as="table.delete_many")
     */
    public function deleteMany($table)
    {
        DB::table($table)->whereIn($this->getNeedle($table), Input::get('needles'))->delete();
        return redirect()->route('table.show', $table);
    }

    /**
     * Get table's needle
     *
     */
    protected function getNeedle($table)
    {
        return Table::where('table_name', $table)->select('needle')->first()->needle;
    }

}
