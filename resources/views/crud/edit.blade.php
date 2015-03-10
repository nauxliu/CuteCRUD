@extends('layouts.master')

@section('content')
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create CRUD</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-12">
<!-- Custom Tabs -->
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li class="active"><a href="#crud_create" data-toggle="tab">Edit CRUD from Table</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="crud_create">

        <div class="row margin">
            {!! Form::open(['route' => ['crud.update', $crud->id], 'method' => 'put' ]) !!}
            <div class="col-md-5">

                @include('layouts.notifications')

                <div class="form-group">
                    <label for="crud_name">Enter CRUD Name</label>
                    <input type="text" class="form-control" name="crud_name" value="{!! $crud->crud_name !!}" id="crud_name" placeholder="Enter CRUD Name">
                </div>

                <div class="form-group">
                    <label for="table_name">Enter Table Name</label>
                    <input type="text" class="form-control" name="table_name" id="table_name" value="{!! $crud->table_name !!}" placeholder="Enter Table Name">
                </div>


                <div class="form-group">
                    <label for="needle">Unqiue / Primary Column Name (Will be used for editing and deleting)</label>
                    <input type="text" class="form-control" name="needle" id="needle" value="{!! $crud->needle !!}" placeholder="Ex : id">
                </div>

                <div class="form-group">
                    <label for="fontawesome_class">Font Awesome Class</label>
                    <input type="text" class="form-control" name="fontawesome_class" id="fontawesome_class" value="{!! $crud->fontawesome_class !!}" placeholder="Ex : fa fa-ellipsis-v">
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input {!! $crud->creatable==1?"checked":"" !!} name="creatable" type="checkbox"/>
                            Should have Create View
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input {!! $crud->editable==1?"checked":"" !!} name="editable" type="checkbox"/>
                            Should have Edit View
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input {!! $crud->listable==1?"checked":"" !!} name="listable" type="checkbox"/>
                            Should have Listing View
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success" name="submit">Update</button>

            </div>
            {!! Form::close() !!}

        </div>

    </div>

</div>
<!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->
</div>
<!-- /.col -->
</div>
</section><!-- /.content -->
@stop