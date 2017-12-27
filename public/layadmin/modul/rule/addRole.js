layui.config({base: '/layadmin/modul/common/'}).use(['form','dialog','his'],function(){
    var form = layui.form,
        dialog = layui.dialog,
        his = layui.his;

    form.on("submit(addRole)",function(data){
        var loadIndex = dialog.load('数据提交中，请稍候');
        his.ajax({
            url: '/admin/role'
            ,type: 'post'
            ,data: data.field
            ,complete: function(){
                dialog.close(loadIndex);
            },
            error: function(msg){
                dialog.error(msg);
            },
            success: function(msg, data, meta){
                dialog.msg("添加成功！");
                dialog.closeAll("iframe");
                //刷新父页面
                parent.location.reload();
            }
        });
        return false;
    })

})