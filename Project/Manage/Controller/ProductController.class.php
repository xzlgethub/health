<?php
/**产品管理
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/23
 * Time: 20:38
 */

namespace Manage\Controller;

use Think\Controller;

class ProductController extends CommonController
{

    /**
     * 产品管理首页
     * @author yxc
     * @version 1.0
     * @return
     */
    public function index()
    {
        $p = I('p')=='' ? 1 : I('p');
        $sele = I('sele')=='' ? '' : I('sele');

        $goods = M('goods');
        if(empty($sele)){
            $list = $goods->page($p . ',10')->select();
            $count = $goods->count();
        }else{
            $list = $goods->where("goods_name like '%$sele%'")->page($p . ',10')->select();
            $count = $goods->where("goods_name like '%$sele%'")->count();
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
        $this->assign('res',$list);
        $this->assign('show',$show);
        $this->assign('sele',$sele);
        $this->assign('page',$p);
        $this->display();
    }

    /**
     * 修改产品页面
     * @author yxc
     * @version 1.0
     * @return
     */
    public function edit()
    {
        $id = I('id');
        $goods = D('App/Goods');
        $res = $goods->selectIdGoods($id);
//        var_dump($res);die;
        $this->assign('res',$res);
        $this->assign('p',I('p'));
        $this->assign('sele',I('sele'));
        $this->display();
    }

    /**
     * 修改产品处理页面
     * @author yxc
     * @version 1.0
     * @return
     */
    public function editAction()
    {
        $id = I('id');
        $data = array(
            'goods_name' => I('goodsname'),
            'price' => I('price'),
            'real_price' => I('real_price'),
            'store_nums' => I('nums'),
            'content' => I('content'),
            'goods_no' => I('goodsno'),
            'goods_brand' => I('goodsbrand')
        );
        $goodspic = $this->doUpload('file/goodspic/');
        if($goodspic['error']==0){
            $imgpaths = $this->thumbImgs($goodspic['msg'],300,300);
            $data['pic_img'] = $imgpaths[0]['pic_path'];
            $data['thumb_img'] = $imgpaths[0]['thumb_pic'];
            unlink('./Public/' . I('ypic'));
            unlink('./Public/' . I('ythumb'));
        }
        $goods = D('App/Goods');
        $goods->saveGoods($id,$data);
        $this->redirect('Product/index',array('p'=>I('p'),'sele'=>I('sele')));
    }

    /**
     * 产品添加页面
     * @author yxc
     * @version 1.0
     * @return
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 产品添加处理页面
     * @author yxc
     * @version 1.0
     * @return
     */
    public function addAction()
    {
        $data = I('post.');
        $goodspic = $this->doUpload('file/goodspic/');
        if($goodspic['error']==1){
            echo "<script>alert('".$goodspic['msg']."');location.href='" . __CONTROLLER__ . "/add'</script>";
            die;
        }
        $picpath = $this->thumbImgs($goodspic['msg'], 300, 300);
        $data['pic_path'] = $picpath[0]['pic_path'];
        $data['thumb_img'] = $picpath[0]['thumb_pic'];
        $goods = D('App/Goods');
        $res = $goods->addGoods($data);
        if($res){
            $this->redirect("Product/index");
        }else{
            $this->redirect("Product/add");
        }
    }

    /**
     * 产品删除处理页面
     * @author yxc
     * @version 1.0
     * @return
     */
    public function delAction()
    {
        $id = I('id');
        $goods = D('App/Goods');
        $result = $goods->selectIdGoods($id);
        unlink('./Public/' . $result['pic_img']);
        unlink('./Public/' . $result['thumb_img']);
        $goods->delGoods();
        $this->redirect('Product/index',array('p'=>I('p'),'sele'=>I('sele')));

    }

    /**
     * 产品上架下架状态修改
     * @author yxc
     * @version 1.0
     * @return
     */
    public function statusGoods()
    {
        $id = I('id');
        $status = I('type');
        $goods = D('App/Goods');
        $goods->saveStatus($id,$status);
        $this->redirect('Product/index',array('p'=>I('p'),'sele'=>I('sele')));
    }

    /**
     * 文件上传类
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $path 子目录
     * @return  Array
     **/
    function doUpload($path)
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
    function thumbImgs($imgpath, $thumbWidth, $thumbHeight)
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