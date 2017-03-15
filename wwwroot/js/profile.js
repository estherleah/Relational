



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
/*
        //function for adding a user using the add button on a profile page
        $(".btnAdd").on("click", function(event) {
            var button = $(event.target)
            var id = button.data("id")

            $.ajax({ url: 'includes/showprofile.php',
                data: {
                    action: 'add',
                    id
                },
                type: 'post',
                success: function(output) {
                    removeMsg = output;
                    $('#infoModal').modal()
                }
            });
        });

*/
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




});
