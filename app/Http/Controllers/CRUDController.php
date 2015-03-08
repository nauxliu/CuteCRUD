<?php namespace App\Http\Controllers;

use App\Utils;
use App\Models\Table;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

/**
 * Class CRUDController
 *
 * @Middleware("App\Http\Middleware\CRUDMiddleware")
 */
class CRUDController extends Controller
{

    /**
     * Show the Index Page
     *
     * @Get("/", as="index")
     */
    public function index()
    {
        $rows = Table::all();
        return view('index', compact('rows'));
    }

    /**
     * Show Create Page
     *
     * @Get("crud/create", as="crud.create")
     */
    public function create()
    {
        return view('crud.create');
    }

    /**
     * Update curd
     *
     * @Post("crud/update/{id}", as="crud.update")
     */
    public function update($id)
    {
        $v = Validator::make(Input::all(), Table::$rules);

        if ($v->fails()) {
            $msg =  Utils::buildMessages($v->errors()->all());
            Flash::error($msg);
            return redirect()->route('crud.edit',$id)->withErrors($v)->withInput();
        }

        if( 0 != Table::where('table_name', Input::get('table_name'))->where('id','!=',$id)->count()){
            Flash::error('Table name already exist.');
            return redirect()->route('crud.edit',$id)->withInput();
        }

        Table::find($id)->update(Input::all());

        Flash::success('CRUD updated successfully.');
        return redirect()->route('index');
    }

    /**
     * Show Edit Page
     *
     * @Get("crud/edit/{id}", as="crud.edit")
     */
    public function edit($id)
    {
        $crud = Table::find($id);
        return view('crud.edit', compact('crud'));
    }

    /**
     * Store crud
     *
     * @Post("crud/create", as="crud.store")
     */
    public function store()
    {
        $v = Validator::make(Input::all(), Table::$rules);

        if ($v->fails()) {
            $msg =  Utils::buildMessages($v->errors()->all());
            Flash::error($msg);
            return redirect()->back()->withErrors($v)->withInput();
        }

        Table::create(Input::all());

        Flash::success('CRUD created successfully.');
        return redirect()->route('index');
    }

    /**
     * Delete crud
     *
     * @Get("crud/delete/{id}", as="crud.delete")
     */
    public function delete($id){
        Table::destroy($id);

        Flash::success('CRUD deleted successfully.');
        return redirect()->route('index')->withInput();
    }
}
