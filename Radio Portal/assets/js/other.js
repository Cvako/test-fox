// Search Links
$(document).on("keydown", "#search-form", function (e) {
  var id = this.id;
  var search_url = "/" + "json-search";

  $("#" + id).autocomplete({
    source: function (request, response) {
      $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: search_url,
        type: "post",
        dataType: "json",
        data: {
          search: request.term,
          request: 1,
        },
        success: function (data) {
          response(data);
        },
      });
    },
    select: function (event, ui) {
      window.location.href = ui.item.url;
      return false;
    },
    open: function () {
      $("ul.ui-menu").width($(this).innerWidth());
    },
    create: function (event, ui) {
      $(this).data("ui-autocomplete")._renderItem = function (ul, item) {
        var rich_html =
          '<div class="d-flex flex-row"><div><img src=\'' +
          item.image +
          '\' class="station-icon rounded" /></div><div class="my-auto"><strong>' +
          item.title +
          "</strong>" +
          "</span></div></div>";
        return $("<li></li>")
          .data("item.autocomplete", item)
          .append(rich_html)
          .appendTo(ul);
      };
    },
  });
});

// Social media share
function sm_share(url, title, w, h) {
  "use strict";

  var dualScreenLeft =
    window.screenLeft != undefined ? window.screenLeft : screen.left;
  var dualScreenTop =
    window.screenTop != undefined ? window.screenTop : screen.top;

  var width = window.innerWidth
    ? window.innerWidth
    : document.documentElement.clientWidth
    ? document.documentElement.clientWidth
    : screen.width;
  var height = window.innerHeight
    ? window.innerHeight
    : document.documentElement.clientHeight
    ? document.documentElement.clientHeight
    : screen.height;

  var left = width / 2 - w / 2 + dualScreenLeft;
  var top = height / 2 - h / 2 + dualScreenTop;
  var newWindow = window.open(
    url,
    title,
    "scrollbars=yes, width=" +
      w +
      ", height=" +
      h +
      ", top=" +
      top +
      ", left=" +
      left
  );

  if (window.focus) {
    newWindow.focus();
  }
}

$(document).ready(function () {
  $(".rate_station").click(function () {
    var station_id = $(this).attr("data-id");
    var rate_action = $(this).attr("data-action");

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: "/vote",
      type: "post",
      dataType: "json",
      data: {
        station_id: station_id,
        direction: rate_action,
      },
      success: function (response) {
        if (response.success == true) {
          var notify = new notificationManager({
            container: $("#notificationsContainer"),
          });

          var anim = true;
          var auto = true;

          notify.setPosition("topright");

          notify.addNotification({
            message: "You have voted successfully.",
            animate: anim,
            autoRemove: auto,
            backgroundColor: "#92c66c",
            progressColor: "#fff",
          });

          ajaxCallBack(response.vote);
        } else {
          var notify = new notificationManager({
            container: $("#notificationsContainer"),
          });

          var anim = true;
          var auto = true;

          notify.setPosition("topright");

          notify.addNotification({
            message: "You have already voted from this IP address.",
            animate: anim,
            autoRemove: auto,
            backgroundColor: "#FFC300",
            progressColor: "#fff",
          });
        }
      },
    });

    function ajaxCallBack(retString) {
      thevalue_d = retString;
      $('[data-id="' + station_id + '"] [id="' + rate_action + '"]').text(
        thevalue_d
      );
    }
  });
});

