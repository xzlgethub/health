<?php

namespace Manage\Controller;
use Think\Controller;
class EditorController extends Controller
{
    /**
     * 上传首页
     *
     * @author saibei
     * @version 1.0
     **/
     public function index()
    {   
        $res = M('editor')->select();
        $this->assign('res',$res);
        $this->display();
    }
    /**
     * 上传页
     *
     * @author saibei
     * @version 1.0
     **/
    public function add()
    {
        $this->display();
    }
    /**
     * 修改页
     *
     * @author saibei
     * @version 1.0
     **/
    public function edit()
    {   
        $id = I('id');
        $res = M('editor')->where("id = '$id'")->find();
        $this->assign('res',$res);
        $this->display();
    }
    /**
     * 添加动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function addAction()
    {   
        $rand_name = uniqid(rand()).'.text';
        $myfile = fopen("./Public/editor/".$rand_name, "w") or die("Unable to open file!");
        $content = $_POST['editorValue'];
        fwrite($myfile, $content);
        fclose($myfile);
        $data = array(
            'name' => I('name'),
            'path' => $rand_name,
        );
        $res = M('editor')->add($data);
        if($res){
            $this->redirect("Editor/index");
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function editAction()
    {   
        //查询原文件
        $id = I('id');
        $res = M('editor')->where("id = '$id'")->find();
        $path = $res['path'];
        //覆盖文件
        $myfile = fopen("./Public/editor/".$path, "w") or die("Unable to open file!");
        $content = $_POST['editorValue'];
        fwrite($myfile, $content);
        fclose($myfile);
        $data = array(
            'name' => I('name'),
        );
        $res1 = M('editor')->where("id = '$id'")->save($data);
        $this->redirect("Editor/index"); 
    }

    /**
     * 删除动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function delAction()
    {
        $id = I('id');
        //查询
        $res = M('editor')->where("id = '$id'")->find();
        $path = $res['path'];
        $res = M('editor')->where("id = '$id'")->delete();
        if($res){
            unlink('./Public/editor/'.$path);
            $this->redirect('Editor/index');
        }else{
            $this->error('删除失败');
        }
    }  
     /**
     * 查看动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function see()
    {   
        $id = I('id');
        $res = M('editor')->where("id = '$id'")->find();
        $this->assign('res',$res);
        $this->display(); 
    }   
}