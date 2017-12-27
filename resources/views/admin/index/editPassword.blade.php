@extends("admin.layout.main")

@section("css")
	<style type="text/css">
		.layui-form {margin: 10px 40px; width: 60%;}
	</style>
@endsection

@section("content")
	<form class="layui-form layui-form-pane">
		<div class="layui-form-item">
			<label class="layui-form-label">旧密码</label>
			<div class="layui-input-block">
				<input type="password" name="oldpwd" value="" placeholder="请输入旧密码" lay-verify="required" class="layui-input pwd">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">新密码</label>
			<div class="layui-input-block">
				<input type="password" name="newpwd" value="" placeholder="请输入新密码" lay-verify="required|newPwd" id="oldPwd" class="layui-input pwd">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">确认密码</label>
			<div class="layui-input-block">
				<input type="password" name="pwdconfirm" value="" placeholder="请确认密码" lay-verify="required|confirmPwd" class="layui-input pwd">
			</div>
		</div>
		{{ csrf_field() }}
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button type="button" class="layui-btn" lay-submit lay-filter="editPassword">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")
	<script type="text/javascript" src="/layadmin/modul/index/editPassword.js"></script>
@endsection
