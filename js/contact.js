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
              var messageAlert = 'alert-' + data.type;
              var messageText = data.message;
              var messageIcon = data.icon;

              var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable fade in contact__msg-container__message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa ' + messageIcon  + ' fa-lg"></i> ' + messageText + '</div>';
              ctc_form.find('.contact__msg-container').html(alertBox);
              btn.button('reset');

              if(data.type === 'success') ctc_form[0].reset();

              setTimeout(() => {
                  ctc_form.find('.alert').fadeOut();
              }, 6000);
            }
        });
        return false;
    });
});
