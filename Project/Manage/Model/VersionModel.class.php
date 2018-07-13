<?php
/**
 * Version表的操作
 *
 * @author xuliang
 *
 **/
namespace Manage\Model;
use Think\Model;
class VersionModel extends Model {
    /**
     * 查找首页软件数据
     *
     * @author xuliang
     * @version 1.0
     * @return array
     **/
	public function showAllSoftware()
	{
		$Model = M('version');
		$res = $Model->order('id desc')->select();
		return $res;
	}
    
    /**
     * 添加软件数据
     * @author xuliang
     * @version 1.0
     * @param1 arr array
     * @return int
     **/
    public function addAction($arr)
    {
        $Model = M('version');
        $arr['time'] = date("Y-m-d H:i:s", time());
        $res = $Model->add($arr);
        return $res;
    }

    /**
     * del  删除软件数据
     * @author xuliang
     * @version 1.0
     * @param1 id int
     * @return int
     **/
    public function del($id)
    {
        $Model = M('version');
        $oneR = $Model->where("id =".$id)->find();
        $usedFile = "./Public/version/".$oneR['version_route'];
        unlink($usedFile);
        $res = $Model->delete($id);
        return $res;
    }
}
