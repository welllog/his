@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">父级</label>
			<div class="layui-input-block">
				<select name="pid">
					<option value="0">默认顶级</option>
					@foreach($rules as $rule)
					<option data-level="{{$rule['level']}}" value="{{$rule['id']}}">{{$rule['ltitle']}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">权限名称</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入权限名称">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">链接</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="href" placeholder="/rules">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">控制器@方法</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="rule" placeholder="RuleController@rules">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">图标</label>
			<div class="layui-input-inline">
				<input type="text" class="layui-input" name="icon" placeholder="">
			</div>
			<p>icon图标参考<mark><a href="http://www.layui.com/doc/element/icon.html">layui</a></mark></p>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" type="button" lay-submit lay-filter="addRule">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")
	<script type="text/javascript" src="/layadmin/modul/rule/addRule.js"></script>
@endsection
