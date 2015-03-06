@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#general_table_settings" data-toggle="tab">General Table
                                Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="general_table_settings">

                            @include('layouts.notifications')

                            <div class="row margin">
                                <strong><p>Table Configuration</p></strong>
                                @if(isset($columns))
                                    {!! Form::open(['url'=>'/table/'.$table.'/settings']) !!}

                                    <button type="submit" class="btn btn-success">Save Changes</button>

                                    {{--<input type="hidden" name="table_name" value="{!! $table !!}"/>--}}

                                    @foreach($columns as $column)
                                        <hr>
                                        <h4>Column Name : {!! $column->column_name !!}</h4>
                                        <input type="hidden" name="columns[]" value="{!! $column->column_name !!}"/>

                                        <div class="row">
                                            <div class="col-md-3"><strong>
                                                    <small>Type</small>
                                                </strong></div>
                                            <div class="col-md-3"><strong>
                                                    <small>Validator</small>
                                                </strong></div>
                                            <div class="col-md-2"><strong>
                                                    <small>In Create Form</small>
                                                </strong></div>
                                            <div class="col-md-2"><strong>
                                                    <small>In Edit Form</small>
                                                </strong></div>
                                            <div class="col-md-2"><strong>
                                                    <small>In Listing Table</small>
                                                </strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control column_type"
                                                        data-column="{!! $column->column_name !!}"
                                                        name="{!! $column->column_name !!}[type]">
                                                    <!--Radio Checkbox Select Range-->
                                                    <option {!! $column->type=="text"?"selected":"" !!} value="text">
                                                        Text
                                                    </option>
                                                    <option {!! $column->type=="password"?"selected":"" !!}
                                                            value="password">Password
                                                    </option>
                                                    <option {!! $column->type=="number"?"selected":"" !!}value="number">
                                                        Number
                                                    </option>
                                                    <option {!! $column->type=="text_area"?"selected":"" !!}
                                                            value="text_area">Normal Textarea
                                                    </option>
                                                    <option {!! $column->type=="content_editor"?"selected":"" !!}
                                                            value="content_editor">Content Editor
                                                    </option>
                                                    <option {!! $column->type=="gender_full"?"selected":"" !!}
                                                            value="gender_full">Gender(Returns male/female)
                                                    </option>
                                                    <option {!! $column->type=="gender_short"?"selected":"" !!}
                                                            value="gender_short">Gender(Returns m/f)
                                                    </option>
                                                    <option {!! $column->type=="true_false"?"selected":"" !!}
                                                            value="true_false">True/False
                                                    </option>
                                                    <option {!! $column->type=="one_or_zero"?"selected":"" !!}
                                                            value="one_or_zero">1/0
                                                    </option>
                                                    <option {!! $column->type=="range"?"selected":"" !!} value="range">
                                                        Range
                                                    </option>
                                                    <option {!! $column->type=="file"?"selected":"" !!} value="file">
                                                        File
                                                    </option>
                                                    <option {!! $column->type=="date"?"selected":"" !!} value="date">
                                                        Date
                                                    </option>
                                                    <option {!! $column->type=="time"?"selected":"" !!} value="time">
                                                        Time
                                                    </option>
                                                    <option {!! $column->type=="datetime"?"selected":"" !!}
                                                            value="datetime">DateTime
                                                    </option>
                                                    <option {!! $column->type=="colorpicker"?"selected":"" !!}
                                                            value="colorpicker">Color Picker
                                                    </option>
                                                    <option {!! $column->type=="radio"?"selected":"" !!} value="radio">
                                                        Radio
                                                    </option>
                                                    <option {!! $column->type=="checkbox"?"selected":"" !!}
                                                            value="checkbox">Checkbox
                                                    </option>
                                                    <option {!! $column->type=="select"?"selected":"" !!}value="select">
                                                        Select
                                                    </option>
                                                </select>

                                                <div id="{!! $column->column_name !!}[range]" style="display:none;">
                                                    <input type="text" name="{!! $column->column_name !!}[range_from]"
                                                           value="{!! $column->type=='radio'?$column->range_from:'' !!}"
                                                           class="form-control"
                                                           placeholder="Range From"/>
                                                    <input type="text" name="{!! $column->column_name !!}[range_to]"
                                                           value="{!! $column->type=='radio'?$column->range_to:'' !!}"
                                                           class="form-control"
                                                           placeholder="Range To"/>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="{!! $column->column_name
                                    !!}[create_rule]" value="{!! $column->create_rule !!}"
                                                       placeholder="Create Validation Rule">
                                                <input type="text" class="form-control" name="{!! $column->column_name
                                    !!}[edit_rule]" value="{!! $column->edit_rule !!}"
                                                       placeholder="Edit Validation Rule">
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-control"
                                                        name="{!! $column->column_name !!}[creatable]">
                                                    <option {!! $column->creatable==1?"selected":"" !!} value="1">Show
                                                    </option>
                                                    <option {!! $column->creatable==0?"selected":"" !!} value="0">Don't
                                                        Show
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-control"
                                                        name="{!! $column->column_name !!}[editable]">
                                                    <option {!! $column->editable==1?"selected":"" !!} value="1">Show
                                                    </option>
                                                    <option {!! $column->editable==0?"selected":"" !!}
                                                            value="0">Don't Show
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-control"
                                                        name="{!! $column->column_name !!}[listable]">
                                                    <option {!! $column->listable==1?"selected":"" !!} value="1">Show
                                                    </option>
                                                    <option {!! $column->listable==0?"selected":"" !!}
                                                            value="0">Don't Show
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="{!! $column->column_name !!}_radio" {!! $column->type=="radio"?"":"style='display:none;'" !!}>
                                            <button data-column="{!! $column->column_name !!}"
                                                    class="btn btn-primary btn-sm radio_add">+ Radio
                                            </button>
                                            @if($column->type=="radio")
                                                @foreach($column->radios as $radio)
                                                    <div class='row margin'>
                                                        <div class='col-md-4'>
                                                            <input type='text'
                                                                   name='{!! $column->column_name !!}[radio][names][]'
                                                                   required class='form-control'
                                                                   placeholder='{!! $radio->key !!}'
                                                                   value="{!! $radio->key !!}">
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <input type='text'
                                                                   name='{!! $column->column_name !!}[radio][values][]'
                                                                   required class='form-control'
                                                                   placeholder='{!! $radio->value !!}'
                                                                   value="{!! $radio->value !!}">
                                                        </div>
                                                        <div class='col-md-1'>
                                                            <button onclick='radio_delete(this)'
                                                                    class='btn btn-danger btn-sm'>-
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div id="{!! $column->column_name !!}_checkbox" {!! $column->type=="checkbox"?"":"style='display:none;'" !!}>
                                            <button data-column="{!! $column->column_name !!}"
                                                    class="btn btn-primary btn-sm checkbox_add">+
                                                Checkbox
                                            </button>
                                            @if($column->type=="checkbox")
                                                @foreach($column->checkboxes as $checkbox)
                                                    <div class='row margin'>
                                                        <div class='col-md-4'>
                                                            <input type='text'
                                                                   name='{!! $column->column_name !!}[checkbox][names][]'
                                                                   required class='form-control'
                                                                   placeholder='{!! $checkbox->key !!}'
                                                                   value="{!! $checkbox->key !!}">
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <input type='text'
                                                                   name='{!! $column->column_name !!}[checkbox][values][]'
                                                                   required class='form-control'
                                                                   placeholder='{!! $checkbox->value !!}'
                                                                   value="{!! $checkbox->value !!}">
                                                        </div>
                                                        <div class='col-md-1'>
                                                            <button onclick='checkbox_delete(this)'
                                                                    class='btn btn-danger btn-sm'>-
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div id="{!! $column->column_name !!}_select" {!! $column->type=="select"?"":"style='display:none;'" !!}>
                                            <button data-column="{!! $column->column_name !!}"
                                                    class="btn btn-primary btn-sm select_add">+ Select
                                                Option
                                            </button>
                                            @if($column->type=="select")
                                                @foreach($column->selects as $select)
                                                    <div class='row margin'>
                                                        <div class='col-md-4'>
                                                            <input type='text'
                                                                   name='{!! $column->column_name !!}[select][names][]'
                                                                   required
                                                                   class='form-control'
                                                                   placeholder='{!! $select->key !!}'
                                                                   value="{!! $select->key !!}">
                                                        </div>
                                                        <div class='col-md-4'>
                                                            <input type='text'
                                                                   name='{!! $column->column_name !!}[select][values][]'
                                                                   required
                                                                   class='form-control'
                                                                   placeholder='{!! $select->value !!}'
                                                                   value="{!! $select->value !!}">
                                                        </div>
                                                        <div class='col-md-1'>
                                                            <button onclick='select_delete(this)'
                                                                    class='btn btn-danger btn-sm'>-
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    @endforeach

                                    <button type="submit" class="btn btn-success">Save Changes</button>

                                    {!! Form::close() !!}
                                @endif
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
    <script type="text/javascript">

        function radio_delete(ele) {
            console.log('Removing radio');
            console.log($(ele));
            $(ele).parent().parent().remove();
        }

        function checkbox_delete(ele) {
            console.log('Removing checkbox');
            console.log($(ele));
            $(ele).parent().parent().remove();
        }

        function select_delete(ele) {
            console.log('Removing select');
            console.log($(ele));
            $(ele).parent().parent().remove();
        }

        $(document).ready(function () {

            $('.column_type').on('change', function () {
                var column_name = $(this).data('column');
                var selected = $(this).find('option:selected').val();

                $('#' + column_name + '_radio').hide();
                $('#' + column_name + '_range').hide();
                $('#' + column_name + '_checkbox').hide();
                $('#' + column_name + '_select').hide();

                if (selected == "radio") {
                    $('#' + column_name + '_radio').show();
                }

                if (selected == "range") {
                    $('#' + column_name + '_range').show();
                }

                if (selected == "checkbox") {
                    $('#' + column_name + '_checkbox').show();
                }

                if (selected == "select") {
                    $('#' + column_name + '_select').show();
                }
            });

            $('.radio_add').on('click', function () {
                var column_name = $(this).data('column');
                $('#' + column_name + '_radio').show();
                $('#' + column_name + '_radio').append("<div class='row margin'><div class='col-md-4'><input " +
                "type='text' name='" + column_name + "[radio][names][]' required class='form-control' " +
                "placeholder='Name'></div>" +
                "<div class='col-md-4'><input type='text' name='" + column_name + "[radio][values][]'  required " +
                "class='form-control' placeholder='Value'></div>" +
                "<div class='col-md-1'><button onclick='radio_delete(this)' class='btn btn-danger btn-sm'>-</button></div></div>");
            });

            $('.checkbox_add').on('click', function () {
                var column_name = $(this).data('column');
                $('#' + column_name + '_checkbox').show();
                $('#' + column_name + '_checkbox').append("<div class='row margin'><div class='col-md-4'><input " +
                "type='text' name='" + column_name + "[checkbox][names][]' required class='form-control' " +
                "placeholder='Name'></div>" +
                "<div class='col-md-4'><input type='text' name='" + column_name + "[checkbox][values][]'  required " +
                "class='form-control' placeholder='Value'></div>" +
                "<div class='col-md-1'><button onclick='checkbox_delete(this)' class='btn btn-danger btn-sm'>-</button></div></div>");
            });

            $('.select_add').on('click', function () {
                var column_name = $(this).data('column');
                $('#' + column_name + '_select').show();
                $('#' + column_name + '_select').append("<div class='row margin'><div class='col-md-4'><input " +
                "type='text' name='" + column_name + "[select][names][]' required class='form-control' " +
                "placeholder='Name'></div>" +
                "<div class='col-md-4'><input type='text' name='" + column_name + "[select][values][]'  required " +
                "class='form-control' placeholder='Value'></div>" +
                "<div class='col-md-1'><button onclick='select_delete(this)' class='btn btn-danger btn-sm'>-</button></div></div>");
            });

        });
    </script>
@stop