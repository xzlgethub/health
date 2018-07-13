<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>健康股运动邀请函</title>
    <link rel="stylesheet" href="/health/Public/h5/common.css">
</head>

<body>
    <img src="/health/Public/h5/image/logo.png" style="width:100%;">
    <div class="index">
        <form action="" method="post">
        <p class="code-text">输入发送给您+<?php echo ($area_code); echo ($phone); ?>的四位验证码</p>
            <input type="hidden" id = 'phone' value="<?php echo ($phone); ?>">
            <input type="hidden" id = 'area_code' value="<?php echo ($area_code); ?>">
        <div class="code">
            <input type="text" placeholder="验证码" style="font-size:14px" name="invite_code" id="invite_code">
            <span style="font-size:10px" onclick="settime(this)" id = 'btn'>（59s后重新获取）</span>
        </div>
        <div class="btn">提交</div>
        </form>
        <div class="dowmload-link">已有账户直接下载<img src="/health/Public/h5/image/arrow-right.png" ></div>
    <div class="bottom-introduce">
        <div class="exercise-item introduce-item">
            <span class="green-line"></span>
            <span class="item-title">运动挖矿</span>
            <p>在安装完手机APP后开始运动挖矿，能获得持续的LIFE收益，LIFE能提现及购买健康股商城内相关产品</p>
        </div>
        <div class="system-item introduce-item">
            <span class="green-line"></span>
            <span class="item-title">健康股的生态系统</span>
            <p>基于医疗健康大数据重新连接医疗机构、健康保险、医生团体等健康相关产业。形成运动、健康、保障、医疗、康复正循环，打造普惠医疗健康金融生态系统</p>
        </div>
    </div>
    </div>
    
</body>
<!--<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>-->
<script src="/health/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script>
    function invokeSettime(obj){
        var countdown=59;
        settime(obj);
        function settime(obj) {
            if (countdown == 0) {
                $(obj).attr("disabled",false);
                $(obj).text("获取验证码");
                countdown = 60;
                return;
            } else {
                $(obj).attr("disabled",true);
                $(obj).text("(" + countdown + ") s 重新发送");
                countdown--;
            }
            setTimeout(function() {
                        settime(obj) }
                    ,1000)
        }
    }

    new invokeSettime("#btn");



$('#btn').click(function(){
    var text = $('#btn').text();
    var phone = $('#phone').val();
    var area_code = $('#area_code').val();
    if(text == '获取验证码'){

//        $.getJSON()
        $.ajax({
            url:"<?php echo U('checkPhone');?>",
            type:'post',
            data:{phone:phone,area_code:area_code,state:1},
            success:function(e){
                if(e == 1){
                    new   invokeSettime("#btn");
                }
            }
        })
    }
})


</script>

</html>