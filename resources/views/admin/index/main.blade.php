@extends("admin.layout.main")

@section("content")
    <div class="row" style="margin-top: 50px;">
        <div>
            <blockquote class="layui-elem-quote title">系统基本参数</blockquote>
            <table class="layui-table">
                <tbody>
                <tr>
                    <td>网站域名</td>
                    <td class="host">{{$system_info['url']}}</td>
                </tr>
                <tr>
                    <td>网站ip</td>
                    <td class="ip">{{$system_info['server_ip']}}</td>
                </tr>
                <tr>
                    <td>web环境</td>
                    <td class="server">{{$system_info['server_soft']}}</td>
                </tr>
                <tr>
                    <td>PHP版本</td>
                    <td class="server">{{$system_info['php_version']}}</td>
                </tr>
                <tr>
                    <td>mysql版本</td>
                    <td class="dataBase">{{$system_info['mysql_version']}}</td>
                </tr>
                <tr>
                    <td>redis版本</td>
                    <td class="dataBase">{{$system_info['redis_version']}}</td>
                </tr>
                <tr>
                    <td>最大上传限制</td>
                    <td class="maxUpload">{{$system_info['max_upload_size']}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("js")
<script type="text/javascript">
    layui.use('jquery', function () {
        var $ = layui.$;

//        $(".panel a").on("click",function(){
//            top.addTab($(this));
//        })
    })


</script>
@endsection
