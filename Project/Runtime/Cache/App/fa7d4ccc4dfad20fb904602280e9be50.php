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
        <form id='form' action="" method="post" onsubmit="return isPoneAvailable()">
        <div class="phone">
            
            <select name="area_code" id="area_code" style="font-size:13px;">
                <option value="86" selected>CN +86</option>
            </select>
            <input type="text" placeholder="请输入您的手机号" style="font-size:14px" name="phone" id="phone" value="">
        </div>
        <div class="code">
            <input type="text" placeholder="验证码" style="font-size:14px" id="checkcode">
            <input type="hidden" id = 'yao_code' value="<?php echo ($yao_code); ?>">
            <span class="encode" id="captcha-container">
                <img  alt="验证码" src="<?php echo U('App/Invite/verify_c',array());?>" title="点击刷新">
        </span>
        </div>
        <div class="btn">获取验证码</div>
        </form>
        <div class="dowmload-link">已有账户直接下载
            <img src="/health/Public/h5/image/arrow-right.png">
        </div>
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
    var captcha_img = $('#captcha-container').find('img')
    var verifyimg = captcha_img.attr("src");
    captcha_img.attr('title', '点击刷新');
    captcha_img.click(function(){
        if( verifyimg.indexOf('?')>0){
            $(this).attr("src", verifyimg+'&random='+Math.random());
        }else{
            $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
        }
    });





    var str = document.getElementById('phone').value;
    function isPoneAvailable(str) {
        var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
        if (!myreg.test(str)) {
            return false;
        } else {
            return true;
        }
    }
    $(".btn").click(function(){
       if(isPoneAvailable(document.getElementById('phone').value)) {
           var phone = $('#phone').val();

           var area_code = $('#area_code').val();

           var checkcode = $('#checkcode').val();
           $.getJSON("http://demo.huliantec.com/lifeshare/index.php/App/Invite/checkPhone?phone="+phone+"&area_code="+area_code+"&checkcode="+checkcode,function(e){
//                   new   invokeSettime("#btn");
                /*   var   da = new Function("return" + data)();
                   var phone = da.phone;
                   var area_code = da.area_code;
                   var yao_code = da.yao_code;*/
                alert(e.phone);
                  if(e == 1){
                       alert('验证码错误！');
                   }else if(e == 2){
                       alert('手机号错误！');
                   }else if(e == 3){
                       alert('已经注册！');
                   }else{
                       location.href = "http://demo.huliantec.com/lifeshare/index.php/App/Invite/code/phone/"+phone+'/area_code/'+area_code+'/yao_code/'+yao_code;
                   }

           })
     /*     var phone = $('#phone').val();
           var area_code = $('#area_code').val();
           check
            $.ajax({
                url:"<?php echo U('checkPhone');?>",
                type:'post',
                data:{}
            })*/



//           location.href = "http://demo.huliantec.com/lifeshare/index.php/App/Invite/code/phone/"+phone+'/area_code/'+area_code+'/yao_code/'+yao_code;

       }else{
           alert('请输入正确的手机号！');
       }
    });
</script>

</html>