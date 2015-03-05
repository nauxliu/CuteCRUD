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

        <a href="/table/{!! $table->table_name !!}/create" class="btn btn-success btn-lg margin">Create New Entry</a>
        <!-- /.box-header -->
        <div class="box-body table-responsive">

            @include('layouts.notifications')

            <table id="crud_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{!! $header !!}</th>
                    @endforeach
                    @if($table->editable)
                        <th>Edit</th>
                    @endif
                        <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<sizeOf($rows);$i++)
                <tr>
                    <input type="hidden" name="position" value="{!! $i !!}"/>
                    @for($j=0;$j<sizeOf($rows[$i]);$j++)
                        <td>{!!  $rows[$i][$headers[$j]]  !!}</td>
                    @endfor
                    @if($table->editable)
                    <td><a href="/table/{!! $table->table_name !!}/edit/{!! $ids[$i] !!}" class="btn btn-success btn-sm">Edit</a></td>
                    @endif
                    <td><a href="/table/{!! $table->table_name !!}/delete/{!! $ids[$i] !!}" class="btn btn-warning btn-sm">Delete</a></td>
                </tr>
                @endfor
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