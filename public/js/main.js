
$(function () {
    $('[data-toggle="popover"]').popover({
        html: true,
    });
    $('[data-toggle="tooltip"]').tooltip({
        html: true,
    });

    var flashContainer = $('.flash-message-wrapper');
    var flashMessages  = flashContainer.find('.flash-message');
    if(flashMessages.length > 0) {
        $.each(flashMessages, function (key, message) {
            message  = $(message);
            // alert, success, warning, error, info/information
            var type = "info";
            if (message.hasClass('alert-alert')) {
                type = "alert";
            }
            if(message.hasClass('alert-success')) {
                type = "success";
            }
            if(message.hasClass('alert-warning')) {
                type = "warning";
            }
            if(message.hasClass('alert-danger')) {
                type = "error";
            }
            if(message.hasClass('alert-error')) {
                type = "error";
            }

            new Noty({
                theme: 'bootstrap-v4',
                type: type,
                text: message.find('.message').html(),
                timeout: 2000 + ((key + 1) * 1000),
                queue: "notification",
            }).show();

        })
    }
})
