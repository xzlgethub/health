<?php
namespace App\Controller;
use Think\Controller;
Vendor("WxPayPubHelper.WxPayPubHelper");
class WechatPayController extends CommonController
{
    const APPID = 'wxb81a4efb78ec1e41';
    const MCHID = '1503742161';
    const KEY = 'x7c96v5634luh98s384hyy9dkj45iusa';
    //入口函数
    public function wechatPay($order_code,$pay_type,$insurance_name,$money){
        $order_codes = M('order')->where("order_code = '{$order_code}' and state = 1")->getField('id');
        if($order_codes){
            $this->ajaxReturn(dataFormat('订单已支付','',3));
        }

        if($pay_type == 1){
            $useM = M('order')->where("order_code = '{$order_code}'")->field('life,uid')->find();
            $rest_m =M('user')->where("id = '{$useM['uid']}'")->getField('life');
            if($rest_m < $useM['life']){

                $this->ajaxReturn(dataFormat('LIFE不够，要多加运动哦','',4));
            }
            $time = time();
            $expire_time = strtotime("+1 year");//到期时间
//            $rest_time = $time + 90*3600*24;
            $jin = date('Y-m-d');
//                    $rest_time = $times + 90*3600*24;
            $rest_time = 90;
            $expire_time = date('Y-m-d',strtotime("$jin +1 year"));
            $orderinfo = M('order')->where("order_code = '{$order_code}'")->field('uid,life')->find();
            $aa = M('user')->where("id = '{$orderinfo['uid']}'")->getField('life');

            $life_or = $aa - $orderinfo['life'];
            $lifearr = array('life'=>$life_or);
            $life_des = M('user')->where("id = '{$orderinfo['uid']}'")->save($lifearr);

            if(!$life_des){
                $this->ajaxReturn(dataFormat('扣款失败','',1));
            }
            $order_data = array('state'=>1,'pay_time'=>$time,'expire_time'=>$expire_time,'pay_type'=>1,'rest_time'=>$rest_time);
            $re = M('order')->where("order_code = '{$order_code}'")->save($order_data);
            if(!$re){
                M('user')->where("id = '{$orderinfo['uid']}'")->setInc('price',$orderinfo['life']);
                $this->ajaxReturn(dataFormat('扣款失败','',2));
            }
            $timess = date('Y-m-d H:i:s');
            $inte = array('uid'=>$orderinfo['uid'],'revenuetype'=>'购买服务','life'=>-$orderinfo['life'],'createtime'=>$timess);
            M('integral')->add($inte);
            $data['life'] = $life_or;
            $this->ajaxReturn(dataFormat('ok',$data,0));
        }else if($pay_type == 2){
            $money = $money*100;
                $json = array();
                //生成预支付交易单的必选参数:
                $newPara = array();
                //应用ID
                $newPara["appid"] = "wxb81a4efb78ec1e41";
                //商户号
                $newPara["mch_id"] = "1503742161";
                //设备号
                $newPara["device_info"] = "WEB";
                //随机字符串,这里推荐使用函数生成
                $newPara["nonce_str"] = random(32);
                //商品描述
                $newPara["body"] =$insurance_name.'';
                //商户订单号,这里是商户自己的内部的订单号
                $newPara["out_trade_no"] = $order_code.'';
                //总金额
                $newPara["total_fee"] =$money;
                //终端IP
                $newPara["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];
                //通知地址，注意，这里的url里面不要加参数
                $newPara["notify_url"] = "http://demo.huliantec.com/lifeshare/index.php/App/Notify/notify";
                //交易类型
                $newPara["trade_type"] = "APP";
                //第一次签名
                $newPara["sign"] = produceWeChatSign($newPara);
                //把数组转化成xml格式
                $xmlData = getWeChatXML($newPara);
                //利用PHP的CURL包，将数据传给微信统一下单接口，返回正常的prepay_id
                $get_data = sendPrePayCurl($xmlData);
                //返回的结果进行判断。
                if($get_data['return_code'] == "SUCCESS" && $get_data['result_code'] == "SUCCESS"){
                    //根据微信支付返回的结果进行二次签名
                    //二次签名所需的随机字符串
                    $newPara["nonce_str"] = random(32,'all',1);
                    //二次签名所需的时间戳
                    $newPara['timeStamp'] = time()."";
                    //二次签名剩余参数的补充
                    $secondSignArray = array(
                        'appid'=>$newPara['appid'],
                        'noncestr'=>$newPara['nonce_str'],
                        'package'=>"Sign=WXPay",
                        'prepayid'=>$get_data['prepay_id'],
                        'partnerid'=>$newPara['mch_id'],
                        'timestamp'=>$newPara['timeStamp'],
                    );
                    $json['datas'] = $secondSignArray;
                    $json['ordersn'] = $newPara["out_trade_no"];
                    $json['datas']['sign'] = weChatSecondSign($newPara,$get_data['prepay_id']);
                    $json['message'] = "预支付完成";
                    //预支付完成,在下方进行自己内部的业务逻辑
                    /*****************************/

                    //更改订单状态
//                    $times = time();
//                        $jin = date('Y-m-d');
////                    $rest_time = $times + 90*3600*24;
//                    $rest_time = 90;
//                    $arr = array(
//                        'state' => 1,
//                        'pay_time'=>$times,
//                        'expire_time'=>strtotime("+1 year"),
//                        'pay_type'=>2,
//                        'rest_time'=>$rest_time
//
//                    );
//                    $where_order = array('order_code'=>$order_code);
//                    M('order')->where($where_order)->save($arr);
                  //更改订单状态




                    $this->ajaxReturn(dataFormat('ok',$json,0));
                }
                else{
                    $json['message'] = $get_data['return_msg'];
                }

                return json_encode($json);
            }
    }



}