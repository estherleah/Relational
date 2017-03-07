// Adapted from http://stackoverflow.com/questions/166221/how-can-i-upload-files-asynchronously
$(function() { // waits for document to be ready

  $(".btnRemove").on("click", function(event) {
      var button = $(event.target);
      var id = button.data("id");
      var url = button.data("url");

      // call php code to remove photo
      $.ajax({
        type: "POST",
        url: 'includes/removePhoto.php',
        data: {id, url},
        cache: false,

        success: function(html) {
            window.history.back();
        }
      });
    });

    $(".btnPost").on("click", function(event) {
      var button = $(event.target);
      var photoid = button.data("photoid");

      var post = $('#postText').val();
      //var dataString = 'post=' + post;
      if (!post) {
        alert('Enter some text');
      }
      else {
        // call php code to write to DB
        $.ajax({
            type: "POST",
            url: 'includes/addPhotoComment.php',
            data: {photoid, post},
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

});
