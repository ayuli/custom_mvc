<?php
namespace frame\lib;

Class Core
{
    // 启动框架
    public function run()
    {
        // 自动加载
        spl_autoload_register([$this,'autoload']);
        // 路由
        $this->route();

    }
    /** 
     * 路由方法 获取对应的控制器方法
     * http://www.yyy.com/index/index 重写模式 所有框架都支持
     * http://www.yyy.com?c=index&a=index pathinfo模式 tp3.2 CI
     * http://www.yyy.com?r=index/index 兼容模式 yii2
     */
    public function route()
    {   
        $query = $_SERVER['QUERY_STRING'];
        $uri = $_SERVER['REQUEST_URI'];
        $script = $_SERVER['SCRIPT_NAME'];
        if(empty($query)){
            // 重写模式
            $r = Route::Rewrite($uri,$script);
        }else{
            // pathinfo模式
            dd('暂时不支持除重写以外的模式');
        }
        $controllerName = "App\\controller\\".ucfirst($r['controller']);
        $actionName = $r['action'];
        // dd($actionName);
        if(class_exists($controllerName)){
            $obj = new $controllerName($r['controller'],$r['action']);
            if(method_exists($obj,$actionName)){
                call_user_func_array([$obj,$actionName],[]);
            }else{
                dd('方法不存在,请检查');
            }
        }else{
            dd('类不存在,请检查');
        }
    }
    // 自动加载的实现
    private function autoload($class)
    {
        $filename = APP_PATH.$class.'.php';
        if(file_exists($filename)){
            include $filename;
        }else{
            // throw new \Exception('找不到控制器'.$ctrlClass);
            dd($class.' 类文件不存在,请检查');
        }
    }
}