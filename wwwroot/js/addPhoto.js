// Adapted from http://stackoverflow.com/questions/166221/how-can-i-upload-files-asynchronously

$(function() { // waits for document to be ready
  $(document).on('click','#uploadButton',function(){
    console.log("output");
    var uploadForm = document.getElementById('uploadForm');
    var uploadFormData = new FormData(uploadForm);

    if (!$('input[type=file]')[0].files[0]) {
      alert('Select a file');
    }
    else {
      // call php code to write to DB
      $.ajax({
          type: "POST",



// add the collectionId here!




          url: "../includes/addPhoto.php?collectionID=",
          data: uploadFormData,
          cache: false,
          contentType: false,
          processData: false,

          success: function(html) {
              // reload data
              $("#existingPhotos").load(location.href + " #existingPhotos");
              console.log(html);
              // clear entry form
              $("#file").val('');
          }
      });
    }

  });
});
