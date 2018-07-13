<?php
/**
 * 文章增删改查等操作
 * @author xl
 * @Date: 2016/8/31 15:30
 **/
namespace Manage\Model;
use Think\Model;
use Think\Log;
class VidoModel extends Model
{
	/**
	 * showArticle 查询新闻数据
	 * @author xl
	 * @version 1.0
	 * @return array
	 **/
	public function index()
	{
		$res = M('knowledge')->order('id desc')->select();
		foreach ($res as &$v){
			$type = M('newstype')->where("id = '{$v['gid']}'")->find();
			$v['pname'] = $type['name'];
			$admin = M('adminuser')->where("id = '{$v['aid']}'")->find();
			$v['aname'] = $admin['name'];
		}
		return $res;
	}

	/**
	 * addAction   添加视频数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    array arr 数据
	 * @return   int
	 */
	public function addAction($arr)
	{
		for($i=0;$i<count($_SESSION['file_name']['servername']);$i++){
			//$val['name'] = $_SESSION['file_name']['servername'][$i];
			$val['name'] = $arr['name'];
			$val['vido_name'] = $_SESSION['file_name']['servername'][$i];
			$val['introduce'] = $arr['introduce'];
			$res = M('vido')->add($val);
		}
		unset($_SESSION['file_name']);
		return $res;
	}

	/**
	 * indexFind   查看单条视频数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    int $id 数据
	 * @return   array
	 */
	public function indexFind($id)
	{
		$res = M('vido')->where("id = '{$id}'")->find();
		return $res;
	}

	/**
	 * del   执行删除视频数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    str id
	 * @return   int
	 */
	public function del($id)
	{
		$m = M('vido');
		//删除数据
		$knowledge = $m->where("id = '{$id}'")->find();
		if($knowledge){
			//删除文件
			$pic1 = "./Public/upload/".$knowledge['vido_name'];
			unlink($pic1);
		}
		$res = $m->where("id = '{$id}'")->delete();
		return $res;
	}
	
	/**
	 * editAction   修改视频数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    array arr 数据
	 * @return   int
	 */
	public function editAction($arr)
	{
		$vido_name = $this -> indexFind($arr['id']);
		if($_SESSION['file_name'] != ''){
			$arr['vido_name'] = $_SESSION['file_name']['servername'][0];
		}
	
		$res = M('vido')->where("id = '{$arr['id']}'")->save($arr);
		if($res && $vido_name['vido_name'] != $arr['vido_name']){
			$pic = "./Public/upload/".$vido_name['vido_name'];
			unlink($pic);		
			unset($_SESSION['file_name']);
		}
		return $res;

	}

	

}
?>
