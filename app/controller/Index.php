<?php
namespace app\controller;

use app\model\IndexModel;
use frame\lib\Controller;
Class Index extends Controller
{
    public function index()
    {
        // echo '鱼鱼鱼自定义框架首页'.'<hr>';
        $obj = new IndexModel();
        $Info = $obj->getInfo();
        // 传值到视图层
        $this->view('',$Info);
    }
  
}