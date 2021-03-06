@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            权限管理
            <small>路由管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="javascript:;">路由管理</a></li>
            <li class="active">路由列表</li>
        </ol>
    </section>
    <section class="content">
        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        {{--<h3 class="box-title">Responsive Hover Table</h3>--}}
                        <div class="box-actions">
                            <div class="btn-group pull-left" style="margin-right:10px;">
                                <button type="button" class="btn btn-default btn-sm">操作</button>
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="javascript:;" data-action="check-all">全部选中</a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:;" data-action="clear-all">全部清选</a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:;" data-href="{{ admUrl('/role/delete') }}"
                                           data-action="batch-del">批量删除</a></li>
                                </ul>
                            </div>
                            <a href="{{ admUrl('/router/data') }}" class="btn btn-default btn-sm pull-left"
                               style="margin-right:10px;">创建</a>
                            <a data-href="{{ admUrl('/router/delete') }}" class="btn btn-danger btn-sm pull-left"
                               data-action="batch-del">删除</a>
                        </div>
                        <div class="box-tools clearfix">
                            <form action="{{ admUrl('/router') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 180px;">
                                    <input type="text" name="keyword" value="{{ $req["keyword"] or '' }}"
                                           class="form-control pull-right" placeholder="搜索">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{ admUrl('/router') }}" class="btn btn-default">全部</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>路由名称</th>
                                <th>路由标记</th>
                                <th>请求方法</th>
                                <th>路由地址</th>
                                <th>查询参数</th>
                                <th>启用状态</th>
                                <th>排序</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                            </tr>
                            @foreach($list as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <a href="{{ admUrl('/router/data?id=' . $item->id) }}"
                                           title="编辑路由">{{ $item->name or '未命名' }}</a>
                                    </td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->method }}</td>
                                    <td>{{ $item->path }}</td>
                                    <td>{{ $item->query }}</td>
                                    <td>
                                        @if($item->status == 'T')
                                            <span class="label label-success">启用</span>
                                        @else
                                            <span class="label label-danger">禁用</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->sort }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                </tr>
                            @endforeach
                            @if($list->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">
                                        暂无数据
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {!! $page->render() !!}
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>
    </section>
@endsection