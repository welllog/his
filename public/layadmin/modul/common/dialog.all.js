layui.define('layer', function (exports) {
    var layer = layui.layer,
        $ = layui.$;

    function Dialog () {}

    Dialog.prototype.success = function (msg, callable) {
        msg = msg || "操作成功";
        layer.alert(msg, {icon: 6}, function (index) {
            layer.close(index);
            callable && callable();
        })
    }

    Dialog.prototype.error = function (msg, callable) {
        msg = msg || "操作失败";
        layer.alert(msg, {icon: 5}, function (index) {
            layer.close(index);
            callable && callable();
        })
    }

    Dialog.prototype.load = function (msg) {
        return layer.msg(msg, {
            icon: 16
            , shade: 0.01
            , time: false
        });
    }

    Dialog.prototype.confirm = function (msg, callable1, callable2) {
        layer.confirm(msg, {btn: ["确定", "取消"]}, function (index) {
            layer.close(index);
            callable1();
        }, function (index) {
            layer.close(index);
            callable2 && callable2();
        })
    }

    Dialog.prototype.msg = function (msg) {
        return layer.msg(msg);
    }

    Dialog.prototype.okMsg = function (msg) {
        return layer.msg(msg, {icon: 1});
    }

    Dialog.prototype.erMsg = function (msg) {
        return layer.msg(msg, {icon: 2});
    }

    Dialog.prototype.open = function (title, content) {
        var index = layer.open({
            title: title,
            type: 2,
            content: content,
            success: function (layero, index) {
                setTimeout(function () {
                    layer.tips('点击此处返回', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                }, 500)

                layer.full(index);
                $(window).on("resize", resizeFun = function () {
                    layer.full(index);
                    layer.iframeAuto(index);
                });

            },
            cancel：function（index）{
                $(window).off("resize", resizeFun);
            }

        })
        
    }

    Dialog.prototype.pop = function (param) {
        // title, area, content, selector, end
        var wh = param.area || ['80%', '65%'];
        var title = param.title || false;
        var popIndex = layer.open({
            title: title,
            type: 2,
            content: param.content,
            shadeClose: true,
            shade: 0.8,
            area: wh,
            maxmin: true,
            success: function (layero, index) {
                setTimeout(function () {
                    layer.tips('点击此处返回', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                }, 500);
                if (param.selector) {
                    // selector为触发按钮的选择器
                    var ibtn = layer.getChildFrame(param.selector, popIndex);
                    ibtn.click(function () {
                        layer.close(popIndex);
                    });
                }
            },
            end: function () {  // 层被销毁时执行
                param.end && param.end();
            }
        })
    }

    Dialog.prototype.closeCurIf = function () {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }

    Dialog.prototype.modal = function (content, area, title) {
        area = area || ["420px", "240px"];
        title = title || false;
        return layer.open({type: 1, title: title, area: area, content: content})
    }

    Dialog.prototype.tips = function (msg, selector) {
        layer.tips(msg, selector, {tips: 3});
    }

    Dialog.prototype.prompt = function (tilte, callable) {
        layer.prompt({title: tilte, formType: 1}, function(val, index){
            layer.close(index);
            callable && callable(val);

        });
    }

    Dialog.prototype.text = function (tilte, callable) {
        layer.prompt({title: tilte, formType: 2}, function(val, index){
            layer.close(index);
            callable && callable(val);
        });
    }

    Dialog.prototype.close = function (index) {
        layer.close(index);
    }

    Dialog.prototype.closeAll = function (type) {
        // "dialog", "page", "iframe", "loading", "tips"
        type = type || '';
        layer.closeAll(type);
    }

    exports('dialog', new Dialog());
});
