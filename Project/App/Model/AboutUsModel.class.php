<?php
/**
 * Created by PhpStorm.
 * User: 杨秀川
 * Date: 2018/4/24
 * Time: 17:20
 */

namespace app\Model;

use Think\Model;

class AboutUsModel extends Model
{
    public $table; //实例化表对象
    public $tableName = 'about_us';

    public function __construct()
    {
        parent::__construct();
        $this->table = M($this->tableName);
    }

    /**
     * 根据版本号查询
     * @author  yangxiuchuan
     * @version 1.0
     * @param1  String $versions 版本号
     * @return
     **/
    public function oneVersions($versions)
    {
        $where = array(
            'versions' => $versions
        );
        $res = $this->table->where($where)->find();
        return $res;
    }

}