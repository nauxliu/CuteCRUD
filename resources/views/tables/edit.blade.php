@extends('layouts.master')

@section('styles')

<link href="/css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<link href="/css/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<link href="/css/datepicker/datepicker3.css" rel="stylesheet"/>
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
        <li class="active">Edit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#user_create" data-toggle="tab">Edit Entry</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="user_create">

                        <div class="row margin">
                            <strong><p>Edit Entry</p></strong>
                            {!! Form::open(['url'=>'/table/'.$table.'/update/'.$needle,'files'=>'true']) !!}
                            <div class="col-md-12">

                            @include('layouts.notifications')

                            @foreach($columns as $column)
                                {!! '';$column_name = $column->column_name !!}

                                @if($column->creatable)
                                    @include('tables.components.'.$column->type)
                                @endif
                            @endforeach

                            <button type="submit" class="btn btn-success">Update</button>
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

@section('scripts')
<script src="/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="/js/moment.min.js" type="text/javascript"></script>
<script src="/js/plugins/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {

        $(".datepickers").datepicker();

        {{--@foreach($datetimepickers as $picker)--}}
        {{--$("#{!! $picker !!}").datetimepicker();--}}
        {{--@endforeach--}}

        {{--@foreach($timepickers as $picker)--}}
        {{--$("#{!! $picker !!}").datetimepicker({--}}
            {{--pickDate: false--}}
        {{--});--}}
        {{--@endforeach--}}

        $(".colorpickers").colorpicker();

    });
</script>
@stop