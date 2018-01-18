layui.define('jquery', function(exports){
    var $ = layui.$;

    function His() {}

    His.prototype.ajax = function (config) {
        var async = (config.async == null) ? true : config.async;
        var contentType,data;
        if (config.contentType == 'form') {
            contentType = "application/x-www-form-urlencoded; charset=utf-8";
            data = config.data;
        } else {
            contentType = "application/json; charset=utf-8";
            data = JSON.stringify(config.data)
        }
        $.ajax({
            url: config.url,
            type: config.type,
            dataType: 'json',
            contentType: contentType,
            timeout: 2000,
            async: async,   // 默认同步
            data: data,
            complete: function () {
                config.complete && config.complete();
            },
            error: function(error){
                var errorInfo;
                if (!error.responseJSON.exception) {
                    if (error.status == 400) {
                        errorInfo = '请求错误';
                    } else if (error.status == 401) {
                        errorInfo = '未经认证的请求';
                    } else if (error.status == 403) {
                        errorInfo = '请求没有权限';
                    } else if (error.status == 404) {
                        errorInfo = '请求未找到';
                    } else if (error.status == 500) {
                        errorInfo = '服务异常';
                    } else if (error.status == 501) {
                        errorInfo = '服务未实现';
                    } else if (error.status == 0) {
                        errorInfo = '网络异常';
                    } else {
                        errorInfo = error.statusText
                    }
                } else {
                    errorInfo = error.responseJSON.exception;
                }
                config.error(errorInfo);
            },
            success: function(res){
                if (res.code != 0) {
                    config.error(res.exception);
                    return false;
                }
                config.success(res.msg, res.data, res.meta);
            }
        });
    }

    exports('his', new His());
});


