<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>登录--his</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/layadmin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/layadmin/modul/login/login.css" media="all" />
</head>
<body>
<img class="bgpic" src="/layadmin/modul/login/bg.jpg">
<div class="login">
    <h1>his-后台登录</h1>
    <form class="layui-form">
        <div class="layui-form-item">
            <input class="layui-input" name="username" placeholder="用户名" lay-verify="required" type="text" autocomplete="off">
        </div>
        <div class="layui-form-item">
            <input class="layui-input" name="password" placeholder="密码" lay-verify="required" type="password" autocomplete="off">
        </div>
        <div class="layui-form-item form_code">
            <input class="layui-input" name="code" placeholder="验证码" lay-verify="required" type="text" autocomplete="off">
            <div class="code"><img id="captcha" src="{{url('/admin/captcha')}}" width="116" height="36"></div>
        </div>
        <div class="layui-form-item remember_me">
            <label class="layui-form-label">记住我</label>
            <div class="layui-input-block">
                <input type="checkbox" name="remember" lay-skin="switch">
            </div>
        </div>
        {{ csrf_field() }}
        <button type="button" class="layui-btn login_btn" lay-submit lay-filter="login">登录</button>
    </form>
</div>
<script type="text/javascript" src="/layadmin/layui/layui.js"></script>
<script type="text/javascript" src="/layadmin/modul/login/login.js"></script>
</body>
</html>