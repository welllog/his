@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:60%;">
		<div class="layui-form-item">
			<label class="layui-form-label">用户组</label>
			<div class="layui-input-block">
				@foreach($roles as $role)
					<input type="checkbox" class="user_group" name="role_id[]" title="{{$role['name']}}" value="{{$role['id']}}" @if($role['checked']) checked @endif">
				@endforeach
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">用户名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="username" value="{{$admin['username']}}" lay-verify="required" placeholder="请输入用户名">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">邮箱</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="email" value="{{$admin['email']}}" lay-verify="email" placeholder="请输入邮箱">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">手机号</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="tel" value="{{$admin['tel']}}" lay-verify="required" placeholder="请输入手机号">
			</div>
		</div>
		<input type="hidden" name="id" value="{{$admin['id']}}">
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button type="button" class="layui-btn" lay-submit lay-filter="editUser">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")
	<script type="text/javascript" src="/layadmin/modul/rule/editUser.js"></script>
@endsection
