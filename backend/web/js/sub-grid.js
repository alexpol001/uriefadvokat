$(document).ready(function () {
    var GroupTypeSelect = $('#group-type');

    function checkMaterial() {
        var subGroupTab = $('a[href="#sub-group"]');
        if (GroupTypeSelect.val() == 100) {
            subGroupTab.css({'display': 'block'});
        } else {
            subGroupTab.hide();
        }
    }

    function showActive(target) {
        $('.sub-grid').hide();
        $('.sub-grid[data-sub-id="' + target + '"]').show();
    }


    $('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        showActive(target);
        $(target + ' .form-group .mce-tinymce .mce-edit-area iframe').each(function () {
            if ($(this).css("height") == "100px") {
                $(this).css("height", "231px");
            }
        });
    });

    showActive($('.nav.nav-tabs li.active a').attr("href"));

    GroupTypeSelect.on('change', function () {
        checkMaterial();
    });

    checkMaterial();
});
