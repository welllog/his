layui.config({base: '/layadmin/modul/common/'}).use(['form','dialog','his'],function(){
    var form = layui.form,
        dialog = layui.dialog,
        his = layui.his,
        $ = layui.jquery;

    form.verify({
        newPwd : function(value, item){
            if(value.length < 6){
                return "密码长度不能小于6位";
            }
        },
        confirmPwd : function(value, item){
            if(!new RegExp($("#oldPwd").val()).test(value)){
                return "两次输入密码不一致，请重新输入！";
            }
        }
    })

    form.on("submit(editPassword)",function(data){
        var index = dialog.load('数据提交中，请稍候');
        his.ajax({
            url: '/admin/user/password',
            type: 'put',
            data: data.field,
            complete: function () {
                dialog.close(index);
            },
            error: function (erMsg) {
                dialog.error(erMsg);
            },
            success: function (msg, data) {
                dialog.success('修改成功!', function () {
                    location.reload();
                })
            }
        });
    })

})