<!doctype html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>扫码统计</title>
    <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.3/weui.min.css"/>
    <style type="text/css">
        body{
            background-color: #f8f8f8;
        }
        .page__hd{
            padding: 40px;
        }
        .page__bd{
            padding: 0 15px;
        }
    </style>
</head>
<body>
<div>
    <div class="page__hd">
        <h1 class="page__title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">扫码统计</font></font></h1>
        <p class="page__desc"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">可领取: {{ $scanUser->scan_number }}个</font></font></p>
        <p class="page__desc"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">共扫码: {{ $scanUser->scan_total }}次</font></font></p>
        <p class="page__desc"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已领取: {{ $scanUser->scan_total - $scanUser->scan_number }}个</font></font></p>
    </div>
    <div class="page__bd">
        @if($scanUser->scan_number != 0)
            <a href="javascript:showDialog();" class="weui-btn weui-btn_primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">当面领取</font></font></a>
        @else
            <a href="javascript:;" class="weui-btn weui-btn_primary weui-btn_disabled"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">当面领取</font></font></a>
        @endif
    </div>
</div>
<div id="dialog" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">确认领取</strong></div>
        <div class="weui-dialog__bd">此页面应由工作人员操作, 私自点击后概不负责.</div>
        <div class="weui-dialog__ft">
            <a href="javascript:send();" class="weui-dialog__btn weui-dialog__btn_default">领取</a>
            <a href="javascript:hiddenDialog();" class="weui-dialog__btn weui-dialog__btn_primary">取消</a>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    // 显示弹窗
    function showDialog() {
        document.getElementById('dialog').style.display = 'block';
    }

    // 隐藏弹窗
    function hiddenDialog() {
        document.getElementById('dialog').style.display = 'none';
    }

    // 领取操作, 跳转页面
    function send() {
        window.location.href = '/send?number={{ $scanUser->scan_number }}&total={{ $scanUser->scan_total }}&code={{ $sendCode->id }}'
    }
</script>
</html>
