@extends("admin.layout.main")

@section("css")
	<link rel="stylesheet" href="/layadmin/extra/treegrid/css/jquery.treegrid.css" media="all" />
@endsection

@section("content")
	<blockquote class="layui-elem-quote news_search">
		<div class="layui-inline">
			<a class="layui-btn ruleAdd_btn" style="background-color:#5FB878">添加权限</a>
		</div>
		<div class="layui-inline">
			<div class="layui-form-mid layui-word-aux">&nbsp;&nbsp;&nbsp;&nbsp;权限更改后,需要所有后台用户重新登录才会立即生效</div>
		</div>
	</blockquote>
	<div class="layui-form links_list">
	  	<table class="layui-table tree">
		    <colgroup>
				<col width="100px">
				<col width="">
				<col>
				<col>
				<col width="20px">
				<col width="20px">
				<col width="7%">
				<col width="">
		    </colgroup>
		    <thead>
				<tr>
					<th>#</th>
					<th style="text-align:left;">权限名称</th>
					<th style="text-align:left;">链接</th>
					<th style="text-align:left;">控制器@方法</th>
					<th>是否验证权限</th>
					<th>是否显示</th>
					<th>排序</th>
					<th>操作</th>
				</tr> 
		    </thead>
		    <tbody class="links_content">
			@foreach ($rules as $rule)
				<tr class="treegrid-{{$rule['id']}} @if($rule['pid']!=0) treegrid-parent-{{$rule['pid']}} @endif">
					<td>{{ $rule['id'] }}</td>
					<td style="text-align:left;">{{ $rule['ltitle'] }}</td>
					<td style="text-align:left;">{{ $rule['href'] }}</td>
					<td style="text-align:left;">{{ $rule['rule'] }}</td>
					<td>
						<input data-id="{{$rule['id']}}" type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="isCheck"
							   @if ($rule['check'] == 1) checked @endif>
					</td>
					<td>
						<input data-id="{{$rule['id']}}" type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="isShow"
							   @if ($rule['status'] == 1) checked @endif>
					</td>
					<td>
						<input data-id="{{$rule['id']}}" type="text" class="layui-input sort_input"  value="{{$rule['sort']}}">
					</td>
					<td>
						<a data-id="{{$rule['id']}}" class="layui-btn layui-btn-xs rule_edit">
							<i class="layui-icon">&#xe642;</i>
							编辑
						</a>
						<a data-id="{{$rule['id']}}" class="layui-btn layui-btn-danger layui-btn-xs rule_del">
							<i class="layui-icon"></i>
							删除
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section("js")
	<script type="text/javascript" src="/layadmin/modul/common/jquery.min.js"></script>
	<script type="text/javascript" src="/layadmin/extra/treegrid/js/jquery.treegrid.js"></script>
	<script type="text/javascript" src="/layadmin/modul/rule/rules.js"></script>
@endsection

