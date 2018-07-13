<?php
/**
* 
*/

	 $target = "http://cf.lmobile.cn/submitdata/Service.asmx/g_Submit";
	 $post_data =
		"sname=dlsdcs00&spwd=zW46mgXE&scorpid=&sprdid=1012818&sdst=18574141757&smsg=".rawurlencode("您的验证码是：123456。请不要把验证码泄露给其他人。【百分信息】");
	echo $gets = Post($post_data, $target);


?>