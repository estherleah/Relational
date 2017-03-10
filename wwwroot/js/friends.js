$(function() {

    // Circle Members --------------------------------------------

    var removeMsg = "";

    // Include member name in info modal
    $('#infoModal').on('show.bs.modal', function (event) {
        // var button = $(event.relatedTarget)
        // var name = button.data("name")
        var modal = $(this)
        modal.find('.message').text(removeMsg+"")
    })

    $(".btnDelete").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")
        //3 cases needed
        //EXISTING FRIENDS - DELETE
        //PENDING FRIENDS - CANCEL
        //SUGGESTED FRIENDS - ADD

        getConfirm('Do you really want to delete this friend?', function(result) {
            if(result == true){
                $.ajax({ url: 'includes/showfriends.php',
                    data: {
                        action: 'deleteFriend',
                        id
                    },
                    type: 'post',
                    success: function(output) {
                        removeMsg = output;
                        $('#infoModal').modal()
                    }
                });
            }
        });
    });

    $(".btnCancelReq").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        $.ajax({ url: 'includes/showfriends.php',
            data: {
                action: 'cancelReq',
                id
            },
            type: 'post',
            success: function(output) {
                removeMsg = output;
                $('#infoModal').modal()
            }
        });
    });

    $(".btnAdd").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        $.ajax({ url: 'includes/showfriends.php',
            data: {
                action: 'addFriend',
                id
            },
            type: 'post',
            success: function(output) {
                removeMsg = output;
                $('#infoModal').modal()
            }
        });
    });

    function getConfirm(confirmMessage,callback){
    confirmMessage = confirmMessage || '';

    $('#confirmationModal').modal();

    $('.message').text(confirmMessage);
    $('.btnCancel').click(function(){
        $('#confirmationModal').modal('hide');
        if (callback) callback(false);

    });
    $('.btnConfirm').click(function(){
        $('#confirmationModal').modal('hide');
        if (callback) callback(true);
    });
}

});
