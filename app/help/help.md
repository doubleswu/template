## 一、资源安装
```
# 创建所有DB
php artisan migrate

php artisan make:migration tableName
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

