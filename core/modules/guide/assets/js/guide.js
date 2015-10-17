$(document).ready(function() {
    $('#guideModal').modal('show');
});

function stopGuide(type) {
    var modal = $('#guideModal');

    $.ajax({
        type: 'post',
        url: '/guide/general/finish',
        dataType: 'json',
        data: {type: type},
        beforeSend: function() {
            $(window).block({
                message : '<div class="progress"><div class="progress-bar progress-bar-striped active" ' +
                'role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
                '<span class="sr-only"></span></div></div><span>Loading</span>',
                css: {
                    'border' : 'none',
                    'padding' : '10px',
                    'z-index' : '9999'
                }
            });
        },
        success: function(res) {
            if ('err' == res.status) {
                $.notify(res.text, "error");
            }

            if ('ok' == res.status) {
                $.notify(res.text, "success");
            }

            modal.modal('hide');
        },
        complete: function() {
            $(window).unblock();
        },
        error: function() {
            $.notify('Запрос был выполнен с ошибкой. Попробуйте позднее', 'error');
        }
    });
}