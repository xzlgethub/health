<?php

namespace Manage\Controller;
use Think\Controller;
class SoftwareController extends CommonController
{
    /**
     * index   软件预览页
     * @author   xuliang
     * @version  1.0
     */
     public function index()
    {
        $Model = M('version');
        $p = I('p');
        if($p == ''){
            $p = '1';
        }
        $count = $Model->count();// 查询满足要求的总记录数
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $Model->page($p . ',10')->order('id desc')->select();
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();

    }

    /**
     * uploadSoftware   app上传的类  上传方法，直接调用
     * @author   xuliang
     * @version  1.0
     * @return   str    返回文件名
     */
    public function uploadSoftware($software){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728000 ;// 设置附件上传大小
        $upload->autoSub   =     false;
        $upload->exts      =     array('apk');// 设置附件上传类型
        $upload->rootPath  =      './Public/'; // 设置附件上传目录
        $upload->savePath  =      'version/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info){
            $this->error($upload->getError(),U('Software/add'),10);
        }else{
            // 上传成功
            foreach($info as $file){
                $picName = $file['savename'];
            }
            return $picName;
        }
    }

    /**
     * addAction   软件数据添加
     * @author   xuliang
     * @version  1.0
     */
     public function addAction()
    {
        $arr = I('post.');
        if($_FILES['version_route']['name']){
            $arr['version_route'] = $this->uploadSoftware($software);
        }
        $data = D('Manage/Version');
        $res = $data->addAction($arr);
        if($res){
            addlog('APP软件&nbsp;&nbsp;&nbsp;版本号：'.$arr['version_code'].'&nbsp;&nbsp;&nbsp;ID：'.$res);
            $this -> redirect('Software/index');
        }
    }

    /**
     * delUser   软件数据删除
     * @author   xuliang
     * @version  1.0
     */
     public function del()
    {
        $data = D('Manage/Version');
        $id = I('id');
        $oneR = M('version')->where("id =".$id)->find();
        $res = $data->del($id);
        if($res){
            //日志
            dellog('APP软件：'.$oneR['version_code']);
            $this -> redirect('Software/index');
        }
    }

}