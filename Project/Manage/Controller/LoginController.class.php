<?php
/**
 * 登录的相关操作和用户的密码修改
 *
 * @author xl
 *
 **/
namespace Manage\Controller;

use Think\Controller;

class LoginController extends Controller
{
    /**
     * 后台登录页
     * @author yxc
     * @version 1.0
     * @return array
     **/
    public function index()
    {
        $logo = M("logo")->where('state=1')->find();
        if($logo==null){
            $logo['name'] = 'file/logo/logo.png';
        }
        $this->assign('logo', $logo);
        $copyright = M("copyright")->find();
        if($copyright==null){
            $copyright['name'] = '2018 ©健康股';
        }
        $this->assign('copyright', $copyright);
        $this->assign('logo', $logo);
        $this->display();
    }

    /**
     * 登录数据验证过程
     * @author yxc
     * @version 1.0
     * @return array
     **/
    public function login()
    {
        $admin = D('Manage/Adminuser');
        $res = $admin->Login();
        if ($res) {
            $this->redirect('Index/index');
        } else {
            $this->redirect('Login/index');
        }
    }

    /**
     * 退出登录
     * @author yxc
     * @version 1.0
     * @return array
     **/
    public function logout()
    {
        session('users', null);
        $this->redirect('Login/index');
    }

    /**
     * 验证登录
     *
     * @author yxc
     * @version 1.0
     * @return array
     **/
    public function vadataajax()
    {
        $name['username'] = trim(I("name"));
        $name['password'] = md5(trim(I("pass")));
        $u = M("adminuser")->where($name)->find();
        if ($u) {
            echo 0;
        } else {
            echo 1;
        }
    }

    /**
     * 修改密码
     * @author yxc
     * @version 1.0
     * @return array
     **/
    public function editpass()
    {
        $adminuser = D('Manage/Adminuser');
        $res = $adminuser->Editpwd();
        $this->ajaxReturn($res);
    }
}