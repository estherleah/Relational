$(function() { // waits for document to be ready
  $(document).on('click','#postSubmit',function(){
    var photoCollectionName = $('#photoCollectionName').val();
    var photoCollectionPrivacyID = $('#privacy').val();

    if (!photoCollectionName) {
      alert('Enter some text');
    }
    else {
      // call php code to write to DB

      $.ajax({
          type: "POST",
          url: 'includes/addPhotoCollection.php',
          data: {
            photoCollectionName,
            photoCollectionPrivacyID
          },
          cache: false,
          success: function(html) {
              // reload data
              $("#existingCollections").load(location.href + " #existingCollections");

              // clear entry form
              $("#photoCollectionName").val('');
              $("#privacy").val('');
          }
      });
    }

  });
});
