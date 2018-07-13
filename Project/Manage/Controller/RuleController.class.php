<?php
/**
 * 权限页
 * @Author: xl
 * @Date: 2016/10/17 16:02
 */
namespace Manage\Controller;
use Think\Controller;
class RuleController extends CommonController
{
    /**
     * 权限首页
     *
     * @author yxc
     * @version 1.0
     **/
    public function index()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $user = M('auth_rule');
        if(empty($sele)){
            $count = $user->count();// 查询满足要求的总记录数
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $user->page($p . ',10')->select();
        }else{
            $list = $user->where("name like '%$sele%' or title like '%$sele%'")->page($p . ',10')->select();
            $count = $user->where("name like '%$sele%' or title like '%$sele%'")->count();// 查询满足要求的总记录数
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
        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->assign('page', $p);// 赋值当前页输出
        $this->assign('sele', $sele);// 赋值搜索内容输出
        $this->display();
    }

    /**
     * 权限修改页
     *
     * @author yxc
     * @version 1.0
     **/
    public function edit()
    {
        $rule = D('Manage/AuthRule');
        $res = $rule->SelectEditRule();
        $this->assign('res',$res);
        $this->assign('p',I('p'));
        $this->assign('sele',I('sele'));
        $this->display();
    }

    /**
     * 权限修改
     *
     * @author yxc
     * @version 1.0
     **/
    public function editAction()
    {
        $rule = D('Manage/AuthRule');
        $res = $rule->EditRule();
        if($res=='true'){
            $this -> redirect('Rule/index',array('p'=>I('p'),'sele'=>I('sele')));
        }
    }

    /**
     * 权限添加动作
     *
     * @author yxc
     * @version 1.0
     **/
    public function addAction()
    {
        $rule = D('Manage/AuthRule');
        $res = $rule->addRule();
        if($res=='true'){
            $this -> redirect('Rule/index');
        }elseif($res=='false'){
            $this -> redirect('Rule/add', array('errorid' => 2));
        }elseif($res=='null'){
            $this -> redirect('Rule/add', array('errorid' => 3));
        }
    }

    /**
     * 权限删除动作
     * @author yxc
     * @version 1.0
     **/
    public function delRule()
    {
        $rule = D('Manage/AuthRule');
        $res = $rule->deleteRule();
        if($res){
            $this->redirect('Rule/index',array('p'=>I('p'),'sele'=>I('sele')));
        }
    }

    /**
     *  查看权限组
     * @author yxc
     * @version 1.0
     **/
    public function RuleGroup()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $user = M('auth_group');
        if($sele == '开启'){
            $sele = '1';
        }elseif ($sele == '关闭'){
            $sele = '0';
        }
        if(empty($sele)){
            $count = $user->count();// 查询满足要求的总记录数
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $user->page($p . ',10')->select();
        }else{
            $list = $user->where("title like '%$sele%' or status like '%$sele%'")->page($p . ',10')->select();
            $count = $user->where("title like '%$sele%' or status like '%$sele%'")->count();// 查询满足要求的总记录数
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
        $this->assign('res', $list);// 赋值数据集
        $this->assign('show', $show);// 赋值分页输出
        $this->assign('page', $p);// 赋值分页输出
        if($sele=='1'){
            $sele = '开启';
        }elseif($sele=='0'){
            $sele = '关闭';
        }
        $this->assign('sele', $sele);// 赋值分页输出
        $this->display();

    }


    /**
     * [ ajax ]查找权限名称方法
     * @author yxc
     * @version 1.0
     * @return json
     **/
    public function findRule()
    {
        $ThinkAuthRule = D('Manage/AuthRule');
        $rules = I('rules');
        $rules = explode(',', $rules);
        for ($i=0; $i<count($rules); $i++){
            $res = $ThinkAuthRule->oneRuleShow($rules[$i]);
            $rule .= $res['title'].'，';
        }
        $rule = rtrim($rule, '，');
        $this->ajaxReturn($rule);
    }

