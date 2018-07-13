<?php
/**
 * GroupAccess表的操作
 * @Author: xl
 * @Date: 2016/10/18 17:02
 */
namespace Manage\Model;
use Think\Model;
use Think\Log;
class AuthGroupAccessModel extends Model
{
    /**
     * 删除[ 权限对应用户表  auth_group_access]数据
     *
     * @author xl
     * @version 1.0
     * @return int 1 / 0
     **/
    public function delGAAction()
    {
    	$id = I('id');
        $res = M('auth_group_access')->where("group_id = '$id'")->delete();

        //sql语句执行错误，插入日志
        //		if(!$res){
        //			Log::write("-------------------------->" . __FUNCTION__ );
        //			Log::write("Id:" . $id);
        //			Log::write("Sql:" . M('auth_group_access')->_sql());
        //			Log::write("<--------------------------" . __FUNCTION__ );
        //		}

        return $res;
    }

    /**
     * 查询[用户/权限组 auth_group_access]表数据
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
    public function allAuthUser()
    {
        $res = M('adminuser')->alias('a')->join(array('LEFT JOIN hl_auth_group_access t ON t.uid = a.id','LEFT JOIN hl_auth_group g ON t.group_id = g.id'))->field('a.id,a.name,t.group_id gid,g.title')->select();
        //sql语句执行错误，插入日志
        //      if(!$res){
        //          Log::write("-------------------------->" . __FUNCTION__ );
        //          Log::write("Res:" . $res);
        //          Log::write("Sql:" . M('adminuser')->_sql());
        //          Log::write("<--------------------------" . __FUNCTION__ );
        //      }

        return $res;
    }

    /**
     * 查询单条的[用户/权限组 auth_group_access]数据
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
    public function findAGA()
    {
        $uid = I('oldAU');
        $res = M('auth_group_access')->where("uid = '$uid'")->find();

        //sql语句执行错误，插入日志
        //      if(!$res){
        //          Log::write("-------------------------->" . __FUNCTION__ );
        //          Log::write("uid:" . $uid);
        //          Log::write("Sql:" . M('auth_group_access')->_sql());
        //          Log::write("<--------------------------" . __FUNCTION__ );
        //      }
        return $res;
    }

    /**
     * 添加[用户/权限组 auth_group_access]表数据
     *
     * @author xl
     * @version 1.0
     * @return int 插入id
     **/
    public function addAGA()
    {
        $uid = I('oldAU');
        $data = array(
            'uid' => $uid,
            'group_id' => I('RuleGroup'),
        );
        $res = M('auth_group_access')->add($data);

        //sql语句执行错误，插入日志
        //      if(!$res){
        //          Log::write("-------------------------->" . __FUNCTION__ );
        //          Log::write("data:" . $data);
        //          Log::write("Sql:" . M('auth_group_access')->_sql());
        //          Log::write("<--------------------------" . __FUNCTION__ );
        //      }
        return $res;
    }

    /**
     * 更改[用户/权限组 auth_group_access]表数据
     *
     * @author xl
     * @version 1.0
     * @param1 int id 用户id
     * @param2 int arr 更改数据
     * @return int 1 / 0
     **/
    public function changeAGA()
    {
        $uid = I('oldAU');
        $data = array(
            'group_id' => I('RuleGroup'),
        );
        $res = M('auth_group_access')->where("uid = '$uid'")->save($data);

        //sql语句执行错误，插入日志
        //      if(!$res){
        //          Log::write("-------------------------->" . __FUNCTION__ );
        //          Log::write("uid:" . $uid);
        //          Log::write("data:" . $data);
        //          Log::write("Sql:" . M('auth_group_access')->_sql());
        //          Log::write("<--------------------------" . __FUNCTION__ );
        //      }
        return $res;
    }
}