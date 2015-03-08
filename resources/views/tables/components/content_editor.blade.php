<div class="form-group">
    {!! Form::label($column_name, $column_name) !!}
    <textarea name="{!! $column_name !!}" rows="10" cols="80" class="form-control ckeditor"
              id="{!! $column_name !!}">{!! array_get($cols, $column_name) !!}</textarea>
</div>