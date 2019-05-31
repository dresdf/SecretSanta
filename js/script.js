jQuery(document).ready(function() {
    //animate games menu
    jQuery('#games').click(function() {
        jQuery('#gamelist').slideToggle(100);
    });

    //profile page functions
    $('#saveWishlistBtn').click(function() {
        //getting the values that user typed
        var newWishlist = $("#wishlist-input").val();

        // forming the queryString
        var data = 'saveWishlist=1'+'&newWishlist=' + newWishlist;
        // ajax call
        $.ajax({
            type: "POST",
            url: "updateProfile.php",
            data: data,
            success: function() { // this happen after we get result
                alert('Update successful!');
            }


        });

        return false;

    });

    $('#updateBtn').click(function() {
        //getting the values that user typed
        var newUsername = $("#profileUsername").val();
        var newPassword = $("#profilePassword").val();

        // forming the queryString
        var data = 'update=1' + '&newUsername=' + newUsername + '&newPassword=' + newPassword;
        // ajax call
        $.ajax({
            type: "POST",
            url: "updateProfile.php",
            data: data,
            success: function() { // this happen after we get result
                alert('Update successful!');
            }
        });
    });

    $('#santaScriptBtn').click(function() {
        $.ajax({
            type: "POST",
            url: "secretSanta.php",
            success: function() { // this happen after we get result
                alert('Update successful!');
            },
            error: function(){
                alert('Nothing happened');
            }
        });

    });


    //animate slider
    jQuery('.flexslider').flexslider({
        animation: "slide",
        controlsContainer: ".slider-holder",
        slideshowSpeed: 5000,
        directionNav: true,
        controlNav: false,
        animationDuration: 900
    });

    //SHOUTBOX
    //
    //populating shoutbox the first time
    refresh_shoutbox();
    // recurring refresh every 15 seconds
    setInterval("refresh_shoutbox()", 15000);

    //hide "submit" button and show it if text is entered
    $("#submit").attr('disabled', 'disabled');
    $("#message").bind('change keyup', function() {
//        $("#submit").toggle($(this).val() !== '');
        $("#submit").removeAttr("disabled");
    });

    //disable the form submit with enter key
    $('.message').keypress(function(e) {
        if (e.which === 13)
            return false;
    });

    //form submit
    $("#submit").click(function() {
        // getting the values that user typed
        var name = $("span#name").text();
        var message = $("#message").val();
        if(message != ""){
        // forming the queryString
        var data = 'name=' + name + '&message=' + message;
        // ajax call
        $.ajax({
            type: "POST",
            url: "shout.php",
            data: data,
            success: function(html) { // this happen after we get result
                $("#shout").slideToggle(500, function() {
                    $(this).html(html).slideToggle(500);
                    $("#message").val("");
                });
            }
        });
    }
        $("#submit").css('disabled', 'disabled');
        return false;

    });

    function refresh_shoutbox() {
        var data = 'refresh=1';

        $.ajax({
            type: "POST",
            url: "shout.php",
            data: data,
            success: function(html) { // this happen after we get result
                $("#shout").html(html);
            }
        });
    }
    //end Shoutbox







});
