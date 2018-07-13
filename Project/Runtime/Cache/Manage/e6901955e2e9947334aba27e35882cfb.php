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
        .note-editor.fullscreen{
            top:45px;
        }
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
            </ul>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar" style="margin-bottom:20px;margin-top:-10px;">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/project/index.php/Manage/Rule/RuleGroup">权限管理</a>
                    </li>
                    <li>
                        <i class="fa fa-angle-right"></i>
                        <small style="color:#888888">权限组修改</small>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>权限组修改
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form-horizontal" action="/project/index.php/Manage/Rule/editAGaction" method="post">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">权限组名称</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="title" value="<?php echo ($res['title']); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">首页</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a1)): foreach($a1 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">用户管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a2)): foreach($a2 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">管理员管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a3)): foreach($a3 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">权限管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a4)): foreach($a4 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">产品管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a5)): foreach($a5 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">logo管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a6)): foreach($a6 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">版权管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a7)): foreach($a7 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">常见问题管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a8)): foreach($a8 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">关于我们管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a9)): foreach($a9 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">意见反馈管理</label>
                                        <div class="col-md-8">
                                            <div class="md-checkbox-inline">
                                                <?php if(is_array($a10)): foreach($a10 as $key=>$vo): ?><div class="md-checkbox" style="margin-right: 40px; margin-top: 4px;">
                                                        <?php if($vo['show'] == 'yes'): ?><input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>" checked="true" />
                                                            <?php else: ?>
                                                            <input type="checkbox" name="rules[]" class="md-check" value="<?php echo ($vo['id']); ?>"/><?php endif; ?>
                                                        <label for="checkbox6">
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            <?php echo ($vo['title']); ?>
                                                        </label>
                                                    </div><?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>


                                    <!--<?php if(is_array($ares)): foreach($ares as $key=>$vo): ?>-->
                                        <!--<?php if(in_array($vo['id'],$res['rules'])){?>-->
                                        <!--<input type="checkbox" name="rules[]" class="md-check" value="<?php echo $vo['id']?>" checked="checked" />-->
                                        <!--<?php }else{?>-->
                                        <!--<input type="checkbox" name="rules[]" class="md-check" value="<?php echo $vo['id']?>"  />-->
                                        <!--<?php }?>-->
                                        <!--[<?php echo ($vo["title"]); ?>]-->
                                    <!--<?php endforeach; endif; ?>-->
                                    <!--<br/>-->
                                    <!--<a href="#" class="check" id="qx">全选</a>-->
                                    <!--<a href="#" class="check" id="qbx">全不选</a>-->
                                    <!--<a href="#" >反选</a>-->
                                    <div class="form-group" style="margin-top:10px">
                                        <label class="control-label col-md-3">状态</label>
                                        <div class="col-md-8">
                                            <div class="btn-group">
                                                <select name="status" id="">
                                                    <option value="1" <?php if($res['status'] == 1 ): ?>selected<?php endif; ?>>开启</option>
                                                    <option value="0" <?php if($res['status'] == 0 ): ?>selected<?php endif; ?>>关闭</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <div class="col-md-4 col-md-offset-1"></div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="id" value="<?php echo ($res['id']); ?>">
                                            <input type="hidden" name="p" value="<?php echo ($p); ?>">
                                            <input type="hidden" name="sele" value="<?php echo ($sele); ?>">
                                            <input type="submit" value="提交" class="btn btn-success" style='width:100px;'/>
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
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
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
<!--<script src="/project/Public/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>-->
<!--<script src="/project/Public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>-->
<!--<script src="/project/Public/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>-->
<!--<script src="/project/Public/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>-->
<!--<script src="/project/Public/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>-->
<!--<script src="/project/Public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->

<!-- summernote editer -->
<script src="/project/Public/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="/project/Public/assets/global/plugins/bootstrap-summernote/lang/summernote-zh-CN.js" type="text/javascript"></script>

<script type="text/javascript" src="/project/Public/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<!--<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>-->
<!--<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>-->
<!--<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>-->
<!--<script type="text/javascript" src="/project/Public/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>-->


<!--开始页面级别的脚本-->
<script src="/project/Public/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="/project/Public/assets/admin/pages/scripts/table-editable.js"></script>
<script src="/project/Public/assets/admin/pages/scripts/components-editors.js"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic核心组件
        Layout.init(); //初始化当前布局
        Demo.init(); // init演示功能
        TableEditable.init();
        ComponentsEditors.init();
        Layout.setSidebarMenuActiveLink('set', $('#RuleGroup'));
    });
</script>
<script type="text/javascript">

    // 启用、关闭
    $('button[name=putaway]').click(function(){
        $(this).removeClass('btn-default').addClass('btn-info').siblings().removeClass('btn-info').addClass('btn-default');
        var btn_putaway = $(this).attr('class');
        if(btn_putaway=='btn btn-info'){
            // 获取当前的status状态
            var status_putaway = $(this).attr('status');
            // 设置到隐藏input中
            $(this).parent().find('input[name=status]').attr('value',status_putaway);
        }
    })

    // checkbox
    $(".md-checkbox").click(function(){
        var check = $(this).find('input').attr('checked');
        if(typeof(check) == 'undefined') {
            $(this).find('input').attr('checked','true');
        }else{
            $(this).find('input').removeAttr('checked');
        }
    })
</script>
</body>
<!-- END BODY -->
</html>