<?php
namespace frame\lib;

Class Route
{
    // 重写模式的路由规则
    static public function Rewrite($url,$script)
    {
        $url = str_replace($script,'',$url);
        $uri = trim($url,'/');
        $route = explode('/',$uri);
        $controller = $route[0] ? $route[0] : app('default_controller');
        $action = $route[1] ? $route[1] : app('default_action');
        return ['controller'=>$controller,'action'=>$action];
    }
}