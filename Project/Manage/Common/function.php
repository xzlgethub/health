<?php

function RuleCheck($rule,$uid,$type=1, $mode='url', $relation='or')
{
    if($uid==1){
        return true;
    }
    $AUTH = new \Think\Auth();

    //获取当前uid所在的角色组id

    //$groups=$auth->getGroups($uid);

//        if($_SESSION['uid']==C('ADMIN_AUTH_KEY')){
//
//            return true;
//
//        }
    $res = $AUTH->check($rule, $uid);
    return $res;
}

/**
 * 文件上传函数
 *
 * @author dongjialin
 * @version 1.0
 **/
function doUpload()
{
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize = 3145728 ;// 设置附件上传大小
    $upload->autoSub = false;
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath = './Public/'; // 设置附件上传根目录
    $upload->savePath = 'file/'; // 设置附件上传（子）目录
    // 上传文件
    $info = $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        $this->error($upload->getError());
    }else{// 上传成功
        foreach($info as $file){
            $picname[] = $file['savename'];
        }
        return $picname;
    }
}

  //添加数据中添加日志
    function addlog($operat)
    {
        $name = $_SESSION['users']['name'];
        $data = array(
            'uname' => $name,
            'operat' => $operat,
            'status' => 1,
            'time' => time(),
        );
        $logres = M('logres');
        $res = $logres->add($data);
        return;
    }

    //修改数据中添加日志
    function editlog($operat)
    {
        $name = $_SESSION['users']['name'];
        $data = array(
            'uname' => $name,
            'operat' => $operat,
            'status' => 3,
            'time' => time(),
        );
        $logres = M('logres');
        $res = $logres->add($data);
        return;
    }

    //删除数据中添加日志
    function dellog($operat)
    {
        $name = $_SESSION['users']['name'];
        $data = array(
            'uname' => $name,
            'operat' => $operat,
            'status' => 2,
            'time' => time(),
        );
        $logres = M('logres');
        $res = $logres->add($data);
        return;
    }


