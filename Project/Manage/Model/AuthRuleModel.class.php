<?php
/**
 * Rule表操作
 * @Author: xl
 * @Date: 2016/10/17 17:07
 */
namespace Manage\Model;
use Think\Model;
use Think\Log;
class AuthRuleModel extends Model
{
	/**
     * 查看所有权限
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
	public function SelectRule()
	{
		$res = M('auth_rule')->select();
		//sql语句执行错误，插入日志
		// if(!$res){
		// 	Log::write("-------------------------->" . __FUNCTION__ );
		// 	Log::write("Sql:" . M('auth_rule')->_sql());
		// 	Log::write("<--------------------------" . __FUNCTION__ );
		// }
		return $res;
	}

	/**
     * 查看要修改的权限
     *
     * @author xl
     * @version 1.0
     * @return array
     **/
	public function SelectEditRule()
	{
		$id = I('id');
		$res = M('auth_rule')->where("id = '$id'")->find();
		//sql语句执行错误，插入日志
		// if(!$res){
		// 	Log::write("-------------------------->" . __FUNCTION__ );
		// 	Log::write("id:" . $id);
		// 	Log::write("Sql:" . M('auth_rule')->_sql());
		// 	Log::write("<--------------------------" . __FUNCTION__ );
		// }
		return $res;
	}

	/**
     * 修改权限
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
	public function EditRule()
	{
		if(!empty($_POST['name']) && !empty($_POST['title'])){
			$data = array(
				'title' => I('title'),
				'name' => I('name'),
				'status' => I('status'),
                'classify' => I('classify')
			);
			$id = I('id');
			$res = M('auth_rule')->where("id = '$id'")->save($data);
			//sql语句执行错误，插入日志
			// if(!$res){
			// 	Log::write("-------------------------->" . __FUNCTION__ );
			// 	Log::write("id:" . $id);
			// 	Log::write("Sql:" . M('auth_rule')->_sql());
			// 	Log::write("<--------------------------" . __FUNCTION__ );
			// }
			$re = 'true';
            return $re;
		}else{
			$re = 'null';
            return $re;
		}
	}

	/**
     * 添加权限
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
	public function addRule()
	{
		if(!empty($_POST['name']) && !empty($_POST['title'])){
			$data = array(
			    'title' => I('title'),
			    'name' => I('name'),
			    'status' => I('status'),
                'classify' => I('classify')
            );
            $res = M('auth_rule')->add($data);
            //sql语句执行错误，插入日志
			// if(!$res){
			// 	Log::write("-------------------------->" . __FUNCTION__ );
			// 	Log::write("data:" . $data);
			// 	Log::write("Sql:" . M('auth_rule')->_sql());
			// 	Log::write("<--------------------------" . __FUNCTION__ );
			// }
			if($res){
				$re = 'true';
                return $re;
			}else{
				$re = 'false';
                return $re;
			}
		}else{
			$re = 'null';
            return $re;
		}
	}
	
	/**
     * 添加权限
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
	public function deleteRule()
	{
		$id = I('id');		
        $res = M('auth_rule')->delete($id);
        //sql语句执行错误，插入日志
		// if(!$res){
		// 	Log::write("-------------------------->" . __FUNCTION__ );
		// 	Log::write("id:" . $id);
		// 	Log::write("Sql:" . M('auth_rule')->_sql());
		// 	Log::write("<--------------------------" . __FUNCTION__ );
		// }
		return $res;
	}

	/**
     * 查询单条权限数据 [ 考虑状态,为开启 status=1 ]
     *
     * @author xl
     * @version 1.0
     * @param1 int id 数据id
     * @return array
     **/
    public function oneRuleShow($id)
    {
        $res = M('auth_rule')->where("status = 1 AND id = " .$id)->find();

        //sql语句执行错误，插入日志
        //		if(!$res){
        //			Log::write("-------------------------->" . __FUNCTION__ );
        //			Log::write("Id:" . $id);
        //			Log::write("Res:" . $res);
        //			Log::write("Sql:" . M('auth_rule')->_sql());
        //			Log::write("<--------------------------" . __FUNCTION__ );
        //		}

        return $res;
    }

    /**
	 * 查找[ 开启 ]的权限数据
	 *
	 * @author xl
	 * @version 1.0
	 * @return array
	 **/
	public function showRules()
	{
		$res = M('auth_rule')->where('status = 1')->field('id, name, title, classify')->select();

		//sql语句执行错误，插入日志
		//		if(!$res){
		//			Log::write("-------------------------->" . __FUNCTION__ );
		//			Log::write("Arr:" . $arr);
		//			Log::write("Res:" . $res);
		//            Log::write("Sql:" . M('kb')->_sql());
		//			Log::write("<--------------------------" . __FUNCTION__ );
		//		}

		return $res;
	}
}