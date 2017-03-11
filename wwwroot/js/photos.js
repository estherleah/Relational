// Adapted from http://stackoverflow.com/questions/166221/how-can-i-upload-files-asynchronously
$(function() { // waits for document to be ready
  $(document).on('click', '.btnUpload', function(event) {
      var button = $(event.target);
      var id = button.data("id");
      var uploadForm = document.getElementById('uploadForm');
      var uploadFormData = new FormData(uploadForm);
      uploadFormData.append('id', id);

      //console.log(uploadFormData.get('id'));

      // Display the key/value pairs
      /*for(var pair of uploadFormData.entries()) {
         console.log(pair[0]+ ', '+ pair[1]);
      }*/

      if (!$('input[type=file]')[0].files[0]) {
        alert('Select a file');
      }
      else {
        // call php code to upload photo
      $.ajax({
        type: "POST",
        url: 'includes/addPhoto.php',
        data: uploadFormData,
        cache: false,
        contentType: false,
        processData: false,

        success: function(html) {
            // reload data
            $("#existingPhotos").load(location.href + " #existingPhotos");
            console.log(html);
            // clear entry form
            $("#fileToUpload").val('');
        }
      });
    }
  });

  $(document).on('click', '.btnRemoveCollection', function(event) {
      var button = $(event.target);
      var collectionid = button.data("collectionid");

      // call php code to remove photo collection
      $.ajax({
          type: "POST",
          url: 'includes/removePhotoCollection.php',
          data: {
              collectionid
          },
          cache: false,

          success: function(html) {
              console.log(html);
              window.history.back();
          }
      });
  });

});
