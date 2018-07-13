<?php
/**
 * user表的数据操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 12:05
 */

namespace app\Model;

use Symfony\Component\Translation\Util\ArrayConverter;
use Think\Model;

class OrderModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'order';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }
    public function saveOrder($id, $save)
    {
        $res = $this->table->where('id=' . $id)->save($save);
        return $res;
    }



    /**
     *每日步数排行榜查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  date $time 时间
     *
     * @return  Array
     **/
    public function getOrderInfo($uid, $offset, $pagesize,$orderType)
    {
        if($orderType == 1){
            $where = array(
                'uid'=>$uid
            );
        }elseif($orderType == 2){
            $where = array(
                'uid'=>$uid,
                'state'=>2
            );
        }elseif($orderType == 3){
            $where = array(
                'uid'=>$uid,
                'state'=>1,
                'is_effect'=>2
            );
        }elseif($orderType == 4){
            $where = array(
                'uid'=>$uid,
                'state'=>1,
                'is_effect'=>1
            );
        }
        $res = $this->table
            ->where($where)
//            ->field('order_name,money,state,name,create_time,pay_time,rest_time,is_effect')
            ->field(array('serve_state','insurance_name','money','state','name','create_time','pay_time','rest_time','id','is_effect','order_code','insurance_id','pay_type','life'))
            ->order('create_time desc')
            ->limit($offset . ',' .$pagesize)
            ->select();
        return $res;
    }


}