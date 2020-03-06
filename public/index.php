<?php
define("__DS__",DIRECTORY_SEPARATOR);  // /目录分隔符
define("PUBLIC_PATH",__DIR__.'\\'); // 入口文件的位置
define("APP_PATH",__DIR__.'\\..\\'); // 入口文件的位置

require "../frame/base.php";

// 启动框架
(new frame\lib\Core())->run(); 





