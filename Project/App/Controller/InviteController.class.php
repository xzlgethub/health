<?php
namespace App\Controller;
use Think\Controller;
class InviteController extends Controller
{

    //检验图形验证码是否正确接口
    public function checkPhone(){
        $phone = I('phone');
//        echo 1;die;
        $t_code = I('checkcode');
        $area_code = I('area_code');
        $yao_code = I('yao_code');
        $state = I('state');
/*        if($state == 1){
            $type = 0;
            //获取验证码
            $code = getCode();
            $codeTable = D('CodeVerification');
            //修改表里手机号对应的验证码信息
            $res = $codeTable->updateCode($phone, $code, $type, $area_code);
            if($res){
                //向手机发送验证码
                sendCode($phone,$code,$area_code);
            }
           echo 1;die;
        }*/
//        echo json_encode(array('phone'=>$phone,'area_code'=>$area_code,'yao_code'=>$yao_code));die;
        if(check_verify($t_code) !== true)
        {
            echo 1;die;
//            $this->ajaxReturn(dataFormat('验证码错误','',1));// 1 验证码错误
        }
        if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)) {
//            $this->ajaxReturn(dataFormat('手机号格式错误','',2));// 2手机号格式错误
            echo 2;die;
        }
            $where = array(
            'phone' => $phone,
            'area_code' => $area_code
        );
        $rel = M('user')->where($where)->find();
        if($rel){
            echo 3;die;
//            $this->ajaxReturn(dataFormat('该用户已注册','',3)); //3 该用户已经注册
        }
        $type = 0;
        //获取验证码
        $code = getCode();
        $codeTable = D('CodeVerification');
        //修改表里手机号对应的验证码信息
        $res = $codeTable->updateCode($phone, $code, $type, $area_code);
       if($res){
            //向手机发送验证码
            sendCode($phone,$code,$area_code);
        }
//        $this->ajaxReturn(dataFormat('验证码已发送','',0));// 0 验证码已发送

        $this->ajaxReturn(array('phone'=>$phone,'area_code'=>$area_code,'yao_code'=>$yao_code));die;

    }
    //验证码失效重复发送验证码
    public function repeat_code(){
        $phone = I('phone');
        $area_code = I('area_code');
        $type = 0;
        $code = getCode();
        $codeTable = D('CodeVerification');
        //修改表里手机号对应的验证码信息
        $res = $codeTable->updateCode($phone, $code, $type, $area_code);
        if($res){
            //向手机发送验证码
            sendCode($phone,$code,$area_code);
        }
       echo 1;die;

    }


    /**
     * 手机验证码校验接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String phone 手机号
     * @param2  String code  用户输入的验证码
     * @param3  String $type 验证码类型
     * @param4  String $area_code 区号
     * @return JSONcodeVerify
     **/
    public function codeVerify()
    {
        $phone = I('phone');
        $area_code = I('area_code');
        $code = I('invite_code');
        $state = I('state');
        $yao_code = I('yao_code');
        $where = array(
            'phone'  => $phone,
            'type'   => 0,
            'area_code' => $area_code,
            'status' => 0
        );
        $cv = D('CodeVerification');
        //查询是否有数据
        $res = $cv->selectOne($where);
        if($res==NULL){
//            $this->ajaxReturn(dataFormat('验证码无效','',1));
            echo 2;die;//验证码无效

        }
        //验证码生成时间戳
        $time = intval($res['time']);
        //当前时间戳
        $nowtime = time();
        //判断是否过期
        if($nowtime>$time+60){
//            $this->ajaxReturn(dataFormat('验证码过期','',2));
        echo 3;die;
        }
        //判断是否正确
        if($code!=$res['code']){
//            $this->ajaxReturn(dataFormat('验证码错误','',3));
            echo 4;die;

        }
        //修改验证码为已使用状态
//        $res = $cv->saveStatus($where);

        //注册成功  入表   给邀请码用户加积分
        $user = D('User');
        $name = getName();
        $invitationCode=invitationCode();
        while($user->selectInvitationCodeFind($invitationCode)!=null){
            $invitationCode=invitationCode();
        }
        $headpic = 'default.jpg';
        $data = array(
            'phone'      => $phone,
            'headpic'    => $headpic,
            'name'    => $name,
            'thumbpic'   => $headpic,
            'createtime' => date('Y-m-d H:i:s'),
            'area_code'  => $area_code,
            'invitation_code' => $invitationCode
        );
        //注册
        $res = $user->add($data);
        if($res==0){
            $this->ajaxReturn(dataFormat('注册失败','',1));
        }
        //添加注册奖励
        $add = array(
            'uid'=>$res,
            'revenuetype'=>'分享奖励',
            'life'=>50,
            'lis'=>10,
            'createtime'=>date('Y-m-d H:i:s'),
            'type'=>0
        );
        $r = M('integral')->add($add);
        if($r){
            //修改用户表字段信息
            M('user')->where('id=' . $res)->setInc('life',50);
            M('user')->where('id=' . $res)->setInc('lis',10);
        }


        //添加注册奖励
        $b_id = M('user')->where("invitation_code = '{$yao_code}'")->getField('id');
        $adds = array(
            'uid'=>$b_id,
            'revenuetype'=>'分享奖励',
            'life'=>50,
            'lis'=>10,
            'createtime'=>date('Y-m-d H:i:s'),
            'type'=>0
        );
         M('integral')->add($adds);
        M('user')->where("invitation_code = '{$yao_code}'")->setInc('life',50);

//        $this->ajaxReturn(dataFormat('注册成功','',0));
        //修改验证码为已使用状态
        $res = $cv->saveStatus($where);
        echo 1;die;
    }

    public function index()
    {
//        $invite_code = I('invite_code');
//        $this->assign('invite_code',$invite_code);
        $yao_code = I('yaoCode');
        $this->assign('yao_code',$yao_code);
//        $this->assign('yao_code',66666);
        $this->display();
    }

    /**
     *
     * 验证码生成
     */
    public function verify_c(){
        ob_clean();
        $Verify =     new \Think\Verify();
        $Verify->fontSize = 15;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->entry();
    }


    public function code(){
        $phone = I('phone');
        $area_code = I('area_code');
        $this->assign('yao_code',I('yao_code'));
        $this->assign('phone',$phone);
        $this->assign('area_code',$area_code);
        $this->display();
    }
    public function download()
    {
        $this->display();
    }
    public function ce(){
        $this->display();
    }


}