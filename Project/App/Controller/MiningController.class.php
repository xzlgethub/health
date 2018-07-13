<?php
/**
 * 医互保挖矿模块相关接口
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 17:28
 */

namespace App\Controller;

class MiningController extends CommonController
{
    /**
     *我的排行榜查询接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $uid 用户ID
     * @param2  date $page 当前页
     * @return  JSON
     **/
    public function userRank($uid, $page=1)
    {
        //每页条数15
        $pagesize = 15;
        //偏移量
        $offset = ($page-1)*$pagesize;
        $steps = D('Steps');
        //获取用户每日排行数据（分页展示）
        $result = $steps->userRank($uid, $offset, $pagesize);
        foreach ($result as $k=>$v){
            //移除当天显示信息
//            if(substr($v['createtime'],0,10)==date('Y-m-d')){
//                unset($result[$k]);
//            }
            if($v['endtime']=='' || $v['endtime']==null){
                unset($result[$k]);
            }
            if(!empty($result[$k])){
                //把最后修改时间赋值给其他变量
                $result[$k]['createtime'] = $result[$k]['endtime'];
                if(date('Y')==substr($result[$k]['createtime'],0,4)){
                    $result[$k]['ranktime'] = date('m月d日',strtotime($result[$k]['createtime']));
                }else{
                    $result[$k]['ranktime'] = date('Y年m月d日',strtotime($result[$k]['createtime']));
                }
            }
        }
        if(!empty($result)){
            $result = array_merge($result);
            foreach ($result as $k=>&$v){
                $v['rankpic'] = $this->picPath . '/Public/' . $v['rankpic'];
            }
            $this->ajaxReturn(dataFormat('ok',$result));
        }
        $this->ajaxReturn(dataFormat('无数据',array(),0));
    }

    /**
     *每日排行榜查询接口(只能获取前100条排行信息)
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $uid 用户ID
     * @param2  Int  $page 当前页数
     * @return  JSON
     **/
    public function rankShow($uid, $page=1)
    {
        if($page>5){
            $this->ajaxReturn(dataFormat('无数据','',1));
        }
        //获取当天日期
        $time = date('Y-m-d');
        //每页条数20
        $pagesize = 20;
        //偏移量
        $offset = ($page-1)*$pagesize;
        $steps = D('Steps');
        //获取当天排名数据
        $result = $steps->rank($time, $offset, $pagesize);
        foreach ($result as $k=>&$v){
            //拼接完整URL路径
            $v['thumbpic'] = $this->picPath . '/Public/' . $v['thumbpic'];
        }
        //获取当前用户的排名信息
        $userrank = $steps->sameDayStep($uid,$time);
        $userrank['thumbpic'] = $this->picPath . '/Public/' . $userrank['thumbpic'];
        if(!empty($result)){
            if($userrank){
                $this->ajaxReturn(dataFormat('ok',array('user'=>$userrank,'rank'=>$result)));
            }else{
                $this->ajaxReturn(dataFormat('ok',array('user'=>'无排名','rank'=>$result)));
            }
        }
        $this->ajaxReturn(dataFormat('无数据','',1));

    }

    /**
     *当天步数录入接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int    $uid 用户ID
     * @param2  String $step 当天总步数
     * @return  JSON
     **/
    public function stepInput($uid, $step)
    {
        //获取当前时间戳
        $time = time();
        //转化时间格式
        $date = date('Y-m-d',$time);
        //转化成当天凌晨0点的时间戳
        $timestamp = strtotime($date);
        $steps = D('Steps');
        //当天life积分
        $integral=0;
        //判断当前录入时间是否超过晚上10点
        if($time>$timestamp+60*60*22 && $time<$timestamp+60*60*24){
            //查询用户当天的life积分
            $row  = $steps->userSteps($uid, $date);
            //计算今天获取的life
            if($row['steps']>=5000){
                if($row['steps']>=20000){
                    $integral = 500;
                }else{
                    $integral = $integral+50+(($row['steps']-5000)*0.03);
                }
            }
            $this->ajaxReturn(dataFormat('超过录入时间',array('life'=>"$integral")));
        }
        //判断用户当前步数是否大于5000步
        if($step>=5000){
            //大于等于五千步数加50life积分
            $integral = $integral+50;
            //除去起始步数计算剩余步数
            $surplus = $step-5000;
            //超出5000步以后每一步加0.03life积分
            $integral = $integral+($surplus*0.03);
        }
        //每天每人最多可以获得500积分
        if($integral>500){
            $integral = 500;
        }
        $res = $steps->updateSteps($uid, $date, $step, $integral);
        if($res>=0){
            $this->ajaxReturn(dataFormat('ok',array('life'=>"$integral")));
        }else{
            $this->ajaxReturn(dataFormat('录入失败','',1));
        }
    }

}