# Caster
A PHP Framework

## 推荐环境
> LAMP
> Ubuntu 16.04LTS
> php7.0

## 安装
```bash
git clone git@github.com:lxzan/Caster.git
composer install
sudo chmod -R 777 runtime
```
## 配置
重命名/config里面的文件去掉'.default', 配置数据库

## 路由
> 路由由`controller/method`的结构构成，默认控制器为`Main`，默认方法为`index`. url里面控制器和方法使用下划线, 项目中都是驼峰命名.
> 控制器里方法前缀有get, post和action, get和post对应相对的http请求, action接受两种请求.

## 模板引擎
> 模板引擎使用的是[Blade](http://d.laravel-china.org/docs/5.4/blade),点击超链接查看文档