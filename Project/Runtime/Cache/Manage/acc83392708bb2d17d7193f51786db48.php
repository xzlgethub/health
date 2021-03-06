<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>管理系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link href="/health/Public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/health/Public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/health/Public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/health/Public/assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="/health/Public/assets/global/css/components-rounded.css" id="style_components" rel="stylesheet"
          type="text/css"/>
    <link href="/health/Public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="/health/Public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" type="image/ico" href="/health/favicon.ico">
    <script src="/health/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <style>
        body {
            font-family: '微软雅黑';
        }
    </style>
</head>
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<div class="logo">
    <a href="index.html">
        <img src="/health/Public/<?php echo ($logo['name']); ?>" width="200" />
    </a>
</div>
<div class="content" style="margin-top:10px;">
    <form class="login-form" id="registerForm frm1" action="/health/index.php/Manage/Login/login" method="post">
        <h3 class="form-title"></h3>
        <div id="u" class="alert alert-danger display-hide" style="height:45px;">
            <span>用户名或密码错误</span>
        </div>
        <div class="alert alert-danger display-hide" id="use" style="height:45px;">
            <span class="user_icon">用户名错误</span>
        </div>
        <div class="alert alert-danger display-hide" id="uu" style="height:45px;">
            <span class="user_icon">请输入用户名和密码</span>
        </div>
        <div class="alert alert-danger display-hide" id="good" style="height:45px;">
            <span class="user_icon">请输入正确信息</span>
        </div>
        <div class="alert alert-danger display-hide" id="mima" style="height:45px;">
            <span class="user_icon">请输入密码</span>
        </div>
        <div class="alert alert-danger display-hide" id="zhang" style="height:45px;">
            <span class="user_icon">请输入用户名</span>
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid placeholder-no-fix" style="font-family:'微软雅黑';" type="text"
                   id="nickname" autocomplete="off" placeholder="用户名" name="username"/>
            <span class="tip"></span>
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid placeholder-no-fix" style="font-family:'微软雅黑';"
                   type="password" id="password" autocomplete="off" placeholder="密码" name="pass">
            <span class="tip"></span>
        </div>
        <div class="form-actions">
            <input type="submit" value="登录" id="sub" class="btn btn-success btn-block uppercase wrap"
                   style="font-family:'微软雅黑';">
        </div>
    </form>
</div>
<div class="copyright">
    <<?php echo ($copyright['name']); ?>>
</div>
<script src="/health/Public/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/health/Public/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/layout/scripts/jquery.validate.min.js" type="text/javascript"></script>
<input type="hidden" value="<<?php echo ($status); ?>>" id="status"/>
<script>
    $(function () {
        $('#password').focus(function () {
//		 $('#password').nextAll().not('.pwd_icon').remove();
            $('#u').css('display', 'none');
            $('#mima').css('display', 'none');
            $('#uu').css('display', 'none');
        });
        $('#nickname').focus(function () {
            $('#u').css('display', 'none');
            $('#zhang').css('display', 'none');
            $('#uu').css('display', 'none');
        });

        $(".login-form").validate({
            /*自定义验证规则*/

            submitHandler: function (form) {
                var name = $("#nickname").val();
                var pass = $("#password").val();
                if (name == '' && pass == '') {
                    $('#uu').css('display', 'block');
                    return false;
                } else if (name == '') {
                    $('#zhang').css('display', 'block');
                    return false;
                } else if (pass == '') {
                    $('#mima').css('display', 'block');
                    return false;
                } else {
                    $.ajax({
                        type: "get",
                        url: "/health/index.php/Manage/Login/vadataajax",
                        data: {name: name, pass: pass},
                        success: function (data) {
                            if (data == 1) {
                                $('#u').css('display', 'block');
                                return false;
                            } else {
                                form.submit();
                            }
                        }
                    });
                }
            }
        });
        //验证账号是否有登录权限
        var status = $("#status").val();
        if (status == 1) {
            alert('账号被禁止');
        } else if (status == 2) {
            alert('账号或密码错误');
        }
    })
</script>
</body>
</html>