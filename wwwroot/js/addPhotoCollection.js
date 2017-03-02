$(function() { // waits for document to be ready
  $(document).on('click','#postSubmit',function(){
    var name = $('#name').val();
    var dataString = 'name=' + name;
    if (!name) {
      alert('Enter some text');
    }
    else {
      // call php code to write to DB
      $.ajax({
          type: "POST",
          url: "../includes/addPhotoCollection.php",
          data: dataString,
          cache: false,
          success: function(html) {
              // reload data
              $("#existingCollections").load(location.href + " #existingCollections");

              // clear entry form
              $("#name").val('');
          }
      });
    }

  });
});
