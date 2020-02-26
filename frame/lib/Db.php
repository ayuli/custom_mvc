<?php
namespace frame\lib;

use PDO;
use frame\lib\Connect;
Class Db
{   
    /**
     *   $data = ['u_name'=>'杜七','u_pwd'=>678];
     *   $res = $obj->table('user')->like('u_name','%王%')->orderBy('u_id','asc')->limit(2)->select();
     *   $res = $obj->table('user')->where('u_name','李四')->delete();
     *   $res = $obj->table('user')->insert($data);
     *   $res = $obj->table('user')->where('u_id',7)->update($data);
     */
    
    // pdo对象
    private $pdo;

    // 字段名
    public $field = '*';

    // 表名
    private $table;

    // 条件
    private $where=null;

    // 模糊查询
    private $like;

    // 排序
    private $order;

    // 条数
    private $limit;

    // 原生sql
    private $sql;

    // 链接数据库
    public function __construct()
    {
        $con = Connect::getInstance();
        $this->pdo = $con->getPDO();
    }

    // 表名
    public function table($param = '')
    {
        if(empty($param)){
            dd('error : table not fund');
        }
        $this->table = $param;

        return $this;
    }

    // 字段
    public function field($param = '*')
    {
        $this->field = $param;

        return $this;
    }

    // where 条件
    public function where($k,$v=null,$p=null)
    {   
        if(is_array($k)){
            $w = null;
            foreach($k as $kk=>$vv){
                $w .= $kk.'='."'$vv'".' and ';
            }
            $w = rtrim($w,' and');
            $this->where = ' where '.$w;
        }else{
            if(is_null($p)){
                $this->where = ' where '.$k.'='."'$v'";
            }else{
                $this->where = ' where '.$k."$v"."'$p'";
            }
        }
        
        return $this;
    }

    // 模糊查询
    public function like($k,$v){
        $this->like = ' where '.$k.' like '."'".$v."'";
        return $this;
    }

    // 排序
    public function orderBy($param,$asc)
    {
        $this->order = ' order by '.$param.' '.$asc;
        return $this;
    }

    //条数
    public function limit($start,$end=null)
    {
        if(!is_null($end)){
            $this->limit = ' limit '.$start.','.$end;
        }else{
            $this->limit = ' limit '.$start;
        }
        return $this;
    }

    // 单条获取
    public function find()
    {
        $this->sql = 'select '.$this->field.' from '.$this->table.$this->where;
        $res = $this->pdo->query($this->sql);
 
        if(is_object($res)){
            $data = $res->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }

    // 多条获取
    public function select()
    {
        $this->sql = 'select '.$this->field.' from '.$this->table.$this->where.$this->like.$this->order.$this->limit;
        // dd($this->sql);
        $res = $this->pdo->query($this->sql);
 
        if(is_object($res)){
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        return false;
    }

    // 增
    public function insert($data)
    {
        if(!is_array($data)){
            return false;
        }
        $field = null;
        $values = null;
        foreach($data as $k => $v){
            $field .= '`'.$k.'`,';
            $values .= '"'.$v.'",';
        }
        $field = rtrim($field, ',');
        $values = rtrim($values, ',');
        $this->sql = 'insert into '.$this->table . "($field)" . " values ($values)";
        $res = $this->pdo->exec($this->sql);
        if($res){
            $newId = $this->pdo->lastInsertId();
            return $newId;
        }else{
            return false;
        }
    }
    // 删
    public function delete()
    {
        if(is_null($this->where)){
            return false;
        }
        $this->sql = 'delete from '.$this->table.$this->where;
        $res = $this->pdo->exec($this->sql);
        return $res;
    }
    // 批量删
    public function deleteAll($where){
        if(is_array($where)){
            if(count($where)>1){
                return dd('只能存在一个key');
            }
            foreach ($where as $key => $val) {
                if(is_array($val)){
                    $condition = $key.' in ('.implode(',', $val) .')';
                } else {
                    $condition = $key. '=' .$val;
                }
            }
        } elseif (is_string($where)){
            dd('请使用数组方式');
        } else { // 这是字符串的方式
            $condition = $where;
        }
        $this->sql = "delete from ".$this->table." where $condition";
        dd($this->sql);
        $res = $this->pdo->exec($this->sql);
        return $res;
    }

    // 改
    public function update($data=null)
    {
        if(!is_array($data)){
            return false;
        }
        $str = null;
        foreach($data as $k => $v){
            $str .= '`'.$k.'`='."'$v',";
        }
        $str = rtrim($str,',');
        $this->sql = 'update '.$this->table.' set '.$str.$this->where;
        $res = $this->pdo->exec($this->sql);
        return $res;
    }
}