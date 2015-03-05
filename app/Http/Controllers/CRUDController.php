<?php namespace App\Http\Controllers;

use \DB;
use \Request;
use \Validator;
use \Input;
use \App\Utils;
use \Session;

class CRUDController extends Controller
{

    public function index()
    {
        $this->data['rows'] = DB::table("crud_table")->get();
        return view('index', $this->data);
    }

    public function create()
    {
        return view('crud.create',$this->data);
    }

    public function edit($id)
    {
        $this->data['crud'] = DB::table("crud_table")->where('id',$id)->first();
        return view('crud.edit',$this->data);
    }

    public function update($id)
    {
        $this->data['crud'] = DB::table("crud_table")->where('id',$id)->first();

        $v = Validator::make(['crud_name' => Input::get('crud_name'),
                'table_name'=> Input::get('table_name'),
                'needle'    => Input::get('needle'),
                'creatable' => Input::has('creatable'),
                'editable'  => Input::has('editable'),
                'listable'  => Input::has('listable')],
            ['crud_name'=>'required','table_name'=>'required','needle'=>'required'
                , 'creatable'=>'required','editable'=>'required', 'listable'=>'required']);

        if ($v->fails()) {
            Session::flash('error_msg',Utils::buildMessages($v->errors()->all()));
            return redirect("/crud/edit/".$id)->withErrors($v)->withInput();
        } else {

            if(DB::table('crud_table')->where('table_name',Input::get('table_name'))->where('id','!=',$id)->count()>0){
                Session::flash('error_msg','Table name already exist');
                return redirect("/crud/edit/".$id)->withInput();
            }

            DB::table('crud_table')->where('id',$id)->update(['crud_name' => Input::get('crud_name'),
                'table_name'       => Input::get('table_name'),
                'slug'             => str_slug(Input::get('table_name')),
                'fontawesome_class'=> Input::get('fontawesome_class','fa fa-ellipsis-v'),
                'needle'           => Input::get('needle'),
                'creatable'        => Input::has('creatable'),
                'editable'         => Input::has('editable'),
                'listable'         => Input::has('listable'),
                'created_at'       => Utils::timestamp(),
                'updated_at'       => Utils::timestamp()]);
        }

        Session::flash('success_msg','CRUD updated successfully');

        return redirect("/crud/all");
    }

    public function store()
    {
        $v = Validator::make(['crud_name' => Input::get('crud_name'),
                'table_name' => Input::get('table_name'),
                'needle'     => Input::get('needle'),
                'creatable'  => Input::has('creatable'),
                'editable'   => Input::has('editable'),
                'listable'   => Input::has('listable')],
            ['crud_name'=>'required','table_name'=>'required|unique:crud_table,table_name','needle'=>'required'
                , 'creatable'=>'required','editable'=>'required', 'listable'=>'required']);

        if ($v->fails()) {
            Session::flash('error_msg',Utils::buildMessages($v->errors()->all()));
            return redirect("/crud/create")->withErrors($v)->withInput();
        } else {
            DB::table('crud_table')->insert(['crud_name' => Input::get('crud_name'),
                    'table_name'        => Input::get('table_name'),
                    'slug'              => str_slug(Input::get('table_name')),
                    'fontawesome_class' => Input::get('fontawesome_class','fa fa-ellipsis-v'),
                    'needle'            => Input::get('needle'),
                    'creatable'         => Input::has('creatable'),
                    'editable'          => Input::has('editable'),
                    'listable'          => Input::has('listable'),
                    'created_at'        => Utils::timestamp(),
                    'updated_at'        => Utils::timestamp()]);
        }

        Session::flash('success_msg','CRUD created successfully');

        return redirect("/crud/all");
    }

    public function delete($id){
        $crud_table = DB::table('crud_table')->where('id',$id)->first();

        DB::table('crud_table_rows')->where('table_name',$crud_table->table_name)->delete();

        DB::table('crud_table')->where('id',$id)->delete();
        Session::flash('success_msg','CRUD deleted successfully');
        return redirect("/crud/all")->withInput();
    }
}
