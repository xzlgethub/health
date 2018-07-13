<?php
/**
 * Advertisement表的操作
 *
 * @author xuliang
 *
 **/
namespace Manage\Model;
use Think\Model;
class AdvertisementModel extends Model {
    /**
     * selects    查询类别数据
     * @author   xuliang
     * @version  1.0
     * @return   array
     */
	public function selects()
	{
		$Model = M('advertisement');
		$res = $Model->select();

        foreach ($res as &$v){
            $v['time'] = date("Y-m-d H:i:m",$v['time']);
            if($v['state'] == '0'){
                $v['state'] = '引导图';
            }else{
                $v['state'] = '启动图';
            }
        }
		return $res;
	}

    /**
     * showOneType   查询单条图片数据
     * @author   xuliang
     * @version  1.0
     * @param    str id 图片id
     * @return   array
     */
	public function findPic($id)
    {
        $Model = M('advertisement');
        $res = $Model->where("id = ".$id)->find();
        $res['time'] = date("Y-m-d H:i:m",$res['time']);
        $res['pid'] = '启动图';

        return $res;
    }

    /**
     * adds  添加广告图片
     * @author xuliang
     * @version 1.0
     * @param1 array val 广告图片数据数组
     * @return int
     **/
	public function adds($val)
	{
	    $Model =  M('advertisement');
        $res = $Model->add($val);

		return $res;
	}

    /**
     * revise    修改图片操作
     * @author   xuliang
     * @version  1.0
     * @param    array val 修改的数据
     * @param    str   id  类别id
     * @return   int
     */
	public function upPic($val)
    {
        //dump($val);die;
        $Model =  M('advertisement');
        $arr['state'] = $val['state'];
        if(!empty($val['pic'])){
            $arr['pic'] = $val['pic'];
            $pic = "./Public/authentication/".$val['ypic'];
            unlink($pic);
        }
        $res = $Model->where("id =".$val['id'])->save($arr);

        return $res;
    }

    /**
     * delType   执行删除图片
     * @author   xuliang
     * @version  1.0
     * @param    str id 类别id
     * @return   int
     */
    public function del($id)
    {
        $Model =  M('advertisement');
        $onePic = $this->findPic($id);
        $pic = "./Public/authentication/".$onePic['pic'];
        unlink($pic);
        $res = $Model->where("id = '{$id}'")->delete();

        return $res;
    }

}
