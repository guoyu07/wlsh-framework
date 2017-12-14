#wlsh-framework
> 名词解释：wlsh（ 为了生活---每个字的第一个拼音 ）

酷毙的码农为了生活自由，基于composer整合yaf框架与swoole等扩展，开发的php内存长驻框架
，低耦合，使用非常少的语法糖，尽量使用原有扩展中的语法。

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