$(document).ready(function () {
  $(".favorites").click(function () {
    var check_status = $("#heart").data("checked");

    if (check_status == "1") {
      $("#heart").css("fill", "rgba(223, 24, 80, 0.35)");
      $("#heart").data("checked", "0");

      var player_data = document.getElementById("player");
      var player_thumbnail = player_data.getAttribute("data-thumb");
      var player_slug = player_data.getAttribute("data-slug");
      var cookie_prefix = player_data.getAttribute("data-cookie-prefix");

      var listen_history_last = Cookies.get(cookie_prefix + "_favorites");

      var listen_history = Cookies.get(cookie_prefix + "_favorites");
      var listen_data = "|" + player_slug + "," + player_thumbnail;
      var listen_historyy = listen_history_last.replace(listen_data, "");

      Cookies.set(cookie_prefix + "_favorites", listen_historyy, {
        expires: 365,
      });

      var notify = new notificationManager({
        container: $("#notificationsContainer"),
      });

      var anim = true;
      var auto = true;

      notify.setPosition("topright");

      notify.addNotification({
        message: "The station has been removed from favourites.",
        animate: anim,
        autoRemove: auto,
        backgroundColor: "#92c66c",
        progressColor: "#ffffff",
      });
    }

    if (check_status == "0") {
      var player_data = document.getElementById("player");
      var player_thumbnail = player_data.getAttribute("data-thumb");
      var player_slug = player_data.getAttribute("data-slug");
      var cookie_prefix = player_data.getAttribute("data-cookie-prefix");

      var favorite_history = Cookies.get(cookie_prefix + "_favorites");
      var favorite_data = "|" + player_slug + "," + player_thumbnail;

      if (favorite_history == undefined) {
        Cookies.set(cookie_prefix + "_favorites", favorite_data, {
          expires: 365,
        });
        favorite_history = favorite_data;
      }

      if (favorite_history.indexOf(favorite_data) === -1) {
        Cookies.set(
          cookie_prefix + "_favorites",
          favorite_history + favorite_data,
          {
            expires: 365,
          }
        );
      }

      var favorite_history_last = Cookies.get(cookie_prefix + "_favorites");

      if (favorite_history_last.indexOf(favorite_data) != -1) {
        var favorite_historyy = favorite_history_last.replace(
          favorite_data,
          ""
        );

        Cookies.set(
          cookie_prefix + "_favorites",
          favorite_historyy + favorite_data,
          {
            expires: 365,
          }
        );
      }

      $("#heart").css("fill", "#df1850");
      $("#heart").data("checked", "1");

      var notify = new notificationManager({
        container: $("#notificationsContainer"),
      });

      var anim = true;
      var auto = true;

      notify.setPosition("topright");

      notify.addNotification({
        message: "The station has been added to favourites.",
        animate: anim,
        autoRemove: auto,
        backgroundColor: "#92c66c",
        progressColor: "#ffffff",
      });
    }
  });
});

jQuery(document).ready(function ($) {
  if (document.getElementById("player")) {
    if ("mediaSession" in navigator) {
      var player_data = document.getElementById("player");
      var player_thumbnail_url = player_data.getAttribute("data-thumb-url");
      var player_title = player_data.getAttribute("data-title");
      var player_stream_url = player_data.getAttribute("data-stream-url");
      var player_site_title = player_data.getAttribute("data-site-title");

      navigator.mediaSession.metadata = new MediaMetadata({
        title: player_site_title,
        artist: player_title,
        artwork: [
          {
            src: player_thumbnail_url,
            sizes: "256x256",
            type: "image/png",
          },
        ],
      });

      navigator.mediaSession.setActionHandler("play", function () {
        $("#jplayer").jPlayer("play");
      });
      navigator.mediaSession.setActionHandler("pause", function () {
        $("#jplayer").jPlayer("pause");
      });
    }
    var stream = {
        mp3: player_stream_url,
      },
      StopStream = "";
    ready = false;
    $("#jplayer").jPlayer({
      ready: function (event) {
        $(this).jPlayer("setMedia", stream).jPlayer("play");
        //  $(this).jPlayer("setMedia", stream).jPlayer("stop");
        navigator.mediaSession.playbackState = "playing";
        if (
          $.jPlayer.platform.android &&
          event.jPlayer.status.waitForPlay == true
        ) {
          document.getElementById("jp_container_1").className =
            "jp-audio jp-state-seeking";
        }
      },
      pause: function () {
        if (
          $.jPlayer.platform.iphone ||
          $.jPlayer.platform.ipad ||
          $.jPlayer.platform.ipod
        ) {
          $("#jplayer").jPlayer("setMedia", stream);
        } else {
          $(this).jPlayer("pause");
          navigator.mediaSession.playbackState = "paused";
          StopStream = setTimeout(closeSocket, 30000);
        }
      },
      play: function () {
        clearTimeout(StopStream);
      },
      volumechange: function (event) {
        var myVol = event.jPlayer.options.volume,
          myMuted = event.jPlayer.options.muted;
        if (myMuted == true) {
          myVol = 0;
        }
        setVolCookie(myVol);
      },
      supplied: "mp3, m4a",
      preload: "none",
      wmode: "window",
      useStateClassSkin: true,
      volume: 0.8,
    });
    var vol = getVolCookie();
    if (vol) {
      if (vol == 0) {
        $("#jplayer").jPlayer("mute");
      } else {
        $("#jplayer").jPlayer("volume", vol);
      }
    }

    function closeSocket() {
      $("#jplayer").jPlayer("setMedia", stream);
    }

    function setVolCookie(value) {
      var expires = "";
      var name = "Radio_Volume";
      var date = new Date();
      date.setDate(date.getDate() + 30);
      expires = "; expires=" + date.toUTCString();
      document.cookie =
        name + "=" + parseFloat(value).toFixed(2) + expires + "; path=/";
    }

    function getVolCookie() {
      var name = "Radio_Volume";
      var v = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
      return v ? v[2] : null;
    }
  }
});

