<?php
/**
 * 文件详细说明
 * @Author: xl
 * @Date: 2017/7/20 16:26
 */
namespace Manage\Model;

use Think\Model;
use Carbon\Carbon;

class LogoModel extends Model
{
    /**
     * addAction   添加logo
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function addLogo($val)
    {
        $res = M('logo')->add($val);
        return $res;
    }

    /**
     * addAction   反选修改状态值
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function saveOpposite($id)
    {
        $save = array(
            'state' => 2
        );
        $res = M('logo')->where('id!=' . $id)->save($save);
        return $res;
    }

    /**
     * addAction   修改状态
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function saveState($id, $state)
    {
        $where = array(
            'id' => $id
        );
        $save = array(
            'state' => $state
        );
        $res = M('logo')->where($where)->save($save);
        return $res;
    }
}