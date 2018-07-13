<?php
$con = mysql_connect("localhost","root","root");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
echo 111;die;
//    var_dump($_POST['ceshi']);die;
//接收微信返回的数据数据,返回的xml格式
$xmlData = file_get_contents('php://input');
//将xml格式转换为数组
//    $xmlData = $GLOBALS['HTTP_RAW_POST_DATA'];
file_put_contents('notify.txt',date('Y-m-d H::i:s'));
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
if($sign == getSign($data)){
    //签名验证成功后，判断返回微信返回的
    if ($data['result_code'] == 'SUCCESS') {
        //根据返回的订单号做业务逻辑

        $times = time();
        $rest_time = 90;
        $arr = array(
            'state' => 1,
            'pay_time'=>$times,
            'expire_time'=>strtotime("+1 year"),
            'pay_type'=>2,
            'rest_time'=>$rest_time

        );
        $where_order = array('order_code'=>$data['out_trade_no']);
        $re = D('Order')->saveOrder($where_order,$arr);
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






function getSign($params) {
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
    $sign = strtoupper($stringSignTemp); //将所有字符转换为大写
    return $sign;
}