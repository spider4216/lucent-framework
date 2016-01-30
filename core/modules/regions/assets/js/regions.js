var n = null;
var content = null;

function enableRegionTool(e) {
    var region = $(e).parents('.region');
    var allRegions = $('.region');
    var regionTool1 = $('.region-tool-ok');
    var regionTool2 = $('.region-tool-cancel');
    var btn1 = '<div class="glyphicon glyphicon-floppy-disk region-tool-ok" onclick="regionToolSave(this)"></div>';
    var btn2 = '<div class="glyphicon glyphicon-remove region-tool-cancel" onclick="regionToolCancel(this, true)"></div>';
    content = region.find('.region-content').html();

    if (regionTool1.length > 0) {
        regionTool1.remove();
    }

    if (regionTool2.length > 0) {
        regionTool2.remove();
    }

    allRegions.removeClass('region-tool-enabled');
    region.addClass('region-tool-enabled');
    region.find('.setting-region').append(btn1, btn2);

    n = region.find('.region-content').dad({
        callback: function() {
            console.log('drug');
        }
    });

    n.activate();
}

function regionToolSave(e) {
    console.log('region save');
    var region = $(e).parents('.region');
    var blocks = region.find('.block');
    var result = {};
    var weight = 0;
    var num = 0;

    blocks.each(function() {
        var type = $(this).attr('data-type');
        var id = $(this).attr('data-id');

        result[num] = {
            type : type,
            id : id,
            weight : weight
        };

        weight++;
        num++;
    });

    $.ajax({
        url: '/regions/general/AjaxBlockSort',
        method: 'post',
        dataType: 'json',
        data: result,
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
                regionToolCancel(e, false);
                $.notify(result.text, "success");
            }
        },
        complete: function() {
            $(window).unblock();
        }
    });
}

function regionToolCancel(e, reset) {
    var region = $(e).parents('.region');
    var regionTool1 = $('.region-tool-ok');
    var regionTool2 = $('.region-tool-cancel');

    if (regionTool1.length > 0) {
        regionTool1.remove();
    }

    if (regionTool2.length > 0) {
        regionTool2.remove();
    }

    region.removeClass('region-tool-enabled');

    n.deactivate();

    if (true === reset) {
        region.find('.region-content').html(content);
    }
}