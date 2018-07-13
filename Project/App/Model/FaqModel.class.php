<?php
/**常见问题表相关操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/26
 * Time: 18:41
 */

namespace app\Model;

use Think\Model;

class FaqModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'faq';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 添加常见问题
     * @author  yangxiuchuan
     * @version 1.0
     * @param1 Array $add 添加的数据
     * @return
     **/
    public function addFaq($add)
    {
        $res = $this->table->add($add);
        return $res;
    }

    /**
     * ID查找单条数据
     * @author  yangxiuchuan
     * @version 1.0
     * @param1 Array $id ID
     * @return
     **/
    public function selectIdOne($id)
    {
        $where = array(
            'id' => $id
        );
        $res = $this->table->where($where)->find();
        return $res;
    }

    /**
     * 通过ID修改数据
     * @author  yangxiuchuan
     * @version 1.0
     * @param1 Array $id ID
     * @param2 Array $data 要修改的数据
     * @return
     **/
    public function saveData($id, $data)
    {
        $where = array(
            'id' => $id
        );
        $res = $this->table->where($where)->save($data);
        return $res;
    }
}