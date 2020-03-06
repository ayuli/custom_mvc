<?php
namespace frame\lib;

Class View
{ 
    public $controller;
    
    public $action;

    public function __construct($controller,$action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function view($path,$data)
    {
        extract($data);
        $filename = APP_PATH.'app\\view\\'.$this->controller.'\\'.$this->action.'.php';
        if(!empty($path)){
            $url = explode('/',trim($path,'/'));
            $count = count($url);
            if($count == 1){
                $filename = APP_PATH.'app\\view\\'.$this->controller.'\\'.$url[0].'.php';
            
            }elseif($count == 2){
                $filename = APP_PATH.'app\\view\\'.$url[0].'\\'.$url[1].'.php';

            }else{
                dd('参数有误');

            }
        }
        if(file_exists($filename)){
            include $filename;

        }else{
            dd('资源不存在，请检查');

        }
    }
}