function ajaxCreate() {
    var form = $("form");
    var formData = form.serialize();

    $.ajax({
        type: 'post',
        url: '/regions/general/ajaxcreate',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            $(window).block({
                message : '<div class="progress"><div class="progress-bar progress-bar-striped active" ' +
                'role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
                '<span class="sr-only"></span></div></div><span>Loading</span>',
                css: {
                    'border' : 'none',
                    'padding' : '10px'
                }
            });
        },
        success: function(result) {
            if ('err' == result.status) {
                $.notify(result.text, "error");
            }

            if ('ok' == result.status) {
                $.notify(result.text, "success");
                setTimeout(function() {
                    window.location.href = '/regions/general/';
                }, 1000);
            }
        },
        complete: function() {
            $(window).unblock();
        }
    });
}

function ajaxUpdate() {
    var form = $("form");
    var formData = form.serialize();

    $.ajax({
        type: 'post',
        url: '/regions/general/ajaxupdate',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            $(window).block({
                message : '<div class="progress"><div class="progress-bar progress-bar-striped active" ' +
                'role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
                '<span class="sr-only"></span></div></div><span>Loading</span>',
                css: {
                    'border' : 'none',
                    'padding' : '10px'
                }
            });
        },
        success: function(result) {
            if ('err' == result.status) {
                $.notify(result.text, "error");
            }

            if ('ok' == result.status) {
                $.notify(result.text, "success");
                setTimeout(function() {
                    window.location.href = '/regions/general/';
                }, 1000);
            }
        },
        complete: function() {
            $(window).unblock();
        }
    });
}