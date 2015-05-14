
<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">Models</a>
        </li>
        @foreach($models as $model)
        <li><a href="#">{{$model->name}}</a></li>
        @endforeach
    </ul>
</div>
<!-- /#sidebar-wrapper -->