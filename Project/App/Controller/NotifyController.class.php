<?php
namespace App\Controller;
use Think\Controller;
class NotifyController extends CommonController
{
    //入口函数
    public function wechatPay($order_code,$pay_typess,$insurance_name,$money){

     /*   $order_code = I('order_code');
        $pay_type = I('pay_type');
        $insurance_name = I('insurance_name');
        $money = I('money');*/
        $order_codes = M('order')->where("order_code = '{$order_code}' and state = 1")->getField('id');
        if($order_codes){
            $this->ajaxReturn(dataFormat('订单已支付','',3));
        }
        if($pay_typess == 1){
            $useM = M('order')->where("order_code = '{$order_code}'")->getField('uid');
            $rest_m =M('user')->where("id = '{$useM}'")->getField('life');
            if($rest_m < $money){

                $this->ajaxReturn(dataFormat('LIFE不够，要多加运动哦','',4));
            }
            $time = time();
            $expire_time = strtotime("+1 year");//到期时间
            $rest_time = $time + 90*3600*24;
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
        }else if($pay_typess == 2){
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
            $newPara["notify_url"] = "http://".$_SERVER["HTTP_HOST"]."/Lifeshare/index.php/App/Notify/notify";
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

                $this->ajaxReturn(dataFormat('ok',$json,0));
            }
            else{
                $json['message'] = $get_data['return_msg'];
            }

            return json_encode($json);
        }
    }


public function notify(){

//    var_dump($_POST['ceshi']);die;
    //接收微信返回的数据数据,返回的xml格式
    $xmlData = file_get_contents('php://input');
    //将xml格式转换为数组
//    $xmlData = $GLOBALS['HTTP_RAW_POST_DATA'];
//    $data = FromXml($xmlData);
    if(!$xmlData){
        echo "xml数据异常！";
    }
    //将XML转为array
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $data = json_decode(json_encode(simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    //用日志记录检查数据是否接受成功，验证成功一次之后，可删除。
    //http://demo.huliantec.com/lifeshare/index.php/Manage/Index/index.html
    $file = fopen('log.txt', 'a+');
    fwrite($file,var_export($data,true));
    //为了防止假数据，验证签名是否和返回的一样。
    //记录一下，返回回来的签名，生成签名的时候，必须剔除sign字段。
    $sign = $data['sign'];
    unset($data['sign']);



$params = $data;
    ksort($params); //将参数数组按照参数名ASCII码从小到大排序
    foreach ($params as $key => $item) {
        if (!empty($item)) {  //剔除参数值为空的参数
            $newArr[] = $key.'='.$item; // 整合新的参数数组
        }
    }
    $stringA = implode("&", $newArr);  //使用 & 符号连接参数
    $stringSignTemp = $stringA."&key=x7c96v5634luh98s384hyy9dkj45iusa"; //拼接key
    // key是在商户平台API安全里自己设置的
    $stringSignTemp = MD5($stringSignTemp); //将字符串进行MD5加密
    $signs = strtoupper($stringSignTemp); //将所有字符转换为大写




    if($sign == $signs){
        file_put_contents('notify.txt',$sign.'='.$signs.'1111111111');
        //签名验证成功后，判断返回微信返回的
        if ($data['result_code'] == 'SUCCESS') {
            //根据返回的订单号做业务逻辑

            $times = time();
            $jin = date('Y-m-d');
            $ex_time = strtotime("$jin +1 year");
            $rest_time = 90;
            $arr = array(
                'state' => 1,
                'pay_time'=>$times,
                'expire_time'=>$ex_time,
                'pay_type'=>2,
                'rest_time'=>$rest_time

            );
            $where_order = array('order_code'=>$data['out_trade_no']);
            $re = M('order')->where($where_order)->save($arr);
//            $re = D('Order')->saveOrder($where_order,$arr);
            //处理完成之后，告诉微信成功结果！
            if($re){
                echo '<xml>
                          <return_code><![CDATA[SUCCESS]]></return_code>
                          <return_msg><![CDATA[OK]]></return_msg>
                      </xml>';
                exit();
            }
        } //支付失败，输出错误信息
        else{
            $file = fopen('log.txt', 'a+');
            fwrite($file,"错误信息：".$data['return_msg'].date("Y-m-d H:i:s"),time()."\r\n");
        }
    }
    else{
        $file = fopen('log.txt', 'a+');
        fwrite($file,"错误信息：签名验证失败".date("Y-m-d H:i:s"),time()."\r\n");
    }


}



}