<?php
namespace Manage\Controller;

use Think\Controller;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class UserController extends CommonController
{
    /**
     * 用户首页
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function index()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele');
        $userModel = M('user');
        if($sele==''){
            $count = $userModel->count();
            $userData = $userModel->order('id asc')->page($p . ',10')->select();
        }else{
            $count = $userModel->where("name like '%$sele%' or phone like '%$sele%'")->count();
            $userData = $userModel->where("name like '%$sele%' or phone like '%$sele%'")->order('id asc')->page($p . ',10')->select();
        }
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $Page->parameter['sele'] = $sele;
        $show = $Page->show();// 分页显示输出
        $this->assign('res',$userData);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->assign('page', $p);//赋值当前页
        $this->assign('sele', $sele);//赋值搜索条件
        $this->display();
    }

    /**
     * 用户步数页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function userStep()
    {
        $id = I('id');
        $p = I('p')=='' ? 1 : I('p');
        $pagesize = 10;

        $user = D('App/User');
        $user_row = $user->fieldOne($id, 'name');

        $list = M('steps')->where('uid=' . $id)->page($p . ',' .$pagesize)->select();
        $count = M('steps')->where('uid=' . $id)->count();

        $Page = new \Think\Page($count, $pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $show = $Page->show();// 分页显示输出

        $this->assign('res',$list);
        $this->assign('show',$show);
        $this->assign('user',$user_row);
        $this->display();
    }

    /**
     *  用户健康资料页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function userReport()
    {
        $id = I('id');
        $p = I('p')=='' ? 1 : I('p');
        $pagesize = 10;

        $user = D('App/User');
        $user_row = $user->fieldOne($id, 'name');

        $list = M('health_information')->where('uid=' . $id)->page($p . ',' . $pagesize)->select();
        $count = M('health_information')->where('uid=' . $id)->count();

        $Page = new \Think\Page($count, $pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $show = $Page->show();// 分页显示输出

        $this->assign('res',$list);
        $this->assign('show',$show);
        $this->assign('user',$user_row);
        $this->assign('p',$p);
        $this->assign('uid',$id);
        $this->display();
    }

    /**
     * 用户健康资料页面审核预览
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function userAuditShow()
    {
        //获取图片ID
        $id = I('id');
        $uid = I('uid');
        $information_where = array(
            'id' => $id
        );
        $user_where = array(
            'id' => $uid
        );
        //获取图片信息
        $userInformation = M('health_information')->where($information_where)->find();
        //获取用户信息
        $user = M('user')->field('name')->where($user_where)->find();

        if($userInformation['reporttype']==1){
            $userInformation['reporttype'] = '体检报告';
        }elseif($userInformation['reporttype']==2){
            $userInformation['reporttype'] = '病历报告';
        }
        if($userInformation['audittype']==0){
            $userInformation['audittype'] = '未审核';
        }elseif($userInformation['audittype']==1){
            $userInformation['audittype'] = '通过';
        }elseif($userInformation['audittype']==2){
            $userInformation['audittype'] = '未通过';
        }
        $this->assign('user',$user['name']);
        $this->assign('information',$userInformation);
        $this->assign('p',I('p'));
        $this->assign('uid',$uid);
        $this->assign('id',$id);
        $this->display();
    }

    /**
     * 用户健康资料页面审核状态修改
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function auditAction()
    {
        $id = I('id');
        $type = I('type');
        $save = array(
            'audittype' => $type
        );
        M('health_information')->where('id=' . $id)->save($save);
        $this->redirect('User/userReport',array('id'=>I('uid'),'p'=>I('p')));
    }

    /**
     * 报告审核首页
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function audit()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $reporttype = (I('reporttype')=='' || I('reporttype')=='0') ? '1' : I('reporttype');
        $pagesize = 10;
        if(empty($sele)){
            $list = M('health_information')
                    ->field('hl_health_information.id,hl_health_information.uid,hl_user.name,hl_user.phone,hl_health_information.pic,hl_health_information.thumbpic,hl_health_information.info,hl_health_information.reporttype,hl_health_information.audittype,hl_health_information.createtime')
                    ->join('__USER__ on __HEALTH_INFORMATION__.uid=__USER__.id')
                    ->where("reporttype=$reporttype")
                    ->page($p . ',' . $pagesize)
                    ->select();
            $count = M('health_information')
                    ->join('__USER__ on __HEALTH_INFORMATION__.uid=__USER__.id')
                    ->where("reporttype=$reporttype")
                    ->count();
        }else{
            $list = M('health_information')
                    ->field('hl_health_information.id,hl_health_information.uid,hl_user.name,hl_user.phone,hl_health_information.pic,hl_health_information.thumbpic,hl_health_information.info,hl_health_information.reporttype,hl_health_information.audittype,hl_health_information.createtime')
                    ->join('__USER__ on __HEALTH_INFORMATION__.uid=__USER__.id')
                    ->where("hl_health_information.reporttype=$reporttype and (hl_user.name like '%$sele%' or hl_user.phone like '%$sele%')")
                    ->page($p . ',' . $pagesize)
                    ->select();
            $count = M('health_information')
                    ->join('__USER__ on __HEALTH_INFORMATION__.uid=__USER__.id')
                    ->where("hl_health_information.reporttype=$reporttype and (hl_user.name like '%$sele%' or hl_user.phone like '%$sele%')")
                    ->count();
        }
        $Page = new \Think\Page($count, $pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $Page->parameter['reporttype'] = $reporttype;
        $Page->parameter['sele'] = $sele;
        $show = $Page->show();// 分页显示输出

        $this->assign('res',$list);
        $this->assign('show',$show);
        $this->assign('p',$p);
        $this->assign('sele',$sele);
        $this->assign('reporttype',$reporttype);
        $this->display();
    }

    /**
     * 报告审核状态处理页面
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function auditStatus()
    {
        $id = I('id');
        $type = I('type');
        $save = array(
            'audittype' => $type
        );
        M('health_information')->where('id=' . $id)->save($save);
        $this->redirect('User/audit',array('p'=>I('p'),'sele'=>I('sele'),'reporttype'=>I('reporttype')));
    }

    /**
     * 报告审核预览
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function auditShow()
    {
        //获取图片ID
        $id = I('id');
        $uid = I('uid');
        $information_where = array(
            'id' => $id
        );
        $user_where = array(
            'id' => $uid
        );
        //获取图片信息
        $userInformation = M('health_information')->where($information_where)->find();
        //获取用户信息
        $user = M('user')->field('name')->where($user_where)->find();

        if($userInformation['reporttype']==1){
            $userInformation['reporttype'] = '体检报告';
        }elseif($userInformation['reporttype']==2){
            $userInformation['reporttype'] = '病历报告';
        }
        if($userInformation['audittype']==0){
            $userInformation['audittype'] = '未审核';
        }elseif($userInformation['audittype']==1){
            $userInformation['audittype'] = '通过';
        }elseif($userInformation['audittype']==2){
            $userInformation['audittype'] = '未通过';
        }
        $this->assign('user',$user['name']);
        $this->assign('information',$userInformation);
        $this->assign('p',I('p'));
        $this->assign('sele',I('sele'));
        $this->assign('reporttype',I('reporttype'));
        $this->display();
    }

    /**
     * 报告审核删除操作
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function auditDel()
    {
        $id = I('id');
        $status = M('health_information')->field('audittype')->where('id=' . $id)->find();
        if($status['audittype']!=0){
            echo "<script>alert('该报告为已审核状态，无法删除，若想删除，请先修改为未审核状态');location.href='".__CONTROLLER__."/audit/p/".I('p')."/sele/".I('sele')."';</script>";
            die;
        }
        M('health_information')->where('id=' . $id)->delete();
        $this->redirect('User/audit',array('p'=>I('p'),'sele'=>I('sele')));
    }

    /**
     * 添加用户
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function addAction()
    {
        $user = D('Manage/User');
        $res = $user->addUser();
        if ($res) {
            $this->redirect('User/index');
        } else {
            $this->redirect('User/add');
        }
    }

    /**
     * 删除用户
     * @author yxc
     * @version 1.0
     * @return 类型
     */
    public function delAction()
    {
        $id = I('id');
        $seeUser = M('user')->where("id = '$id'")->find();
        $res = M('user')->where("id = '$id'")->delete();
        if($res){
            //日志
            $operat = $seeUser['account'];
            dellog('用户：'.$operat);
        }
        $this->redirect('User/index');
    }

    /**
     * 验证用户数据
     * @author yxc
     * @version 1.0
     **/
    public function vadataajax()
    {
        $uid = I('uid');
        $phone = I('phone');
        $idnum = I('idnum');
        $user = M('user');

        $resUser = $user->where("idnum = '{$idnum}'")->select();
        $resPhone = $user->where("tel = '{$phone}'")->select();
        //查看手机号是否存在
        foreach ($resPhone as $k1=>$tel){
            if($tel['id'] == $uid){
                unset($tel);
            }else{
                $tel1[] = $tel;
            }
        }
        //查看帐号是否存在
        foreach ($resUser as $k3=>$U_name){
            if($U_name['id'] == $uid){
                unset($U_name);
            }else{
                $idnums[] = $U_name;
            }
        }

        if ($idnums){
            echo '2';
        }elseif ($tel1){
            echo '3';
        }else{
            echo '4';
        }

    }

    /**
     * 修改用户
     * @author xl
     * @version 1.0
     * @return 类型
     */
    public function edit()
    {
        $id = I('id');
        $res = M('user')->where("id = '$id'")->find();
        $this->assign('res', $res);
        $this->assign('p', I('p'));
        $this->assign('sele', I('sele'));
        $this->display();
    }

    /**
     * editUser   用户执行修改操作
     * @author   xuliang
     * @version  1.0
     * @param    array val 修改数据
     * @return   int
     */
    public function editAction()
    {
        $val = I('post.');
        unset($val['p']);
        unset($val['sele']);
        if($_FILES['pic']['name'] != ''){//上传封面图
            $file = $this->doUpload('file/headpic/');
            if($file['error']==1){
                echo "<script>alert('图片上传失败');location.href='".__CONTROLLER__."/edit/id/".$val['id']."'</script>";
                die;
            }
            $picpath = $this->thumbImgs($file['msg'], 300, 300);

            $val['headpic'] = $picpath[0]['pic_path'];
            $val['thumbpic'] = $picpath[0]['thumb_pic'];
        }
        $admin = D('Manage/User');
        $pwd = strlen($val['pwd']);
        if($pwd != '32'){
            $val['pwd'] = md5($val['pwd']);
        }
        $res = $admin->edit_User($val);
        if($res){  //添加日志
            $seeUser = M('user')->where("id = '".$val['id']."'")->find();
            editlog('用户：'.$seeUser['account'].'&nbsp;&nbsp;&nbsp;ID：'.$seeUser['id']);
        }
        $this -> redirect('User/index',array('p'=>I('p'),'sele'=>I('sele')));
    }

    /**
     * del   删除
     * @author   xuliang
     * @version  1.0
     */
    public function del()
    {
        $id= I('id');
        $Model = M('user');
        $delUser = $Model->where("id = '$id'")->delete();
        $this -> redirect('User/index',array('p'=>I('p'),'sele'=>I('sele')));
    }


    /**
     * statusUser     用户限制操作
     * @author   yangxiuchuan
     * @version  1.0
     * @param    str id
     * @param    str type  状态
     * @return   str
     */
    public function statusUser()
    {
        $id = I('id');
        $type = I('type');
        $page = I('page');
        $sele = I('sele');
        $seeUser = M('user')->where("id = '$id'")->find();
        $data = D('Manage/User');
        $res = $data->statusUser($id,$type);

        $this -> redirect('User/index',array('p'=>$page,'sele'=>$sele));
    }


    /**
     * 文件上传类
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $path 子目录
     * @return  Array
     **/
    public function doUpload($path)
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 0;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Public/'; // 设置附件上传根目录
        $upload->savePath = $path; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {
            // 上传错误提示错误信息
            return array('error' => 1, 'msg' => $upload->getError());
        } else {
            //上传成功
            return array('error' => 0, 'msg' => $info);
        }
    }

    /**
     * 缩略图生成
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Array $imgpath    上传成功的图片数据
     * @param2  Int   $thumbWidth  缩略图宽度
     * @param3  Int   $thumbHeight 缩略图高度
     * @return  Array
     **/
    public function thumbImgs($imgpath, $thumbWidth, $thumbHeight)
    {
        $image = new \Think\Image();

        foreach($imgpath as $file) {

            $thumb_file = $file['savepath'] . $file['savename'];
            $save_path = $file['savepath'] . 'thumb_' . $file['savename'];
            $res = $image->open( './Public/' . $thumb_file )->thumb( $thumbWidth, $thumbHeight,\Think\Image::IMAGE_THUMB_SCALE )->save( './Public/' . $save_path );
            if($res==true){
                $picpath[] = array(
                    'pic_path' => $thumb_file,
                    'thumb_pic' => $save_path
                );
            }else{
                $picpath[] = array(
                    'pic_path' => $thumb_file,
                    'thumb_pic' => $thumb_file
                );
            }
        }
        return $picpath;
    }
}