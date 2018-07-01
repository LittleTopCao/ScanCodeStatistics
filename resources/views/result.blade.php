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
        @if ($isSendSuccess)
            <h1 class="page__title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">领取成功</font></font></h1>
            <p class="page__desc"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已领取: {{ $number }}个, 请发放礼品.</font></font></p>
        @else
            <h1 class="page__title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">领取失败</font></font></h1>
            <p class="page__desc"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">领取失败, 请重新扫码并检查可领取个数.</font></font></p>
        @endif
    </div>
    <div class="page__bd">
        <a href="javascript:close();" class="weui-btn weui-btn_primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">确定</font></font></a>
    </div>
</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript"></script>
<script type="text/javascript">
    wx.config({!! app('wechat.official_account')->jssdk->buildConfig(array('closeWindow'), true) !!});
    // 关闭网页
    function close() {
        wx.closeWindow();
    }
</script>
</html>
