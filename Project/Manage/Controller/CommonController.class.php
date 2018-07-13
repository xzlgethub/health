<?php
/**
 * 登录判断页
 *
 * @author dongjialin
 * @version 1.0
 **/
namespace Manage\Controller;

use Think\Controller;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CommonController extends Controller
{
    /**
     * 判断是否有登录人员，如果没有，跳转登录页
     *
     * @author dongjialin
     * @version 1.0
     * @param1 null null
     * @return array
     **/
    public function _initialize()
    {
        // 使用composer自动加载器
        //require $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/vendor/autoload.php';

        // 设置Whoops提供的错误和异常处理
        /*$whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();*/

        // $this->division(10, 0);

        //carbon时间
        // printf("Now: %s", Carbon::now());

        //日志
       /* $log = new Logger('name');
        $log->pushHandler(new StreamHandler(__ROOT__ . 'log/your.log', Logger::WARNING));*/

        $user = SESSION('users');
        if($user['id']==1){
            return true;
        }
        if (ACTION_NAME == 'myupload') {
            return;
        } else {
            if ($user == false) {
                $this->redirect('Login/index');
            }
        }

        //权限
        $AUTH = new \Think\Auth();
        //类库位置应该位于ThinkPHP\Library\Think\
        if(!$AUTH->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, $user['id'])){
            echo "<script>
                    if(confirm('没有权限!!!')){
                        location.href='".$_SERVER["HTTP_REFERER"]."';
                        //window.location.href='http://demo.huliantec.com/Wisdom/index.php/Backstage/Index/index';
                    }else{
                        location.href='".$_SERVER["HTTP_REFERER"]."';
                    }</script>";
        }elseif($user == false){
            $this -> redirect('Login/index');
        }


    }
}