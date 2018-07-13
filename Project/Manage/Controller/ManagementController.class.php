<?php
/**
 * 管理员页面
 * @Author: xl
 * @Date: 2016/10/19 16:56
 */
namespace Manage\Controller;
use Think\Controller;
class ManagementController extends CommonController {
    /**
     * 管理员首页预览
     *
     * @author yxc
     * @version 1.0
     **/
	public function administrator()
	{
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $user = M('adminuser');
        $auth = M('auth_group');
        if(empty($sele)){
            $count = $user->where("id>1")->count();// 查询满足要求的总记录数
            $list = $user->where("id>1")->page($p . ',10')->select();
        }else{
            $count = $user->where("(username like '%$sele%' or name like '%$sele%' or phone like '%$sele%') AND id>1")->count();// 查询满足要求的总记录数
            $list = $user->where("(username like '%$sele%' or name like '%$sele%' or phone like '%$sele%') AND id>1")->page($p . ',10')->select();
        }
        $all = $auth->select();
        foreach ($list as $key=>$val){
            foreach ($all as $k=>$v){
                if($val['type']==$v['id']){
                    $list[$key]['typename'] = $v['title'];
                }
            }
            if(!isset($list[$key]['typename'])){
                $list[$key]['typename'] = '无角色';
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
        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->assign('page', $p);// 赋值当前页
        $this->assign('sele', $sele);// 赋值搜索条件
        $this->display();
	}

	/**
     * AJAX查询权限组
     * @author yxc
     * @version 1.0
     **/
	public function SelectRuleType()
	{
		$ThinkAuthGroup = D('Manage/ThinkAuthGroup');
		$res = $ThinkAuthGroup->SelectGroup();
		$this->ajaxReturn($res);
	}

	/**
     * 添加页
     * @author yxc
     * @version 1.0
     **/
	public function add()
	{
		$role = D('Manage/Role');
		$res = M('auth_group')->select();
		$this->assign('res', $res);
		$this->display();
	}

	/**
     * 添加管理员
     * @author yxc
     * @version 1.0
     **/
	public function addUser()
	{
		$User = D('Manage/User');
        $name = I('name');
		$res = $User->addUsers();
		if($res){
            //日志
            $data = array(
                'uid' => $res,
                'group_id' => I('type'),
            );
            M('auth_group_access')->add($data);
            addlog('管理员：'.$name.'&nbsp;&nbsp;&nbsp;ID：'.$res);
			$this->redirect('Management/administrator');
		}
	}

    /**
     * 验证管理员数据
     * @author yxc
     * @version 1.0
     **/
    public function vadataajax()
    {
        $uid = I('uid');
        //$name = I('name');
        $phone = I('phone');
        $username = I('username');
        $user = M('adminuser');

        //$resName = $user->where("name = '{$name}'")->select();
        $resUser = $user->where("username = '{$username}'")->select();
        $resPhone = $user->where("phone = '{$phone}'")->select();

        if($uid){
            //查看手机号是否存在
            foreach ($resPhone as $k1=>$tel){
                if($tel['id'] == $uid){
                    unset($tel);
                }else{
                    $tel1[] = $tel;
                }
            }
            /*//查看姓名是否存在
            foreach ($resName as $k2=>$name2){
                if($name2['id'] == $uid){
                    unset($name2);
                }else{
                    $Uname[] = $name2;
                }
            }*/
            //查看帐号是否存在
            foreach ($resUser as $k3=>$U_name){
                if($U_name['id'] == $uid){
                    unset($U_name);
                }else{
                    $account[] = $U_name;
                }
            }

            /*if($Uname){
                echo '1';
            }else*/if ($account){
                echo '2';
            }elseif ($tel1){
                echo '3';
            }else{
                echo '4';
            }

        }else{//添加认证
            /*if($resName){
                echo '1';
            }else*/if ($resUser){
                echo '2';
            }elseif ($resPhone){
                echo '3';
            }else{
                echo '4';
            }
        }

    }

	/**
     * 修改管理员
     * @author yxc
     * @version 1.0
     **/
	public function edit()
	{
		$User = D('Manage/User');
		$res = $User->SelectUser();
		$this->assign('res',$res);
		$auth = M('auth_group')->select();
		$this->assign('re',$auth);
		$this->assign('page',I('p'));
		$this->assign('sele',I('sele'));
		$this->display();
	}

	/**
     * 修改管理员动作
     * @author yxc
     * @version 1.0
     **/
	public function editAction()
	{
        $id = I('id');
		$User = D('Manage/User');
		$res = $User->EditUser();
        if($res){
            editlog('管理员&nbsp;&nbsp;&nbsp;ID：'.$id);
        }
        $this->redirect('Management/administrator',array('p'=>I('p'),'sele'=>I('sele')));
	}

	/**
     * 删除管理员动作
     * @author yxc
     * @version 1.0
     **/
	public function del()
	{
	    $id = I('id');
        $user = M('adminuser');
        $seeUser = $user->where("id = '$id'")->find();
		$User = D('Manage/User');
		$res = $User->DelUser();
		if($res){
            //日志
            dellog('管理员：'.$seeUser['name']);
			$this->redirect('Management/administrator',array('p'=>I('p'),'sele'=>I('sele')));
		}
	}

	/**
     * 管理员重置密码
     * @author yxc
     * @version 1.0
     **/
	public function repassword()
	{
        $id = I('id');
		$User = D('Manage/User');
		$res = $User->rePwdUser();
        editlog('管理员&nbsp;&nbsp;&nbsp;重置密码&nbsp;&nbsp;&nbsp;ID：'.$id);
		$this->redirect('Management/administrator');
	}


}