layui.config({base: '/layadmin/modul/common/'}).use(['form','dialog','his'],function(){
    var form = layui.form,
        dialog = layui.dialog,
        his = layui.his,
        $ = layui.$;

    form.on("submit(editUser)",function(data){
        if ($('.user_group:checked').length == 0) dialog.msg('请选择用户组');
        var loadIndex = dialog.load('数据提交中，请稍候');
        his.ajax({
            url: '/admin/user'
            ,type: 'put'
            ,data: data.field
            ,contentType: 'form'
            ,complete: function () {
                dialog.close(loadIndex);
            }
            ,error: function (msg) {
                dialog.error(msg);
            }
            ,success: function (msg, data, meta) {
                dialog.msg('更新成功！');
                dialog.closeAll('iframe');
                parent.location.reload();
            }
        });

    })

})