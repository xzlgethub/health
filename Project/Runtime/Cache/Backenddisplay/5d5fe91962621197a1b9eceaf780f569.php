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
    <link href="/project/Public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="/project/Public/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/project/Public/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="/project/Public/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="/project/Public/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/project/Public/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="/project/Public/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
    <link href="/project/Public/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="favicon.ico"/>
    <script src="/project/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <style>
        .dataTable .details {
            background-color: #45B6AF;
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
                                <a role="menuitem" tabindex="-1" href="/project/index.php/Backenddisplay/Login/logout"><i
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
                                    $.post("/project/index.php/Backenddisplay/Login/editpass", {
                                        pass: pwd,
                                        newpass: newpwd,
                                        repass: repwd
                                    }, function (data) {
                                        if (data == 1) {
                                            alert("修改成功");
                                            window.location.href = "/project/index.php/Backenddisplay/Login/logout";
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
                <li class="sidebar-toggler-wrapper">
    <!-- 导航隐藏块开始 -->
    <div class="sidebar-toggler" style="margin: 10px 10px 10px 0;"></div>
    <!-- 导航隐藏块结束 -->
</li>

<li>
    <a href="/project/index.php/Backenddisplay/Index/index" id="page0">
        <i class="icon-home"></i>
        <span class="title">首页</span>
    </a>
</li>

<!--<li>-->
    <!--<a href="/project/index.php/Backenddisplay/User/index" id="user">-->
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
            <a href="/project/index.php/Backenddisplay/User/index" id="user">
                <i class="icon-user"></i>
                用户预览</a>
        </li>
        <li class="">
            <a href="/project/index.php/Backenddisplay/User/audit" id="audit">
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
			<a href="/project/index.php/Backenddisplay/Management/administrator" id="admin">
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
			<a href="/project/index.php/Backenddisplay/Rule/index" id="Rule">
				<i class="icon-lock"></i>
				权限预览</a>
		</li>
		<li>
			<a href="/project/index.php/Backenddisplay/Rule/RuleGroup" id="RuleGroup">
				<i class="icon-users"></i>
				权限组预览</a>
		</li>
		<li>
			<a href="/project/index.php/Backenddisplay/Rule/RuleUser" id="RuleUser">
				<i class="icon-tag"></i>
				用户分配</a>
		</li>
    </ul>
</li>

<li>
    <a href="/project/index.php/Backenddisplay/Product/index" id="product">
        <i class="fa fa-shopping-cart"></i>
        <span class="title">产品管理</span>
    </a>
</li>

<li>
    <a href="/project/index.php/Backenddisplay/Logo/index" id="logo">
        <i class="glyphicon glyphicon-fire"></i>
        <span class="title">logo管理</span>
    </a>
</li>

<li>
    <a href="/project/index.php/Backenddisplay/Copyright/index" id="copyright">
        <i class="glyphicon glyphicon-barcode"></i>
        <span class="title">版权管理</span>
    </a>
</li>
<li>
    <a href="/project/index.php/Backenddisplay/Faq/index" id="faq">
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
            <!--<a href="/project/index.php/Backenddisplay/Advertisement/index" id="Advertisement">-->
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
            <a href="/project/index.php/Backenddisplay/Software/index" id="Software">
                <i class="icon-docs"></i>APP软件预览 </a>
        </li>
    </ul>
</li>-->

<!--<li>-->
    <!--<a href="/project/index.php/Backenddisplay/Software/index" id="Software">-->
        <!--<i class="icon-social-dropbox"></i>-->
        <!--<span class="title">APP软件管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<li>-->
    <!--<a href="/project/index.php/Backenddisplay/Slide/index" id="page222">-->
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
                <!--<a href="/project/index.php/Backenddisplay/Article/index" id="page1">-->
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
            <!--<a href="/project/index.php/Backenddisplay/Datadic/adminRole" id="adminRole">-->
                <!--<i class="icon-docs"></i>角色预览 </a>-->
        <!--</li>-->
        <!--<li>-->
            <!--<a href="/project/index.php/Backenddisplay/Datadic/journalism" id="journalism">-->
                <!--<i class="icon-docs"></i>新闻类别预览 </a>-->
        <!--</li>-->
    <!--</ul>-->
<!--</li>-->

<li>
    <a href="/project/index.php/Backenddisplay/My/aboutus" id="aboutus">
        <i class="icon-notebook"></i>
        <span class="title">关于我们管理</span>
    </a>
</li>

<li>
    <a href="/project/index.php/Backenddisplay/Feedback/index" id="Feedback">
        <i class="icon-pencil"></i>
        <span class="title">意见反馈管理</span>
    </a>
</li>

<!--<li>-->
    <!--<a href="/project/index.php/Backenddisplay/Vido/index" id="vido">-->
        <!--<i class="glyphicon glyphicon-facetime-video"></i>-->
        <!--<span class="title">视频管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<li class="start">-->
    <!--<a href="/project/index.php/Backenddisplay/Log/index" id="log">-->
        <!--<i class="icon-speech"></i>-->
        <!--<span class="title">日志管理</span>-->
    <!--</a>-->
<!--</li>-->

<!--<li class="start">-->
    <!--<a href="/project/index.php/Backenddisplay/Picdata/index" id="Picdata">-->
        <!--<i class="glyphicon glyphicon-picture"></i>-->
        <!--<span class="title">图片库管理</span>-->
    <!--</a>-->
<!--</li>-->





            </ul>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar" style="margin-bottom:20px;margin-top:-10px;">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-shopping-cart"></i>
                        <a href="/project/index.php/Backenddisplay/Product/index">产品管理</a>
                    </li>
                    <li>
                        <i class="fa fa-angle-right"></i>
                        <small style="color:#888888">产品预览</small>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-shopping-cart"></i>产品预览
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3 col-md-push-0">
                                    <?php if(RuleCheck('Backenddisplay/Management/add',$_SESSION['uid'])): ?><div class="btn-group">
                                            <a class="btn red-intense" href="/project/index.php/Backenddisplay/Product/add"><i class="fa fa-plus"></i> 添加商品</a>
                                        </div><?php endif; ?>
                                </div>
                                <div class="col-md-8 col-md-push-2">
                                    <div class="row">
                                        <form action="/project/index.php/Backenddisplay/Product/index" method="get">
                                            <!--<div class="col-md-3 col-md-push-5">
                                                <select class="form-control" id="type" name="xx">
                                                    <option value="xm">姓名</option>
                                                    <option value="zh">帐号</option>
                                                    <option value="sj">手机号</option>
                                                    <option value="qx">权限组</option>
                                                </select>
                                            </div>-->
                                            <div class="col-md-8 col-md-push-2" >
                                                <!--<input type="hidden" name="type" value="1">-->
                                                <input type="text" name="sele" placeholder="请输入（商品名称）内容进行搜索" class="form-control" value="<?php echo ($sele); ?>">
                                            </div>
                                            <div class="col-md-1 col-md-push-1" style="margin-left:0px;">
                                                <input type="hidden" value="1" name="p">
                                                <input type="submit" value="搜索" class="btn btn-success"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover" style="margin-top:10px">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>商品名称</th>
                                    <th>商品货号</th>
                                    <th>商品图片</th>
                                    <th>商品价格</th>
                                    <th>库存</th>
                                    <th>商品状态</th>
                                    <th>创建时间</th>
                                    <th>操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($res)): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                        <td><?php echo ($vo["id"]); ?></td>
                                        <td><?php echo ($vo["goods_name"]); ?></td>
                                        <td><?php echo ($vo["goods_no"]); ?></td>
                                        <td width="160"><img src="/project/Public/<?php echo ($vo["thumb_img"]); ?>" width="150" height="50"></td>
                                        <td><?php echo ($vo["price"]); ?></td>
                                        <td><?php echo ($vo["store_nums"]); ?></td>
                                        <td>
                                            <?php if(RuleCheck('Backenddisplay/Product/statusGoods',$_SESSION['uid'])): if($vo["status"] == 0): ?><a href="/project/index.php/Backenddisplay/Product/statusGoods/id/<?php echo ($vo["id"]); ?>/type/1/p/<?php echo ($page); ?>/sele/<?php echo ($sele); ?>" class="btn  btn-xs">【已下架】</a>
                                                    <?php elseif($vo["status"] == 1): ?>
                                                    <a href="/project/index.php/Backenddisplay/Product/statusGoods/id/<?php echo ($vo["id"]); ?>/type/0/p/<?php echo ($page); ?>/sele/<?php echo ($sele); ?>" class="btn btn-danger btn-xs">【以上架】</a><?php endif; endif; ?>
                                        </td>
                                        <td><?php echo ($vo["create_time"]); ?></td>
                                        <td>
                                            <?php if(RuleCheck('Backenddisplay/Product/edit',$_SESSION['uid'])): ?><a href="/project/index.php/Backenddisplay/Product/edit/id/<?php echo ($vo["id"]); ?>/p/<?php echo ($page); ?>/sele/<?php echo ($sele); ?>" >修改</a> |<?php endif; ?>
                                            <?php if(RuleCheck('Backenddisplay/Product/delAction',$_SESSION['uid'])): ?><a href="javascript:del(<?php echo ($vo["id"]); ?>,<?php echo ($page); ?>,'<?php echo ($sele); ?>');">删除 </a><?php endif; ?>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
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

<script src="/project/Public/assets/global/plugins/respond.min.js"></script>
<script src="/project/Public/assets/global/plugins/excanvas.min.js"></script>
<!--[endif]-->
<script src="/project/Public/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/project/Public/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

<!--
<script type="text/javascript" src="/project/Public/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
-->

<script src="/project/Public/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/pages/scripts/table-advanced.js"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        TableAdvanced.init();
        Layout.setSidebarMenuActiveLink('set', $('#product'));
    });

    function del(id,p,sele){
        if(sele==undefined){
            sele = '';
        }
        if(confirm("确定要删除该条数据吗？")){
            //跳转网页,并携带参数
            window.location="/project/index.php/Backenddisplay/Product/delAction/id/"+id+"/p/"+p+"/sele/"+sele;
        }
    }
</script>
</body>
</html>