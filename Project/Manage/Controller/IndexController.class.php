<?php

namespace Manage\Controller;

use Think\Controller;
use Carbon\Carbon;

class IndexController extends Controller
{
    /**
     * 首页
     * @author   yxc
     * @version  1.0
     * @return   类型
     */
    public function index()
    {
//        var_dump($_SESSION);die;
        $usercontent = M('user')->count();//总人数
        $feedback    = M('feedback')->count();//总意见反馈数量
        $faq         = M('Faq')->count();//常见问题总数
        $pv          = M('steps')->where("createtime like '" . date('Y-m-d') . "%'")->count();
        $rate = 0.0001;//比率
        $rate_user = round($usercontent*$rate);//总人数比率
        $rate_feedback = round($feedback*$rate);//反馈意见比率
        $rate_faq = round($faq*$rate);//常见问题比率
        $rate_pv  = round($pv/$usercontent);

        $this->assign('usercontent',$usercontent);
        $this->assign('feedback',$feedback);
        $this->assign('faq',$faq);
        $this->assign('pv',$pv);
        $this->assign('rate_user',$rate_user);
        $this->assign('rate_feedback',$rate_feedback);
        $this->assign('rate_faq',$rate_faq);
        $this->assign('rate_pv',$rate_pv);
        $this->display();
    }

}