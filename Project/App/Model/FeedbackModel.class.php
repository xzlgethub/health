<?php
/**反馈意见表相关操作
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/24
 * Time: 16:32
 */

namespace app\Model;

use Think\Model;

class FeedbackModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'feedback';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 添加反馈
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  Int $data  要添加的数据
     * @return  int
     **/
    public function addFeedback($data)
    {
        $res = $this->table->add($data);
        return $res;
    }
}