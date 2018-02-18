$(function () {

    $("#contact-form").submit(function () {

        var btn = $('#submit_message'), ctc_form = $('#contact-form');
        btn.button('loading');

        var url = "mail.php"; 

        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(), 
            success: function (data)
            {
                var alertBox = '<div class="alert alert-success alert-dismissable fade in success-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your message has been successfully sent  </div>';
                ctc_form.find('.messages').html(alertBox);
                ctc_form[0].reset();
                btn.button('reset');

                setTimeout(() => {
                    ctc_form.find('.alert').fadeOut();
                }, 3000);
            }
        });
        return false; 
    });
});
