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
        <li><a href="{!! route('index') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>

        {!! Form::open([
            'url' => route('table.delete_many',  $table->table_name),
            'method' => 'delete'])
        !!}

        <a href="{!! route('table.create', $table->table_name) !!}" class="btn btn-success btn-lg margin">Create New
            Entry</a>
        <button class="btn btn-warning">Delete Selected</button>
        <!-- /.box-header -->
        <div class="box-body table-responsive">

            @include('layouts.notifications')

            <table id="crud_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                        {{--<th width="10"><button class="btn btn-sm btn-info" id="select_all">Select All</button></th>--}}
                        <th width="10"><input type="checkbox" id="select_all"/></th>
                    @foreach($columns_names as $name)
                        <th>{!! $name !!}</th>
                    @endforeach
                    @if($table->editable)
                        <th width="70">Edit</th>
                    @endif
                        <th width="70">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($columns as $key => $column)
                <tr>
                        <td>{!! Form::checkbox('needles[]', $needles[$key]) !!}</td>
                    @foreach($column as $item)
                        <td>{!!  $item  !!}</td>
                    @endforeach
                    @if($table->editable)
                        <td><a href="{!! route('table.edit', [$table->table_name, $needles[$key]]) !!}" class="btn
                        btn-success btn-sm center-block">Edit</a></td>
                    @endif
                        <td><a href="{!! route('table.delete', [$table->table_name, $needles[$key]]) !!}" class="btn
                        btn-warning btn-sm center-block">Delete</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->

        {!! Form::close() !!}

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
<script>
    $('#select_all').on('ifChecked', function(){
        $("input[name='needles[]']").iCheck('check');
    });
    $('#select_all').on('ifUnchecked', function(){
        $("input[name='needles[]']").iCheck('uncheck');
    });

</script>
@stop