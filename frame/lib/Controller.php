<?php
namespace frame\lib;

Class Controller
{
    public $resource;
    public function __construct($controller,$action)
    {
        $this->view = new View($controller,$action);
    }
    public function view($path,$data)
    {
        // $this->resource->view($path,$data);
    }
}