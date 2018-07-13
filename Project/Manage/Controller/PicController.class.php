<?php

namespace Manage\Controller;
use Think\Controller;
class PicController extends Controller
{
    /**
     * 上传首页
     *
     * @author saibei
     * @version 1.0
     **/
     public function index()
    {   
        $res = M('pic')->select();
        $this->assign('res',$res);
        $this->display();
    }
    /**
     * 上传页
     *
     * @author saibei
     * @version 1.0
     **/
    public function add()
    {
        $this->display();
    }
    /**
     * 修改页
     *
     * @author saibei
     * @version 1.0
     **/
    public function edit()
    {   
        $id = I('id');
        $res = M('pic')->where("id = '$id'")->find();
        $this->assign('res',$res);
        $this->display();
    }
    /**
     * 添加动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function addAction()
    {   
        $name = I('spic');
        //$pic = M('picgood');
        for($i=0;$i<count($name);$i++){
            $name1[] =  '(\''.$name[$i].'\')';
        }
        $name2 = implode(',', $name1);
        $Model = new \Think\Model();
        $res1 = $Model->execute("INSERT  INTO `hl_pic`(`picname`) values $name2");
        if($res1){
            $this->redirect("Pic/index");
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function editAction()
    {
        $id = I('id');
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     10*1024*1024 ;// 设置附件上传大小  
        $upload->autoSub   =     false;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->rootPath  =      './Public/'; // 设置附件上传目录    
        $upload->savePath  =      'picture/'; // 设置附件上传目录
        // 上传文件     
        $info   =   $upload->upload(); 
        if($info){
            // 上传成功
            foreach($info as $file){
                $image = new \Think\Image(); 
                $image->open('./Public/picture/'.$file['savename']);
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                $image->thumb(80, 80)->save('./Public/picture/'.'s_'.$file['savename']);
                $picname = $file['savename'];
            }
        }
        //查询原图片名
        $res = M('pic')->where("id = '$id'")->find();
        $pic = $res['picname'];
        if(empty($picname)){
            $data = array(
                'picname' => $pic,
            );
        }else{
            $data = array(
                'picname' => $picname,
            );
        }
        $res1 = M('pic')->where("id = '$id'")->save($data);
        if($res1 && empty($picname)){
            unlink('./Public/picture/'.$picname);
            unlink('./Public/picture/s_'.$picname);
        }else{
            unlink('./Public/picture/'.$pic);
            unlink('./Public/picture/s_'.$pic);
        }
        $this->redirect('Pic/index');
    }

    /**
     * 删除动作
     *
     * @author saibei
     * @version 1.0
     **/
    public function delAction()
    {
        $id = I('id');
        //查询
        $res = M('pic')->where("id = '$id'")->find();
        $picname = $res['picname'];
        $res = M('pic')->where("id = '$id'")->delete();
        if($res){
            unlink('./Public/picture/'.$picname);
            unlink('./Public/picture/s_'.$picname);
            $this->redirect('Pic/index');
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 文件上传函数
     *
     * @author saibei
     * @version 1.0
     **/
    public function doUpload()
    {
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     10*1024*1024 ;// 设置附件上传大小  
        $upload->autoSub   =     false;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->rootPath  =      './Public/'; // 设置附件上传目录    
        $upload->savePath  =      'picture/'; // 设置附件上传目录
        // 上传文件     
        $info   =   $upload->upload(); 
        if(!$info){
            // 上传错误提示错误信息        
            $this->error($upload->getError());  
        }else{
            // 上传成功
            foreach($info as $file){
                $image = new \Think\Image(); 
                $image->open('./Public/picture/'.$file['savename']);
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                $image->thumb(80, 80)->save('./Public/picture/'.'s_'.$file['savename']);
                $picname = $file['savename'];
            }
            $this->ajaxReturn($picname);
        }
    }   
}