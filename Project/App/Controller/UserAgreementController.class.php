<?php
/**
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/23
 * Time: 14:17
 */

namespace app\Controller;

use Think\Controller;

class UserAgreementController extends Controller
{
    //用户协议页面
    public function userAgreement()
    {
        $this->display('user_agreement');
    }
}