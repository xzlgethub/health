<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hello MUI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/project/Public/mui/css/mui.min.css">
</head>

<body class="mui-fullscreen">
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <div class="mui-input-row mui-search" style="width:260px;margin:0 50px;position: absolute;">
        <input type="search" class="mui-input-clear" id="searchInput" onkeyup="enterSearch(event)" placeholder="找不到问题？点我搜索">
    </div>
</header>
<div class="mui-content" style="">
    <h1 class="mui-title"><?php echo ($res["title"]); ?></h1>
    <p class="mui-content" style="margin-top: 100px"><?php echo ($res["content"]); ?></p>
</div>


</body>
<script src="/project/Public/mui/js/mui.min.js "></script>
<script>
    mui.init();
    function enterSearch(e) {
        if(e.keyCode == 13) {
            var search = mui('#searchInput')[0].value
            mui.openWindow({
                id: 'index',
                url: '/project/index.php/App/Faq/index?search='+search,
            })
        }
    }
</script>

</html>