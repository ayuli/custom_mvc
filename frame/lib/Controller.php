<?php
namespace frame\lib;

Class Controller
{
    public $resource;

    public $controller;

    public $action;

    public function __construct($controller,$action)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->resource = new View($controller,$action);
    }
 
    public function view($path,$data)
    {
        $this->resource->view($path,$data);
    }

    public function redirect($path){
        $redirect = explode('/',trim($path,'/'));
        $count = count($redirect);
        if($count == 1){
            $controller = $this->controller;
            $action = $redirect[0];
        }elseif($count == 2){
            $controller = $redirect[0];
            $action = $redirect[1];
        }else{
            dd('参数有误');
        }
        $controllerName = "App\\controller\\".ucfirst($controller);
        $actionName = $action;
        if(class_exists($controllerName)){
            $obj = new $controllerName($controller,$action);
            if(method_exists($obj,$actionName)){
                call_user_func_array([$obj,$actionName],[]);
            }else{
                dd('方法不存在,请检查');
            }
        }else{
            dd('类不存在,请检查');
        }
    }
    
    // public function redirect($path){
    //     $redirect = explode('/',trim($path,'/'));
    //     $count = count($redirect);
    //     if($count == 1){
    //         $url = $this->controller.'/'.$redirect[0];
    //     }elseif($count == 2){
    //         $url = $path;
    //     }else{
    //         dd('参数有误');
    //     }
    //     $turl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.$url;
    //     header('location:'.$turl);
    // }

}