<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>平台管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="Ruleor"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="/project/Public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/project/Public/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/project/Public/assets/global/plugins/bootstrap-summernote/summernote.css">
    <link id="style_color" href="/project/Public/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
    <style>
        .portlet.light.bordered {
            border: 0px solid #e1e1e1 !important;
        }
    </style>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content ">
<!-- BEGIN HEADER -->
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
<script src="/project/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<div class="page-header navbar navbar-fixed-top" style="">
    <div class="page-header-inner">
        <div class="page-logo col-md-2">
            <img src="/project/Public/<?php echo ($_SESSION['users']['logo']); ?>" style="margin-top:-4px;width:140px;"/>
        </div>
        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="/project/Public/assets/admin/layout/img/avatar3_small.jpg"/>
                            <span class="username username-hide-on-mobile"><?php echo ($_SESSION['users']['name']); ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default" style="min-width: 130px;width: 130px;">
                            <li id="mm" role="presentation">
                                <a data-toggle="modal" data-target="#myModal"><i class="icon-lock"></i> 修改密码</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="/project/index.php/Manage/Login/logout"><i
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
                                    $.post("/project/index.php/Manage/Login/editpass", {
                                        pass: pwd,
                                        newpass: newpwd,
                                        repass: repwd
                                    }, function (data) {
                                        if (data == 1) {
                                            alert("修改成功");
                                            window.location.href = "/project/index.php/Manage/Login/logout";
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
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="sidebar-toggler-wrapper">
    <!-- 导航隐藏块开始 -->
    <div class="sidebar-toggler" style="margin: 10px 10px 10px 0;"></div>
    <!-- 导航隐藏块结束 -->
</li>

<li>
    <a href="/project/index.php/Manage/Index/index" id="page0">
        <i class="icon-home"></i>
        <span class="title">首页</span>
    </a>
</li>

<!--<li>-->
    <!--<a href="/project/index.php/Manage/User/index" id="user">-->
        <!--<i class="icon-user"></i>-->
        <!--<span class="title">用户管理</span>-->
    <!--</a>-->
<!--</li>-->
<li class="start">
    <a href="javascript:;">
        <i class="icon-user"></i>
        <span class="title">用户管理</span>
        <span class="selected "></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li class="">
            <a href="/project/index.php/Manage/User/index" id="user">
                <i class="icon-user"></i>
                用户预览</a>
        </li>
        <li class="">
            <a href="/project/index.php/Manage/User/audit" id="audit">
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
			<a href="/project/index.php/Manage/Management/administrator" id="admin">
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
			<a href="/project/index.php/Manage/Rule/index" id="Rule">
				<i class="icon-lock"></i>
				权限预览</a>
		</li>
		<li>
			<a href="/project/index.php/Manage/Rule/RuleGroup" id="RuleGroup">
				<i class="icon-users"></i>
				权限组预览</a>
		</li>
		<li>
			<a href="/project/index.php/Manage/Rule/RuleUser" id="RuleUser">
				<i class="icon-tag"></i>
				用户分配</a>
		</li>
    </ul>
</li>

<li>
    <a href="/project/index.php/Manage/Product/index" id="product">
        <i class="fa fa-shopping-cart"></i>
        <span class="title">产品管理</span>
    </a>
</li>

<li>
    <a href="/project/index.php/Manage/Logo/index" id="logo">
        <i class="glyphicon glyphicon-fire"></i>
        <span class="title">logo管理</span>
    </a>
</li>

<li>
    <a href="/project/index.php/Manage/Copyright/index" id="copyright">
        <i class="glyphicon glyphicon-barcode"></i>
        <span class="title">版权管理</span>
    </a>
</li>
<li>
    <a href="/project/index.php/Manage/Faq/index" id="faq">
        <i class="fa fa-question-circle"></i>
        <span class="title">常见问题管理</span>
    </a>
</li>

<!--<li class="start">-->
    <!--<a href="javascript:;">-->
        <!--<i class="glyphicon glyphicon-picture"></i>-->
        <!--<span class="title">APP图片管理</span>-->
        <!--<span class="arrow "></span>-->
    <!--</a>-->
    <!--<ul class="sub-menu">-->
        <!--<li>-->
            <!--<a href="/project/index.php/Manage/Advertisement/index" id="Advertisement">-->
                <!--<i class="icon-docs"></i>图片预览 </a>-->
        <!--</li>-->
    <!--</ul>-->
<!--</li>-->

<!--<li>
    <a href="javascript:;">
        <i class="icon-social-dropbox"></i>
        <span class="title">APP软件管理</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li>
            <a href="/project/index.php/Manage/Software/index" id="Software">
                <i class="icon-docs"></i>APP软件预览 </a>
        </li>
    </ul>
</li>-->

<!--<li>-->
    <!--<a href="/project/index.php/Manage/Software/index" id="Software">-->
        <!--<i class="icon-social-dropbox"></i>-->
        <!--<span class="title">APP软件管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<li>-->
    <!--<a href="/project/index.php/Manage/Slide/index" id="page222">-->
        <!--<i class="glyphicon glyphicon-picture"></i>-->
        <!--<span class="title">轮播图管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<?php if(in_array('4',$_SESSION['menu_rule']) || $_SESSION['users']['id'] == '1'): ?>-->
    <!--<li class="start">-->
        <!--<a href="javascript:;">-->
            <!--<i class="icon-book-open"></i>-->
            <!--<span class="title">文章管理</span>-->
            <!--<span class="selected"></span>-->
            <!--<span class="arrow"></span>-->
        <!--</a>-->
        <!--<ul class="sub-menu">-->
            <!--<li class="">-->
                <!--<a href="/project/index.php/Manage/Article/index" id="page1">-->
                    <!--<i class="icon-folder"></i>-->
                    <!--文章预览</a>-->
            <!--</li>-->
        <!--</ul>-->
    <!--</li>-->
<!--<?php endif; ?>-->

<!--<li>-->
    <!--<a href="javascript:;">-->
        <!--<i class="icon-layers"></i>-->
        <!--<span class="title">数据字典管理</span>-->
        <!--<span class="arrow "></span>-->
    <!--</a>-->
    <!--<ul class="sub-menu">-->
        <!--<li>-->
            <!--<a href="/project/index.php/Manage/Datadic/adminRole" id="adminRole">-->
                <!--<i class="icon-docs"></i>角色预览 </a>-->
        <!--</li>-->
        <!--<li>-->
            <!--<a href="/project/index.php/Manage/Datadic/journalism" id="journalism">-->
                <!--<i class="icon-docs"></i>新闻类别预览 </a>-->
        <!--</li>-->
    <!--</ul>-->
<!--</li>-->

<li>
    <a href="/project/index.php/Manage/My/aboutus" id="aboutus">
        <i class="icon-notebook"></i>
        <span class="title">关于我们管理</span>
    </a>
</li>

<li>
    <a href="/project/index.php/Manage/Feedback/index" id="Feedback">
        <i class="icon-pencil"></i>
        <span class="title">意见反馈管理</span>
    </a>
</li>

<!--<li>-->
    <!--<a href="/project/index.php/Manage/Vido/index" id="vido">-->
        <!--<i class="glyphicon glyphicon-facetime-video"></i>-->
        <!--<span class="title">视频管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<li class="start">-->
    <!--<a href="/project/index.php/Manage/Log/index" id="log">-->
        <!--<i class="icon-speech"></i>-->
        <!--<span class="title">日志管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<li class="start">-->
    <!--<a href="/project/index.php/Manage/Picdata/index" id="Picdata">-->
        <!--<i class="glyphicon glyphicon-picture"></i>-->
        <!--<span class="title">图片库管理</span>-->
    <!--</a>-->
<!--</li>-->





            </ul>
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar" style="margin-bottom:20px;margin-top:-10px;">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/project/index.php/Manage/Faq/index">常见问题管理</a>
                    </li>
                    <li>
                        <i class="fa fa-angle-right"></i>
                        <small style="color:#888888">常见问题添加</small>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>常见问题添加
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form-horizontal form" action="/project/index.php/Manage/Faq/addAction" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group" style="margin-top:10px">
                                        <label class="control-label col-md-2">标题</label>
                                        <div class="col-md-10">
                                            <input type="text" id="" class="form-control" name="title" placeholder="请输入标题">
                                            <span class="tip"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">内容</label>
                                        <div class="col-md-10">
                                            <textarea id="content" class="form-control" name="content" style="height: 300px" placeholder="请输入内容"></textarea>
                                            <span class="tip"></span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top:10px">
                                        <label class="control-label col-md-2">权重</label>
                                        <div class="col-md-10">
                                            <input type="text" id="weight" class="form-control" name="weight" placeholder="输入数字，数字越大排名靠前">
                                            <span class="tip"></span>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-top:10px;">
                                        <div class="col-md-3 col-md-offset-1"></div>
                                        <div class="col-md-4">
                                            <input type="submit" value="添加" class="btn btn-success" style='width:100px;'/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
    <!-- END CONTENT -->
</div>

<div class="page-footer">
    <div class="page-footer-inner">
        <<?php echo ($_SESSION['users']['copyright']); ?>>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<script src="/project/Public/assets/global/plugins/respond.min.js"></script>
<script src="/project/Public/assets/global/plugins/excanvas.min.js"></script>

<script src="/project/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/project/Public/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript" src="/project/Public/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<!--验证js-->
<script src="/project/Public/assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>

<!--开始页面级别的脚本-->
<script src="/project/Public/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Layout.setSidebarMenuActiveLink('set', $('#faq'));
    });
</script>
<!--上传图片限制-->
<script type="text/javascript">
    file = document.getElementById('file');
    file.addEventListener('change',function(){
        size = this.files[0].size/1024
        console.log(size+'KB')

        // 如果大于2048KB
        if(size>2048){
            submit.disabled=true;
            if(confirm("图片过大！！！")){
                //跳转网页,并携带参数
                //window.location="/project/index.php/Manage/Faq/delTypeAction/id/"+id;
            }
        }else{
            // 小于等于2048
            submit.disabled=false;
        }
    })
</script>
<script>
    $(function () {
        $(".form-horizontal").validate({
            /*自定义验证规则*/
            rules:{
                title:{ required:true },
                content:{ required:true },
                weight:{ required:true },
            },messages: {
                title: {
                    required: "<span style='color:red;'>请输入标题名称！</span>"　　//注意，同样是必填项，但是优先显示在messages里的提示信息
                },
                content: {
                    required: "<span style='color:red;'>请输入内容！</span>"　　//注意，同样是必填项，但是优先显示在messages里的提示信息
                },
                weight: {
                    required: "<span style='color:red;'>请输入权重级别！</span>"　　//注意，同样是必填项，但是优先显示在messages里的提示信息
                }
            },
        });
    })
</script>
<input type='hidden' value='<<?php echo ($errorid); ?>>' id='errorid' />
</body>
<!-- END BODY -->
</html>