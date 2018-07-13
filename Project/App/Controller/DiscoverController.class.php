<?php
/**
 * 发现页面相关接口
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/19
 * Time: 15:22
 */

namespace App\Controller;


class DiscoverController extends CommonController
{
    /**
     * 商品展示接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1
     * @return  JSON
     **/
    public function showGoods()
    {
        $goods = D('Goods');
        //查询所有商品（无分页）
        $result = $goods->selectGoods();
        //判断数据是否为空
        if($result==NULL){
            $this->ajaxReturn(dataFormat('无数据',array()));
        }
        //拼接完整url图片路径
        foreach($result as $k=>&$v){
            if($v['goods_brand']==''){
                $v['goods_brand'] = array();
            }else{
                $v['goods_brand'] = explode(',',$v['goods_brand']);
            }
            $v['thumb_img'] = $this->picPath . '/Public/' . $v['thumb_img'];
        }
        $this->ajaxReturn(dataFormat('ok',$result));
    }

    /**
     * 生成订单
     * @author  youlong
     * @version 1.0
     * @param1  Int $uid  所属用户的ID
     * @param2  string $name  姓名
     * @param3  Int $phone 手机号
     * @param4  string $idCard  身份证号
     * @return  JSON
     **/
    public function createOrder($uid, $name,$phone,$idCard,$insurance_id)
    {
        if($name == NULL){
            $this->ajaxReturn(dataFormat('姓名为空','',1));
        }elseif($phone == NULL || !is_numeric($phone) || strlen($phone) != 11){
            $this->ajaxReturn(dataFormat('请输入正确的手机号','',2));
        }elseif(!is_idcard($idCard)){
            $this->ajaxReturn(dataFormat('请输入正确的身份证号','',3));
        }
        $where = array(
            'id'=>$insurance_id
        );
        $arr = M('goods')->where($where)->field('goods_name,real_price,price')->find();
 /*       $where = array(
            'id_card' => $idCard
        );
        $ob = D('PrefectInformation');
        $preInfo = $ob->where($where)->find();
        if($preInfo){
            $this->ajaxReturn(dataFormat('该信息已存在','',4));
        }*/
        $time = time();
        $array = array(
            'uid' => $uid,
            'insurance_id' => $insurance_id,
            'name' => $name,
            'phone' => $phone,
            'id_card' => $idCard,
            'order_code'=>create_order(),
            'create_time'=>$time,
            'money'=>$arr['real_price'],
            'insurance_name'=>$arr['goods_name'],
            'life'=>$arr['price']

        );
        $add =M('order')->add($array);
        if(!$add){
            $this->ajaxReturn(dataFormat('该订单生成失败','',5));
        }
        $data = M('order')->where("id = '{$add}'")->field('order_code')->find();
        $this->ajaxReturn(dataFormat('ok',$data,0));

    }










}