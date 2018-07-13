<?php
/**
 * user表的数据操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/17
 * Time: 12:05
 */

namespace app\Model;

use Symfony\Component\Translation\Util\ArrayConverter;
use Think\Model;

class PrefectInformationModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'prefect_information';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 注册用户信息
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Array $data
     * @return Int
     **/
    public function addUser($data)
    {
        $res = $this->table->add($data);
        return $res;
    }

    /**
     * 手机号单条查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 string phone
     * @return
     **/
    public function phoneOne($phone)
    {
        $where = array(
            'phone'=>$phone
        );
        $res = $this->table->where($where)->find();
        return $res;
    }

    /**
     * 用户ID单条查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid
     * @return Array
     **/
    public function uidOne($uid)
    {
        $where = array(
            'id' => $uid
        );
        $res = $this->table->field('id,phone,name,age,sex,headpic,thumbpic,life,lis')->where($where)->find();
        return $res;
    }

    /**
     * 修改用户数据
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid
     * @return Array
     **/
   public function saveOne($uid, $save)
   {
        $where = array(
            'id' => $uid
        );
        $res = $this->table->where($where)->save($save);
        return $res;
   }

    /**
     * 用户单个字段查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * @param2 String $field 要查询的单个字段
     * @return Array
     **/
    public function fieldOne($uid, $field)
    {
        $where = array(
            'id' => $uid
        );
        $res = $this->table->field($field)->where($where)->find();
        return $res;
    }

    /**
     * 条件字段查询
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $where 查询条件
     * @param2 String $field 要查询的单个字段
     * @return Array
     **/
    public function selectRow($where, $field)
    {
        $res = $this->table->field($field)->where($where)->find();
        return $res;
    }

    /**
     * 用户手机号修改
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $id 用户ID
     * @param2 String $phone 修改的手机号
     * @param2 String $area_code 区号
     * @return Array
     **/
    public function updatePhone($uid, $phone, $area_code)
    {
        $where = array(
            'id' => $uid
        );
        $save = array(
            'phone' => $phone,
            'area_code' => $area_code
        );
        $res = $this->table->where($where)->save($save);
        return $res;
    }

    /**
     * 跟新用户积分
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * @param2 Int $addlis要加的积分
     * @return Int
     **/
    public function updateIntegral($uid, $addlis)
    {
        $where = array(
            'id' => $uid
        );
        $res = $this->table->where($where)->setInc('lis',$addlis);
        return $res;
    }

    /**
     * 查询邀请码
     * @author yangxiuchuan
     * @version 1.0
     * @param1 Int $uid 用户ID
     * @return Int
     **/
    public function selectInvitationCodeFind($code)
    {
        $where = array(
            'invitation_code' => $code
        );
        $res = $this->table->where($where)->find();
        return $res;
    }

    //******************************************************************************************************************//

}