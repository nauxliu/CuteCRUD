<div class="form-group">
    {!! Form::label($column_name, $column_name) !!}
    <br/>
    {!! ''; $relation = $column->relationship !!}
    <p style="color: #FF7963;">Belongs to table '{!! $relation->table !!}', foreign key '{!! $relation->foreign_key
    !!}'.</p>
    {!! Form::text($column_name, array_get($cols, $column_name), ['class' => 'form-control']) !!}
</div>