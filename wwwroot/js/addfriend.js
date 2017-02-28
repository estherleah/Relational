$(function() { // waits for document to be ready
  $(document).on('click','#postSubmit',function(){
    var post = $('#postText').val();
    var dataString = 'post=' + post;
    if (!post) {
      alert('Enter some text');
    }
    else {
      // call php code to write to DB
      $.ajax({
          type: "POST",
          url: "../includes/addFriend.php",
          data: dataString,
          cache: false,
          success: function(html) {
              // reload data
              $("#previousposts").load(location.href + " #previousposts");

              // clear entry form
              //$("#postText").val('');
          }
      });
    }

  });

});
