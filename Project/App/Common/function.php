<?php
/**
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 9:24
 */

/**
 * 计算给定时间戳与当前时间相差的时间，并以一种比较友好的方式输出
 * @param  [int] $timestamp [给定的时间戳]
 * @param  [int] $current_time [要与之相减的时间戳，默认为当前时间]
 * @return [string]            [相差天数]
 */
function tmspan($timestamp,$current_time=0){
    if(!$current_time) $current_time=time();
    $span=$current_time-$timestamp;
    if($span<60){
        return "刚刚";
    }else if($span<3600){
        return intval($span/60)."分钟前";
    }else if($span<24*3600){
        return intval($span/3600)."小时前";
    }else if($span<(7*24*3600)){
        return intval($span/(24*3600))."天前";
    }else{
        return date('Y-m-d',$timestamp);
    }
}

//生成訂單號
function create_order(){
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    return $orderSn;
}
/**
 * 随机字符
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string
 */
function random($length=32, $type='all', $convert=-1){
    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );

    if(!isset($config[$type])) $type = 'string';
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) -1;
    for($i = 0; $i < $length; $i++){
        $code .= $string{mt_rand(0, $strlen)};
    }
    if(!empty($convert)){
        $code = ($convert > 0)? strtoupper($code) : strtolower($code);
    }
    return $code;
}


//第一次签名的函数produceWeChatSign
function produceWeChatSign($newPara){
    $stringA = getSignContent($newPara);

    return $stringA;
}

//生成xml格式的函数
function getWeChatXML($newPara){
    $xmlData = "<xml>";
    foreach ($newPara as $key => $value) {
        $xmlData = $xmlData."<".$key.">".$value."</".$key.">";
    }
    $xmlData = $xmlData."</xml>";
    return $xmlData;
}

//通过curl发送数据给微信接口的函数
function sendPrePayCurl($xmlData) {
    $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    $header[] = "Content-type: text/xml";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlData);
    $data = curl_exec($curl);
    if (curl_errno($curl)) {
        print curl_error($curl);
    }
    curl_close($curl);
    return XMLDataParse($data);

}

