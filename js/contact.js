$(function () {

    $("#contact-form").submit(function () {

        var url = "mail.php"; 

        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(), 
            success: function (data)
            {
                console.log(data);
                var messageAlert = 'alert-' + data.type;
                var messageText = data.message;

                var alertBox = '<div class="alert alert-success alert-dismissable fade in success-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your message has been successfully sent  </div>';
                $('#contact-form').find('.messages').html(alertBox);
                $('#contact-form')[0].reset();

                setTimeout(() => {
                    // $('#contact-form').find('.messages').html('');
                    $('#contact-form').find('.alert').fadeOut();
                }, 3000);
            }
        });
        return false; 
    });

});