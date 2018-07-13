<?php
/**
 * 文件详细说明
 * @Author: dongjialin
 * @Date: 2017/7/20 16:26
 */
namespace Manage\Model;

use Think\Model;
use Carbon\Carbon;

class UserModel extends Model
{
    public function addUser()
    {
        $data = array(
            'username' => I('username'),
            'password' => I('password'),
            'time' => date(Carbon::now()),
            'type' => I('type')
        );
        $res = M('user')->add($data);
        return $res;
    }

    /*****************************************管理员表操作***********************************************************/
    /**
     * 查询全部管理员
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function SelectAdmin()
    {
        $user = M('adminuser');
        $res = $user->where("id > 1")->select();

        $role = M('role');
        for($i=0;$i<count($res);$i++){
            $roleid = $res[$i]['type'];
            $re = $role->where("id = '$roleid'")->field('name')->find();
            $res[$i]['typename'] = $re['name'];
        }
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }
        return $res;
    }

    /**
     * addUsers 添加管理员
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function addUsers()
    {
        $user = M('adminuser');
        $data = array(
            'name' => I('name'),
            'username' => I('username'),
            'phone' => I('phone'),
            'password' => md5(I('password')),
            'type' => I('type'),
        );
        $res = $user->add($data);
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }
        return $res;
    }

    /**
     * SelectUser   查询要修改的管理员
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function SelectUser()
    {
        $id = I('id');
        $user = M('adminuser');
        $res = $user->where("id = '$id'")->find();
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }
        return $res;
    }

    /**
     * EditUser 修改管理员
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function EditUser()
    {
        $id = I('id');
        $data = I('post.');
        $pwd = strlen($data['password']);
        if($pwd != '32'){
            $data['password'] = md5($data['password']);
        }

        $row = M('auth_group_access')->where('uid='.$id)->find();
        if($row){
            $save = array(
                'group_id' => $data['type']
            );
            M('auth_group_access')->where('uid='.$id)->save($save);
        }else{
            $add = array(
                'group_id' => $data['type'],
                'uid' => $id
            );
            M('auth_group_access')->add($add);
        }

        $user = M('adminuser');
        $res = $user->where("id = '$id'")->save($data);

        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("data:" . $data);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }
        return $res;
    }

    /**
     * rePwdUser    重置管理员密码
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function rePwdUser()
    {
        $id = I('id');
        $data = array(
            'pwd' => md5(admin),
        );
        $user = M('adminuser');
        $res = $user->where("id = '$id'")->save($data);
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("data:" . $data);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }
        return $res;
    }

    /**
     * DelUser  删除管理员
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function DelUser()
    {
        $id = I('id');
        $user = M('adminuser');
        $res = $user->where("id = '$id'")->delete();
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("data:" . $data);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }
        return $res;
    }

    /***********************************************用户管理******************************************************/
    /**
     * 查找用户数据
     * @author xuliang
     * @version 1.0
     * @return array
     **/
    public function showUser($where)
    {
        $Model = M('user');
        $res = $Model->where("account != 'admin'")->order('id desc')->select();
        foreach($res as $k=>$v){
            $zw = M('grouping')->where("id = '{$v['gid']}'")->find();
            $village = M('village')->where("id = '{$v['province']}'")->find();
            $res[$k]['zw'] = $zw['name'];
            $res[$k]['cz'] = $village['name'];
            if($v['sex'] == '0'){
                $res[$k]['sex'] = '女';
            }elseif($v['sex'] == '1'){
                $res[$k]['sex'] = '男';
            }

        }
        return $res;
    }

    /**
     * edit_User   修改操作
     * @author   xuliang
     * @version  1.0
     * @param    array val
     * @return   int
     */
    public function edit_User($val)
    {
        $res = M('user')->where("id = '{$val['id']}'")->save($val);
        return $res;
    }

    /**
     * findUser  查找单条用户数据
     * @author xuliang
     * @version 1.0
     * @param1 id str
     * @return array
     **/
    public function findUser($id)
    {
        $Model = M('user');
        $res = $Model->where("id = '{$id}'")->find();
        if($res['sex'] == '0'){
            $res['sex'] = '女';
        }elseif($res['sex'] == '1'){
            $res['sex'] = '男';
        }
        /*$zw = M('grouping')->where("id = '{$res['gid']}'")->find();
        $village = M('village')->where("id = '{$res['province']}'")->find();
        $res['gname'] = $zw['name'];
        $res['pname'] = $village['name'];*/
        return $res;
    }

    /**
     * stateUser  前台登录状态
     * @author   xuliang
     * @version  1.0
     * @param    str id
     * @param    str state
     * @return   int
     */
//    public function stateUser($id,$state)
//    {
//        $arr['state'] = $state;
//        $res = M('user')->where("id = '$id'")->save($arr);
//        return $res;
//    }

    /**
     * statusUser  前台登录状态
     * @author   xuliang
     * @version  1.0
     * @param    str id
     * @param    str state
     * @return   int
     */
    public function statusUser($id,$state)
    {
        $arr['status'] = $state;
        $res = M('user')->where("id = '$id'")->save($arr);
        return $res;
    }


}