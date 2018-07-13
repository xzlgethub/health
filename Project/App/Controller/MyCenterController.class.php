<?php
/**
 * 个人中心模块相关接口
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/18
 * Time: 13:55
 */

namespace App\Controller;

use Think\Db;

class MyCenterController extends CommonController
{
    /**
     * 完善个人信息接口
     * @author  youlong
     * @version 1.0
     * @param1  Int $uid  所属用户的ID
     * @param2  string $name  姓名
     * @param3  Int $phone 手机号
     * @param4  string $idCard  身份证号
     * @return  JSON
     **/
    public function prefectInformation($uid, $name,$phone,$idCard,$insurance_id)
    {
        if($name == NULL){
            $this->ajaxReturn(dataFormat('姓名为空','',1));
        }elseif($phone == NULL || !is_numeric($phone) || strlen($phone) != 11){
            $this->ajaxReturn(dataFormat('请输入正确的手机号','',2));
        }elseif(!is_idcard($idCard)){
            $this->ajaxReturn(dataFormat('请输入正确的身份证号','',3));
        }
        $where = array(
            'id_card' => $idCard
        );
        $ob = D('PrefectInformation');
        $preInfo = $ob->where($where)->find();
        if($preInfo){
            $this->ajaxReturn(dataFormat('该信息已存在','',4));
        }
        $array = array(
            'uid' => $uid,
            'insurance_id' => $insurance_id,
            'name' => $name,
            'phone' => $phone,
            'id_card' => $idCard
        );
        $add =$ob->add($array);
        if(!$add){
            $this->ajaxReturn(dataFormat('该信息添加失败请重新添加','',5));
        }
        $this->ajaxReturn(dataFormat('ok','',0));

    }


    /**
     * 获取用户资料接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid  用户的ID
     * @param2  Int $type 0=基本信息 1=详细信息 默认是0
     * @return  JSON
     **/
    public function personalData($uid, $type=0)
    {
        $user = D('User');
        //获取用户数据
        $res = $user->uidOne($uid);
        if($res==NULL){
            $this->ajaxReturn(dataFormat('数据查询失败','',1));
        }
        $res['headpic'] = $this->picPath . '/Public/' . $res['headpic'];
        $res['thumbpic'] = $this->picPath . '/Public/' . $res['thumbpic'];
        //判断是要详细信息还是基本信息
        if($type==0){
            $result = array(
                'phone'    => substr_replace($res['phone'],'****',3,4),
                'name'     => $res['name'],
                'thumbpic' => $res['thumbpic']
            );
            $this->ajaxReturn(dataFormat('ok',$result));
        }
        $this->ajaxReturn(dataFormat('ok',$res));
    }

    /**
     * 个人资料姓名修改接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @param2  String $name 修改的值
     * @return  JSON
     **/
    public function saveName($uid, $name)
    {
        $user = D('User');
        $save = array(
            'name'=>$name
        );
        $res = $user->saveOne($uid, $save);
        if($res!=1){
            $this->ajaxReturn(dataFormat('修改姓名失败','',1));
        }
        $this->ajaxReturn(dataFormat('ok',$name));
    }

    /**
     * 个人资料头像修改接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @return  JSON
     **/
    public function saveImg($uid)
    {
        $file = doUpload('file/headpic/');
        if($file['error']==1){
            $this->ajaxReturn(dataFormat('ok',$file['msg'],1));
        }
        $picpath = thumbImgs($file['msg'], 300, 300);
        $save = array(
            'headpic' => $picpath[0]['pic_path'],
            'thumbpic' => $picpath[0]['thumb_pic'],
        );
        $user = D('User');
        $res = $user->saveOne($uid,$save);
        if($res==1){
            $imgPath = array(
                'headpic'  => $this->picPath . '/Public/' . $picpath[0]['pic_path'],
                'thumbpic' => $this->picPath . '/Public/' . $picpath[0]['thumb_pic'],
            );
            $this->ajaxReturn(dataFormat('ok',$imgPath));
        }
        $this->ajaxReturn(dataFormat('图片修改失败','',2));
    }

