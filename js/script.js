$(function() {

    var ul = document.getElementById('messages-list');
    var listItems = Array.prototype.slice.call(ul.querySelectorAll("li"));

    listItems.forEach(function(item) {
        item.addEventListener("click", function(event) {
            $('#message').val(this.textContent);
        });
    });

    $('form').on('submit', function(e) {

        e.preventDefault();

        
        var errorMsg = "";

        if($('#phoneNumber1').val().length < 10) {
            errorMsg += "<p>Please enter a valid phone number!</p>";
        }

        if($('#message').val() == ""){
            errorMsg += "<p>Please type your message first!</p>";
        }

        if(errorMsg != ''){

            $('#error').html(errorMsg);
        }else{
            $('#error').html('');
            $.ajax({
                type: 'post',
                url: 'send_sms.php',
                data: $('form').serialize(),
                success: function() {
                    $('#error').html('<p>Message Sent</p>').css('color', 'green').fadeOut(4000,function(){
                        $(this).html("").fadeIn(); 
                    });
                    $('textarea').val("");
                    $('#phoneNumber1').val("");
                }
            });
        }
        
    });

});