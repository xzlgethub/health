<?php
namespace App\Controller;
use Think\Controller;
class IndexController extends Controller
{

    public function index()
    {
//        $xmlData = file_get_contents('php://input');
        $xmlData = $GLOBALS['HTTP_RAW_POST_DATA'];
        var_dump($xmlData);die;
     /*   $contents = file_get_contents("test.txt");
        //每次访问此路径将内容输出，查看内容的差别
        //var_dump($contents);

        $this->assign("contents", $contents);
        $this->display();*/
    }

    //定时执行的方法
    public function crons()
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        //在文件中写入内容tmspan
//        file_put_contents("tests.txt", date("Y-m-d H:i:s") . "执行定时任务！22211" . "\r\n<br>", FILE_APPEND);
        $where = array(
            'state'=>1,
            'is_effect'=>2
        );
        $arr = M('order')->where($where)->field('id,pay_time,rest_time')->select();
        if($arr){
            $xian = date('Y-m-d');
            foreach($arr as $k=>$v){
                $jin = date('Y-m-d',$v['pay_time']);
                $dao = $dao = date('Y-m-d',strtotime("$jin +90 day"));;
                $tian = floor((strtotime($dao)-strtotime($xian))/86400);
                if($tian>0){
                    M('order')->where("id = '{$v['id']}'")->setField('rest_time',$tian);
                }else{
                    M('order')->where("id = '{$v['id']}'")->setField('is_effect',1);
                }

            }
        }



    }









    //定时任务，计算每天用户排行，修改排名，添加积分
    public function script()
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        //执行开始时间
        $startTime = time();

        $steps = M('steps');
        //获取当前时间
        $date = date('Y-m-d', time());
        $where = array(
            'createtime' => $date
        );

        $where['life'] = array('gt', 0);
        //查询当天用户步数排行
        $result = $steps->where($where)->order('steps desc')->select();
//        echo $steps->getLastSql();die;
        $first = 0;
        if($result){
        //循环遍历排行榜
        foreach ($result as $k => $v) {
            //记录当天排行榜冠军ID
            if ($k == 0) {
                $first = $v['uid'];
            }
            $wheres = array(
                'createtime' => $date,
                'uid' => $v['uid']
            );
            $save = array(
                'rank' => $k + 1,
                'firstuid' => $first,
                'endtime' => date('Y-m-d H:i:s')
            );
            //修改当前用户的rank排行和冠军ID
            $steps->where($wheres)->save($save);


            $integral = 0;
            if ($v['steps'] >= 5000) {
                if ($v['steps'] >= 20000) {
                    $integral = 500;
                } else {
                    $integral = $integral + 50 + (($v['steps'] - 5000) * 0.03);
                }
                if($k == 0){
                    $add = array(
                        'uid' => $v['uid'],
                        'revenuetype' => '走路挖矿',
                        'life' => $integral+100,
                        'lis' => $integral * 0.1,
                        'type' => 0,
                        'createtime' => date('Y-m-d H:i:s')
                    );
                }else{
                    $add = array(
                        'uid' => $v['uid'],
                        'revenuetype' => '走路挖矿',
                        'life' => $integral,
                        'lis' => $integral * 0.1,
                        'type' => 0,
                        'createtime' => date('Y-m-d H:i:s')
                    );
                }

                //添加积分明细表
                $res = M('integral')->add($add);
                if ($res) {
                    //修改用户表中的LIS数据
                    M('user')->where(array('id' => $v['uid']))->setInc('lis', $integral * 0.1);
                    M('user')->where(array('id' => $v['uid']))->setInc('life', $integral);
                }
            }

        }
    }
        //执行结束时间
        $endTime = time();
        echo $endTime-$startTime;
    }
}