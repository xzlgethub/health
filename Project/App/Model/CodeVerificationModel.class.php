<?php
/**
 * 短信验证表相关操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/18
 * Time: 9:54
 */

namespace app\Model;

use Think\Model;

class CodeVerificationModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'code_verification';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 添加数据
     * @author yangxiuchuan
     * @version 1.0
     * @param1 String $phone 手机号
     * @param2 Int   $code 验证码
     * @param3 Int   $type 验证码类型
     * @param3 Int   $area_code  区号
     * @return Int
     **/
    public function addCode($phone, $code, $type, $area_code)
    {
        $insert = array(
            'phone'  => $phone,
            'code'   => $code,
            'time'   => time(),
            'type'   => $type,
            'area_code' => $area_code,
            'status' => 0
        );
        $res = $this->table->add($insert);
        return $res;
    }

    /**
     * 获取单条数据
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Array $where
     * @return Array
     **/
    public function selectOne($where)
    {
        $res = $this->table->where($where)->find();
        return $res;
    }

    /**
     * 跟新数据
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Array $where
     * @param2 Int   $save
     * @return Int
     **/
    public function saveCode($where, $save)
    {
        $res = $this->table->where($where)->save($save);
        return $res;
    }

    /**
     * 修改当前验证码为使用状态
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Array $where
     * @param2 Int   $status
     * @return Int
     **/
    public function saveStatus($where,$status=1)
    {
        $save = array(
            'status'=>$status
        );
        $res = $this->table->where($where)->save($save);
        return $res;
    }

    /**
     * 跟新数据
     * @author yangxiuchuan
     * @version 1.0
     * @param1 String $phone    手机号
     * @param2 Int   $code      验证码
     * @param3 Int   $type      验证码类型
     * @param3 Int   $area_code 区号
     * @return Int
     **/
    public function updateCode($phone, $code, $type, $area_code)
    {
        $where = array(
            'phone' => $phone,
            'type'  => $type,
            'area_code' => $area_code
        );
        $row = $this->selectOne($where);
        if($row==NULL){
            return $this->addCode($phone, $code, $type, $area_code);
        }
        $save = array(
            'code'   => $code,
            'time'   => time(),
            'status' => 0
        );
        $res = $this->saveCode($where,$save);
        return $res;
    }
}