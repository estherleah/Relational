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

});
