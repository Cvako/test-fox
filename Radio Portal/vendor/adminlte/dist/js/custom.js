// Delete Prompt
$(document).ready(function() {
  "use strict";

  $("._delete_data").on('click', function(e) {
    var data_id = $(this).attr("data-id");
    var delete_data = document.getElementById("table");
    var delete_message_title = delete_data.getAttribute("data-delete-prompt-title");
    var delete_message_body = delete_data.getAttribute("data-delete-prompt-body");
    var delete_yes = delete_data.getAttribute("data-yes");
    var delete_cancel = delete_data.getAttribute("data-cancel");

    Swal.fire({
      title: delete_message_title,
      text: delete_message_body,
      type: "error",
      showCancelButton: true,
      confirmButtonText: delete_yes,
      cancelButtonText: delete_cancel
    }).then(result => {
      if (result.value) {
        $(document)
          .find("#delete_from_" + data_id)
          .submit();
      }
    });
  });
});
  
  // Sort Posts
$(function() {
  "use strict";

  $(".sortable-posts").sortable({
    stop: function() {
      var sort_type = $(this).attr("id");
      $.map($(this).find("tr"), function(el) {
        var id = el.id;
        var sort = $(el).index();
        var success_notification = 0;

        $.ajax({
          url: sort_type,
          type: "GET",
          data: {
            id: id,
            sort: sort
          },
          success: function(response) {
            if (response == "success") {
              
                var notify = new notificationManager({
                            container: $('#notificationsContainer')
                        });

                        var anim = true;
                        var auto = true;

                        notify.setPosition('topright');

                        notify.addNotification({
                            message: "Item has been sorted successfully.",
                            animate: anim,
                            autoRemove: auto,
                            backgroundColor: "#92c66c",
                            progressColor: "#fff"
                        });


            } else {

               var notify = new notificationManager({
                            container: $('#notificationsContainer')
                        });

                        var anim = true;
                        var auto = true;

                        notify.setPosition('topright');

                        notify.addNotification({
                            message: "An error occoured.",
                            animate: anim,
                            autoRemove: auto,
                            backgroundColor: "#ce2525",
                            progressColor: "#fff"
                        });


            }
          }
        });
        $(".sortable-posts").disableSelection();
      });
    }
  });
});


// Summernote - Text Editor
$(function() {
  "use strict";

  $(".textarea").summernote({ height: 250 });

  $('.textarea-style').on('summernote.change.codeview', function(we, contents, $editable) {
    $('.textarea-style').val(contents);
  });
});

  // Sort Posts
$(function() {
  "use strict";

  $(".sortable-items").sortable({
    stop: function() {
      var sort_type = $(this).attr("id");
      $.map($(this).find("tr"), function(el) {
        var id = el.id;
        var sort = $(el).index();
        var success_notification = 0;
        var sort_url = ""+ '/../../' + sort_type + "";
        $.ajax({
          url: + '../' + sort_url,
          type: "GET",
          data: {
            id: id,
            sort: sort
          },
          success: function(response) {
            if (response == "success") {
              
                var notify = new notificationManager({
                            container: $('#notificationsContainer')
                        });

                        var anim = true;
                        var auto = true;

                        notify.setPosition('topright');

                        notify.addNotification({
                            message: "Item has been sorted successfully.",
                            animate: anim,
                            autoRemove: auto,
                            backgroundColor: "#92c66c",
                            progressColor: "#fff"
                        });


            } else {

               var notify = new notificationManager({
                            container: $('#notificationsContainer')
                        });

                        var anim = true;
                        var auto = true;

                        notify.setPosition('topright');

                        notify.addNotification({
                            message: "An error occoured.",
                            animate: anim,
                            autoRemove: auto,
                            backgroundColor: "#ce2525",
                            progressColor: "#fff"
                        });


            }
          }
        });
        $(".sortable-items").disableSelection();
      });
    }
  });
});
  
  
  // Solve Problem Redirection
  $(document).on("click","._solve_data",function(e){ 
    var data_id = $(this).attr("data-id");
        $(document)
          .find("#solve_from_" + data_id)
          .submit();
      }
  );
  
    // Unsolve Problem Redirection
  $(document).on("click","._unsolve_data",function(e){ 
    var data_id = $(this).attr("data-id");
        $(document)
          .find("#unsolve_from_" + data_id)
          .submit();
      }
  );
  
  $(document).ready(function(){
  "use strict";

  $("#browse-image").change(function(){
    $('.custom-file').addClass('select-image');
  });
  
    $("#browse-logo").change(function(){
    $('.custom-file-logo').addClass('select-image');
  });
  
    $("#browse-favicon").change(function(){
    $('.custom-file-favicon').addClass('select-image');
  });
  
    $("#browse-station").change(function(){
    $('.custom-file-station').addClass('select-image');
  });
  
    $("#browse-genre").change(function(){
    $('.custom-file-genre').addClass('select-image');
  });
   
    $("#browse-share").change(function(){
    $('.custom-file-share').addClass('select-image');
  });
  
});

   $(function() {
            $('.shortcodes a').click(function() {
                var value = $(this).text();
                var input = $(this).closest(".col-md-12").find("input");
                var_input = JSON.stringify(input.length);
                if ( var_input == '0' ) {
                input = $(this).closest(".col-md-12").find("textarea");
                }
                input.val(input.val() + value + ' ');
                return false;
            });
        });
        
        // Query Cache Clear Prompt
$(document).ready(function() {
    "use strict";

    $('#clear_cache').click(function(e) {
        event.preventDefault();

        var delete_data = document.getElementById('cache-info');
        var delete_yes = delete_data.getAttribute('data-yes');
        var delete_cancel = delete_data.getAttribute('data-cancel');
        var title = delete_data.getAttribute('data-title');
        var text = delete_data.getAttribute('data-text');

        var url = $(this).find("a").attr("href");

        Swal.fire({
            title: "" + title + "",
            text: "" + text + "",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: delete_yes,
            cancelButtonText: delete_cancel
        }).then((result) => {
            if (result.value) {
                window.location = url;
            }
        })
    });
});

// Color Picker
 $(function () {
    $('.my-colorpicker2').colorpicker()
  });
  
  // Ekko Lightbox
$(function() {
  "use strict";

  $(document).on("click", '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
      alwaysShowClose: false
    });
  });
});