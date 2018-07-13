<?php
/**
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/26
 * Time: 18:33
 */

namespace Manage\Controller;

use Think\Controller;

class FaqController extends CommonController
{
    /**
     * 常见问题首页
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function index()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $pagesize = 10;
        if(empty($sele)){
            $list = M('faq')->page($p  . ',' . $pagesize)->order('weight desc')->select();
            $count = M('faq')->count();
        }else{
            $list = M('faq')->where("title like '%$sele%'")->order('weight desc')->page($p  . ',' . $pagesize)->select();
            $count = M('faq')->where("title like '%$sele%'")->count();
        }
        $Page = new \Think\Page($count, $pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
//        $Page->parameter['sele'] = $sele;
        $show = $Page->show();// 分页显示输出
        $this->assign('res',$list);
        $this->assign('show',$show);
        $this->assign('page',$p);
        $this->assign('sele',$sele);
        $this->display();
    }

    /**
     * 添加页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 添加处理页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function addAction()
    {
        $title = I('title');
        $content = I('content');
        $weight = I('weight');
        $faq = D('App/Faq');
        $add = array(
            'title' => $title,
            'content' => $content,
            'weight' => $weight,
            'createtime' => date('Y-m-d H:i:s')
        );
        $res = $faq->addFaq($add);
        if($res){
            $this->redirect('Faq/index');
        }
        $this->redirect('Faq/add');
    }

    /**
     * 修改页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function edit()
    {
        $id = I('id');
        $faq = D('App/Faq');
        $row = $faq->selectIdOne($id);
        $this->assign('res',$row);
        $this->assign('p',I('p'));
        $this->assign('sele',I('sele'));
        $this->display();
    }

    /**
     * 修改处理页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function editAction()
    {
        $id = I('id');
        $title = I('title');
        $content = I('content');
        $weight = I('weight');
        $save = array(
            'title' => $title,
            'content' => $content,
            'weight' => $weight
        );
        $faq = D('App/Faq');
        $faq->saveData($id, $save);
        $this->redirect('Faq/index',array('p'=>I('p'),'sele'=>I('sele')));
    }

    /**
     * 删除页
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function delAction()
    {
        $id = I('id');
        M('faq')->delete($id);
        $this->redirect('Faq/index',array('p'=>I('p'),'sele'=>I('sele')));
    }
}