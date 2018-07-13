<?php
/**
 * 文件详细说明
 * @Author: dongjialin
 * @Date: 2017/7/20 16:26
 */
namespace Manage\Model;

use Think\Model;
use Carbon\Carbon;

class CopyrightModel extends Model
{
    public function addUser()
    {
        $data = array(
            'username' => I('username'),
            'password' => I('password'),
            'time' => date(Carbon::now())
        );
        $res = M('copyright')->add($data);
        return $res;
    }
}