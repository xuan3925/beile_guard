/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
    
  function hengshuping() {
    if (window.orientation == 180 || window.orientation == 0) {
        $('body').removeClass('jm-body-landscape');
    }
    if (window.orientation == 90 || window.orientation == -90) {
        $('body').addClass('jm-body-landscape');
    }
  }
  window.addEventListener(
    "onorientationchange" in window ? "orientationchange" : "resize",
    hengshuping,
    false
  );

  window.addEventListener("pageshow", function(e) {
    // 通过persisted属性判断是否存在 BF Cache
    if (e.persisted) {
      $("audio")[0].pause();
      location.reload();
    }
  });

  //    var deviceH = document.documentElement.clientHeight + "px";
  //    $("body").css({height: deviceH,backgroundSize: "100% "+deviceH});
  //    $('select,input').on("click", function () {
  //        $("body").css({backgroundSize: "100% "+deviceH});
  //    });
  //播放背景音乐相关
  var bgAudio = $("audio")[0];
  var stopAudio = sessionStorage.getItem("bl_music_paused");
  if (stopAudio != "true") {
    bgAudio.play();
    $("#music").addClass("rotation");
  }

  $("#music").on("click", function() {
    if (bgAudio.paused) {
      bgAudio.play();
      $("#music").addClass("rotation");
      sessionStorage.setItem("bl_music_paused", false);
    } else {
      bgAudio.currentTime = 0;
      bgAudio.pause();
      $("#music").removeClass("rotation");
      sessionStorage.setItem("bl_music_paused", true);
    }
  });

  $("input[readonly]").on("click", function() {
    $(this).blur();
  });

  // 勋章相关
  $(".jm-medal").on("click", function() {
    var _url = $(this)
      .find("img")
      .attr("src");
    $(".jm-layer")
      .find(".jm-layer-medal img")
      .attr("src", _url);
    $(".jm-layer")
      .find("p")
      .html($(this).data("text"));
    $(".jm-layer").removeClass("hidden");
  });

  $(".jm-layer-close").on("click", function() {
    $(".jm-layer").addClass("hidden");
  });

  var u = navigator.userAgent;
  var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);

  $(".jm-video:not(.jm-video-empty)").click(function() {
    var this_src = $(this).data("video");
    if (!this_src) return false;

    autoPlayMusic(false);
    //        var this_src = "https://guardcdn.beilezx.com/upload/2018/3/14/1521018147473_mipbi.mp4";
    var div = document.createElement("div");
    var video = document.createElement("video");
    div.className = "jm-video-layer";
    div.appendChild(video);
    video.src = this_src;
    $("body").append(div);
    video.play();
    if (isiOS) {
      video.controls = true;
    } else {
      $("video").attr("x-webkit-airplay", "true");
      $("video").attr("airplay", "allow");
      $("video").attr("webkit-playsinlin", "true");
      $("video").attr("x5-video-player-type", "h5");
      $("video").attr("x5-video-player-fullscreen", "true");
      $("video").attr("playsinline", "");
    }
    video.addEventListener("pause", function() {
      autoPlayMusic(true);
      div.parentNode.removeChild(div);
    });
    video.addEventListener("end", function() {
      autoPlayMusic(true);
      div.parentNode.removeChild(div);
    });
  });
});

function autoPlayMusic(play) {
  if ($("audio").length > 0) {
    var bgAudio = $("audio")[0];
    var stopAudio = sessionStorage.getItem("bl_music_paused");
    if (stopAudio != "true" && play) {
      bgAudio.play();
      $("#music").addClass("rotation");
    } else {
      bgAudio.pause();
      $("#music").removeClass("rotation");
    }
  }
}

function checkPhone(val) {
  var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
  return val.length == 11 && mobile.test(val);
}

function jmConfirm(msg, opt) {
  weui.confirm(msg, opt);
}

function jmAlert(msg, opt, countDown) {
  if (opt == undefined) {
    weui.alert(msg);
  } else {
    weui.alert(msg, { title: opt.title }, opt.action);
  }
  if (countDown) {
    countDown();
  }
}

function jmMsg(msg, dur) {
  weui.toast(msg, {
    duration: dur || 2000,
    className: "jm-weui-dialog"
  });
}

function activity_stop()
{
  jmAlert('活动已结束');
}

var _count_down;
var loading_ajax;
var isLoading = false;

function countDown(s, update, end) {
  _count_down = setInterval(function() {
    if (s <= 1) {
      clearInterval(_count_down);
      end();
    } else {
      s--;
      update(s);
    }
  }, 1000);
}

function formatTime(s) {
  var _m = Math.floor(s / 60);
  var _s = s % 60;
  return (_m < 10 ? "0" + _m : _m) + ":" + (_s < 10 ? "0" + _s : _s);
}

function jmAjax(_opt) {
  if (isLoading) {
    return;
  } else {
    isLoading = true;
    var opt = $.extend(true, {}, { loading: true }, _opt);
    $.ajax({
      url: opt.url,
      type: opt.type || "GET",
      dataType: "json",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: opt.data || {},
      beforeSend: function() {
        if (opt.loading) {
          loading_ajax = weui.loading("数据加载中", {
            className: "jm-weui-dialog"
          });
        }
      },
      complete: function() {
        isLoading = false;
        if (opt.loading) {
          loading_ajax.hide();
        }
      },
      success: function(data) {
        opt.success(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if (opt.error) {
          opt.error(jqXHR, textStatus, errorThrown);
        } else {
          var http_status = jqXHR.status;
          if (http_status != "422") {
            if (opt.alert) jmAlert("服务器异常");
            else jmMsg("服务器异常");
            return false;
          }

          var response = JSON.parse(jqXHR.response);
          for (var i in response.errors) {
            if (opt.alert) jmAlert(response.errors[i]["0"]);
            else jmMsg(response.errors[i]["0"]);

            break;
          }
        }
      }
    });
  }
}
