# 该项目已替换为https://github.com/welllog/orinfyAdmin
## his基于*laravel5.5* 跟 *layui2.2* 的极简后台（只有登录和权限）

***
### 项目示例地址
[his.orinfy.com/admin](http://his.orinfy.com/admin)

|账号|密码|
|:--:|:--:|
|admin|admin888|


### 安装步骤

1. 下载或克隆项目，进入项目根目录执行``composer install``,等待框架安装
2. 将.env.example修改为.env,并进行相关配置,然后在项目根目录执行``php artisan key:generate``
3. 手动创建数据库,执行``php artisan migrate:refresh --seed``迁移数据库表结构和数据
4. 配置好环境即可运行

### 注意事项
* 需要环境为php>7。
* 默认配置使用了redis及phpredis扩展，可自行更改相应配置
* 目前仅实现了后台登录及权限功能
* 后台路由: domain/admin

### 感谢
* 后台ui是在BrotherMa的layuicms上稍作修改而来，[layuicms地址](https://github.com/BrotherMa/layuiCMS)
* [layui文档地址](http://www.layui.com/doc/)
* [laravel社区地址](https://laravel-china.org/)

### 
**项目主要是自己学习用，如果发现bug,可发送邮件至2531072685@qq.com联系我**




