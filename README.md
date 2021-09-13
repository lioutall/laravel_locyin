## 关于 laravel_locyin

《Flutter 实战开发旅行社交手机APP》Laravel 服务器端，各目录和文件详细说明请查看[ Laravel 中文文档](https://learnku.com/docs/laravel/8.x)。

## 安装
安装拓展包
```
composer update
```
编辑配置文件，把XXXX都填上

```
cp .env_example .env
vim .env
```
生成数据加密秘钥
```
php artisan key:generate
```
生成 jwt 令牌秘钥
```
php artisan jwt:secret
```
数据库迁移
```
php artisan migrate
```
安装 Laravel-Admin
```
php artisan admin:install
```
填充用户和群组账号数据表（可选）
```
php artisan db:seed
```
设置权限

```
chmod -R 775 storage

```

服务器缓存相关
```
php artisan route:cache

php artisan config:cache

php artisan cache:clear
```


## License

The laravel_locyin is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
