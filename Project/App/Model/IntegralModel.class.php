<?php
/**
 * 积分详情表相关操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 14:48
 */

namespace app\Model;

use Think\Model;

class IntegralModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'integral';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 添加
     * @author yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @param2  String $revenuetype 录入明细
     * @param3  Int    $file life积分
     * $param4  Int    $lis  lis积分
     * $param5  Int    $type 录入类型
     * @return JSON
     **/
    public function addIntegral($uid, $revenuetype, $life, $lis, $type)
    {
        $add = array(
            'uid' => $uid,
            'revenuetype' => $revenuetype,
            'life' => $life,
            'lis' => $lis,
            'type' => $type
        );
        $res = $this->table->add($add);
        return $res;
    }

    /**
     * 用户积分明细分页查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * @return JSON
     **/
    public function integralDetail($uid, $startrow, $pagesize)
    {
        $where = array(
            'uid' => $uid
        );
        $res = $this->table->field('revenuetype,life,createtime')->where($where)->order('createtime desc')->limit($startrow.','.$pagesize)->select();
        if($res != NULL ){
            foreach ($res as $key=>$val){
                if (substr($val['life'],0,1)!='-'){
                    $res[$key]['life'] = '+' . $res[$key]['life'];
                }
            }
            return $res;
        }else{
            return NULL;
        }


    }

    /**
     * 获取条件记录数
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Array $where 条件
     * @return JSON
     **/
    public function whereCount($where)
    {
        $res = $this->table->where($where)->count();
        return $res;
    }


}