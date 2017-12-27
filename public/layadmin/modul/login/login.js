layui.config({base: '/layadmin/modul/common/'}).use(['form', 'dialog', 'his'],function(){
    var form = layui.form,
        $ = layui.jquery,
        dialog = layui.dialog,
        his = layui.his;

    // 验证码刷新
    $('#captcha').click(function(){
        $(this).attr('src', '/admin/captcha/' + Math.random());
    });

    function flushForm () {
        $('#captcha').attr('src', '/admin/captcha/' + Math.random());
        $('[name="password"]').val('');
        $('[name="code"]').val('');
    }

    //登录按钮事件
    form.on("submit(login)",function(data){
        his.ajax({
            url: '/admin/login',
            type: 'POST',
            data: data.field,
            error: function (errMsg) {
                dialog.error(errMsg, flushForm);
            },
            success: function (msg, data) {
                top.location.href='/admin/index';
                dialog.msg('登录成功,正在为您跳转');
            }
        });
        return false;
    })
})