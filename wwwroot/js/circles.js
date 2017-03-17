$(function() {

    // User's Circles -------------------------------------------

    $(".btnLeaveCircle").on("click", function(event) {
        getConfirm('Do you really want to leave this circle?', function(result) {
            if(result == true){
                var button = $(event.target)
                var circleID = button.data("circleid")
                $.ajax({ url: 'includes/showcircle.php',
                    data: {
                        action: 'leaveCircle',
                        circleID
                    },
                    type: 'post',
                    success: function(output) {
                        removeMsg = output;
                        $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                            window.location.reload(true);
                        })
                        $('#infoModal').modal()
                    }
                });
            }
        });
    });

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
                        $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                            window.location.href = "circles.php";
                        })
                        $('#infoModal').modal()
                    }
                });
            }
        });
    });

    $(".btnAddMember").on("click", function(event) {
        $('#inviteModal').modal()
    });


    // Circle Search --------------------------------------------

    $(".circleSearch").keyup(function() {
        var searchid = $(this).val();
        var dataString = 'search=' + searchid;

        if (searchid == '') {
            jQuery("#circleResult").fadeOut();
        } else {
            $.ajax({
                type: "POST",
                url: 'includes/findcircles.php',
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#circleResult").html(html).show();
                }
            });
        }
        return false;
    });

    jQuery("#circleResult").on("click", function(e) {
        var clicked = $(e.target);
        var circleID = clicked.find('.cid').html();
        if(circleID != null){
            var url = 'circle.php?id=' + circleID;
            window.open(url, "_self");
        }
    });

    jQuery(document).on("click", function(e) {
        var $clicked = $(e.target);
        if (!$clicked.hasClass("circleSearch")) {
            jQuery("#circleResult").fadeOut();
        }
    });

    $('#circleSearchid').click(function() {
        jQuery("#circleResult").fadeIn();
    });

    // Friend Search --------------------------------------------

    $(".inviteSearch").keyup(function() {
        var searchid = $(this).val();
        var dataString = 'search=' + searchid;

        if (searchid == '') {
            jQuery("#inviteResult").fadeOut();
        } else {
            $.ajax({
                type: "POST",
                url: 'includes/search.php',
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#inviteResult").html(html).show();
                }
            });
        }
        return false;
    });

    jQuery("#inviteResult").on("click", function(e) {
        var clicked = $(e.target);
        var userID = clicked.find('.uid').html();
        var userName = clicked.find('.name').html();
        var invitedUsers = new Array();
        $('.invited').each(function(){
            invitedUsers.push($(this).attr('id'));
        });

        if (userID != null && userName != null && $.inArray(userID, invitedUsers) == -1){
            $("#inviteStaging").append("<div class=\"invited\" id=\""+
            userID+
            "\"><button type=\"button\" class=\"close\" aria-label=\"Close\" style=\"margin-left:10px; color:#fff\"><span aria-hidden=\"true\">&times;</span></button>"+
            userName+
            "</div>");
        }

        $(".invited").on("click", function(event) {
            $(this).closest('.invited').remove();
        });
    });

    $('#inviteSearch').click(function() {
        jQuery("#inviteResult").fadeIn();
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
                        $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                            window.location.reload(true);
                        })
                        $('#infoModal').modal()
                    }
                });
            }
        });
    });

    $(".btnInvite").on("click", function(event) {
        $('.invited').each(function(){
            var newUserID =  $(this).attr('id');
            $.ajax({ url: 'includes/showcircle.php',
                data: {
                    action: 'addUser',
                    newUserID
                },
                type: 'post',
                success: function(output) {
                    removeMsg = output;
                    $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                        window.location.reload(true);
                    })
                    $('#infoModal').modal()
                }
            });
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
                        $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                            window.location.reload(true);
                        })
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
                $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                    window.location.reload(true);
                })
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
                $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                    window.location.reload(true);
                })
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
                        $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                            window.location.reload(true);
                        })
                        $('#infoModal').modal()
                    },
                    error: function(output) {
                        removeMsg = output;
                        $("#infoModal").find(".btnClose").off('click').on("click", function(event) {
                            window.location.reload(true);
                        })
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
