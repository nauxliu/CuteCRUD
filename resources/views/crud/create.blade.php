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
    <li class="active"><a href="#crud_create" data-toggle="tab">Create CRUD from Table</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="crud_create">

        <div class="row margin">
            {!! Form::open(['url'=>'/crud/create']) !!}
            <div class="col-md-5">

                @include('layouts.notifications')

                <div class="form-group">
                    {!! Form::label('crud_name', 'Enter CRUD Name') !!}
                    {!! Form::text('crud_name', null,
                        ['id' => 'crud_name', 'class' => 'form-control', 'placeholder' => 'Enter CRUD Name'])
                    !!}
                </div>

                <div class="form-group">
                    {!! Form::label('table_name', 'Enter Table Name') !!}
                    {!! Form::text('table_name', null,
                        ['id' => 'table_name', 'class' => 'form-control', 'placeholder' => 'Enter Table Name'])
                    !!}
                </div>

                <div class="form-group">
                    {!! Form::label('needle', 'Unqiue / Primary Column Name (Will be used for editing and deleting)') !!}
                    {!! Form::text('needle', null,
                        ['id' => 'needle', 'class' => 'form-control', 'placeholder' => 'Ex : id'])
                    !!}
                </div>

                <div class="form-group">
                    {!! Form::label('fontawesome_class', 'Font Awesome Class') !!}
                    {!! Form::text('fontawesome_classe', null,
                        ['id' => 'fontawesome_class', 'class' => 'form-control', 'placeholder' => 'Ex : fa fa-ellipsis-v'])
                    !!}
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('creatable') !!}
                            Should have Create View
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('editable') !!}
                            Should have Edit View
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('listable') !!}
                            Should have Listing View
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success" name="submit">Create</button>

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