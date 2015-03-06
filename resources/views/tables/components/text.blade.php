<div class="form-group">
    {!! Form::label($column_name, $column_name) !!}
    {!! Form::text($column_name, array_get($cols, $column_name),['class' => 'form-control', 'placeholder' => "Enter {$column_name}"]) !!}
</div>