# wlsh-framework
> 名词解释：wlsh（ 为了生活---每个字的第一个拼音 ）

酷毙的码农为了生活自由，基于composer整合yaf框架与swoole等扩展，开发的php内存长驻框架
，低耦合，使用非常少的语法糖，尽量使用原有扩展中的语法。

> wlsh-framework框架使用最低要求：必须已安装php 7.2，yaf 3.0.5框架，swoole 2.0.10扩展。

运行：在命令行下进入框架根目录中：php server.php 默认 http://127.0.0.1:9501

application/library/HttpServer.php 该类是wlsh-framework的核心所在，是基于swoole的服务器。

> wlsh-framework是可以直接独立运行，不依赖于apache，nginx等服务器。其独立运行性能高于其它服务器。

```

catfan/Medoo扩展中第293行修改,增加mysql数据库断线重启基于swoole实现的pdo连接池

if(!$statement->execute()){
    //断线重启pdo连接池
    if( !empty($statement->errorInfo()[1]) &&  $statement->errorInfo()[1] == '2006'){
        \Yaf\Registry::get('http')->reload();
    }
}

```

> 还在更新整理中 2017-12-14 勿使用