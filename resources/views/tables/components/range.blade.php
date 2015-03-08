<div class="form-group">
    {!! Form::label($column_name, $column_name) !!}
    <br/>

    {!! '';
        $range = $column->pairs()->first();
    !!}

    {!! Form::selectRange($column_name, $range->key, $range->value, array_get($cols, $column_name), ['class' => 'form-control']) !!}
</div>