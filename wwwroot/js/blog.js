$(function() {
  $(document).on('click','#postSubmit',function(){
    var post = $('#postText').val();
    var dataString = 'post=' + post;
    if (!post) {
      alert('Enter some text');
    }
    else {
      // call php code to write to DB
      $.ajax({
          type: 'POST',
          url: 'includes/addBlogEntry.php',
          data: dataString,
          cache: false,
          success: function(html) {
              // reload data
              $('#previousposts').load(location.href + ' #previousposts');
              console.log(html);

              // clear entry form
              $("#postText").val('');
          }
      });
    }
  });

  $(document).on('click', '.btnRemove', function(event) {
    var button = $(event.target);
    var entryid = button.data('entryid');

    // call php code to remove blog entry from DB
    $.ajax({
        type: 'POST',
        url: 'includes/removeBlogEntry.php',
        data: {
            entryid
        },
        cache: false,
        success: function(html) {
            // reload data
            $('#previousposts').load(location.href + ' #previousposts');
            console.log(html);
        }
    });
  });
});
