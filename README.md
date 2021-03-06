## The Phalcon Framework

##### A full-stack PHP framework delivered as a C-extension
##### 一个基于Phalcon开箱即用的API框架


### 简述
- 由于是用来写API的，所以禁用View。

### Use
```
composer install
```

### 功能描述
- [x] 运行日志
- [x] 异常处理
- [x] 字段验证
- [x] DB监听
- [x] RabbitMQ
- [x] RedisProvider
- [x] Command
- [x] Model Event

### Use

#### 获取配置
```
$config = $this->di->getConfig();
$config = $this->di->getShared('config');
```

#### CLI模式
```
php run version
```

#### 创建Model
```
phalcon model --name=users --get-set --extends=Model --namespace=App\\Models
```