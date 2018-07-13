<?php
/**常见问题相关控制
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/25
 * Time: 11:13
 */

namespace App\Controller;

use Think\Controller;

class FaqController extends Controller
{
    /**
     * 常见问题首页
     * @author  yangxiuchuan
     * @version 1.0
     * @return
     **/
    public function index()
    {
        $name = I('search');
        //搜索条件
        if($name==''){
            //查询权重大的前十条数据
            $res = M('faq')->order('weight desc')->limit('0,10')->select();
        }else{
            $res = M('faq')->where("title like '%$name%' or content like '%$name%'")->order('weight desc')->limit('0,10')->select();
        }
//        foreach ($res as $k=>&$v){
//            $v['content'] = substr($v['content'],0,75).'...';
//        }
        $this->assign('res',$res);
        $this->assign('search',$name);
        $this->display();
    }

    /**
     * 常见问题详情页
     * @author  yangxiuchuan
     * @version 1.0
     * @return
     **/
    public function info()
    {
        //获取标题的ID
        $id = I('id');
        if($id!=''){
            //查询标题信息
            $res = M('faq')->where('id=' . $id)->find();
        }
        $this->assign('res',$res);
        $this->display();
    }
}