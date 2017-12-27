@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">用户组名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="name" lay-verify="required" placeholder="请输入用户组名称">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit type="button" lay-filter="addRole">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")
	<script type="text/javascript" src="/layadmin/modul/rule/addRole.js"></script>
@endsection
