<?php
/**
 * Version表的操作
 *
 * @author xuliang
 *
 **/
namespace Manage\Model;
use Think\Model;
class FeedbackModel extends Model {
    /**
     * del  删除意见反馈数据
     * @author xuliang
     * @version 1.0
     * @param1 id int
     * @return int
     **/
    public function del($id)
    {
        $Model = M('feedback');
        $res = $Model->delete($id);
        return $res;
    }
}
