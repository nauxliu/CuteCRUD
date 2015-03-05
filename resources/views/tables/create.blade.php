@extends('layouts.master')

@section('styles')

<link href="/css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<link href="/css/datepicker/datepicker3.css" rel="stylesheet"/>
<link href="/css/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
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
        <li class="active">Create</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#user_create" data-toggle="tab">Create New Entry</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="user_create">

                        <div class="row margin">
                            <strong><p>New Entry</p></strong>
                            {!! Form::open(['url'=>'/table/'.$table->table_name.'/create','files'=>'true']) !!}
                            <div class="col-md-12">

                            @include('layouts.notifications')

                            @foreach($columns as $column)
                                @if($column->creatable==1)
                                @if($column->type=="text")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <input type="text" class="form-control" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" placeholder="Enter {!! $column->column_name !!}">
                                </div>
                                @endif

                                @if($column->type=="password")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <input name="{!! $column->column_name !!}" type="password" class="form-control" id="{!! $column->column_name !!}" placeholder="Enter {!! $column->column_name !!}">
                                </div>
                                @endif

                                @if($column->type=="number")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <input name="{!! $column->column_name !!}" type="number" class="form-control" id="{!! $column->column_name !!}" placeholder="Enter {!! $column->column_name !!}">
                                </div>
                                @endif

                                @if($column->type=="textarea")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <textarea name="{!! $column->column_name !!}" rows="10" cols="80" class="form-control" id="{!! $column->column_name !!}">Enter {!! $column->column_name !!}</textarea>
                                </div>
                                @endif

                                @if($column->type=="content_editor")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <textarea name="{!! $column->column_name !!}" rows="10" cols="80" class="form-control ckeditor" id="{!! $column->column_name !!}">Enter {!! $column->column_name !!}</textarea>
                                </div>
                                @endif

                                @if($column->type=="gender_full")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    Male <input class="form-control" type="radio" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="male"/>
                                    Female <input class="form-control" type="radio" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="female"/>
                                </div>
                                @endif

                                @if($column->type=="gender_short")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    Male <input class="form-control" type="radio" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="m"/>
                                    Female <input class="form-control" type="radio" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="f"/>
                                </div>
                                @endif

                                @if($column->type=="true_false")
                                <div class="form-group">
                                    <input class="form-control" type="checkbox" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="true"/>
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                </div>
                                @endif

                                @if($column->type=="one_or_zero")
                                <div class="form-group">
                                    <input class="form-control" type="checkbox" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="1"/>
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                </div>
                                @endif


                                @if($column->type=="range")
                                <div class="form-group">
                                    <label class="form-control" for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <input type="range" min="{!! $column->range_from !!}" max="{!! $column->range_to !!}" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}"/>
                                </div>
                                @endif

                                @if($column->type=="file")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <input class="form-control" type="file" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}"/>
                                </div>
                                @endif

                                @if($column->type=="date")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <input class="form-control datepickers" type="text" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}"/>
                                </div>
                                @endif

                                @if($column->type=="datetime")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <div class='input-group' id='datetimepickers'>
                                        <input id="{!! $column->column_name !!}" name="{!! $column->column_name !!}" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                @endif

                                @if($column->type=="time")
                                <div class="bootstrap-timepicker">
                                   <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                   <input type="text" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" class="form-control timepickers"
                                </div>
                                @endif

                                @if($column->type=="colorpicker")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <div class="input-group colorpickers">
                                        <input type="text" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" class="form-control"/>
                                        <div class="input-group-addon">
                                            <i></i>
                                        </div>
                                    </div><!-- /.input group -->
                                </div>
                                @endif

                                @if($column->type=="radio")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    @foreach($column->radios as $radio)
                                    {!! $radio->key !!} <input type="radio" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="{!! $radio->value !!}" class="form-control"/>
                                    @endforeach
                                </div>
                                @endif

                                @if($column->type=="checkbox")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    @foreach($column->checkboxes as $checkbox)
                                    {!! $checkbox->key !!}<input type="checkbox" name="{!! $column->column_name !!}" id="{!! $column->column_name !!}" value="{!! $checkbox->value !!}" class="form-control"/>
                                    @endforeach
                                </div>
                                @endif

                                @if($column->type=="select")
                                <div class="form-group">
                                    <label for="{!! $column->column_name !!}">{!! $column->column_name !!}</label>
                                    <select name="{!! $column->column_name !!}" class="form-control">
                                        @foreach($column->selects as $select)
                                            <option value="{!! $select->value !!}">{!! $select->key !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @endif
                            @endforeach

                            <button type="submit" class="btn btn-success">Create</button>

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

        @foreach($datetimepickers as $picker)
            $("#{!! $picker !!}").datetimepicker();
        @endforeach

        @foreach($timepickers as $picker)
            $("#{!! $picker !!}").datetimepicker({
                pickDate: false
            });
        @endforeach

        $(".colorpickers").colorpicker();

    });
</script>
@stop