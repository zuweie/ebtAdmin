#### 简介

ebtAdmin 是一个基于免费开源的，快速、简单的面向对象的 轻量级ThinkPHP开发框架所制作的一个通用后台。

#### 快速使用

* 将ebtAdmin下载的/your/webapp/path/
* 然后在浏览器中输入http://localhost/Admin/Install/install
* 然后键入超级管理员用户登录账户，密码，昵称。保存。
* 然后ebtAdmin便会安装Admin模块，User模块。
* 安装成功后，浏览器会跳转至 http：//localhost/Admin/Public/index。这也是后台的入口位置。键入刚刚保存的管理员用户和密码，即可进入ebtAdmin的后台。

#### 模块的安装

在原生的ThinkPHP架构中，用户自己编写的应用模块是需要放在Application/下。ebtAdmin提供的一个简单的安装，卸载应用模块的功能。使用户可以快速建立自己模块所需要的数据表，在不需要该模块时，也可快速删除自己的数据表。

* 在/Application/yourmodule/ 中建立Appinfo目录。
* 在/Application/yourmodule/Appinfo/中建立四个文件
  * 1 info.php。返回一个数组, array('name'=>'xxx', 'author'=>'xxx', 'version'=>'xxx', 'admin_entrance'=>'后台入口', 'desc'=>'xxx').具体可以参照/Application/User/Appinfo/info.php 的写法。
  * 2 install.php。此文件主要调用install.sql内的sql脚本。使其生成用户想要数据表。具体写法请参照/Application/User/Appinfo/install.php.
  * 3 install.sql. 生成数据表的SQL脚本文件。具体写法请参照/Application/User/Appinfo/install.sql。
  * 4 uninstall.php 卸载数据表，具体写法请参照/Application/User/Appinfo/uninstall.php
  

#### 关于如何使用这个后台

* 后台的主要框架类 Administrator，这个类可以继承，也可以单独使用。它位置在/Application/Admin/Controller/AdministratorController.class.php

* Administrator有两个关键的ACTION，分别为displayList()和displayConfig()，分别用于列表显示 和 字段修改，这个也是后台数据处理最常用到的方式。
 
 * 关于列表显示：
 * 1 配置Administrator->pageKeyList的值
 * 2 调用Administrator->displayList($ListData);

