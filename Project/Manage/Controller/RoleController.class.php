<?php
/**
 * 角色控制器
 * @Author: xl
 * @Date: 2018/01/17
 */
namespace Manage\Controller;
use Think\Controller;
class RoleController extends CommonController
{
    /**
     * index    角色首页
     * @author xl
     * @version 1.0
     **/
	public function index()
	{
		$role = D('Manage/Role');
		$res = $role->select();
		$this->assign('res',$res);
		$this->display();
	}

    /**
     * addAction    角色添加
     *
     * @author xl
     * @version 1.0
     **/
	public function addAction()
	{
        $role = D('Manage/Role');
		if (!$role->create()){ // 创建数据对象
			// 如果创建失败 表示验证没有通过 输出错误提示信息
			exit($role->getError());
		}else{
			// 验证通过 写入新增数据
			$role->add();
        	$this->redirect('Role/index');
		}
	}

    /**
     * 角色删除
     *
     * @author xl
     * @version 1.0
     **/
	public function delAction()
	{
		$id = I('id');
        $role = D('Manage/Role');
		$res = $role->where("id = '$id'")->delete();
        $this->redirect('Role/index');
	}

    /**
     * 角色修改页
     *
     * @author xl
     * @version 1.0
     **/
	public function edit()
	{
		$id = I('id');
        $role = D('Manage/Role');
		$res = $role->where("id = '$id'")->find();
		$this->assign('res',$res);
		$this->display();
	}

    /**
     * 角色修改页动作
     * @author xl
     * @version 1.0
     **/
	public function editAction()
	{
        $role = D('Manage/Role');
    	$role->id = I('id');
        $role->name = I('name');
		$res = $role->save();
		if($res){
        	$this->redirect('Role/index');
		}
	}
}