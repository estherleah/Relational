$(function() {

    $(".search").keyup(function() {
        var searchid = $(this).val();
        var dataString = 'search=' + searchid;
        var url = 'http://localhost/gc06/includes/search.php';

        if (searchid == '') {
            jQuery("#result").fadeOut();
        } else {
            $.ajax({
                type: "POST",
                url: 'includes/search.php',
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

});
