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

    /**
     * show create page
     *
     * @author Xuan
     * @param $table
     * @return \Illuminate\View\View
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
     * @author Xuan
     * @param $table
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($table, $id)
    {

        $columns = TableRow::where('table_name', $table)->where('editable', 1)->get();

        $cols = DB::table($table)->where('id', $id)->first();
        $cols = Utils::object_to_array($cols);

        return view('tables.edit', compact('table', 'id', 'columns', 'cols'));
    }

    /**
     * Update a row
     *
     * @author Xuan
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($table, $id)
    {
        $columns = TableRow::where('table_name', $table)->where('editable', 1)->get();

        $rules = [];
        foreach($columns as $column){
            $rules[$column->column_name] = $column->edit_rule;
        }

        $v = Validator::make(Input::all(), $rules);

        if($v->fails()){
            Session::flash('error_msg', Utils::buildMessages($v->errors()->all()));
            return redirect()->back();
        }

        DB::table($table)->where('id', $id)->update(Input::except(['_token']));

        Session::flash('success_msg', 'Entry updated successfully');
        return redirect()->back();
    }

    /**
     * Store a new
     *
     * @author Xuan
     * @param $table
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($table)
    {
        $columns = TableRow::where('table_name', $table)->where('creatable', 1)->get();

        $rules = [];
        foreach($columns as $column){
            $rules[$column->column_name] = $column->create_rule;
        }

        $v = Validator::make(Input::all(), $rules);

        if($v->fails()){
            Session::flash('error_msg', Utils::buildMessages($v->errors()->all()));
            return Redirect::back()->withErrors($v)->withInput();
        }

        DB::table($table)->insertGetId(Input::except(['_token']));

        Session::flash('success_msg', 'Entry created successfully');
        return redirect('/table/'.$table.'/list');
    }

    /**
     * Show table's rows list
     *
     * @author Xuan
     * @param $table_name
     * @return \Illuminate\View\View
     */
    public function all($table_name)
    {
        $table = Table::where('table_name', $table_name)->first();
        $columns_names = TableRow::where('table_name', $table_name)->where('listable', 1)->lists('column_name');
        $columns = DB::table($table_name)->select($columns_names)->paginate(15);
        $ids = DB::table($table_name)->select('id')->paginate(15)->lists('id');

        return view('tables.list', compact('columns_names', 'table', 'columns', 'ids'));
    }

    /**
     * Delete a row
     *
     * @author Xuan
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($table, $id)
    {
        DB::table($table)->where('id', $id)->delete();

        Session::flash('success_msg', 'Entry deleted successfully');
        return redirect("/table/{$table}/list");
    }

}
