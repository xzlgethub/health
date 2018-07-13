<?php
/**
 * 公共类
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/16
 * Time: 16:01
 */

namespace App\Controller;

use Boris\Boris;
use Think\Controller;

class CommonController extends Controller
{
//   public $picPath = 'http://123.56.146.165/Lifeshare'; //图片根域名
   public $picPath = 'http://demo.huliantec.com/lifeshare'; //图片根域名
    private $appkey = '585972bd7a1bf853573aeb0120fce1f9'; //接口验证的加密字符串
    private $privatekey = 'c30adcd0bcf2c4c739c9510f044b72a2';//接口验证的加密字符串

    /**
     * 接口验证
     * @author yangxiuchuan
     * @version 1.0
     * @param1
     * @return JSON
     **/
    public function __construct()
    {
//        return false;
        if(CONTROLLER_NAME  . '/' . ACTION_NAME=='MyCenter/saveImg' || CONTROLLER_NAME  . '/' . ACTION_NAME=='MyCenter/uploadReport'){
            return true;
        }
        //获取访问的接口名称
        $action = CONTROLLER_NAME  . '/' . ACTION_NAME;
        $create_sign = md5Port($this->appkey . $action . $this->privatekey);
       // var_dump($create_sign);die;

        $dataflow = file_get_contents('php://input');
        $data = json_decode($dataflow,true);
        $_POST = $data;
       if(!isset($data['sign'])){
           $this->ajaxReturn(dataFormat('无sign值','',300));
        }
        //获取前台生成的sign
        $sign = $data['sign'];
        //验证sign是否正确
        if($sign!=$create_sign){
            $this->ajaxReturn(dataFormat('sign验证失败','',400));
        }
    }
}