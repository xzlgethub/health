<?php
/**
 * 步数表相关操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 17:31
 */

namespace app\Model;

use Think\Model;

class StepsModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'steps';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     *用户步数分页查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $uid 用户ID
     * @param2  Int  $offset 偏移量
     * @param3  Int  $pagesize 展示条数
     * @return  Array
     **/
    public function historySteps($uid, $offset, $pagesize)
    {
        $where = array(
            'uid' => $uid,
        );
        $res = $this->table->field('steps,life,createtime')->where($where)->order('createtime desc')->limit($offset . ',' .$pagesize)->select();
        return $res;
    }

    /**
     *挖矿首页用户排行信息分页查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $uid      用户ID
     * @param2  Int  $offset   偏移量
     * @param3  Int  $pagesize 每页条数
     * @return  Array
     **/
    public function userRank($uid, $offset, $pagesize)
    {
        $where = array(
            'uid' => $uid
        );
        $res = $this->table
                    ->field('hl_steps.uid,hl_steps.steps,hl_steps.rank,hl_steps.life,hl_user.name as rankname,hl_user.thumbpic as rankpic,hl_steps.createtime,hl_steps.endtime')
                    ->join('__USER__ ON __STEPS__.firstuid = __USER__.id','LEFT')
                    ->where($where)
                    ->limit($offset . ',' . $pagesize)
                    ->order('hl_steps.createtime desc')
                    ->select();
        return $res;
    }

    /**
     *每日冠军查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  date $time 时间
     * @return  Array
     **/
    public function first($time)
    {
        $where = array(
            'hl_steps.createtime' => $time,
            'hl_steps.rank' => 1
        );
        $res = $this->table
                    ->field('hl_user.id,hl_user.name,hl_user.thumbpic')
                    ->join('__USER__ ON __STEPS__.uid = __USER__.id','RIGHT')
                    ->where($where)
                    ->order('createtime desc')
                    ->select();
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
    public function rank($time, $offset, $pagesize)
    {
        $where = array(
            'hl_steps.createtime' => $time
        );
        $res = $this->table
                    ->field('hl_steps.uid,hl_user.name,hl_steps.life,hl_user.thumbpic')
                    ->join('__USER__ ON __STEPS__.uid = __USER__.id')
                    ->where($where)
                    ->order('steps desc')
                    ->limit($offset . ',' .$pagesize)
                    ->select();
        return $res;
    }

    /**
     *跟新步数
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  date $time 时间
     * @return  Array
     **/
    public function updateSteps($uid, $time, $steps, $integral)
    {
        $where = array(
            'uid'        => $uid,
            'createtime' => $time
        );
        $row = $this->field('uid')->table->where($where)->find();
        if($row){
            $save = array(
                'steps' => $steps,
                'life' => $integral
            );
            $res = $this->table->where($where)->save($save);
            return $res;
        }else{
            $insert = array(
                'uid'        => $uid,
                'createtime' => $time,
                'steps' => $steps,
                'life' => $integral
            );
            $res = $this->table->add($insert);
            return $res;
        }
    }

    /**
     *用户指定时间步数查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $uid  用户ID
     * @param2  date $time 时间
     * @return  Array
     **/
    public function userSteps($uid, $time)
    {
        $where = array(
            'uid' => $uid,
            'createtime' => $time
        );
        $res = $this->table->field('steps')->where($where)->find();
        return $res;
    }

    /**
     *当天用户步数排行查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $uid  用户ID
     * @return  Array
     **/
    public function sameDayStep($uid, $time)
    {
        $where = array(
            'createtime' => $time
        );
        $res = $this->table->field('uid,steps,life')->where($where)->order('steps desc')->select();
        foreach($res as $k=>$v){
            if($v['uid']==$uid){
                $user = $v;
                $img = M('user')->field('thumbpic')->where('id=' . $v['uid'])->find();
                $user['thumbpic'] = $img['thumbpic'];
                $user['rank'] = $k+1;
                return $user;
            }
        }
        return false;
    }


}