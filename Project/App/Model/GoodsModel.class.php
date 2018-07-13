<?php
/**
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/19
 * Time: 15:25
 */

namespace app\Model;

use Think\Model;

class GoodsModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'goods';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 商品查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1
     * @return  Array
     **/
    public function selectGoods($page=1,$pagesize=10)
    {
        $res = $this->table->field('id,goods_name,price,real_price,thumb_img,content,goods_brand,detail_url')->page($page.','.$pagesize)->select();
        return $res;
    }



    //*********************************后台管理**************************************//


    /**
     * 商品添加
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Array  $_POST  要添加的数据
     * @return  Array
     **/
    public function addGoods($data)
    {
        $add = array(
            'goods_name' => $data['goodsname'],
            'price' => $data['price'],
            'store_nums' => $data['nums'],
            'content' => $data['content'],
            'goods_no' => $data['goodsno'],
            'create_time' => date('Y-m-d H:i:s'),
            'pic_img' => $data['pic_path'],
            'thumb_img' => $data['thumb_img'],
            'goods_brand' => trim($data['goodsbrand']),
            'status' => 1
        );
        $res = $this->table->add($add);
        return $res;
    }

    /**
     * 删除添加
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $id  要删除的数据的ID
     * @return  Array
     **/
    public function delGoods()
    {
        $id = I('id');

        $res = $this->table->where('id=' . $id)->delete();
        return $res;
    }

    /**
     * 通过ID查询商品
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int  $id  查询的ID
     * @return  Array
     **/
    public function selectIdGoods($id)
    {
        $where = array(
            'id' => $id
        );
        $res = $this->table->where($where)->find();
        return $res;
    }

    /**
     * 修改商品的状态
     * @author  yangxiuchuan
     * @version 1.0
     * @param1    $id  查询的ID
     * @param2    $status 状态值
     * @return  Array
     **/
    public function saveStatus($id,$status)
    {
        $where = array(
            'id' => $id
        );
        $save = array(
            'status' => $status
        );
        $res = $this->table->where($where)->save($save);
        return $res;
    }

    /**
     * 修改商信息
     * @author  yangxiuchuan
     * @version 1.0
     * @param1 Int   $id  商品ID
     * @param2 Array   $data 修改的数据
     * @return
     **/
    public function saveGoods($id, $save)
    {
        $res = $this->table->where('id=' . $id)->save($save);
        return $res;
    }
}