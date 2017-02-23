$(function() { // waits for document to be ready
  $(document).on('click','#messageSubmit',function(){
    var message = $('#messageText').val();
    var dataString = 'message=' + message;
    if (!message) {
      alert('Enter some text (JS)');
    }
    else {
      // call php code to write to DB
      $.ajax({
          type: "POST",
          url: "../includes/chatProcess.php",
          data: dataString,
          cache: false,
          success: function(html) {
              // reload data
            $("#previousmessages").load(location.href + " #previousmessages");

              // clear entry form
              $("#messageText").val('');
          }
      });
    }

  });

});
