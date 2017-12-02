// Adapted from http://stackoverflow.com/questions/166221/how-can-i-upload-files-asynchronously
$(function() { // waits for document to be ready

    $(document).on('click', '.btnRemovePhoto', function(event) {
      getConfirm('Do you really want to delete this photo as well as all its annotations and comments?', function(result) {
          if(result === true){
            var button = $(event.target);
            var photoid = button.data("photoid");
            var photourl = button.data("photourl");

            // call php code to remove photo
            $.ajax({
                type: "POST",
                url: 'includes/removePhoto.php',
                data: {
                    photoid,
                    photourl
                },
                cache: false,

                success: function(html) {
                    console.log(html);
                    window.history.back();
                }
            });
          }});
    });

    $(document).on('click', '.btnPost', function(event) {
        var button = $(event.target);
        var photoid = button.data("photoid");

        var post = $('#postText').val();
        //var dataString = 'post=' + post;
        if (!post) {
            alert('Enter some text');
        } else {
            // call php code to write to DB
            $.ajax({
                type: "POST",
                url: 'includes/addPhotoComment.php',
                data: {
                    photoid,
                    post
                },
                cache: false,
                success: function(html) {
                    // reload data
                    $("#previousposts").load(location.href + " #previousposts");
                    console.log(html);
                    // clear entry form
                    $("#postText").val('');
                }
            });
        }

    });

    $(document).on("click", ".btnLike", function(event) {
      var button = $(event.target);
      var photoid = button.data("photoid");
      var annotationtype = button.data("annotationtype");

      // call php code to write to DB
      $.ajax({
          type: "POST",
          url: 'includes/changePhotoAnnotation.php',
          data: {
              photoid,
              annotationtype
          },
          cache: false,
          success: function(html) {
              // reload data
              $("#likes").load(location.href + " #likes");
              //location.reload();
              console.log(html);
          }
      });
    });

    $(document).on('click', '.btnRemoveComment', function(event) {
      var button = $(event.target);
      var commentid = button.data('commentid');

      // call php code to remove photo comment from DB
      $.ajax({
          type: 'POST',
          url: 'includes/removePhotoComment.php',
          data: {
              commentid
          },
          cache: false,
          success: function(html) {
              // reload data
              $('#previousposts').load(location.href + ' #previousposts');
              console.log(html);
          }
      });
    });

    function getConfirm(confirmMessage,callback){
      confirmMessage = confirmMessage || '';

      $('#confirmationModal').modal();

      $('.message').text(confirmMessage);
      $('.btnCancel').click(function(){
          $('#confirmationModal').modal('hide');
          if (callback) callback(false);

      });
      $('.btnConfirm').click(function(){
          $('#confirmationModal').modal('hide');
          if (callback) callback(true);
      });
    }

});
