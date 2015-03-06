<div class="form-group">
    {!! Form::label($column_name, $column_name) !!}
    <br/>
    @foreach($column->pairs as $radio)
        @if(array_get($cols, $column_name) == $radio->value)
            {!! $radio->key !!}: {!! Form::radio($column_name, $radio->value, true) !!}
        @else
            {!! $radio->key !!}: {!! Form::radio($column_name, $radio->value, false) !!}
        @endif
        &nbsp;&nbsp;
    @endforeach
</div>