    /**
     * 查找要修改的权限组方法
     * @author yxc
     * @version 1.0
     **/
    public function editRuleGroup()
    {
        $ThinkAuthGroup = D('Manage/AuthGroup');
        $res = $ThinkAuthGroup->selectEditGroup();

        $ThinkAuthRule = D('Manage/AuthRule');
        $ares = $ThinkAuthRule->showRules();
        $rules = explode(',', $res['rules']);
        for ($i=0; $i<count($rules); $i++){
            for ($j=0; $j<count($ares); $j++){
                if ($rules[$i] == $ares[$j]['id']){
                    $ares[$j]['show'] = 'yes';
                }
            }
        }
        $count = count($ares);
        //首页
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '1'){
                $a1[] = $ares[$i];
            }
        }
        $this->assign('a1' ,$a1);
        //用户管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '2'){
                $a2[] = $ares[$i];
            }
        }
        $this->assign('a2' ,$a2);
        //管理员管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '3'){
                $a3[] = $ares[$i];
            }
        }
        $this->assign('a3' ,$a3);
        //权限管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '4'){
                $a4[] = $ares[$i];
            }
        }
        $this->assign('a4' ,$a4);
        //产品管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '5'){
                $a5[] = $ares[$i];
            }
        }
        $this->assign('a5' ,$a5);
        //Logo管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '6'){
                $a6[] = $ares[$i];
            }
        }
        $this->assign('a6' ,$a6);
        //版权管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '7'){
                $a7[] = $ares[$i];
            }
        }
        $this->assign('a7' ,$a7);
        //常见问题管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '8'){
                $a8[] = $ares[$i];
            }
        }
        $this->assign('a8' ,$a8);
        //关于我们
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '9'){
                $a9[] = $ares[$i];
            }
        }
        $this->assign('a9' ,$a9);
        //意见反馈
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '10'){
                $a10[] = $ares[$i];
            }
        }
        $this->assign('a10' ,$a10);

        $this->assign('p' ,I('p'));
        $this->assign('sele' ,I('sele'));
        $this->assign('res' ,$res);
        $this->display();
    }

    /**
     * 查找要修改的权限组方法
     * @author yxc
     * @version 1.0
     **/
    public function editAGaction()
    {
        $ThinkAuthGroup = D('Manage/AuthGroup');
        $res = $ThinkAuthGroup->editAGaction();
        if($res){
            $this->redirect('Rule/RuleGroup',array('p'=>I('p'),'sele'=>I('sele')));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 权限组添加页
     *
     * @author yxc
     * @version 1.0
     **/
    public function addRuleGroup()
    {
        $ThinkAuthRule = D('Manage/AuthRule');
        $ares = $ThinkAuthRule->showRules();
        $count = count($ares);
        //首页
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '1'){
                $a1[] = $ares[$i];
            }
        }
        $this->assign('a1' ,$a1);
        //用户管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '2'){
                $a2[] = $ares[$i];
            }
        }
        $this->assign('a2' ,$a2);
        //管理员管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '3'){
                $a3[] = $ares[$i];
            }
        }
        $this->assign('a3' ,$a3);
        //权限管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '4'){
                $a4[] = $ares[$i];
            }
        }
        $this->assign('a4' ,$a4);
        //产品管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '5'){
                $a5[] = $ares[$i];
            }
        }
        $this->assign('a5' ,$a5);
        //Logo管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '6'){
                $a6[] = $ares[$i];
            }
        }
        $this->assign('a6' ,$a6);
        //版权管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '7'){
                $a7[] = $ares[$i];
            }
        }
        $this->assign('a7' ,$a7);
        //常见问题管理
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '8'){
                $a8[] = $ares[$i];
            }
        }
        $this->assign('a8' ,$a8);
        //关于我们
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '9'){
                $a9[] = $ares[$i];
            }
        }
        $this->assign('a9' ,$a9);
        //意见反馈
        for ($i=0; $i<$count; $i++){
            if ($ares[$i]['classify'] == '10'){
                $a10[] = $ares[$i];
            }
        }
        $this->assign('a10' ,$a10);

        $this->display();
    }

    /**
     * 权限组添加动作
     *
     * @author yxc
     * @version 1.0
     **/
    public function addAGaction()
    {
        $ThinkAuthGroup = D('Manage/AuthGroup');
        $res = $ThinkAuthGroup->addGaction();
        if($res){
            $this->redirect('Rule/RuleGroup');
        }else{
            $this->redirect('Rule/RuleGroup');
        }
    }
    
    /**
     * 删除权限组
     *
     * @author yxc
     * @version 1.0
     **/
    public function delRuleGroup(){
        $ThinkAuthGroup = D('Manage/AuthGroup');
        $res1 = $ThinkAuthGroup->delGaction();

        $ThinkAuthGroupAccess = D('Manage/AuthGroupAccess');
        $res2 = $ThinkAuthGroupAccess->delGAAction();
        if ($res1 || $res2){
            $this->redirect('Rule/RuleGroup',array('p'=>I('p'),'sele'=>I('sele')));
        }else{
            $this->error('权限组删除失败');
        }
    }

    /**
     * 用户分配页面
     *
     * @author yxc
     * @version 1.0
     **/
    public function RuleUser()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');
        $ThinkAuthGroupAccess = M('auth_group_access');
        if(empty($sele)){
            $list = M('adminuser')
                    ->alias('a')
                    ->join(array('LEFT JOIN hl_auth_group_access t ON t.uid = a.id','LEFT JOIN hl_auth_group g ON t.group_id = g.id'))
                    ->field('a.id,a.name,t.group_id gid,g.title')
                    ->order('a.id asc')
                    ->page($p . ',10')
                    ->select();
            $count = M('adminuser')
                    ->alias('a')
                    ->join(array('LEFT JOIN hl_auth_group_access t ON t.uid = a.id','LEFT JOIN hl_auth_group g ON t.group_id = g.id'))
                    ->field('a.id,a.name,t.group_id gid,g.title')
                    ->count();
        }else{
            $list = M('adminuser')
                ->alias('a')
                ->join(array('LEFT JOIN hl_auth_group_access t ON t.uid = a.id','LEFT JOIN hl_auth_group g ON t.group_id = g.id'))
                ->field('a.id,a.name,t.group_id gid,g.title')
                ->where("name like '%$sele%' or username like '%$sele%' or title like '%$sele%'")
                ->order('a.id asc')
                ->page($p . ',10')
                ->select();
            $count = M('adminuser')
                ->alias('a')
                ->join(array('LEFT JOIN hl_auth_group_access t ON t.uid = a.id','LEFT JOIN hl_auth_group g ON t.group_id = g.id'))
                ->field('a.id,a.name,t.group_id gid,g.title')
                ->where("name like '%$sele%' or username like '%$sele%' or title like '%$sele%'")
                ->count();
        }
        for ($i=0; $i<count($list); $i++){
            if(empty($list[$i]['title'])){
                $list[$i]['title'] = '未分配权限';
            }
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
        $this->assign('show',$show);
        $this->assign('res',$list);
        $this->assign('page',$p);
        $this->assign('sele',$sele);
        $this->display();
    }

    /**
     * [ ajax ]查询权限组数据
     *
     * @author xl
     * @version 1.0
     * @return json
     **/
    public function findRuleGroup()
    {
        $ThinkAuthGroup = D('Manage/AuthGroup');
        $gid = I('gid');
        $res = $ThinkAuthGroup->showAuthGroup();
        for ($i=0; $i<count($res); $i++){
            if($res[$i]['id'] == $gid){
                $res[$i]['selected'] = 'yes';
            }
        }
        $this->ajaxReturn($res);
    }

    /**
     * [ ajax ]修改用户权限组数据
     *
     * @author xl
     * @version 1.0
     **/
    public function changeAGA()
    {
        $uid = I('oldAU');
        $ThinkAuthGroupAccess = D('Manage/AuthGroupAccess');
        // 查询用户当前是否拥有权限组, 没有则执行添加
        $cres = $ThinkAuthGroupAccess->findAGA();
        if(empty($cres)){
            $addres = $ThinkAuthGroupAccess->addAGA();
            if($addres){
                $data = array(
                    'type' => I('RuleGroup'),
                );
                M('adminuser')->where("id = '$uid'")->save($data);
                $this->redirect('Rule/RuleUser');
            }else{
                $this->error('修改权限组失败');
            }
        }else{
            $res = $ThinkAuthGroupAccess->changeAGA();
            if($res){
                $data = array(
                    'type' => I('RuleGroup'),
                );
                M('adminuser')->where("id = '$uid'")->save($data);
                $this->redirect('Rule/RuleUser');
            }else{
                $this->error('修改权限组失败');
            }
        }
    }
}