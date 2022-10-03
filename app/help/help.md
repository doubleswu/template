## 一、资源安装
### 1、数据库相关
#### a、Mysql表
```
# 创建所有DB
php artisan migrate

php artisan make:migration tableName
```

#### b、构建数据
```
php artisan project:InitDb
```


## 二、接口文档
### 登录模块
#### 1、登陆接口
- 请求方式: get
- 请求链接
```
http://xxx/api/user/login
```
- 入参

    |  字段名称   | 字段类型  | 描述 |
    |  ----  | ----  | ----  |
    | username  | string | 用户名称
    | password  | string |用户密码

- 出参
    
    后续所有的请求都需要把token写到到接口的header头。
```json
{
    "code": 0,
    "msg": "",
    "requestId": null,
    "results": {
        "username": "doubleswu",
        "token": "dGVzdC1pdi11di1pdXYtdur3nGBzGosf3nOct8fmB3P43yIi3ftVAhU3CGrHQxuR"
    }
}
```

#### 2、小程序登陆
- 请求方式: get
- 请求链接
```
http://xxx/api/user/token
```
- 简介
  
    基于code获取小程序登陆token。https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html

- 入参

  |  字段名称   | 字段类型  | 描述 |
      |  ----  | ----  | ----  |
  | code  | string | 用户登录凭证（有效期五分钟）

- 出参


```json
# 正常
{
    "code": 0,
    "msg": "",
    "requestId": null,
    "results": {
        "token": "3455cd02385d9017cd485b4286b5b860",
    }
}

# 异常：
{
    "code": 300001,
    "msg": "获取微信token异常",
    "requestId": null,
    "results": []
}
```

