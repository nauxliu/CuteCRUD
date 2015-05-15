@extends('app')

@section('content')
    @include('layouts.content-header',['title' => 'Models'])
    <div id="toolbar" class="btn-group">
        <button type="button" class="btn btn-default">
            <i class="glyphicon glyphicon-plus"></i> 添加
        </button>
    </div>
    <table id="table"
           data-toggle="table"
           data-search="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-toolbar="#toolbar">
        <thead>
        <tr>
            <th data-field="id">Id</th>
            <th data-field="name">Model 名</th>
            <th data-field="table">table 名</th>
            <th data-field="needle">主键</th>
            <th data-field="creatable" data-cell-style="yesNoCellStyle" data-align="center">可创建</th>
            <th data-field="editable" data-cell-style="yesNoCellStyle" data-align="center">可编辑</th>
            <th data-field="listable" data-cell-style="yesNoCellStyle" data-align="center">可列出</th>
            <th data-field="created_at" data-align="center">创建时间</th>
            <th data-width="100" data-align="center">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($models as $model)
            <tr>
                <td>{{ $model->id }}</td>
                <td>{{ $model->name }}</td>
                <td>{{ $model->table }}</td>
                <td>{{ $model->needle }}</td>
                <td>{{ $model->creatable }}</td>
                <td>{{ $model->editable }}</td>
                <td>{{ $model->listable }}</td>
                <td>{{ $model->created_at }}</td>
                <td>
                    <button class="btn btn-warning btn-xs">编辑</button>
                    <button class="btn btn-danger btn-xs">删除</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection