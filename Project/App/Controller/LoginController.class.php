<?php
/**
 * 登陆和注册相关接口
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 9:56
 */

namespace App\Controller;

class LoginController extends CommonController
{
    /**
     * 发送验证码
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String phone 手机号
     * @param2  Int    $type 验证码类型
     * @param3  String $area_code 区号
     * @return  JSON
     **/
    protected function securityCode($phone, $type, $area_code)
    {
        //获取验证码
        $code = getCode();
        $codeTable = D('CodeVerification');
        //修改表里手机号对应的验证码信息
        $res = $codeTable->updateCode($phone, $code, $type, $area_code);
        if($res){
                //向手机发送验证码
            sendCode($phone,$code,$area_code);
//            $this->ajaxReturn(dataFormat('ok',$code));
            return array('code'=>0,'msg'=>'ok','data'=>$code);
        }
//        $this->ajaxReturn(dataFormat('no','',1));
        return array('code'=>1,'msg'=>'no');
    }

    /**
     * 验证码校验
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String phone 手机号
     * @param2  String code  用户输入的验证码
     * @param3  String $type 验证码类型
     * @param4  String $area_code 区号
     * @return JSON
     **/
    protected function codeVerify($phone, $code, $type, $area_code)
    {
        $where = array(
            'phone'  => $phone,
            'type'   => $type,
            'area_code' => $area_code,
            'status' => 0
        );
        $cv = D('CodeVerification');
        //查询是否有数据
        $res = $cv->selectOne($where);
        if($res==NULL){
//            $this->ajaxReturn(dataFormat('请重新提交',3));
            return array('code'=>3,'msg'=>'请重新提获取验证码');
        }
        //验证码生成时间戳
        $time = intval($res['time']);
        //当前时间戳
        $nowtime = time();
        //判断是否过期
        if($nowtime>$time+60*5){
//            $this->ajaxReturn(dataFormat('验证码过期',2));
            return array('code'=>2,'msg'=>'验证码过期');
        }
        //判断是否正确
        if($code!=$res['code']){
//            $this->ajaxReturn(dataFormat('验证码错误',1));
            return array('code'=>1,'msg'=>'验证码错误');
        }
        //修改验证码为已使用状态
        $res = $cv->saveStatus($where);
//        $this->ajaxReturn(dataFormat('ok'));
        return array('code'=>0,'msg'=>'ok');
    }

    /**
     * 手机号登陆接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $phone 手机号
     * @param2  String $pwd   登陆密码
     * @param2  String $area_code 区号
     * @return  JSON
     **/
    public function login($phone, $pwd, $area_code)
    {
        $user = D('User');
        $where = array(
            'phone' => $phone,
            'area_code' => $area_code
        );
        $field = 'id,phone,pwd,name,thumbpic,life,lis,status,invitation_code';
        //查询是否有该手机号
        $row = $user->selectRow($where, $field);
        if($row == NULL){
            $this->ajaxReturn(dataFormat('手机号或密码不正确','',1));
        }
        if($row['status']==0){
            $this->ajaxReturn(dataFormat('手机号已被禁用','',1));
        }
        if(md5($pwd)!=$row['pwd']){
            $this->ajaxReturn(dataFormat('手机号或密码不正确','',1));
        }
        unset($row['pwd']);
        //拼接完整URL图片路径
        $row['thumbpic'] = $this->picPath . '/Public/' . $row['thumbpic'];
        $this->ajaxReturn(dataFormat('ok',$row));
    }

    /**
     * 短信登陆接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $phone 手机号
     * @param2  String $code   短信验证码
     * @param2  String $area_code 区号
     * @return  JSON
     **/
    public function noteLogin($phone, $code, $area_code)
    {
        //验证码校验
        $res = $this->codeVerify($phone, $code, 1,$area_code);

        if($res['code']==0){
            $user = D('User');
            $where = array(
                'phone' => $phone,
                'area_code' => $area_code
            );
            $field = 'id,phone,name,thumbpic,life,lis,status';
            //查询是否有该手机号
            $row = $user->selectRow($where, $field);
            if($row['status']==0){
                $this->ajaxReturn(dataFormat('手机号已被禁用','',1));
            }
            $row['thumbpic'] = $this->picPath . '/Public/' . $row['thumbpic'];
            $this->ajaxReturn(dataFormat('ok',$row));
        }else{
            $this->ajaxReturn(dataFormat($res['msg'],'',$res['code']));
        }
    }

    /**
     * 注册验证码发送接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String phone 手机号
     * @return  JSON
     **/
    public function registerCode($phone, $area_code)
    {
        //发送验证码
        $status = $this->securityCode($phone, 0, $area_code);
        if($status['code']==0){
            $this->ajaxReturn(dataFormat($status['msg'],$status['data'],$status['code']));
        }
        $this->ajaxReturn(dataFormat($status['msg'],'',$status['code']));
    }

    /**
     * 登陆验证码发送接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String phone 手机号
     * @param2  String $area_code 区号
     * @return  JSON
     **/
    public function loginCode($phone,$area_code)
    {
        $user = D('User');
        $where = array(
            'phone' => $phone,
            'area_code' => $area_code
        );
        $field = 'phone';
        //查询手机是否注册
        $row = $user->selectRow($where, $field);
        if(!$row){
            $this->ajaxReturn(dataFormat('请先注册','',2));
        }
        $status = $this->securityCode($phone, 1,$area_code);
        if($status['code']==0){
            $this->ajaxReturn(dataFormat($status['msg'],$status['data'],$status['code']));
        }
        $this->ajaxReturn(dataFormat($status['msg'],'',$status['code']));
    }

    /**
     * 注册验证码验证接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $phone 手机号
     * @param1  String $code  验证码
     * @param1  String $area_code 区号
     * @return  JSON
     **/
    public function registerVerify($phone, $code, $area_code)
    {
        //校验验证码
        $res = $this->codeVerify($phone, $code, 0,$area_code);
        if($res['code']==0){
            $this->ajaxReturn(dataFormat('ok',$phone));
        }else{
            $this->ajaxReturn(dataFormat($res['msg'],'',$res['code']));
        }
    }

    /**
     * 注册滑动验证接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String phone 手机号
     * @param2  String $area_code 区号
     * @return  JSON
     **/
    public function uniqueness($phone, $area_code)
    {
        if(!isset($phone)){
            $this->ajaxReturn(dataFormat('手机号为空','',3));
        }
        $user = D('User');
        //获取当前手机号数据
        $where = array(
            'phone' => $phone,
            'area_code' => $area_code
        );
        $field = 'phone';
        $res = $user->selectRow($where, $field);
        if($res!=NULL){
            $this->ajaxReturn(dataFormat('手机号已存在','',2));
        }
        $json = $this->securityCode($phone, 0, $area_code);
        if($json['code']==0){
            $this->ajaxReturn(dataFormat('ok',$json['data']));
        }else{
            $this->ajaxReturn(dataFormat('发送验证码失败','',1));
        }
    }

    /**
     * 注册接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $phone 手机号
     * @param2  String $pwd   密码
     * @param3  String $cpwd  确认密码
     * @param3  String $area_code 区号
     * @return  JSON
     **/
    public function register($phone, $pwd, $cpwd, $area_code)
    {
        if($pwd!=$cpwd){
            $this->ajaxReturn(dataFormat('两次密码不一致','',2));
        }
        if(empty($phone)){
            $this->ajaxReturn(dataFormat('请填写手机号','',3));
        }
        $cv = D('User');
        $name = getName();
        $invitationCode=invitationCode();
        while($cv->selectInvitationCodeFind($invitationCode)!=null){
            $invitationCode=invitationCode();
        }
        $headpic = 'default.jpg';
        $data = array(
            'phone'      => $phone,
            'pwd'        => md5Pwd($pwd),
            'name'       => $name,
            'headpic'    => $headpic,
            'thumbpic'   => $headpic,
            'createtime' => date('Y-m-d H:i:s'),
            'area_code'  => $area_code,
            'invitation_code' => $invitationCode
        );
        //注册
        $res = $cv->addUser($data);
        if($res==0){
            $this->ajaxReturn(dataFormat('注册失败','',1));
        }
        //添加注册奖励
        $add = array(
            'uid'=>$res,
            'revenuetype'=>'注册奖励',
            'life'=>100,
            'lis'=>10,
            'createtime'=>date('Y-m-d H:i:s'),
            'type'=>0
        );
        $r = M('integral')->add($add);
        if($r){
            //修改用户表字段信息
            M('user')->where('id=' . $res)->setInc('life',100);
            M('user')->where('id=' . $res)->setInc('lis',10);
        }
        $this->login($phone, $pwd, $area_code);
//        $this->ajaxReturn(dataFormat('ok',''));
    }

    /**
     *修改手机号短信发送接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $phone 手机号
     * @param1  String $area_code 区号
     * @return  JSON
     **/

    public function updateCode($phone, $area_code)
    {
        if(!isset($phone)){
            $this->ajaxReturn(dataFormat('手机号为空','',3));
        }
        $user = D('User');
        //获取当前手机号数据
        $where = array(
            'phone' => $phone,
            'area_code' => $area_code
        );
        $field = 'phone';
        $res = $user->selectRow($where, $field);
        if($res!=NULL){
            $this->ajaxReturn(dataFormat('手机号已被注册','',2));
        }
        $status = $this->securityCode($phone, 2, $area_code);
        if($status['code']==0){
            $this->ajaxReturn(dataFormat($status['msg'],$status['data'],$status['code']));
        }
        $this->ajaxReturn(dataFormat($status['msg'],'',$status['code']));
    }

    /**
     *手机号修改接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int    $uid 用户ID
     * @param2  String $phone 新手机号
     * @param3  String $code  验证码
     * @param3  String $area_code  新的区号
     * @return  JSON
     **/
    public function updateVerify($uid, $phone, $code, $area_code)
    {
        $res = $this->codeVerify($phone, $code, 2, $area_code);
        if($res['code']==0){
            $user = D('User');
            $users = $user->updatePhone($uid,$phone,$area_code);
            if($users){
                $this->ajaxReturn(dataFormat('ok',$phone));
            }
            $this->ajaxReturn(dataFormat('修改失败','',4));
//            $this->ajaxReturn(dataFormat('ok',$phone));
        }else{
            $this->ajaxReturn(dataFormat($res['msg'],'',$res['code']));
        }
    }
}