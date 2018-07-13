<?php
/**
 * 文章增删改查等操作
 * @author xl
 * @Date: 2016/8/31 15:30
 **/
namespace Manage\Model;
use Think\Model;
use Think\Log;
class KnowledgeModel extends Model
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
	 * addFiles   添加文件数据filename表操作
	 * @author   xuliang
	 * @version  1.0
	 * @param    array arr 数据
	 * @return   int
	 */
	public function addFiles($kid)
	{
		$pdf = '.pdf';
		for($i=0;$i<count($_SESSION['file_name']['servername']);$i++){
			$val['filename'] = $_SESSION['file_name']['servername'][$i];
			$val['name'] = $_SESSION['file_name']['name'][$i];
			$val['kid'] = $kid;
			$str = strtolower($_SESSION['file_name']['servername'][$i]);
		}
		unset($_SESSION['file_name']);
		return $res;
	}

	/**
	 * addAction   添加新闻数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    array arr 数据
	 * @return   int
	 */
	public function addAction($arr)
	{
		$val['aid'] = $_SESSION['users']['id'];
		$val['pic'] = $arr['pic']?:'xwmr.png';
		$val['gid'] = $arr['gid'];
		$val['path'] = $arr['path'];
		$val['introduce'] = $arr['introduce'];
		$val['curriculum'] = $arr['curriculum'];
		$val['title'] = $arr['title'];
		$val['time'] = date("Y-m-d H:i:s",time());
		$res = M('knowledge')->add($val);
		return $res;
	}

	/**
	 * indexFind   查看单条新闻数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    int $id 数据
	 * @return   array
	 */
	public function indexFind($id)
	{
		$res = M('knowledge')->where("id = '{$id}'")->find();
		$type = M('newstype')->where("id = '{$res['gid']}'")->find();
		$res['pname'] = $type['name'];
		return $res;
	}

	/**
	 * editAction   修改新闻数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    array arr 数据
	 * @return   int
	 */
	public function editAction($arr)
	{
		//删除封面图
		if($arr['pic'] && $arr['ypic'] != 'xwmr.png'){
			$pic = "./Public/logo/".$arr['ypic'];
			unlink($pic);
			$val['pic'] = $arr['pic'];
		}elseif ($arr['pic'] && $arr['ypic'] == 'xwmr.png'){
			$val['pic'] = $arr['pic'];
		}

		$val['gid'] = $arr['gid'];
		$val['title'] = $arr['title'];
		$val['introduce'] = $arr['introduce'];
		$val['curriculum'] = $arr['curriculum'];
		$res = M('knowledge')->where("id = '{$arr['id']}'")->save($val);
		return $res;
	}

	/**
	 * del   执行删除新闻数据
	 * @author   xuliang
	 * @version  1.0
	 * @param    str id
	 * @return   int
	 */
	public function del($id)
	{
		$m = M('knowledge');
		//删除数据
		$knowledge = $m->where("id = '{$id}'")->find();
		if($knowledge){

			if($knowledge['pic'] != 'xwmr.png'){
				//删除封面图
				$pic = "./Public/logo/".$knowledge['pic'];
				unlink($pic);
			}

			//删除文件
			$pic1 = "./Public/file/".$knowledge['curriculum'];
			unlink($pic1);
		}
		$res = $m->where("id = '{$id}'")->delete();
		return $res;
	}

	/**
	 * 查询类别数据
	 * @author xuliang
	 * @version 1.0
	 * @return array
	 **/
	public function showType()
	{
		$res = M('newstype')->select();
		for($i=0;$i<count($res);$i++){
			$res[$i]['time'] = date("Y-m-d H:i:s", $res[$i]['time']);
		}
		return $res;
	}

	/**
	 * 查询单条的类别数据
	 * @author xuliang
	 * @version 1.0
	 * @param1 int id 数据id
	 * @return array
	 **/
	public function oneType($id){
		$res = M('newstype')->where("id = " .$id)->find();
		$res['time'] = date("Y-m-d H:i:s", $res['time']);
		return $res;
	}

}
?>
