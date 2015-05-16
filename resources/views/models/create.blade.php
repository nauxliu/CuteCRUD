@extends('app')

@section('content')
    @include('layouts.content-header',['title' => 'Models', 'second' => '新建'])

    <form class="form-horizontal">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Modle 名</label>
            <div class="col-sm-8">
                <input type="email"  name="name" class="form-control" id="inputEmail3" placeholder="Model Name">
                <span id="helpBlock" class="help-block">为 Model 起个名字吧，它会显示在侧边栏上。</span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Table 名</label>
            <div class="col-sm-8">
                <input type="password" name="table" class="form-control" id="inputPassword3" placeholder="Table Name">
                <span id="helpBlock" class="help-block">填入其对应的 table 名</span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">主键</label>
            <div class="col-sm-8">
                <input type="password" name="needle" class="form-control" id="inputPassword3" placeholder="Needle">
                <span id="helpBlock" class="help-block">填入一个主键或唯一键 ( unique )</span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">功能</label>
            <div class="col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="creatable"> 可创建(Creatable)
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="listable"> 可列出(Listable)
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="editable"> 可编辑(Editable)
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">创建</button>
            </div>
        </div>
    </form>
@endsection