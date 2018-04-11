<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo app('wechat.official_account')->jssdk->buildConfig(['onMenuShareAppMessage', 'onMenuShareTimeline']); ?>);

    wx.ready(function () {

		var bgAudio = $('audio')[0];
		var stopAudio = sessionStorage.getItem('bl_music_paused');
		if (stopAudio != "true") {
			bgAudio.play();
			$('#music').addClass('rotation');
		}

    	var _Weixin = <?php 
    		echo json_encode([
				'link'  => false === Auth::check() ? route('index') : route('activities.ranking.show', ['id'=>Auth::user()->id]),
				'logo'  => resources_domain('images/share_img.png'),
				'title' => '贝乐学科英语，“守护地球大作战”活动！',
				'desc'  => '加入我们，守护我们共同的家园！',
			], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    	 ?>

    	// 分享给朋友
	    wx.onMenuShareAppMessage({
			title: _Weixin.title, // 分享标题
			desc: _Weixin.desc, // 分享描述
			link: _Weixin.link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: _Weixin.logo, // 分享图标
			type: 'link', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () {
				share_success()
			},
			cancel: function () {
				// 用户取消分享后执行的回调函数
			}
		});

	    // 分享到朋友圈
		wx.onMenuShareTimeline({
		    title: _Weixin.title, // 分享标题
		    link: _Weixin.link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		    imgUrl: _Weixin.logo, // 分享图标
		    success: function () {
			    share_success();
			},
			cancel: function () {
			    // 用户取消分享后执行的回调函数
		    }
		});

		function share_success()
		{
			@if (Auth::check())
			jmAjax({
                url: "{{ route('activities.share') }}",
                type: "POST",
                success: function (data) {
                    $("#activity-ranking").text(data.activity.ranking);
                    $("#activity-guardian-exp").text(data.activity.guardian_exp);
                }
            });
            @endif
		}
		
	});

</script>