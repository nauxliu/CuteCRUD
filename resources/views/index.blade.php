@extends('layouts.master')

@section('styles')
<link href="/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>

        <a href="/crud/create" class="btn btn-success btn-lg margin">Create New CRUD</a>
        <!-- /.box-header -->
        <div class="box-body table-responsive">

            @include('layouts.notifications')

            <table id="crud_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>CRUD Name</th>
                    <th>Table Name</th>
                    <th>Font Awesome Class</th>
                    <th>Unique/Primary Column</th>
                    <th>Creatable</th>
                    <th>Editable</th>
                    <th>Listable</th>
                    <th>Created On</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                <tr>
                    <td>{!! $row->id !!}</td>
                    <td>{!! $row->crud_name !!}</td>
                    <td>{!! $row->table_name !!}</td>
                    <td>{!! $row->fontawesome_class !!}</td>
                    <td>{!! $row->needle !!}</td>
                    <td>{!! $row->creatable !!}</td>
                    <td>{!! $row->editable !!}</td>
                    <td>{!! $row->listable !!}</td>
                    <td>{!! $row->created_at !!}</td>
                    <td><a href="/crud/edit/{!! $row->id !!}" class="btn btn-success btn-sm">Edit</a></td>
                    <td><a href="/crud/delete/{!! $row->id !!}" class="btn btn-warning btn-sm">Delete</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section><!-- /.content -->
@stop

@section('scripts')
<script src="/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#crud_list').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
@stop