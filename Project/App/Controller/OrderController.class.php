<?php
/**
 * 个人中心模块相关接口
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/18
 * Time: 13:55
 */

namespace App\Controller;

use Think\Db;

class OrderController extends CommonController
{
    //展示接口
    public function viewGoods($insuranceID){
        $re = M('goods')->where("id = '{$insuranceID}'")->field('detail_url,goods_brand,goods_name,price,id,real_price,thumb_img,content')->find();
        $re['goods_brand'] = explode(',',$re['goods_brand']);
        $re['thumb_img'] = 'http://demo.huliantec.com/lifeshare/Public/'.$re['thumb_img'];
        if($re){
            $this->ajaxReturn(dataFormat('ok',$re,0));
        }
        $this->ajaxReturn(dataFormat('暂无数据','',1));
    }

    //订单列表  1全部订单  2待支付 3待生效 4已生效
    public function orderList($uid,$orderType,$page=1){
        $pagesize = 10;
        //偏移量
        $offset = ($page-1)*$pagesize;
        $order = D('Order');
        //获取数据
        $result = $order->getOrderInfo($uid, $offset, $pagesize,$orderType);
        foreach($result as $k=>&$v){
            $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $v['pay_time'] = date('Y-m-d H:i:s',$v['pay_time']);
            if($v['state'] == 1 and $v['is_effect'] == 1){
               $v['state'] = '已生效';
            }elseif($v['state'] == 2){
                $v['state'] = '待支付';
            }elseif($v['state'] == 1 and $v['is_effect'] == 2){
                $v['state'] = '等待期:';
            }
            if($v['pay_type'] == null){
                $v['pay_type'] = 2;
            }
            if($v['pay_type'] == 1){
                $v['money'] = $v['life'];
            }
          /*  $rest_time = ($v['rest_time']-time())/86400;
            $v['rest_time'] = ceil($rest_time);*/
//            $v['rest_time'] =  floor((strtotime($v['rest_time'])-time())/86400);
            $v['view_href'] = "http://demo.huliantec.com/lifeshare/health/index.html";
        }
        if(!$result){
            $this->ajaxReturn(dataFormat('暂无订单','',1));
        }
        $this->ajaxReturn(dataFormat('ok',$result,0));
    }

  //订单详情页  $orderId 订单id
    public function orderDetail($orderId){
        $orderInfo = M('order')
            ->where("id = '{$orderId}'")
            ->field('order_code,pay_time,create_time,name,expire_time,money,phone,id_card,state,is_effect,serve_state,insurance_name,id,insurance_id,pay_type,life')
            ->find();
        if($orderInfo['pay_type'] == null){
            $orderInfo['pay_type'] = 2;
        }
        if($orderInfo['pay_type'] ==1){
            $orderInfo['money'] = $orderInfo['life'];
        }
        if(!$orderInfo){
            $this->ajaxReturn(dataFormat('访问失败','',1));
        }
        $orderInfo['pay_time'] = date('Y-m-d H:i:s',$orderInfo['pay_time']);
        $orderInfo['gua'] = date('Y-m-d',$orderInfo['pay_time']).'至'.$orderInfo['expire_time'];
        $orderInfo['create_time'] = date('Y-m-d H:i:s',$orderInfo['create_time']);
        if($orderInfo['state'] == 1 and $orderInfo['is_effect'] == 1){
            $orderInfo['state'] = '已生效';
        }elseif($orderInfo['state'] == 2){
            $orderInfo['state'] = '待支付';
        }elseif($orderInfo['state'] == 1 and $orderInfo['is_effect'] == 2){
            $v['state'] = '等待期';
        }
        $orderInfo['order_id'] = $orderId;
        $this->ajaxReturn(dataFormat('ok',$orderInfo,0));


    }

    //删除订单
    public function delOrder($orderId){
        $re = M('order')->where("id = '{$orderId}'")->delete();
        if(!$re){
            $this->ajaxReturn(dataFormat('删除失败','',1));
        }
        $this->ajaxReturn(dataFormat('ok','',0));
    }
    //发起服务
    public function startServe($orderId){
        $data = array(
            'serve_time'=>time(),
            'serve_state'=>1
        );
        $re = M('order')->where("id = '{$orderId}'")->save($data);
        if(!$re){
            $this->ajaxReturn(dataFormat('发起服务失败','',1));
        }
        $this->ajaxReturn(dataFormat('ok','',0));
    }


}