    /**
     * 钱包数据信息接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @return  JSON
     **/
    public function walletData($uid, $page=1)
    {
        $integral = D('Integral');
        if($page==1){
            $user = D('user');
            $user_integral = $user->fieldOne($uid, 'life');
            $result = $integral->integralDetail($uid,0,10);
            if(empty($result)){
                $this->ajaxReturn(dataFormat('暂无收支明细',array('life'=>$user_integral['life'],'detail'=>array())));
            }
            $this->ajaxReturn(dataFormat('ok',array('life'=>$user_integral['life'],'detail'=>$result)));
        }
        $where = array(
            'uid' => $uid
        );
        $user = D('user');
        $user_integral = $user->fieldOne($uid, 'life');
        //每页10条数据
        $pagesize = 10;
        //获取总记录数
        $sum = $integral->whereCount($where);
        //获取总页数
        $totalpage =ceil($sum/$pagesize);
        if($page>$totalpage){
            $this->ajaxReturn(dataFormat('暂无收支明细',array('life'=>$user_integral['life'],'detail'=>array())));
        }
        $startrow = ($page-1)*$pagesize;
        $result = $integral->integralDetail($uid, $startrow, $pagesize);
        $this->ajaxReturn(dataFormat('ok',array('life'=>$user_integral['life'],'detail'=>$result)));
    }

    public function decLife($uid){
        $arr = M('order')->where("uid = '{$uid}' and pay_type = 1")->order("pay_time desc")->field("life,pay_time")->select();
        if(!$arr){
            $this->ajaxReturn(dataFormat('暂无收支明细','',1));
        }
        $arr['title'] = '购买服务';
        $this->ajaxReturn(dataFormat('暂无收支明细',$arr,1));
    }

    /**
     * 登陆密码修改接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @param2  String $pwd 原密码
     * @param3  String $newpwd 新密码
     * @param4  String $cpwd 确认新密码
     * @return  JSON
     **/
    public function pwdAlter($uid, $pwd, $newpwd, $cpwd)
    {
        $user = D('User');
        $userpwd = $user->fieldOne($uid, 'pwd');
        if($userpwd['pwd']!=md5($pwd)){
            $this->ajaxReturn(dataFormat('原密码错误','',1));
        }
        if($newpwd!=$cpwd){
            $this->ajaxReturn(dataFormat('新密码输入不一致','',2));
        }
        $save = array(
            'pwd' => md5($newpwd)
        );
        $res = $user->saveOne($uid, $save);
        if($res==1){
            $this->ajaxReturn(dataFormat('ok',''));
        }elseif($res==0){
            $this->ajaxReturn(dataFormat('更改密码不能与旧密码相同','',3));
        }
        $this->ajaxReturn(dataFormat('密码修改失败','',3));
    }



    /**
     * 报告查询接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @param2  Int $type 报告类型
     * @param3  Int $page 当前页
     * @return  JSON
     **/
    public function userReport($uid, $type, $page=1)
    {
        //每页条数15
        $pagesize = 15;
        $report = D('HealthInformation');
        //偏移量
        $offset = ($page-1)*$pagesize;
        $res = $report->selectReport($uid, $type, $offset, $pagesize);
        $count = $report->reportCount($uid, $type);
        if(empty($res)){
            $this->ajaxReturn(dataFormat('无数据',array('count'=>$count,'result'=>array())));
        }
        foreach ($res as $k=>&$v){
            $v['pic'] = $this->picPath . '/Public/' . $v['pic'];
            $v['thumbpic'] = $this->picPath . '/Public/' . $v['thumbpic'];
            $v['createtime'] = substr($v['createtime'],0,10);
        }
        $this->ajaxReturn(dataFormat('ok',array('count'=>$count,'result'=>$res)));
    }

