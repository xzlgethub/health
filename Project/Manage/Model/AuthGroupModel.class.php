<?php
/**
 * RuleGroup表操作
 * @Author: xl
 * @Date: 2016/10/18 13:43
 */
namespace Manage\Model;
use Think\Model;
use Think\Log;
class AuthGroupModel extends Model
{
	/**
     * 查看所有权限组
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
	public function SelectGroup()
	{
		$res = M('auth_group')->select();
		//sql语句执行错误，插入日志
		// if(!$res){
		// 	Log::write("-------------------------->" . __FUNCTION__ );
		// 	Log::write("Sql:" . M('auth_group')->_sql());
		// 	Log::write("<--------------------------" . __FUNCTION__ );
		// }
		return $res;
	}

	/**
     * 查看要修改的权限组
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
	public function selectEditGroup()
	{
		$id = I('id');
		$res = M('auth_group')->where("id = '$id'")->find();
		//sql语句执行错误，插入日志
		// if(!$res){
		// 	Log::write("-------------------------->" . __FUNCTION__ );
		// 	Log::write("Sql:" . M('auth_group')->_sql());
		// 	Log::write("<--------------------------" . __FUNCTION__ );
		// }
		return $res;
	}

	/**
     * 执行要修改的权限组动作
     *
     * @author xl
     * @version 1.0
     * @return int
     **/
	public function editAGaction()
	{
		$id = I('id');
        $rules = implode(',', I('rules'));
        $data = array(
            'title' => I('title'),
            'rules' => $rules,
            'status' => I('status'),
        );
        $res = M('auth_group')->where("id = " .$id)->save($data);

        //sql语句执行错误，插入日志
        //		if(!$res){
        //			Log::write("-------------------------->" . __FUNCTION__ );
        //			Log::write("Id:" . $id);
        //			Log::write("data:" . $data);
        //			Log::write("Sql:" . M('auth_group')->_sql());
        //			Log::write("<--------------------------" . __FUNCTION__ );
        //		}
		return $res;
	}

	/**
     * 添加权限组数据动作
     *
     * @author xl
     * @version 1.0
     * @return int
     **/
    public function addGaction()
    {
        $rules = implode(',', I('rules'));
        $data = array(
            'title' => I('title'),
            'rules' => $rules,
            'status' => I('status')
        );
        $res = M('auth_group')->add($data);

        //sql语句执行错误，插入日志
        //		if(!$res){
        //			Log::write("-------------------------->" . __FUNCTION__ );
        //			Log::write("data:" . $data);
        //			Log::write("Sql:" . M('auth_group')->_sql());
        //			Log::write("<--------------------------" . __FUNCTION__ );
        //		}

        return $res;
    }

    /**
     * 删除权限组数据
     *
     * @author xl
     * @version 1.0
     * @return int 1 / 0
     **/
    public function delGaction()
    {
        //获取id
        $id = I('id');
        $res = M('auth_group')->where("id = '$id'")->delete();

        //sql语句执行错误，插入日志
        //		if(!$res){
        //			Log::write("-------------------------->" . __FUNCTION__ );
        //			Log::write("Id:" . $id);
        //			Log::write("Sql:" . M('auth_group')->_sql());
        //			Log::write("<--------------------------" . __FUNCTION__ );
        //		}

        return $res;
    }

    /**
     * 查询权限组数据
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
    public function showAuthGroup()
    {
        $res = M('auth_group')->where('status = 1')->select();
        return $res;
    }
}