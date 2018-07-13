<?php

namespace Manage\Controller;
use Think\Controller;
class FeedbackController extends CommonController
{
    /**
     *意见反馈首页
     * @author  yxc
     * @version  1.0
     */
     public function index()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $pagesize = 10;
        $Model = M('Feedback');
        if($sele==''){
            $list = $Model
                    ->field('hl_feedback.id,hl_feedback.feedback,hl_feedback.contact_way,hl_feedback.createtime,hl_user.name')
                    ->join('__USER__ on __FEEDBACK__.uid=__USER__.id','LEFT')
                    ->order('hl_feedback.id desc')
                    ->page($p.','.$pagesize)
                    ->select();
            $count = $Model
                    ->join('__USER__ on __FEEDBACK__.uid=__USER__.id','LEFT')
                    ->count();
        }else{
            $list = $Model
                    ->field('hl_feedback.id,hl_feedback.feedback,hl_feedback.contact_way,hl_feedback.createtime,hl_user.name')
                    ->join('__USER__ on __FEEDBACK__.uid=__USER__.id','LEFT')
                    ->where("hl_user.name like '%$sele%' or hl_feedback.feedback like '%$sele%'")
                    ->order('hl_feedback.id desc')
                    ->page($p.','.$pagesize)
                    ->select();
            $count = $Model
                    ->join('__USER__ on __FEEDBACK__.uid=__USER__.id','LEFT')
                    ->where("hl_user.name like '%$sele%' or hl_feedback.feedback like '%$sele%'")
                    ->count();
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
        $this->assign('res',$list);
        $this->assign('show',$show);
        $this->assign('sele',$sele);
        $this->assign('page',$p);
        $this->display();

    }

    /**
     * 意见反馈删除动作
     * @author  yxc
     * @version  1.0
     */
     public function del()
    {
        $data = D('Manage/Feedback');
        $id = I('id');
        $data->del($id);
        $this -> redirect('Feedback/index',array('p'=>I('p'),'sele'=>I('sele')));
    }

}