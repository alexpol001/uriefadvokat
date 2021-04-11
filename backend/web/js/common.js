$(document).ready(function() {
    function fullScreen(elem, offset = 0) {
        if (elem.length > 0) {
            elem.height($(window).height() - elem.offset().top - $('.main-footer').outerHeight()-offset)
        }
    }

    $(window).resize(function() {
        fullScreen($('.file-manager > div'), 15);
        fullScreen($('.content .frontend-frame'));
    });

    $(window).resize();

    $('#material-form').on('submit', function(event){
        var is_error = false;
        var first_err_elem = false;
        $(this).find('.help-block').each(function () {
            var help_block = $(this);
            var form_group = help_block.closest('.form-group');
            var field = form_group.find('.value-field');
            var field_name = form_group.find('label').html();
            field.each(function () {
                if ($.trim($(this).val()) === '') {
                    form_group.addClass('has-error');
                    help_block.html("Необходимо заполнить «"+field_name+"».");
                    is_error = true;
                    if (!first_err_elem) {
                        first_err_elem = form_group;
                    }
                }
            });
        });
        if (is_error) {
            var tab = first_err_elem.closest('.tab-pane');
            $('.nav-tabs a[href="#' + tab[0].id + '"]').tab('show');
            $(window).scrollTop(first_err_elem.offset().top-15);
            return false;
        }
    });

    $('#material-form .value-field').on('iconpickerSelected', function () {
        var form_group = $(this).closest('.form-group');
        doValidate(form_group);
    });

    $('#material-form .value-field').on('change', function () {
        var form_group = $(this).closest('.form-group');
        doValidate(form_group);
    });

    $('#material-form .value-field').on('blur', function () {
        var form_group = $(this).closest('.form-group');
        doValidate(form_group);
    });

    function doValidate(form_group) {
        var help_block = form_group.find('.help-block');
        if (help_block.length > 0) {
            var field = form_group.find('.value-field');
            var field_name = form_group.find('label').html();
            var is_error = false;
            field.each(function () {
                if ($.trim($(this).val()) === '') {
                    form_group.addClass('has-error');
                    help_block.html("Необходимо заполнить «"+field_name+"».");
                    is_error = true;
                }
            });
            if (!is_error) {
                resetFormGroup(form_group, help_block);
            }
        }
    }

    var time_out = false;
    function resetFormGroup(form_group, help_block) {
        if (!time_out) {
            time_out = true;
            setTimeout(function () {
                help_block.html('');
                form_group.removeClass('has-error');
                time_out = false;
            }, 50);
        }
    }
});
