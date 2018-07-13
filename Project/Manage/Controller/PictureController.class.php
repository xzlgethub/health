<?php

namespace Manage\Controller;

use Think\Controller;

class PictureController extends Controller
{
    /**
     * 上传首页
     *
     * @author dongjialin
     * @version 1.0
     **/
    public function index()
    {
        $picture = M('picture');
        $res = $picture->select();
        $this->assign('res', $res);
        $this->display();
    }

    /**
     * 上传页
     *
     * @author dongjialin
     * @version 1.0
     **/
    public function add()
    {
        $this->display();
    }

    /**
     * 修改页
     *
     * @author dongjialin
     * @version 1.0
     **/
    public function edit()
    {
        $id = I('id');
        $this->assign('id', $id);

        $picture = M('picture');
        $res = $picture->where("id = '$id'")->find();
        $this->assign('res', $res);
        $this->display();
    }

    /**
     * 添加动作
     *
     * @author dongjialin
     * @version 1.0
     **/
    public function addAction()
    {
        $picname = doUpload();
        $picture = M('picture');
        for ($i = 0; $i < count($picname); $i++) {
            $data = array("picname" => $picname[$i]);
            $picture = $picture->add($data);
        }
        $this->redirect('Picture/index');
    }

    /**
     * 修改动作
     *
     * @author dongjialin
     * @version 1.0
     **/
    public function editAction()
    {
        $picname = doUpload();
        $data = array(
            'picname' => $picname['0']
        );

        $id = I('id');
        $picture = M('picture');
        //查询原图片并删除
        $res = $picture->where("id = '$id'")->find();
        unlink('./Public/file/' . $res['picname']);

        //修改新图片名
        $res1 = $picture->where("id = '$id'")->save($data);

        $this->redirect('Picture/index');
    }

    /**
     * 删除动作
     *
     * @author dongjialin
     * @version 1.0
     **/
    public function delAction()
    {
        $id = I('id');
        //查询
        $res = M('picture')->where("id = '$id'")->find();
        unlink('./Public/file/' . $res['picname']);

        $res1 = M('picture')->where("id = '$id'")->delete();
        if ($res1) {
            $this->redirect('Picture/index');
        } else {
            $this->error('删除失败');
        }
    }
}