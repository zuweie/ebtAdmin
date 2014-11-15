<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);




// 定义网站根目录
define('IS_HTTPS', 0);
define('SITE_DOMAIN', strip_tags($_SERVER['HTTP_HOST']));
define('SITE_URL', (IS_HTTPS? 'https:':'http:').'//'.SITE_DOMAIN.'/');

// 定义静态资源目录
define('PUBLIC_STATIC', SITE_URL.'Public/static/');

// 定义应用目录
define('APP_PATH','./Application/');
define('APP_DIR', SITE_URL.'Application/');

define('UPLOADS_PATH', './Public/Uploads/');
define('UPLOADS_DIR', SITE_URL.'/Public/Uploads/');

define('DATAS_PATH', './Public/Datas/');
define('DATAS_DIR', SITE_URL.'/Public/Datas/');

define('THEMES_DIR', SITE_URL.'Public/theme/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单