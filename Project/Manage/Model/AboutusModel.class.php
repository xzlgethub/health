<?php
/**
 * my表的操作
 *
 * @author xuliang
 *
 **/
namespace Manage\Model;
use Think\Model;
class AboutusModel extends Model {
    /**
     * showAlldata 查找首页我的数据
     * @author xuliang
     * @version 1.0
     * @return array
     **/
    public function showAlldata()
    {
        $Model = M('about_us');
        $res = $Model->select();
        return $res;
    }

    /**
     * findAboutus 查找首页我的数据
     * @author xuliang
     * @version 1.0
     * @param1 id int
     * @return array
     **/
    public function findAboutus($id)
    {
        $Model = M('about_us');
        $res = $Model->where("id = '$id'")->find();
        return $res;
    }

    /**
     * addAction 添加我的数据
     * @author xuliang
     * @version 1.0
     * @param1 arr array
     * @return int
     **/
    public function addAction($arr)
    {
        $val = array(
            'content' => $arr['content'],
            'copyright' => $arr['copyright'],
            'versions' => $arr['versions'],
            'create_time' => date('Y-m-d H:i:s'),
            'save_time' => date('Y-m-d H:i:s')
        );
        $Model = M('about_us');
        $arr['time'] = time();
        $res = $Model->add($val);
        return $res;
    }

    /**
     * addData  添加关于我们数据
     * @author  xuliang
     * @version 1.0
     * @param1  arr array
     * @return  int
     **/
    public function addData($arr)
    {
        $Model = M('aboutus');
        $arr['time'] = time();
        $res = $Model->add($arr);
        return $res;
    }

    /**
     * editAction 修改我的数据
     * @author xuliang
     * @version 1.0
     * @param1 arr array
     * @return int
     **/
    public function editAction($arr)
    {
        $val = array(
            'content' =>$arr['content'],
            'copyright' => $arr['copyright'],
            'versions' => $arr['versions']
        );
        $Model = M('about_us');
        $res = $Model->where("id = '{$arr['id']}'")->save($val);
        return $res;
    }

    /**
     * delaboutus  删除关于我们数据
     * @author xuliang
     * @version 1.0
     * @param1 id int
     * @return int
     **/
    public function delaboutus($id)
    {
        $Model = M('about_us');
        $res = $Model->delete($id);
        return $res;
    }
}
