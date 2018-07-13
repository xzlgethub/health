<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>平台管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="/health/Public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="/health/Public/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="favicon.ico"/>
    <script src="/health/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <style>
        body{
            font-family:'微软雅黑';
        }
    </style>
</head>

<body  class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
<!--<body class="page-header-fixed page-quick-sidebar-over-content ">-->
<!-- BEGIN HEADER -->

<!--引入View/Public/head.html-->
<!--头信息-->
<style>
    * {
        font-family: '微软雅黑';
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: '微软雅黑';
    }

    #sample_6_filter label {
        margin-left: 345px;
    }
</style>
<script src="/health/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<div class="page-header navbar navbar-fixed-top" style="">
    <div class="page-header-inner">
        <div class="page-logo col-md-2">
            <img src="/health/Public/<?php echo ($_SESSION['users']['logo']); ?>" style="margin-top:-4px;width:140px;"/>
        </div>
        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="/health/Public/assets/admin/layout/img/avatar3_small.jpg"/>
                            <span class="username username-hide-on-mobile"><?php echo ($_SESSION['users']['name']); ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default" style="min-width: 130px;width: 130px;">
                            <li id="mm" role="presentation">
                                <a data-toggle="modal" data-target="#myModal"><i class="icon-lock"></i> 修改密码</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="/health/index.php/Manage/Login/logout"><i
                                        class="icon-key"></i> 退出</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true"
     style="background-color:#bbb;opacity: 0.9;height:1000px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel" style="font-family:'微软雅黑';">修改密码</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-top:10px;">
                    <div class="col-md-2 col-md-offset-2"><h5 style="font-family:'微软雅黑';">原密码</h5></div>
                    <div class="col-md-4">
                        <input id="pwd" type="password" name="pwd" class="form-control"/>
                    </div>
                </div>
                <div class="row" style="padding-top:10px;">
                    <div class="col-md-2 col-md-offset-2"><h5 style="font-family:'微软雅黑';">新密码</h5></div>
                    <div class="col-md-4">
                        <input id="newpwd" type="password" name="newpwd" class="form-control"/>
                    </div>
                </div>
                <div class="row" style="padding-top:10px;">
                    <div class="col-md-2 col-md-offset-2"><h5 style="font-family:'微软雅黑';">重复密码</h5></div>
                    <div class="col-md-4">
                        <input id="repwd" type="password" name="repwd" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-5">
                    <span id="span" style="font-family:'微软雅黑';color:red;"></span>
                </div>
                <input id="uid" type="hidden" name="id" value="<<?php echo ($_SESSION['users']['id']); ?>>"/>
                <input type="button" value="关闭" style="font-family:'微软雅黑';" class="btn btn-default"
                       data-dismiss="modal"/>
                <input id="sub" type="submit" value="保存" style="font-family:'微软雅黑';" class="btn btn-primary"/>

                <script>
                    $(function () {
                        $('#mm').click(function () {
                            $('#span').text('');
                        })

                        $('#sub').click(function () {
                            var pwd = $('#pwd').val();
                            var newpwd = $('#newpwd').val();
                            var repwd = $('#repwd').val();
                            if (newpwd == repwd) {
                                var reg = /^[0-9A-Za-z]{5,50}$/;
                                if (reg.test(newpwd)) {
                                    $.post("/health/index.php/Manage/Login/editpass", {
                                        pass: pwd,
                                        newpass: newpwd,
                                        repass: repwd
                                    }, function (data) {
                                        if (data == 1) {
                                            alert("修改成功");
                                            window.location.href = "/health/index.php/Manage/Login/logout";
                                        } else {
                                            $('#span').text(data);
                                        }
                                    })
                                } else {
                                    $("#span").text("密码不应低于5位");
                                }
                            } else {
                                $("#span").text("两次密码不一致");
                            }
                        })
                    })
                </script>
            </div>
        </div>
    </div>
</div>


<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

                <!--引入View/Public/common.html-->
                <!--菜单栏信息-->
                <li class="sidebar-toggler-wrapper">
    <!-- 导航隐藏块开始 -->
    <div class="sidebar-toggler" style="margin: 10px 10px 10px 0;"></div>
    <!-- 导航隐藏块结束 -->
</li>
<li>
    <a href="/health/index.php/Manage/Index/index" id="page0">
        <i class="icon-home"></i>
        <span class="title">首页</span>
    </a>
</li>
<li class="start">
    <a href="javascript:;">
        <i class="icon-user"></i>
        <span class="title">用户管理</span>
        <span class="selected "></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li class="">
            <a href="/health/index.php/Manage/User/index" id="user">
                <i class="icon-user"></i>
                用户预览</a>
        </li>
        <li class="">
            <a href="/health/index.php/Manage/User/audit" id="audit">
                <i class="icon-user"></i>
                用户报告审核</a>
        </li>
    </ul>
</li>
<li class="start">
    <a href="javascript:;">
        <i class="icon-user"></i>
        <span class="title">管理员管理</span>
        <span class="selected "></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
		<li class="">
			<a href="/health/index.php/Manage/Management/administrator" id="admin">
				<i class="icon-user"></i>
				管理员预览</a>
		</li>
    </ul>
</li>
<li class="start">
    <a href="javascript:;">
        <i class="icon-lock"></i>
        <span class="title">权限管理</span>
        <span class="selected "></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
		<li class="">
			<a href="/health/index.php/Manage/Rule/index" id="Rule">
				<i class="icon-lock"></i>
				权限预览</a>
		</li>
		<li>
			<a href="/health/index.php/Manage/Rule/RuleGroup" id="RuleGroup">
				<i class="icon-users"></i>
				权限组预览</a>
		</li>
		<li>
			<a href="/health/index.php/Manage/Rule/RuleUser" id="RuleUser">
				<i class="icon-tag"></i>
				用户分配</a>
		</li>
    </ul>
