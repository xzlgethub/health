<?php
/**
 * Log表增删改查等操作
 *
 * @author xl
 * @Date: 2018/11/30
 **/
namespace Manage\Model;
use Think\Model;
use Think\Log;
class LogresModel extends Model
{
    /**
     * 查询日志数据
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function showLogs($where)
    {
        $res = M('logres')->where($where)->order('time desc')->select();
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("data:" . $data);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }

        return $res;
    }

    /**
     * Log日志删除数据
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function deleteLogs($id)
    {
        $res = M('logres')->where("id = '{$id}'")->delete();
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("data:" . $data);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }

        return $res;
    }

    /**
     * 指定时间的范围区间查询数据
     *
     * @author xl
     * @version 1.0
     * @return str
     **/
    public function rangeQueries($num, $count)
    {
        $res = M('logres')->order('time desc')->limit($num, $count)->select();
        //sql语句执行错误，插入日志
        // if(!$res){
        //  Log::write("-------------------------->" . __FUNCTION__ );
        //  Log::write("ID:" . $id);
        //  Log::write("data:" . $data);
        //  Log::write("Sql:" . M('user')->_sql());
        //  Log::write("<--------------------------" . __FUNCTION__ );
        // }

        return $res;
    }
}