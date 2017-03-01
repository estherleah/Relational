// Adapted from http://stackoverflow.com/questions/166221/how-can-i-upload-files-asynchronously
$(function() { // waits for document to be ready
  $(".btnUpload").on("click", function(event) {
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
        url: "../includes/addPhoto.php",
        data: uploadFormData,
        cache: false,
        contentType: false,
        processData: false,

        success: function(html) {
            // reload data
            $("#existingPhotos").load(location.href + " #existingPhotos");
            alert(html);
            // clear entry form
            $("#fileToUpload").val('');
        }
      });
    }
  });



  $(".btnRemove").on("click", function(event) {
      var button = $(event.target);
      var id = button.data("id");
      var url = button.data("url");

      $("#existingPhotos").load(location.href + " #existingPhotos");
      // call php code to remove photo
      $.ajax({
        type: "POST",
        url: "../includes/removePhoto.php",
        data: {id, url},
        cache: false,

        success: function(html) {
            // reload data
            $("#existingPhotos").load(location.href + " #existingPhotos");
            alert(html);
        }
      });
    });

});
