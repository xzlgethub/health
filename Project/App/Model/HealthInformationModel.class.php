<?php
/**
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/19
 * Time: 1:11
 */

namespace app\Model;

use Think\Model;

class HealthInformationModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'health_information';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 报告添加
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * $param2 Int $type 报告类型
     * $param3 String $picpath 图片路径
     * $param4 String $thumbpath 缩略图路径
     * @return Array
     **/
    public function addReport($uid, $type, $picpath, $thumbpath)
    {
        $insert = array(
            'uid'        => $uid,
            'reporttype' => $type,
            'pic'        => $picpath,
            'thumbpic'   => $thumbpath,
            'createtime' => date('Y-m-d H:i:s'),
            'info'       => ''
        );
        $res = $this->table->add($insert);
        return $res;
    }

    /**
     * 报告查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * $param2 Int $type 报告类型
     * $param3 Int $offset 偏移量
     * $param4 Int $pagesize 每页条数
     * @return Array
     **/
    public function selectReport($uid, $type, $offset, $pagesize)
    {
        $where = array(
            'uid'        => $uid,
            'reporttype' => $type,
        );
        $res = $this->table->field('id,pic,thumbpic,info,createtime,audittype')->where($where)->order('createtime desc')->limit($offset . ',' . $pagesize)->select();
        return $res;
    }

    /**
     * 通过ID查询单条
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $id 图片ID
     * @return Array
     **/
    public function selectOne($id)
    {
        $where = array(
            'id' => $id
        );
        $res = $this->table->where($where)->find();
        return $res;
    }

    /**
     * 报告总数查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * $param2 Int $type 报告类型
     * @return Array
     **/
    public function reportCount($uid, $type)
    {
        $where = array(
            'uid'        => $uid,
            'reporttype' => $type,
        );
        $res = $this->table->where($where)->count();
        return $res;
    }


    /**
     * 通过ID删除报告图片
     * @author yangxiuchuan
     * @version 1.0
     * @param1 String $ids   图片ID（可以多个ID id1,id2,id3）
     * @return Array
     **/
    public function deleteReport($ids)
    {
//        $map['id'] = array(
//            0 => 'in',
//            1 => $ids
//        );
//        $map['audittype'] = array(
//            0 => 'or',
//            1 => '0,2'
//        );
        $where = "id in($ids) and (audittype=0 or audittype=2)";
        $res = $this->table->where($where)->delete();
        return $res;
    }

    /**
     * 跟新图片描述
     * @author yangxiuchuan
     * @version 1.0
     * @param1 String $pid 图片ID
     * @param2 String $info 描述
     * @return Array
     **/
    public function updateDescribe($pid, $info)
    {
        $where = array(
            'id' => $pid
        );
        $save = array(
            'info' => $info
        );
        $res = $this->table->where($where)->save($save);
        return $res;
    }
}