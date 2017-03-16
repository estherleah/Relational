



$(function() { // waits for document to be ready
//add the like add button thing somewhere


    $(".btnUpload").on("click", function() {
        var uploadForm = document.getElementById('uploadForm');
        var uploadFormData = new FormData(uploadForm);

        if (!$('input[type=file]')[0].files[0]) {
            alert('Select a file');
        }
        else {
            // call php code to write to DB
                $.ajax({
                    type: "POST",
                    url: 'includes/addProfilePic.php',
                    data: uploadFormData,
                    cache: false,

                    success: function() {
                        $("#currentPic").load(location.href + " #currentPic");
                        // alert('Success');
                        // clear entry form
                        $("#fileToUpload").val('');
                    }
                });
            }
        });

            $(".btnAdd").on("click", function(event) {
            var button = $(event.target);
            var id = button.data('id');

            $.ajax({
                type: 'post',
                url: 'includes/profileAdd.php',
                data: {
                    id
                },

                success: function(html) {

                    // reload data

                    console.log(html);
                     document.location.reload();
                }
            });
          });

          $(".btnAccept").on("click", function(event) {
          var button = $(event.target);
          var id = button.data('id');

          $.ajax({
              type: 'post',
              url: 'includes/profileAccept.php',
              data: {
                  id
              },

              success: function(html) {

                  // reload data

                  console.log(html);
                   document.location.reload();
              }
          });
        });


          $(".btnCancel").on("click", function(event) {
          var button = $(event.target);
          var id = button.data('id');

          $.ajax({
              type: 'post',
              url: 'includes/profileCancel.php',
              data: {
                  id
              },

              success: function(html) {

                  // reload data

                  console.log(html);
                   document.location.reload();
              }
          });
        });

        $(".btnDelete").on("click", function(event) {
        var button = $(event.target);
        var id = button.data('id');

        $.ajax({
            type: 'post',
            url: 'includes/profileDelete.php',
            data: {
                id
            },

            success: function(html) {

                // reload data

                console.log(html);
                 document.location.reload();
            }
        });
      });


});
