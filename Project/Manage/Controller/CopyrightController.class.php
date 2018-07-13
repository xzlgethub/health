<?php
namespace Manage\Controller;

use Think\Controller;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CopyrightController extends CommonController
{
    /**
     * 版权首页
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function index()
    {
        $res = M('copyright')->find();
        $this->assign('res', $res);
        $this->display();
    }

    /**
     * 添加版权
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function addAction()
    {
        $val['name'] = I('name');
        $res = M('copyright')->add($val);
        if ($res) {
            $_SESSION['users']['copyright'] = $val['name'];
            $this->redirect('Copyright/index');
        }else{
            $this->redirect('Copyright/add');
        }
    }

    /**
     * 删除版权
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function delAction()
    {
        $id = I('id');
        M('copyright')->where("id = '$id'")->delete();
        $this->redirect('Copyright/index');
    }

    /**
     * 修改版权
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function edit()
    {
        $id = I('id');
        $res = M('copyright')->where("id = '$id'")->find();
        $this->assign('res', $res);
        $this->display();
    }

    /**
     * 修改动作
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function editAction()
    {
        $id = I('id');
        $data = array('name' => I('name'));
        $res = M('copyright')->where("id = '$id'")->save($data);
        if($res){
            $_SESSION['users']['copyright'] = I('name');
        }
        $this->redirect('Copyright/index');
    }
}