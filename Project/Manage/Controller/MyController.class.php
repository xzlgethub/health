<?php

namespace Manage\Controller;
use Think\Controller;
class MyController extends CommonController
{
    /**
     * action   关于我们预览页
     * @author   yxc
     * @version  1.0
     */
    public function aboutus()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $pagesize = 10;
        if($sele==''){
            $list = M('about_us')->order('id desc')->page('1,10')->select();
            $count = M('about_us')->count();
        }else{
            $list = M('about_us')->where("versions like '%$sele%'")->order('id desc')->page($p . ',' . $pagesize)->select();
            $count = M('about_us')->where("versions like '%$sele%'")->count();
        }
        $Page = new \Think\Page($count, $pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $Page->parameter['sele'] = $sele;
        $show = $Page->show();// 分页显示输出
        $this->assign('res', $list);
        $this->assign('show',$show);
        $this->assign('page',$p);
        $this->assign('sele',$sele);
        $this->display();
    }

    /**
     * aboutus   我的数据添加页面
     * @author   yxc
     * @version  1.0
     */
    public function add()
    {
        $this->display('addabou');
    }

    /**
     * addAction   我的数据添加
     * @author   yxc
     * @version  1.0
     */
     public function addAction()
    {
        $data = D('Manage/Aboutus');
        $arr = I('post.');
        $res = $data->addAction($arr);
        if($res){
            addlog('关于我们&nbsp;&nbsp;&nbsp;ID：'.$res);
            $this -> redirect('My/aboutus');
        }
    }

    /**
     * add   关于我们修改页
     * @author   yxc
     * @version  1.0
     */
     public function edit()
    {
        $data = D('Manage/Aboutus');
        $id = I('id');
        $res = $data->findAboutus($id);
        $this->assign('res', $res);
        $this->assign('p', I('p')==''?1:I('p'));
        $this->assign('sele', I('sele')==''?'':I('sele'));
        $this->display();
    }

    /**
     * editAction   关于我们数据修改
     * @author   yxc
     * @version  1.0
     */
     public function editAction()
    {
        $arr = I('post.');
        $data = D('Manage/Aboutus');
        $res = $data->editAction($arr);
        if($res){
            editlog('关于我们&nbsp;&nbsp;&nbsp;ID：'.$arr['id']);
        }
        $this -> redirect('My/aboutus',array('p'=>I('p'),'sele'=>I('sele')));
    }

    /**
     * delUser   删除关于我们数据
     * @author   yxc
     * @version  1.0
     */
    public function delaboutus()
    {
        $data = D('Manage/Aboutus');
        $id = I('id');
        $res = $data->delaboutus($id);
        if($res){
            dellog('关于我们');
            $this -> redirect('My/aboutus',array('p'=>I('p'),'sele'=>I('sele')));
        }
    }

}