// Lazy Load
$(document).ready(function () {
  "use strict";

  $(".lazy").Lazy({
    scrollDirection: "vertical",
    effect: "fadeIn",
    visibleOnly: true,
    onError: function (element) {
      console.log("error loading " + element.data("src"));
    },
  });
});

/*
 * Bootstrap Cookie Alert by Wruczek
 * https://github.com/Wruczek/Bootstrap-Cookie-Alert
 * Released under MIT license
 */
(function () {
    "use strict";

    var cookieAlert = document.querySelector(".cookiealert");
    var acceptCookies = document.querySelector(".acceptcookies");

    if (!cookieAlert) {
       return;
    }

    cookieAlert.offsetHeight; // Force browser to trigger reflow (https://stackoverflow.com/a/39451131)

    // Show the alert if we cant find the "acceptCookies" cookie
    if (!getCookie("acceptCookies")) {
        cookieAlert.classList.add("show");
    }

    // When clicking on the agree button, create a 1 year
    // cookie to remember user's choice and close the banner
    acceptCookies.addEventListener("click", function () {
        setCookie("acceptCookies", true, 365);
        cookieAlert.classList.remove("show");
    });

    // Cookie functions from w3schools
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
})();

// m3u8 Player Function
if (document.getElementById("hls-example")) {
  var player = videojs("hls-example");
  function getVolCookie() {
    var name = "Radio_Volume";
    var v = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
    return v ? v[2] : null;
  }

  player.volume(getVolCookie());
  player.play();

  $(function () {
    var myPlayer = videojs("#hls-example");
    var play_time = 0;
    var salise_counter = 0;
    var timerInterval;

    function format(s) {
      var m = Math.floor(s / 60);
      m = m >= 10 ? m : "0" + m;
      s = s % 60;
      s = s >= 10 ? s : "0" + s;
      return m + ":" + s;
    }

    function updateCurrentTime() {
      $(".jp-current-time").html(format(play_time));
    }

    function startTimer() {
      timerInterval = setInterval(function () {
        salise_counter += 1;
        if (salise_counter >= 100) {
          play_time++;
          salise_counter = 0;
          updateCurrentTime();
        }
      }, 10);
    }

    function stopTimer() {
      clearInterval(timerInterval);
    }

    $(".m3-play, .m3-pause").on("click", function () {
      if (myPlayer.paused()) {
        myPlayer.play();
        $(".m3-play").hide();
        $(".m3-pause").show();
        startTimer();
      } else {
        myPlayer.pause();
        $(".m3-pause").hide();
        $(".m3-play").show();
        stopTimer();
      }
    });

    $(".jp-mute, .jp-unmute").on("click", function () {
      var myPlayer = videojs("#hls-example");
      if (myPlayer.muted()) {
        myPlayer.muted(false);
      } else {
        myPlayer.muted(true);
      }
    });

    $("#volume-bar").click(function () {
      setTimeout(function () {
        myPlayer.volume(getVolCookie());
      }, 10);
    });
  });
}

if (document.getElementById("player")) {
    var player_data = document.getElementById('player');
    var player_thumbnail = player_data.getAttribute('data-thumb');
    var player_slug = player_data.getAttribute('data-slug');
    var cookie_prefix = player_data.getAttribute('data-cookie-prefix');

    var listen_history = Cookies.get(cookie_prefix + '_history');
    var listen_data = '|' + player_slug + ',' + player_thumbnail;

    if (listen_history == undefined) {
        Cookies.set(cookie_prefix + '_history', listen_data, {
            expires: 365
        });
        listen_history = listen_data;
    }

    if (listen_history.indexOf(listen_data) === -1) {
        Cookies.set(cookie_prefix + '_history', listen_history + listen_data, {
            expires: 365
        });
    }

    var listen_history_last = Cookies.get(cookie_prefix + '_history');

    if (listen_history_last.indexOf(listen_data) != -1) {

        var listen_historyy = listen_history_last.replace(listen_data, '');

        Cookies.set(cookie_prefix + '_history', listen_historyy + listen_data, {
            expires: 365
        });

    }

    var cookie_prefix = player_data.getAttribute('data-cookie-prefix');
    var favorite_history = Cookies.get(cookie_prefix + '_favorites');
    var favorite_data = '|' + player_slug + ',' + player_thumbnail;
    if (favorite_history != undefined && favorite_history.indexOf(favorite_data) != -1) {
        $('#heart').css('fill', '#df1850');
        $('#heart').data('checked', '1');
    }

}

// Select Picker
if (window.location.href.indexOf("/submit-radio") > -1) {
$.fn.selectpicker.Constructor.BootstrapVersion = '4';
$('select').selectpicker();
}