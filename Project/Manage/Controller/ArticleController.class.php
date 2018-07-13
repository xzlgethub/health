<?php
namespace Manage\Controller;
use Think\Controller;
class ArticleController extends CommonController
{
    /**
     * 文章预览
     * @author xl
     * @version 1.0
     **/
    public function index()
    {
        $user = M('knowledge');
        $village = M('newstype')->select();
        $this->assign("village", $village);
        $gid = I('gid');
        if($p == ''){
            $p = '1';
        }
        if($gid){
            $list = $user->where("gid = '{$gid}'")->order('id desc')->page($p . ',10')->select();
            $count = $user->where("gid = '{$gid}'")->order('id desc')->count();// 查询满足要求的总记录数

        }else{
            $count = $user->order('id desc')->count();// 查询满足要求的总记录数
            $list = $user->order('id desc')->page($p . ',10')->select();
        }
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        foreach ($list as &$v){
            $type = M('newstype')->where("id = '{$v['gid']}'")->find();
            $v['pname'] = $type['name'];
            $admin = M('adminuser')->where("id = '{$v['aid']}'")->find();
            $v['aname'] = $admin['name'];
        }
        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();

    }

    /**
     * seeWz 文章搜索首页
     * @author xl
     * @version 1.0
     * @return 类型
     */
    public function seeWz()
    {
        $type = I("type");
        $xx = I("xx");
        $p1 = I("p");
        $sele = I('sele');
        $this->redirect('Article/index', array("type" => $type,"sele" => $sele,"p" => $p1,"xx" => $xx));
    }

    /**
     * wzAjax  验证文章数据
     * @author xl
     * @version 1.0
     **/
    public function wzAjax()
    {
        $uid = I('uid');
        $title = I('title');
        $user = M('knowledge');
        $resName = $user->where("title = '{$title}'")->select();
        //查看姓名是否存在
        foreach ($resName as $k2=>$name2){
            if($name2['id'] == $uid){
                unset($name2);
            }else{
                $Uname[] = $name2;
            }
        }

        if($Uname){
            echo '1';
        }else{
            echo '4';
        }
    }

    /**
     * add  文章预览
     * @author xl
     * @version 1.0
     **/
    public function add()
    {
        $res = M('newstype')->select();
        $this->assign("grouping", $res);
        $this->display();
    }

    /**
     * addAction   添加新闻
     * @author   xuliang
     * @version  1.0
     * @param    array val
     * @return   int
     */
    public function addAction()
    {
        $val = I('post.');
        //$val['state'] = '2';
        if($_FILES['pic']['name'] != ''){//上传封面图
            $val['pic'] = $this->uploadImg();
        }

        // 文章处理
        $rand_name = uniqid(rand()).'.html';
        $myfile = fopen("./Public/file/".$rand_name, "w") or die("Unable to open file!");
        //$content = $_POST['curriculum'];
        $content = "<meta http-equiv=Content-Type content=\"text/html;charset = utf-8\">".$_POST['curriculum'];
        fwrite($myfile, $content);
        fclose($myfile);
        $val['curriculum'] = $rand_name;
        $data = D('Manage/Knowledge');
        $data->addAction($val);
        $this -> redirect('Article/index');
    }

    /**
     * content   文章信息
     * @author   xuliang
     * @version  1.0
     * @param    type str 文件名
     * @return   str
     */
    public function content()
    {
        $id = I('id');
        $filename = M('knowledge')->where("id = '{$id}'")->find();
        $this->assign('res' ,$filename['curriculum']);
        $this->display();
    }

    /**
     * delAction   删除文章数据
     * @author   xuliang
     * @version  1.0
     * @param    str id id
     * @return  int
     */
    public function del()
    {
        $id = I('id');
        $data = D('Manage/Knowledge');
        $res = $data->del($id);
        $this -> redirect('Article/index');
    }

    /**
     * edit   文章修改页
     * @author   xuliang
     * @version  1.0
     * @param    str id id
     * @return  int
     */
    public function edit()
    {
        $id = I('id');
        $data = D('Manage/Knowledge');
        $res = $data->indexFind($id);
        $showType = $data->showType();
        $this->assign('res' ,$res);
        $this->assign('showType' ,$showType);
        $this->display();
    }

    /**
     * editAction   修改文章操作
     * @author   xuliang
     * @version  1.0
     * @param    array val
     * @return   int
     */
    public function editAction()
    {
        $val = I('post.');
        if($_FILES['pic']['name'] != ''){//上传封面图
            $val['pic'] = $this->uploadImg();
        }

        // 文章处理
        $rand_name = I('curriculum');
        $myfile = fopen("./Public/file/".$rand_name, "w") or die("Unable to open file!");
        $content = "<meta http-equiv=Content-Type content=\"text/html;charset = utf-8\">".$_POST['content'];
        fwrite($myfile, $content);
        fclose($myfile);
        $val['curriculum'] = $rand_name;

        $data = D('Manage/Knowledge');
        $data->editAction($val);
        $this -> redirect('Article/index');
    }

    /**
     * uploadImg   上传封面图
     * @author   xuliang
     * @version  1.0
     * @return   str    返回文件名
     */
    public function uploadImg(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728000 ;// 设置附件上传大小
        $upload->autoSub   =     false;
        //$upload->exts      =     array('apk');// 设置附件上传类型
        $upload->rootPath  =      './Public/'; // 设置附件上传目录
        $upload->savePath  =      'logo/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info){
            //$this->error($upload->getError(),U('Software/add'),10);
        }else{
            // 上传成功
            foreach($info as $file){
                $picName = $file['savename'];
            }
            return $picName;
        }
    }

}