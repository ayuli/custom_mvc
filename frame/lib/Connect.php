<?php
namespace frame\lib;

use PDO;

class Connect
{
    private $pdo;
    static public $instance;
    private function __construct()
    {
        try{
            $dsn = db('type').':host='.db('hostname').';dbname='.db('dbname');
            $this->pdo = new PDO($dsn,db('username'),db('password'));
        }catch(\PDoException $e){
            dd('connection failed reason: '.$e->getMessage());
        }
    }
    private function __clone()
    {
    }
    public static function getInstance()
    {
        if(!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getPDO()
    {
        return $this->pdo;
    }
}