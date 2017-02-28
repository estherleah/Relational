$(function() {

    // User's Circles -------------------------------------------

    $(".btnLeaveCircle").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        $.ajax({ url: 'includes/showcircle.php',
            data: {
                action: 'removeUser',
                id
            },
            type: 'post',
            success: function(output) {
                removeMsg = output;
                $('#infoModal').modal()
            }
        });
    });

    $(".btnCreateCircle").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        $.ajax({ url: 'includes/showcircle.php',
            data: {
                action: 'removeUser',
                id
            },
            type: 'post',
            success: function(output) {
                removeMsg = output;
                $('#infoModal').modal()
            }
        });
    });


    // Circle Search --------------------------------------------

    $(".search").keyup(function() {
        var searchid = $(this).val();
        var dataString = 'search=' + searchid;

        if (searchid == '') {
            jQuery("#result").fadeOut();
        } else {
            $.ajax({
                type: "POST",
                url: 'includes/findcircles.php',
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#result").html(html).show();
                }
            });
        }
        return false;
    });

    jQuery("#result").on("click", function(e) {
        var $clicked = $(e.target);
        var $userID = $clicked.find('.uid').html();
        //var decoded = $("<div/>").html($userID).text();
        //$('#searchid').val(decoded);
        var url = "http://localhost:8888/user/" + $userID;
        window.open(url, "_self");
    });

    jQuery(document).on("click", function(e) {
        var $clicked = $(e.target);
        if (!$clicked.hasClass("search")) {
            jQuery("#result").fadeOut();
        }
    });

    $('#searchid').click(function() {
        jQuery("#result").fadeIn();
    });


    // Circle ----------------------------------------------------

    $(".btnDeleteCircle").on("click", function(event) {
        getConfirm('Do you really want to delete this circle?', function(result) {
            if(result == true){
                $.ajax({ url: 'includes/showcircle.php',
                    data: {
                        action: 'deleteCircle'
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


    // Circle Members --------------------------------------------

    var removeMsg = "";

    // Include member name in info modal
    $('#infoModal').on('show.bs.modal', function (event) {
        // var button = $(event.relatedTarget)
        // var name = button.data("name")
        var modal = $(this)
        modal.find('.message').text(removeMsg+"")
    })

    $(".btnRemove").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        getConfirm('Do you really want to remove this user from the circle?', function(result) {
            if(result == true){
                $.ajax({ url: 'includes/showcircle.php',
                    data: {
                        action: 'removeUser',
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

    $(".btnMAdmin").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        $.ajax({ url: 'includes/showcircle.php',
            data: {
                action: 'makeAdmin',
                id
            },
            type: 'post',
            success: function(output) {
                removeMsg = output;
                $('#infoModal').modal()
            }
        });
    });

    $(".btnRAdmin").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        $.ajax({ url: 'includes/showcircle.php',
            data: {
                action: 'revokeAdmin',
                id
            },
            type: 'post',
            success: function(output) {
                removeMsg = output;
                $('#infoModal').modal()
            }
        });
    });

    $(".btnMOwner").on("click", function(event) {
        var button = $(event.target)
        var id = button.data("id")

        getConfirm('Do you really want to pass your ownership rights? You will remain an admin in this circle.', function(result) {
            if(result == true){
                $.ajax({ url: 'includes/showcircle.php',
                    data: {
                        action: 'makeOwner',
                        id
                    },
                    type: 'post',
                    success: function(output) {
                        removeMsg = output;
                        $('#infoModal').modal()
                    },
                    error: function(output) {
                        removeMsg = output;
                        $('#infoModal').modal()
                    }
                });
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