// Report Submission Form Control
function report_submission_form() {
  "use strict";

  var email = $.trim($("#email").val());
  var reason = $.trim($("#reason").val());

  report_submission_send();
}

// Report Submission
function report_submission_send() {
  "use strict";

  var frm = $("#report-submission-form");
  var formData = new FormData(frm[0]);

  try {
    var recaptcha = grecaptcha.getResponse(0);
    formData.append("recaptcha", recaptcha);
  } catch (e) {}

  var submission_data = document.getElementById("report-submission-section");
  var data_error = submission_data.getAttribute("data-error");
  var station_id = submission_data.getAttribute("data-station-id");

  formData.append("station_id", station_id);

  var data_recaptcha_error = submission_data.getAttribute(
    "data-recaptcha-error"
  );

  const recaptcha_errors = [
    "missing-input-secret",
    "invalid-input-secret",
    "missing-input-response",
    "invalid-input-response",
    "bad-request",
    "timeout-or-duplicate",
  ];

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    type: "POST",
    url: "../report",
    data: formData,
    processData: false,
    contentType: false,
    success: function (msg) {
      $("#report-submission-form")[0].reset();
      $(".g-recaptcha").remove();
      $("#report-submission-section :input").prop("disabled", true);
      $("#report-submission-result").html(msg);
    },
    error: function (xhr) {
      $.each(xhr.responseJSON.errors, function (key, value) {
        if (recaptcha_errors.indexOf(value) > -1) {
          grecaptcha.reset();
          $("#report-submission-result").html(
            '<div class="alert alert-danger mt-3 show" role="alert"><b>' +
              data_error +
              ":</b> " +
              data_recaptcha_error +
              "</div"
          );
          return false;
        }

        $("#report-submission-result").html(
          '<div class="alert alert-danger mt-3 show" role="alert"><b>' +
            data_error +
            ":</b> " +
            value +
            "</div"
        );
        return false;
      });
    },
  });
}

// Contact Form Control
function contact_form() {
  "use strict";

  var name = $.trim($("#name").val());
  var email = $.trim($("#email").val());
  var subject = $.trim($("#subject").val());
  var message = $.trim($("#message").val());

  contact_form_send();
}

// Contact Form Submission
function contact_form_send() {
  "use strict";

  var frm = $("#contact-form");
  var formData = new FormData(frm[0]);
  try {
    var recaptcha = grecaptcha.getResponse();
    formData.append("recaptcha", recaptcha);
  } catch (e) {}

  var submission_data = document.getElementById("contact-form-section");
  var data_error = submission_data.getAttribute("data-error");
  var data_recaptcha_error = submission_data.getAttribute(
    "data-recaptcha-error"
  );

  const recaptcha_errors = [
    "missing-input-secret",
    "invalid-input-secret",
    "missing-input-response",
    "invalid-input-response",
    "bad-request",
    "timeout-or-duplicate",
  ];

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    type: "POST",
    url: "contact-form",
    data: formData,
    processData: false,
    contentType: false,
    success: function (msg) {
      $("#contact-form")[0].reset();
      $(".g-recaptcha").remove();
      $("#contact-form-section :input").prop("disabled", true);
      $("#contact-form-result").html(msg);
    },
    error: function (xhr) {
      $.each(xhr.responseJSON.errors, function (key, value) {
        if (recaptcha_errors.indexOf(value) > -1) {
          grecaptcha.reset();
          $("#contact-form-result").html(
            '<div class="alert alert-danger show" role="alert"><b>' +
              data_error +
              ":</b> " +
              data_recaptcha_error +
              "</div"
          );
          return false;
        }

        $("#contact-form-result").html(
          '<div class="alert alert-danger show" role="alert"><b>' +
            data_error +
            ":</b> " +
            value +
            "</div"
        );
        return false;
      });
    },
  });
}

