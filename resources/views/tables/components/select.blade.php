<div class="form-group">
    {!! Form::label($column_name, $column_name) !!}
    <br/>

    {!! '';
        $names = $column->pairs()->lists('key');
        $values = $column->pairs()->lists('value');
    !!}

    {!! Form::select($column_name, array_combine($values, $names), array_get($cols, $column_name), ['class' => 'form-control']) !!}
</div>