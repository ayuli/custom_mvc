<?php
namespace app\model;

use frame\lib\Db;
// use frame\lib\Model;
Class IndexModel 
{
    public function getInfo()
    {
        $obj = new Db();
        // $data = ['u_name'=>'杜七','u_pwd'=>678];
        // $where = ['u_id'=>[21,22]];
        // $where = 'u_id in (21,22)';
        // $res = $obj->table('user')->where($where)->select();
        $res = $obj->table('user')->find();
        // $res = $obj->table('user')->like('u_name','%王%')->orderBy('u_id','asc')->limit(2)->select();
        // $res = $obj->table('user')->where('u_name','李四')->delete();
        // $res = $obj->table('user')->insert($data);
        // $res = $obj->table('user')->deleteAll($where);
        // $res = $obj->table('user')->deleteAll($where);
        // $res = $obj->table('user')->where('u_id',7)->update($data);
        return $res;
    }
}