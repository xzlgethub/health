<?php
namespace Manage\Controller;

use Think\Controller;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class OrderController extends CommonController
{
    /**
     * 订单首页
     * @author yxc
     * @version 1.0
     * @return 类型
     */

    public function index()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $type = I('type',0);

        $goods = M('order');
        if(!$type){
            if(empty($sele)){
                $list = $goods->page($p . ',10')->order('create_time desc')->select();
                $count = $goods->count();
            }else{
                $list = $goods->where("insurance_name like '%$sele%'")->page($p . ',10')->order('create_time desc')->select();
                $count = $goods->where("insurance_name like '%$sele%'")->order('create_time desc')->count();
            }
        }else{
            if($type == 2){
                $where = array(
                    'state'=>2
                );
            }elseif($type == 3){
                $where = array(
                    'state'=>1,
                    'is_effect'=>2
                );
            }elseif($type == 4){
                $where = array(
                    'state'=>1,
                    'is_effect'=>1,
                    'serve_time'=>2
                );
            }elseif($type == 5){
                $where = array(
                    'state'=>1,
                    'is_effect'=>1,
                    'serve_time'=>1
                );
                $this->assign('serve_a',1);
            }
            if(empty($sele)){
                $list = $goods->where($where)->page($p . ',10')->order('create_time desc')->select();
                $count = $goods->where($where)->order('create_time desc')->count();
            }else{
                $where['insurance_name'] = array('like','%$sele%');
                $list = $goods->where($where)->page($p . ',10')->order('create_time desc')->select();
                $count = $goods->where($where)->order('create_time desc')->count();
            }
        }
        foreach($list as $k=>&$v){
           if($v['state'] == 2){
               $v['state'] = '待支付';
           }elseif($v['is_effect'] == 2 and $v['state'] == 1){
               $v['state'] = '待生效';
           }elseif($v['state'] == 1 and $v['is_effect'] == 1 and $v['server_state'] == 2){
               $v['state'] = '已生效';
           }elseif($v['state'] == 1 and $v['is_effect'] == 2 and $v['server_state'] == 1){
               $v['state'] = '已发起服务';
           }
           if(!$v['pay_time']){
               $v['pay_time'] = '';
           }
        }
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
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
    public function upServe()
    {
        $id = I('id');
        $data = array('serve_time'=>time(),'handle_serve'=>1);
        $re = M('order')->where("id = '{$id}'")->save($data);
        echo $re;
    }
    public function delOrder()
    {
        $id = I('id');
        $re = M('order')->where("id = '{$id}'")->delete();
        echo $re;
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