<?php

namespace Manage\Controller;
use Think\Controller;
class DatadicController extends Controller
{
    /**
     * adminRole    角色首页
     * @author xl
     * @version 1.0
     **/
     public function adminRole()
    {
        $user = M('role');
        $p = I('p');
        if($p == ''){
            $p = '1';
        }

        $count = $user->count();// 查询满足要求的总记录数
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $user->page($p . ',10')->select();
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();

    }

    /**
     * vadataajax  验证角色数据
     * @author xl
     * @version 1.0
     **/
    public function vadataajax()
    {
        $uid = I('uid');
        $name = I('name');
        $user = M('role');

        $resName = $user->where("name = '{$name}'")->select();

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
     * addJs    添加动作
     * @author xl
     * @version 1.0
     **/
    public function addJs()
    {
        $data['name'] = I('name');
        M('role')->add($data);
        $this->redirect("Datadic/adminRole");
    }

    /**
     * 修改页
     * @author xl
     * @version 1.0
     **/
    public function edit()
    {
        $id = I('id');
        $res = M('role')->where("id = '$id'")->find();
        $this->assign('res',$res);
        $this->display();
    }

    /**
     * editAction   修改动作
     * @author xl
     * @version 1.0
     **/
    public function editAction()
    {
        $data = I('post.');
        M('role')->where("id = '{$data['id']}'")->save($data);
        $this->redirect("Datadic/adminRole");
    }

    /**
     * del  删除动作
     * @author xl
     * @version 1.0
     **/
    public function del()
    {
        $id = I('id');
        M('role')->where("id = '$id'")->delete();
        $this->redirect("Datadic/adminRole");
    }

    /****************************************角色管理结束**************************************************************/
    /**
     * journalism    新闻类别首页
     * @author xl
     * @version 1.0
     **/
    public function journalism()
    {
        $user = M('newstype');
        $p = I('p');
        if($p == ''){
            $p = '1';
        }

        $count = $user->count();// 查询满足要求的总记录数
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $user->page($p . ',10')->select();
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->display();
    }

    /**
     * newsTypeAjax  验证角色数据
     * @author xl
     * @version 1.0
     **/
    public function newsTypeAjax()
    {
        $uid = I('uid');
        $name = I('name');
        $user = M('newstype');
        $resName = $user->where("name = '{$name}'")->select();
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
     * addNewsType    添加动作
     * @author xl
     * @version 1.0
     **/
    public function addNewsType()
    {
        $data['name'] = I('name');
        M('newstype')->add($data);
        $this->redirect("Datadic/journalism");
    }

    /**
     * editJournalism   修改页
     * @author xl
     * @version 1.0
     **/
    public function editJournalism()
    {
        $id = I('id');
        $res = M('newstype')->where("id = '$id'")->find();
        $this->assign('res',$res);
        $this->display();
    }

    /**
     * editNewsType   修改动作
     * @author xl
     * @version 1.0
     **/
    public function editNewsType()
    {
        $data = I('post.');
        M('newstype')->where("id = '{$data['id']}'")->save($data);
        $this->redirect("Datadic/journalism");
    }

    /**
     * delNewstype  删除动作
     * @author xl
     * @version 1.0
     **/
    public function delNewstype()
    {
        $id = I('id');
        M('newstype')->where("id = '$id'")->delete();
        $this->redirect("Datadic/journalism");
    }


}