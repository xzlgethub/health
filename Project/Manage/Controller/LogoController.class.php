<?php
namespace Manage\Controller;

use Think\Controller;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogoController extends CommonController
{
    /**
     * Logo首页
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function index()
    {
        $res = M('logo')->order('state asc')->select();
        $this->assign('res', $res);
        $this->display();
    }

    /**
     *状态修改
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function stateLogo()
    {
        $id = I('id');
        $state = I('state');
        $logo = D('Logo');
        $res = $logo->saveState($id, $state);
        if($res){
            if($state==1){
                $logo->saveOpposite($id);
            }
            $where = array(
                'state' => 1
            );
            $picpath = M('logo')->where($where)->find();
            $_SESSION['users']['logo'] = $picpath['name'];
        }
        $this->redirect('Logo/index');
    }

    /**
     *添加Logo
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function addAction()
    {
        $var['state'] = I('state');
        $file = $_FILES['name'];
        $var['name'] = $this->myupload($file);

        $user = D('Manage/Logo');
        $res = $user->addLogo($var);
        if($res){
            if($var['state']==1){
                $_SESSION['users']['logo'] = $var['name'];
                $user->saveOpposite($res);
            }
            //日志
            addlog('LOGO&nbsp;&nbsp;&nbsp;ID：'.$res);
        }
        $this->redirect('Logo/index');
    }

    /** myupload 图片上传的类
     * 上传方法，直接调用  返回文件名
     */
    public function myupload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728000 ;// 设置附件上传大小
        $upload->autoSub   =     false;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/'; // 设置附件上传目录
        $upload->savePath  =      'file/logo/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info){
            // 上传错误提示错误信息
            //$this->error($upload->getError());
            $this->error($upload->getError(),U('logo/add'),10);
            return false;
        }else{
            // 上传成功
            foreach($info as $file){
                $picName = $file['savepath'] . $file['savename'];
            }
            return $picName;
        }
    }


    /**
     * 删除Logo
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function delAction()
    {
        $id = I('id');
        $res = M('logo')->where("id = '$id'")->find();
        $pic = "./Public/".$res['name'];
        unlink($pic);
        $logo = M('logo')->where("id = '$id'")->delete();
        if($logo){
            //日志
            dellog('LOGO：'.$res['id']);
        }
        $this->redirect('Logo/index');
    }

    /**
     * 修改Logo
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function edit()
    {
        $id = I('id');
        $res = M('logo')->where("id = '$id'")->find();
        $this->assign('res', $res);
        $this->display();
    }

    /**
     *修改动作
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function editAction()
    {
        $id = I('id');
        $state = I('state');
        $yname = I('yname');
        $file = $_FILES['name'];
        $var['name'] = $this->myupload($file);
        if($var['name']== false){
            $var['name'] = $yname;
        }
        $res = M('logo')->where("id = '$id'")->save($var);
        if($res){
            if($var['name']!=false){
                $pic = "./Public/".$yname;
                unlink($pic);
                $_SESSION['users']['logo'] = $var['name'];

                editlog('LOGO：ID：'.$res['id']);
            }
            if($state==1){
                $user = D('Manage/Logo');
                $user->saveOpposite($id);
            }
        }
        $this->redirect('Logo/index');
    }
}