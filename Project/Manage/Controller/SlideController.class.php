<?php

namespace Manage\Controller;
use Think\Controller;
class SlideController extends Controller
{
    /**
     * 上传首页
     * @author xl
     * @version 1.0
     **/
     public function index()
    {
        $user = M('slide');
        $p = I('p');
        if($p == ''){
            $p = '1';
        }

        $count = $user->page($p . ',10')->order('id desc')->count();// 查询满足要求的总记录数
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $user->page($p . ',10')->order('id desc')->select();
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();

    }

    /**
     * 上传页
     * @author xl
     * @version 1.0
     **/
    public function add()
    {
        $res = M('pics')->order('id desc')->select();
        $this->assign('res',$res);
        $this->display();
    }

    /**
     * 修改页
     * @author xl
     * @version 1.0
     **/
    public function edit()
    {   
        $id = I('id');
        $res = M('slide')->where("id = '$id'")->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*图片上传的类
    * 上传方法，直接调用  返回文件名
    */
    public function myupload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728000 ;// 设置附件上传大小
        $upload->autoSub   =     false;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/'; // 设置附件上传目录
        $upload->savePath  =      'slide/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if($info){
            // 上传成功
            foreach($info as $file){
                $picName = $file['savename'];
            }
            return $picName;
        }
    }

    /**
     * 添加动作
     * @author xl
     * @version 1.0
     **/
    public function addAction()
    {
        $data = I('post.');
        $file = $_FILES['pic'];
        $data['pic'] = $this->myupload($file);
        $res = M('slide')->add($data);
        if($res){
            //日志
            addlog('轮播图：'.$data['name'].'&nbsp;&nbsp;&nbsp;ID：'.$res);
        }
        $this->redirect("Slide/index");
    }

    /**
     * editAction   修改动作
     * @author xl
     * @version 1.0
     **/
    public function editAction()
    {
        $data = I('post.');
        if($_FILES['pic']['name'] == ''){
            unset($data['ypic']);
        }else{
            $file = $_FILES['pic'];
            $data['pic'] = $this->myupload($file);
            unlink('./Public/slide/'.$data['ypic']);
            unset($data['ypic']);
        }
        $oneR = M('slide')->where("id =".$data['id'])->find();
        $res = M('slide')->where("id = '{$data['id']}'")->save($data);
        if($res){  //添加日志
            editlog('轮播图：'.$oneR['name'].'&nbsp;&nbsp;&nbsp;ID：'.$data['id']);
        }
        $this->redirect('Slide/index');
    }

    /**
     * 删除动作
     * @author xl
     * @version 1.0
     **/
    public function delAction()
    {
        $id = I('id');
        //查询
        $ress = M('slide')->where("id = '$id'")->find();
        $picname = $ress['pic'];
        $res = M('slide')->where("id = '$id'")->delete();
        if($res){
            //日志
            dellog('轮播图：'.$ress['name']);
        }
        unlink('./Public/slide/'.$picname);
        $this->redirect('Slide/index');
    }

    /**
     * status   轮播图状态操作
     * @author   xuliang
     * @version  1.0
     * @param    str id     轮播id
     * @param    str type   状态
     * @return   类型
     */
    public function status()
    {
        $id = I('id');
        $type['status'] = I('type');
        M('slide')->where("id = '{$id}'")->save($type);
        $this->redirect('Slide/index');
    }

    /**
     * slideajax   轮播图状态操作
     * @author   xuliang
     * @version  1.0
     * @param    str id     轮播id
     * @param    str type   状态
     * @return   类型
     */
    public function slideajax()
    {
        $id = I('uid');
        $type['status'] = '1';
        for($i=0;$i<count($id);$i++){
            $slide = M('slide')->where("id = '{$id[$i]}' AND status != '1'")->find();
            if($slide){
                M('slide')->where("id = '{$id[$i]}'")->save($type);
            }
        }
        //$this->ajaxReturn($id);
        $this->redirect('Slide/index');
    }

}