</li>

<li>
    <a href="/health/index.php/Manage/Product/index" id="product">
        <i class="fa fa-reorder"></i>
        <span class="title">产品管理</span>
    </a>
</li>
<li class = 'active'>
    <a href="/health/index.php/Manage/Order/index" id="order">
        <i class="fa fa-shopping-cart"></i>
        <span class="title">订单管理</span>
    </a>
</li>

<li>
    <a href="/health/index.php/Manage/Logo/index" id="logo">
        <i class="glyphicon glyphicon-fire"></i>
        <span class="title">logo管理</span>
    </a>
</li>

<li>
    <a href="/health/index.php/Manage/Copyright/index" id="copyright">
        <i class="glyphicon glyphicon-barcode"></i>
        <span class="title">版权管理</span>
    </a>
</li>
<li>
    <a href="/health/index.php/Manage/Faq/index" id="faq">
        <i class="fa fa-question-circle"></i>
        <span class="title">常见问题管理</span>
    </a>
</li>

<li>
    <a href="/health/index.php/Manage/My/aboutus" id="aboutus">
        <i class="icon-notebook"></i>
        <span class="title">关于我们管理</span>
    </a>
</li>

<li>
    <a href="/health/index.php/Manage/Feedback/index" id="Feedback">
        <i class="icon-pencil"></i>
        <span class="title">意见反馈管理</span>
    </a>
</li>

            </ul>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--<h3 style="margin-top: -10px;">首页</h3>-->
            <div class="page-bar" style="margin-bottom:20px;margin-top:-10px;">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/health/index.php/Manage/Index/index">首页</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet-body">
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-purple-soft">
                                                <span data-counter="counterup" data-value="<?php echo ($usercontent); ?>"></span>
                                            </h3>
                                            <small>会员总人数</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-user"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                    <span style="width: <?php echo ($rate_user); ?>%;" class="progress-bar progress-bar-success purple-soft">
                                        <span class="sr-only"><?php echo ($rate_user); ?>% change</span>
                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> change </div>
                                            <div class="status-number"> <?php echo ($rate_user); ?>% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-red-haze">
                                                <span data-counter="counterup" data-value="<?php echo ($feedback); ?>">0</span>
                                            </h3>
                                            <small>意见反馈总数</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-like"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                    <span style="width: <?php echo ($rate_feedback); ?>%;" class="progress-bar progress-bar-success red-haze">
                                        <span class="sr-only"><?php echo ($rate_feedback); ?>% change</span>
                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> change </div>
                                            <div class="status-number"> <?php echo ($rate_feedback); ?>% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-green-sharp">
                                                <span data-counter="counterup" data-value="<?php echo ($pv); ?>">0</span>
                                                <small class="font-green-sharp"></small>
                                            </h3>
                                            <small>当天访问量</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-pie-chart"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                    <span style="width: <?php echo ($rate_pv); ?>%;" class="progress-bar progress-bar-success green-sharp">
                                        <span class="sr-only"><?php echo ($rate_pv); ?>% progress</span>
                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> progress </div>
                                            <div class="status-number"> <?php echo ($rate_pv); ?>% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-blue-sharp">
                                                <span data-counter="counterup" data-value="<?php echo ($faq); ?>"></span>
                                            </h3>
                                            <small>常见问题文章总数</small>
                                        </div>
                                        <div class="icon">
                                            <i class="icon-basket"></i>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                    <span style="width: <?php echo ($rate_faq); ?>%;" class="progress-bar progress-bar-success blue-sharp">
                                        <span class="sr-only"><?php echo ($rate_faq); ?>% grow</span>
                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> grow </div>
                                            <div class="status-number"> <?php echo ($rate_faq); ?>% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" >
                            <div class="htmleaf-content">
                                <!--<div style="width:97%;margin:0 auto;">&lt;!&ndash;background-color: #Ffffff;&ndash;&gt;-->
                                    <!--<h4>会员人数增长报表<span></span></h4>-->
                                    <!--<div>-->
                                        <!--<canvas id="canvas" height="200" width="600"></canvas>-->
                                    <!--</div>-->
                                <!--</div>-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-footer">
    <div class="page-footer-inner">
        <<?php echo ($_SESSION['users']['copyright']); ?>>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/health/Public/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/scripts/Chart.js" type="text/javascript"></script>

<!--开始页面级别的脚本-->
<script src="/health/Public/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic核心组件
        Layout.init(); //初始化当前布局
        Demo.init(); // init演示功能
        Layout.setSidebarMenuActiveLink('set', $('#page0'));
    });
</script>

<script>
    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var lineChartData = {
        labels : ["2017/1","2017/2","2017/3","2017/4","2017/5","2017/6","2017/7","2017/8","2017/9","2017/10","2017/11","2017/12"],
        datasets : [
            {
                label: "My First dataset",
                //绿色
                fillColor : "rgba(28,188,155,0.2)",
                strokeColor : "rgba(28,188,155,1)",
                pointColor : "rgba(28,188,155,1)",
                pointStrokeColor : "#fff",  //点外圈颜色
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(28,188,155,1)",
                data : [50,70,40,60,30,60,80,100,120,130,140,160]
            }
        ]
    }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }
</script>
</body>
</html>