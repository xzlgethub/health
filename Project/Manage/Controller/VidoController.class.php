<?php

namespace Manage\Controller;
use Think\Controller;
class VidoController extends CommonController
{
    /**
     * index     查询视频
     * @author   xuliang
     * @version  1.0
     * @return   array
     */
    public function index()
    {
        $Model =  M('vido');
        $type = I('type');
        $this->assign("type", $type);
        $p = I('p');
        $sele = I('sele');
        if($p == ''){
            $p = '1';
        }

        if ($type == '1') {
            $list = $Model->where("name like '%$sele%'")->page($p . ',5')->select();
            $count = $Model->where("name like '%$sele%'")->count();// 查询满足要求的总记录数
        }else{
            $count = $Model->count();// 查询满足要求的总记录数
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $Model->page($p . ',5')->select();
        }
        $Page = new \Think\Page($count, 5);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();
    }

    /**
     * seeAdv 管理员搜索首页
     * @author xl
     * @version 1.0
     * @return 类型
     */
    public function seeAdv()
    {
        $type = I("type");
        $p1 = I("p");
        $sele = I('sele');
        $this->redirect('Vido/index', array("type" => $type,"sele" => $sele,"p" => $p1));
    }

    /*图片上传的类
    * 上传方法，直接调用  返回文件名
    */
    public function myupload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728000 ;// 设置附件上传大小
        $upload->autoSub   =     false;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/'; // 设置附件上传目录
        $upload->savePath  =      'authentication/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info){
            // 上传错误提示错误信息
            //$this->error($upload->getError());
            $this->error($upload->getError(),U('Advertisement/add'),10);
        }else{
            // 上传成功
            foreach($info as $file){
                $picName = $file['savename'];
            }
            return $picName;
        }
    }

    /**
     * addAction     添加图片
     * @author   xuliang
     * @version  1.0
     * @param    str name 添加的数据
     * @return   无
     */
    public function addAction()
    {
        $val = I('post.');
        $data = D('Manage/Vido');
        $res = $data->addAction($val);
		if($res){
			//日志
			addlog('视频：'.$val['name'].'&nbsp;&nbsp;&nbsp;ID：'.$res);
		}
        $this -> redirect('Vido/index');
    }

    /**
     * content   文件信息
     * @author   xuliang
     * @version  1.0
     * @param    type str 文件名
     * @return   str
     */
    public function content()
    {
        $id = I('id');
        $filename = M('vido')->where("id = '{$id}'")->find();
        $this->assign('res' ,$filename['vido_name']);

        $this->display();
    }

    /**
     * edit      显示单条视频数据
     * @author   xuliang
     * @version  1.0
     * @param    str id id
     * @return   array
     */
    public function edit()
    {
        $id = I('id');
        $type = D('Manage/Vido');
        $res = $type->indexFind($id);
        $this->assign("res", $res);
        $this->display();
    }

    /**
     * editAction   执行修改图片
     * @author   xuliang
     * @version  1.0
     * @param    array 修改的数据
     * @return  wu
     */
    public function editAction()
    {
        $val = I('post.');
		$data = D('Manage/Vido');
		$addF = $data->editAction($val);
		if($addF){  //添加日志
			$res = $data->indexFind($val['id']);
			editlog('视频：'.$res['name'].'&nbsp;&nbsp;&nbsp;ID：'.$res['id']);
		}
		$this -> redirect('Vido/index');
    }

    /**
     * del   删除视频
     * @author   xuliang
     * @version  1.0
     * @param    str id 视频id
     * @return   类型
     */
    public function del()
    {
        $id = I('id');
        $data = D('Manage/Vido');
        $findVido = $data->indexFind($id);
        $res = $data->del($id);
        if($res){
			//日志
			$operat = $findVido['name'];
			dellog('视频：'.$operat);
        }
		$this -> redirect('Vido/index');
    }
}