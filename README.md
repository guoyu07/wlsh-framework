# wlsh-framework
> 名词解释：wlsh（ 为了生活---每个字的第一个拼音 ）

酷毙的码农为了生活自由，基于composer整合yaf框架与swoole等扩展，开发的php内存长驻框架
，低耦合，使用非常少的语法糖，尽量使用原有扩展中的语法，提供最优状态以减少PHPer学习新框架的成本。

### 基本要求
对于使用wlsh-framework的开发者，需要掌握swoole基本的理念，熟悉yaf框架，熟悉composer用法及理念。对于这三点要求，我想PHPer应很容易达到。

> wlsh-framework框架启动最低要求：必须已安装php 7.2，yaf 3.0.5框架，swoole 2.0.10扩展。

### 使用对象

个人php开发者，php小团队小项目，百万以下级别的项目，拿来试验玩玩的项目等，能使你的这些项目用低配的机器开发出同类框架所比不了的性能。

### 安装

git clone https://github.com/hanhyu/wlsh-framework.git
或
composer create-project hanhyu/wlsh-framework wlsh dev-master


### 运行

在命令行下进入框架根目录中执行：php server.php  默认路由： http://127.0.0.1:9501

目录application/library/HttpServer.php 该类是wlsh-framework的核心所在，基于swoole的服务器，业务部分由yaf完成操作。

> wlsh-framework是可以直接独立运行，不依赖于apache，nginx等服务器。其独立运行性能远高于其它服务器。

###扩展

wlsh-framework中初始状态只加入了两个基本的扩展：一个模板引擎twig扩展，一个PHP数据库框架medoo扩展; 其他扩展可根据自己
使用的场景不同用composer require 安装自己想用的扩展。

> 为什么不使用数据库orm框架，作者做过大量测试，使用orm时运行的性能非常低下，且会增加PHPer学习成本。所以推荐使用基本的pdo扩展就足够用了。
找了很多扩展最后发现medoo扩展是基于pdo开发的，且测试性能基本与原生pdo性能一致。当然，更推荐直接使用sql语句开发，
我们酷毙的码农不缺的就是时间，使用orm快速开发省下来的时间跟带来的性能比较，时间是唯不足道的，一天上班8小时，
使用orm写代码与使用sql写代码的时间对比可以忽略不计，当然对于那些写一个复杂点的sql就需要一整天时间的开发人员来说也不用气馁，
酷毙的码农只有时间不缺，我们缺的只有RMB。

###注意事项

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