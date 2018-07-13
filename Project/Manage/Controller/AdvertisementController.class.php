<?php

namespace Manage\Controller;
use Think\Controller;
class AdvertisementController extends CommonController
{
    /**
     * index     查询广告图片
     * @author   xuliang
     * @version  1.0
     * @return   array
     */
    public function index()
    {
        $Model =  M('advertisement');
        $type = I('type');
        $this->assign("type", $type);
        $p = I('p');
        $sele = I('sele');
        if($sele == '启' || $sele == '启动'|| $sele == '启动图'){
            $sele = '1';
        }elseif($sele == '引' || $sele == '引导'|| $sele == '引导图'){
            $sele = '0';
        }
        if($p == ''){
            $p = '1';
        }

        if ($type == '1') {
            $list = $Model->where("state = '{$sele}'")->page($p . ',5')->select();
            $count = $Model->where("state = '{$sele}'")->count();// 查询满足要求的总记录数
        }else{
            $count = $Model->count();// 查询满足要求的总记录数
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $Model->page($p . ',5')->select();
        }
        $Page = new \Think\Page($count, 5);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        foreach ($list as &$v){
            $v['time'] = date("Y-m-d H:i:m",$v['time']);
            if($v['state'] == '0'){
                $v['state'] = '引导图';
            }else{
                $v['state'] = '启动图';
            }
        }
        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();
    }

    /**
     * seeAdv 管理员搜索首页
     * @author xl
     * @version 1.0
     * @return 类型
     */
    public function seeAdv()
    {
        $type = I("type");
        $p1 = I("p");
        $sele = I('sele');
        $this->redirect('Advertisement/index', array("type" => $type,"sele" => $sele,"p" => $p1));
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
        $upload->savePath  =      'authentication/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info){
            // 上传错误提示错误信息
            //$this->error($upload->getError());
            $this->error($upload->getError(),U('Advertisement/add'),10);
        }else{
            // 上传成功
            foreach($info as $file){
                $picName = $file['savename'];
            }
            return $picName;
        }
    }

    /**
     * addAction     添加图片
     * @author   xuliang
     * @version  1.0
     * @param    str name 添加的数据
     * @return   无
     */
    public function addAction()
    {
        $val = I('post.');
        $file = $_FILES['pic'];
        $val['pic'] = $this->myupload($file);
        if($val['state'] == '0'){
            $state = '引导图';
        }elseif($val['state'] == '1'){
            $state = '启动图';
        }
        $val['time'] = time();
        $type = D('Manage/Advertisement');
        $res = $type->adds($val);
        if($res){
            //日志
            addlog('APP图片：'.$state.'&nbsp;&nbsp;&nbsp;ID：'.$res);
            $this -> redirect('Advertisement/index');
        }
    }

    /**
     * edit      显示单条图片数据
     * @author   xuliang
     * @version  1.0
     * @param    str id 图片表id
     * @return   array
     */
    public function edit()
    {
        $id = I('id');
        $type = D('Manage/Advertisement');
        $res = $type->findPic($id);
        $this->assign("res", $res);
        $this->display();
    }

    /**
     * editAction   执行修改图片
     * @author   xuliang
     * @version  1.0
     * @param    array 修改的数据
     * @return  wu
     */
    public function editAction()
    {
        $val = I('post.');
        $file = $_FILES['pic'];
        $val['pic'] = $this->myupload($file);
        if($val['state'] == '0'){
            $state = '引导图';
        }elseif($val['state'] == '1'){
            $state = '启动图';
        }
        $data = D('Manage/Advertisement');
        $res = $data->upPic($val);
        if($res){
            //日志
            editlog('APP图片：'.$state.'&nbsp;&nbsp;&nbsp;ID：'.$val['id']);
        }
        $this -> redirect('Advertisement/index');
    }

    /**
     * delAction   删除图片
     * @author   xuliang
     * @version  1.0
     * @param    类型 参数名 参数的说明
     * @param    类型 参数名 参数的说明
     * @return   类型
     */
    public function delAction()
    {
        $id = I('id');
        $pica = M('advertisement')->where("id = '{$id}'")->find();
        if($pica['state'] == '0'){
            $state = '引导图';
        }elseif($pica['state'] == '1'){
            $state = '启动图';
        }
        $data = D('Manage/Advertisement');
        $res = $data->del($id);
        if($res){
            dellog('APP图片：'.$state.'&nbsp;&nbsp;&nbsp;ID：'.$id);
            $this -> redirect('Advertisement/index');
        }
    }
}