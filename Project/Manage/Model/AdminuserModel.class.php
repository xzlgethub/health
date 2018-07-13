<?php
/**
 * user表增删改查等操作
 *
 * @author dongjialin
 * @Date: 2016/10/17 13:10
 **/
namespace Manage\Model;

use Think\Model;

class AdminuserModel extends Model
{
    /**
     * 登录验证
     *
     * @author dongjialin
     * @version 1.0
     * @return str
     **/
    public function Login()
    {
        $username = I('post.username');
        $password = I('post.pass');
        $where = array(
            'username' => $username,
            'password' => md5($password)
        );
        $adminuser = M('adminuser');
        $r = $adminuser->where($where)->find();
        if (md5($password) == $r['password'] && $username == $r['username']) {
            $logo = M('logo')->where('state=1')->find();
            if($logo==null){
                $logo['name'] = 'file/logo/logo.png';
            }
            $r['logo'] = $logo['name'];
            $copyright = M('copyright')->find();
            if($copyright==null){
                $copyright['name'] = '2018 ©健康股';
            }
            $r['copyright'] = $copyright['name'];
            session('users', $r);
            session('uid',$r['id']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改密码
     *
     * @author dongjialin
     * @version 1.0
     * @return str
     **/
    public function Editpwd()
    {
        $id = session('users.id');
        $pass = I('pass');
        $adminuser = M('adminuser');
        $res = $adminuser->where("id='$id'")->find();
        if ($res['password'] == md5($pass)) {
            $newpwd = I('newpass');
            $repwd = I('repass');
            $n = strlen($newpwd);
            if ($n <= 5) {
                $pwds = '密码长度在必须大于6位';
                $this->ajaxReturn($pwds);
            } else {
                if ($pass != $newpwd) {
                    if ($newpwd == $repwd) {
                        $data = array(
                            'password' => md5($newpwd),
                        );
                        $res = $adminuser->where("id = '$id'")->save($data);
                        if ($res) {
                            $re = 1;
                            return $re;
                        } else {
                            $re = '修改失败';
                            return $re;
                        }
                    } else {
                        $re = '两次密码不一致';
                        return $re;
                    }
                } else {
                    $re = '原密码与新密码相同';
                    return $re;
                }
            }
        } else {
            $re = '原始密码错误';
            return $re;
        }
    }
}