    /**
     * 报告上传接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $uid 用户ID
     * @param2  Int $type 报告类型
     * @return  JSON
     **/
    public function uploadReport($uid, $type)
    {
        $file = doUpload('file/reportpic/');
        if($file['error']==1){
            $this->ajaxReturn(dataFormat($file['msg'],'',1));
        }
        $picpath = thumbImgs($file['msg'], 300, 300);
        $report = D('HealthInformation');
        $res = $report->addReport($uid, $type, $picpath[0]['pic_path'], $picpath[0]['thumb_pic']);
        if($res){
            $result = $report->selectOne($res);
            $result['pic'] = $this->picPath . '/Public/' . $result['pic'];
            $result['thumbpic'] = $this->picPath . '/Public/' . $result['thumbpic'];
            unset($result['uid']);
            unset($result['reporttype']);
            $this->ajaxReturn(dataFormat('ok',$result));
        }
        $this->ajaxReturn(dataFormat('上传失败','',2));
    }

    /**
     * 报告删除接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $ids 图片ID
     * @return  JSON
     **/
    public function deleteReport($ids)
    {
        $report = D('HealthInformation');
        $res = $report->deleteReport($ids);
        if($res>0){
            $this->ajaxReturn(dataFormat('ok',''));
        }
        $this->ajaxReturn(dataFormat('图片已审核或已被删除','',1));
    }

    /**
     * 报告图片描述修改接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $pid 图片ID
     * @param2  String $info 图片描述
     * @return  JSON
     **/
    public function updateDescribe($pid , $info)
    {
        $report = D('HealthInformation');
        $res = $report->updateDescribe($pid, $info);
        $data = $report->selectOne($pid);
        $data['pic'] = $this->picPath . '/Public/' .$data['pic'];
        $data['thumbpic'] = $this->picPath . '/Public/' . $data['thumbpic'];
        if($res){
            $this->ajaxReturn(dataFormat('ok',$data));
        }
        $this->ajaxReturn(dataFormat('ok',$data));
    }

    /**
     * 用户历史步数查询接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int    $uid   用户ID
     * @param2  Int    $page  当前页
     * @return  JSON
     **/
    public function historySteps($uid, $page=1)
    {
        $pagesize = 15;
        $offset = ($page-1)*$pagesize;
        $steps = D('Steps');
        $result = $steps->historySteps($uid, $offset, $pagesize);
        if(empty($result)){
            $this->ajaxReturn(dataFormat('无数据','',1));
        }
        foreach ($result as $k=>&$v){
            $v['createtime'] = substr($v['createtime'],0,10);
        }
        $this->ajaxReturn(dataFormat('ok',$result));
    }

    /**
     * 反馈意见接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $content 反馈意见
     * @param2  Int    $uid   用户ID
     * @param3  String $phone 用户联系方式
     * @return  JSON
     **/
    public function feedback($content,$uid=0,$phone='')
    {
        $add = array(
            'feedback' => $content,
            'uid' =>$uid,
            'contact_way' => $phone,
            'createtime' => date('Y-m-d H:i:s')
        );
        $feedback = D('Feedback');
        $res = $feedback->addFeedback($add);
        if($res){
            $this->ajaxReturn(dataFormat('ok',''));
        }else{
            $this->ajaxReturn(dataFormat('no','',1));
        }
    }

    /**
     * 关于我们接口
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $versions 版本号
     * @return  JSON
     **/
    public function aboutUs($versions='1.0.0')
    {
        $AboutUs = D('AboutUs');
        $result = $AboutUs->oneVersions($versions);
        if(!$result){
            $data['content'] = '健康股构建一个去中心化的"普惠医疗"健康金融区块链平台\n\n基于医疗健康大数据重新连接医疗机构、健康保险、医生团体等健康相关产业\n\n形成运动、健康、保障、医疗、康复、正循环，打造普惠医疗健康金融生态系统';
            $data['foot'] = '版本：' . $versions . '\nCopyright © 2018 健康股 | All rights reserved';
//            $data['foot'] = '版本：1.0.0\nCopyright © 2018 健康股 | All rights reserved';
            $this->ajaxReturn(dataFormat('ok',$data));
        }
        $this->ajaxReturn(dataFormat('ok',$result));
    }
}