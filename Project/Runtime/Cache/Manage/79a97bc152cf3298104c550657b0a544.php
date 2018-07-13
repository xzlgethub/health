<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
    <link href="/health/Public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="/health/Public/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/health/Public/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="/health/Public/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="/health/Public/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <link href="/health/Public/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="/health/Public/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
    <link href="/health/Public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
    <style type="text/css">
        .dataTables_filter .form-control {
            margin-left: 87px;
        }
        .portlet.light.bordered {
            border: 0px solid #e1e1e1 !important;
        }

        .pages a,.pages span {
            display:inline-block;
            padding:2px 5px;
            margin:0 1px;
            border:1px solid #f0f0f0;
            -webkit-border-radius:3px;
            -moz-border-radius:3px;
            border-radius:3px;
        }
        .pages a,.pages li {
            display:inline-block;
            list-style: none;
            text-decoration:none; color:#58A0D3;
        }
        .pages a.first,.pages a.prev,.pages a.next,.pages a.end{
            margin:0;
        }
        .pages a:hover{
            border-color:#50A8E6;
        }
        .pages span.current{
            background:#50A8E6;
            color:#FFF;
            font-weight:700;
            border-color:#50A8E6;
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
<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
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
        <i class="fa fa-shopping-cart"></i>
        <span class="title">产品管理</span>
    </a>
</li>
<li>
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
            <div class="page-bar" style="margin-bottom:20px;margin-top:-10px;">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/health/index.php/Manage/Rule/RuleUser">权限管理</a>
                    </li>
                    <li>
                        <i class="fa fa-angle-right"></i>
                        <small style="color:#888888">用户分配</small>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>用户分配
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row"></div>
                                <table class="table table-striped table-bordered table-hover" id="sample_editable_1" >
                                <thead>
                                <tr>
                                    <th>用户名</th>
                                    <th>所属权限组</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($res)): foreach($res as $key=>$res): ?><tr>
                                        <td><?php echo ($res["name"]); ?></td>
                                        <td><?php echo ($res["title"]); ?></td>
                                        <td>
                                            <?php if(RuleCheck('Manage/Rule/changeAGA',$_SESSION['uid'])): ?><a data-toggle="modal" data-target="#auModal" data-id="<?php echo ($res['id']); ?>" data-gid="<?php echo ($res['gid']); ?>" class="sendAjax" href="javascript:;">更改权限组</a><?php endif; ?>
                                            <!--<a href="javascript:delRule(<<?php echo ($res["id"]); ?>>);">删除 </a>-->
                                        </td>
                                    </tr><?php endforeach; endif; ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-10 col-md-push-3">
                                    <!--<div class="pagination">-->
                                    <!--<ul>-->
                                    <div class="pages">
                                        <?php echo ($show); ?>
                                    </div>
                                    <!--</ul>-->
                                    <!--</div>-->
                                </div>
                            </div>
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
<!-- END CONTAINER -->
<!-- myModal BEGIN -->
<div class="modal fade" id="auModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/health/index.php/Manage/Rule/changeAGA" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">权限组更改</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <label class="col-md-3 control-label" style="margin-top: 5px;">请选择权限组</label>
                    <div class="col-md-9">
                        <select class="form-control" name="RuleGroup" id="showRuleg">
                        </select>
                    </div>
                    <input type="hidden" name="oldAG" value="">
                    <input type="hidden" name="oldAU" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" disabled="disabled" id="changeAG">提交</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="page-footer">
    <div class="page-footer-inner">
        <<?php echo ($_SESSION['users']['copyright']); ?>>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<!--[if lt IE 9]>
<script src="/health/Public/assets/global/plugins/respond.min.js"></script>
<script src="/health/Public/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/health/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/health/Public/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/health/Public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/health/Public/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/health/Public/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/health/Public/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="/health/Public/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="/health/Public/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="/health/Public/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>


<script src="/health/Public/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="/health/Public/assets/admin/pages/scripts/table-advanced.js"></script>
<script src="/health/Public/assets/admin/pages/scripts/table-editable.js"></script>
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        TableEditable.init();
        Layout.setSidebarMenuActiveLink('set', $('#RuleUser'));
    });
</script>
<script>
    function delRule(id){
        if(confirm("确定要删除该条数据吗？")){
            //跳转网页,并携带参数
            window.location="/health/index.php/Manage/Rule/delRule/id/"+id;
        }
    }

    // 点击查看权限事件
    $(".sendAjax").click(function(){
        // 获取 权限组id
        var gid = $(this).attr('data-gid');
        if (gid == ''){
            gid = '0';
        }
        // 将当前用户所属权限组id保存到hidden隐藏域中
        $("input[name=oldAG]").val(gid);
        // 获取用户id
        var uid = $(this).attr('data-id');
        // 将当前用户id保存到hidden隐藏域中
        $("input[name=oldAU]").val(uid);
        // 发送ajax请求获取权限名称
        $.ajax({
            url: '/health/index.php/Manage/Rule/findRuleGroup',
            type: 'POST',
            dataType: 'json',
            data: {gid: gid},
            success: function(data){
                $("#showRuleg").html("<option value='0'>请选择</option>");
                var newoption = "";
                for (i=0; i<data.length; i++){
                    if( data[i]['selected'] == 'yes'){
                        newoption = $("<option value='"+data[i]['id']+"' selected>"+data[i]['title']+"</option>");
                    }else{
                        newoption = $("<option value='"+data[i]['id']+"'>"+data[i]['title']+"</option>");
                    }
                    $("#showRuleg").append(newoption);
                }
            },
            error: function(){
                alert('获取权限错误...');
            },
            async: false
        })
    })

    // 改变权限组事件
    $("#showRuleg").change(function(){
        // 获取当前选中的权限组id
        var sid = $(this).children('option:selected').val();
        // 获取当前用户所属权限组的id
        var gid = $("input[name=oldAG]").val();
        // 获取当前用户id
        var uid = $("input[name=oldAU]").val();
        // 如果权限组发生变化则允许用户提交信息
        if(gid != sid){
            // 将 [ 提交 ] 按钮开启
            $("#changeAG").removeAttr('disabled');
        }else{
            $("#changeAG").attr('disabled','disabled');
        }
    })
</script>
</body>
<!-- END BODY -->
</html>