// Comment Form Submission
function comment_form_send() {
  "use strict";

  var frm = $("#comment-form");
  var formData = new FormData(frm[0]);
  try {
    var recaptcha = grecaptcha.getResponse(1);
    formData.append("recaptcha", recaptcha);
  } catch (e) {}

  var submission_data = document.getElementById("comment-section");
  var data_error = submission_data.getAttribute("data-error");
  var data_recaptcha_error = submission_data.getAttribute(
    "data-recaptcha-error"
  );

  const recaptcha_errors = [
    "missing-input-secret",
    "invalid-input-secret",
    "missing-input-response",
    "invalid-input-response",
    "bad-request",
    "timeout-or-duplicate",
  ];

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    type: "POST",
    url: "/comment",
    data: formData,
    processData: false,
    contentType: false,
    success: function (msg) {
      $("#comment-form")[0].reset();
      $(".g-recaptcha").remove();
      $("#comment-section :input").prop("disabled", true);
      $("#comment_result").html(msg);
    },
    error: function (xhr) {
      $.each(xhr.responseJSON.errors, function (key, value) {
        if (recaptcha_errors.indexOf(value) > -1) {
          grecaptcha.reset();
          $("#comment_result").html(
            '<div class="alert alert-danger show my-2" role="alert"><b>' +
              data_error +
              ":</b> " +
              data_recaptcha_error +
              "</div"
          );
          return false;
        }

        $("#comment_result").html(
          '<div class="alert alert-danger show my-2" role="alert"><b>' +
            data_error +
            ":</b> " +
            value +
            "</div"
        );
        return false;
      });
    },
  });
}

// Submission Form Control
function submission_form_control() {
  "use strict";

  var name = $.trim($("#name").val());
  var email = $.trim($("#email").val());
  var title = $.trim($("#title").val());
  var description = $.trim($("#description").val());
  var category = $.trim($("#category").val());
  var platform = $.trim($("#platform").val());
  var developer = $.trim($("#developer").val());
  var url = $.trim($("#url").val());
  var license = $.trim($("#license").val());
  var file_size = $.trim($("#file-size").val());
  var version = $.trim($("#version").val());
  var detailed_description = $.trim($("#detailed-description").val());
  var image = $.trim($("#image").val());
  var submission_data = document.getElementById("submission-section");
  var fill_all_fields = submission_data.getAttribute("data-fill-all-fields");

    submission_send();

}

// Post Submission
function submission_send() {
  "use strict";

  var frm = $("#submission-form");
  var formData = new FormData(frm[0]);
  formData.append("image", $("input[type=file]")[0].files[0]);

  try {
    var recaptcha = grecaptcha.getResponse();
    formData.append("recaptcha", recaptcha);
  } catch (e) {}

  var submission_data = document.getElementById("submission-section");
  var data_error = submission_data.getAttribute("data-error");
  var data_recaptcha_error = submission_data.getAttribute(
    "data-recaptcha-error"
  );

  const recaptcha_errors = [
    "missing-input-secret",
    "invalid-input-secret",
    "missing-input-response",
    "invalid-input-response",
    "bad-request",
    "timeout-or-duplicate",
  ];

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    type: "POST",
    enctype: "multipart/form-data",
    url: "/submission",
    data: formData,
    processData: false,
    contentType: false,
    success: function (msg) {
      $("#submission-section :input").prop("disabled", true);
      $("#submission-result").html(msg);
      $("#submission-form")[0].reset();
      $(".g-recaptcha").remove();
    },
    error: function (xhr) {
      $.each(xhr.responseJSON.errors, function (key, value) {
        if (recaptcha_errors.indexOf(value) > -1) {
          grecaptcha.reset();
          $("#submission-result").html(
            '<div class="alert alert-danger mb-2 mt-2" role="alert"><b>' +
              data_error +
              ":</b> " +
              data_recaptcha_error +
              "</div"
          );
          return false;
        }

        $("#submission-result").html(
          '<div class="alert alert-danger mb-2 mt-2" role="alert"><b>' +
            data_error +
            ":</b> " +
            value +
            "</div"
        );
        return false;
      });
    },
  });
}