//xml格式数据解析函数
function XMLDataParse($data){
    $msg = array();
    $msg = (array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
    return $msg;
}

//二次签名的函数
function weChatSecondSign($newPara,$prepay_id){
    $secondSignArray = array(
        "appid"=>$newPara['appid'],
        "noncestr"=>$newPara['nonce_str'],
        "package"=>"Sign=WXPay",
        "prepayid"=>$prepay_id,
        "partnerid"=>$newPara['mch_id'],
        "timestamp"=>$newPara['timeStamp'],
    );
    $stringA = getSignContent($secondSignArray);

    return $stringA;
}
//将xml转化为数组，接收微信返回数据时用到
function FromXml($xml)
{
    if(!$xml){
        echo "xml数据异常！";
    }
    //将XML转为array
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $data;
}

/*function getSignContent($signArray){
    //去除数组中的空值
    $arr = array_filter($signArray);
    //如果数组中有签名删除签名
        if(isset($arr['sing']))
        {
           unset($arr['sing']);
        }
       //按照键名字典排序
        ksort($arr);
         //生成URL格式的字符串

    $buff = "";
    foreach ($arr as $k => $v)
    {
        if($k != "sign" && $v != "" && !is_array($v)){
            $buff .= $k . "=" . $v . "&";
        }
    }

    $buff = trim($buff, "&");

    //签名步骤二：在string后加入KEY
    $string = $buff . "&key=x7c96v5634luh98s384hyy9dkj45iusa";
    //签名步骤三：MD5加密
    $string = md5($string);
    //签名步骤四：所有字符转为大写
    $result = strtoupper($string);
    return $result;
}*/
function getSignContent($params) {
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



/**
 * 验证码检查
 */
function check_verify($code, $id = ""){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 返回json格式
 * @author  youlong
 * @version 1.0
 * @param1  String $id 身份证号
 * @return  布尔
 **/
function is_idcard( $id )
{
    $id = strtoupper($id);
    $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
    $arr_split = array();
    if(!preg_match($regx, $id))
    {
        return FALSE;
    }
    if(15==strlen($id)) //检查15位
    {
        $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

        @preg_match($regx, $id, $arr_split);
        //检查生日日期是否正确
        $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
        if(!strtotime($dtm_birth))
        {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    else      //检查18位
    {
        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
        @preg_match($regx, $id, $arr_split);
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
        if(!strtotime($dtm_birth)) //检查生日日期是否正确
        {
            return FALSE;
        }
        else
        {
            //检验18位身份证的校验码是否正确。
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            $sign = 0;
            for ( $i = 0; $i < 17; $i++ )
            {
                $b = (int) $id{$i};
                $w = $arr_int[$i];
                $sign += $b * $w;
            }
            $n = $sign % 11;
            $val_num = $arr_ch[$n];
            if ($val_num != substr($id,17, 1))
            {
                return FALSE;
            } //phpfensi.com
            else
            {
                return TRUE;
            }
        }
    }

}

/**
 * 返回json格式
 * @author  yangxiuchuan
 * @version 1.0
 * @param1  Array $data 数据
 * @param2  int   $type 错误码
 * @return  Json
 **/
function echoJson($data, $type=0)
{
    echo json_encode(dataFormat($data,$type),JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * 数据格式
 * @author  yangxiuchuan
 * @version 1.0
 * @param1  Array $msg  信息提示
 * @param2  Array $data 数据
 * @param3  int   $type 错误码
 * @return  Array
 **/
function  dataFormat($msg, $data, $type=0)
{
    return array('code'=>$type,'msg'=>$msg,'data'=>$data);
}

/**
 * 接口加密规则
 * @author  yangxiuchuan
 * @version 1.0
 * @param1  String $str 要加密的字符串
 * @return  String
 **/
function md5Port($str)
{
    return md5($str);
}

/**
 * 登陆密码加密规则
 * @author  yangxiuchuan
 * @version 1.0
 * @param1  String $pwd 要加密的字符串
 * @return  String
 **/
function md5Pwd($pwd)
{
    return md5($pwd);
}

/**
 * 生成邀请码
 * @author  yangxiuchuan
 * @version 1.0
 * @param1
 * @return  String
**/
function invitationCode()
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charslen = strlen($chars);
    $name = '';
    for($i=0;$i<8;$i++){
        $name .= $chars[rand(0,$charslen-1)];
    }
    return $name;
}

/**
 * 随机获取名字
 * @author  yangxiuchuan
 * @version 1.0
 * @param1
 * @return  String
 **/
function getName()
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charslen = strlen($chars);
    //名字前缀
    $name = 'jkg_';
    //名字后缀长度
    $namelen = rand(8,16);
    for($i=0;$i<$namelen;$i++){
        $name .= $chars[rand(1,$charslen-1)];
    }
    return $name;
}

/**
 * 生成验证码
 * @author  yangxiuchuan
 * @version 1.0
 * @param1
 * @return  String
 **/
function getCode()
{
    $code = '';
    for($i=0;$i<4;$i++){
        $code .= rand(0,9);
    }
    return $code;
}

/**
 * 文件上传类
 * @author  yangxiuchuan
 * @version 1.0
 * @param1  String $path 子目录
 * @return  Array
 **/
function doUpload($path)
{
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize = 0;// 设置附件上传大小
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath = './Public/'; // 设置附件上传根目录
    $upload->savePath = $path; // 设置附件上传（子）目录
    // 上传文件
    $info = $upload->upload();
    if (!$info) {
        // 上传错误提示错误信息
        return array('error' => 1, 'msg' => $upload->getError());
    } else {
        //上传成功
        return array('error' => 0, 'msg' => $info);
    }
}

/**
 * 缩略图生成
 * @author  yangxiuchuan
 * @version 1.0
 * @param1  Array $imgpath    上传成功的图片数据
 * @param2  Int   $thumbWidth  缩略图宽度
 * @param3  Int   $thumbHeight 缩略图高度
 * @return  Array
 **/
function thumbImgs($imgpath, $thumbWidth, $thumbHeight)
{
    $image = new \Think\Image();

    foreach($imgpath as $file) {

        $thumb_file = $file['savepath'] . $file['savename'];
        $save_path = $file['savepath'] . 'thumb_' . $file['savename'];
        $res = $image->open( './Public/' . $thumb_file )->thumb( $thumbWidth, $thumbHeight,\Think\Image::IMAGE_THUMB_SCALE )->save( './Public/' . $save_path );
        if($res==true){
            $picpath[] = array(
                'pic_path' => $thumb_file,
                'thumb_pic' => $save_path
            );
        }else{
            $picpath[] = array(
                'pic_path' => $thumb_file,
                'thumb_pic' => $thumb_file
            );
        }
    }
    return $picpath;
}

/**
 * 向手机发送验证吗
 * @author  xuliang
 * @version 1.0
 * @param1   String $phone 手机号
 * @param2  String $rand  验证码
 * @param3  String $area_code 区号
 * @return  String
 */
function sendCode($phone,$rand,$area_code)
{
    //第三方插件
    Vendor('SendSMS/sms');
    $target = "http://cf.lmobile.cn/submitdata/Service.asmx/g_Submit";
    //测试账号
    if($area_code=='86'){
        $post_data ="sname=dlhulian&spwd=dT9qP2qx&scorpid=&sprdid=1012818&sdst={$phone}&smsg=".rawurlencode("【健康股】验证码：{$rand}(健康股欢迎您)");
    }else{
        $post_data = "sname=dlhulian&spwd=dT9qP2qx&scorpid=&sprdid=1012818&sdst={$phone}&smsg=".rawurlencode("【健康股】验证码：{$rand}(健康股欢迎您)");
    }

    return Post($post_data, $target);
}



