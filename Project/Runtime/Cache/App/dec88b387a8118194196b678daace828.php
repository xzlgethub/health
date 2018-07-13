<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hello MUI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/health/Public/mui/css/mui.min.css">
</head>

<body class="mui-fullscreen">
<header class="mui-bar mui-bar-nav">
    <div class="mui-input-row mui-search">
        <input type="search" class="mui-input-clear" id="searchInput" onkeyup="enterSearch(event)" placeholder="找不到问题？点我搜索" value="<?php echo ($search); ?>">
    </div>
</header>
<div class="mui-content" style="margin-top: -15px">
    <?php if(is_array($res)): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="mui-table-view">
            <li class="mui-table-view-cell mui-collapse">
                <a class="mui-navigate-right" href="#"><?php echo ($vo["title"]); ?></a>
                <div class="mui-collapse-content">
                    <p><?php echo ($vo["content"]); ?><!--[<a href="#" class="info" id="<?php echo ($vo["id"]); ?>">详情</a>]--></p>
                </div>
            </li>
        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
</div>


</body>
<script src="/health/Public/mui/js/mui.min.js "></script>
<script>
    mui.init();
    function enterSearch(e) {
        if(e.keyCode == 13) {
            var search = mui('#searchInput')[0].value

            mui.openWindow({
                id: 'index',
                url: '/health/index.php/App/Invite/index?search='+search,
                extras: {
                    search: search
                }
            })
        }
    }
    mui('.mui-collapse-content').on('tap','.info',function () {
        var search = mui('#searchInput')[0].value
        var id = mui(this)[0].id;
        console.log(id);
        mui.openWindow({
            url:'/health/index.php/App/Invite/info?id='+id,
            id:'info.html',
            extras: {
                search: search
            }
        })
    })
</script>

</html>