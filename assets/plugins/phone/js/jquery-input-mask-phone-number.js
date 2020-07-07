// ==================================================
// 
// jquery-input-mask-phone-number v1.0
//
// Licensed (The MIT License)
// 
// Copyright © Raja Rama Mohan Thavalam <rajaram.tavalam@gmail.com>
//
// ==================================================

(function ($) {
    $.fn.usPhoneFormat = function (options) {
        var params = $.extend({
            format: 'xxx-xxx-xxxx',
            international: false,

        }, options);

        var modulo = 13;

        if (params.format === 'xxx-xxx-xxxx') {
            $(this).bind('paste', function (e) {
                e.preventDefault();
                var inputValue = e.originalEvent.clipboardData.getData('Text');
                if (!$.isNumeric(inputValue)) {
                    return false;
                } else {
                    inputValue = String(inputValue.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3"));
                    $(this).val(inputValue);
                    $(this).val('');
                    inputValue = inputValue.substring(0, 12);
                    $(this).val(inputValue);
                }
            });
            $(this).on('keydown touchend', function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
                var curchr = this.value.length;
                var curval = $(this).val();
                if (curchr == 3 && e.which != 8 && e.which != 0) {
                    $(this).val(curval + "-");
                } else if (curchr == 7 && e.which != 8 && e.which != 0) {
                    $(this).val(curval + "-");
                }
                $(this).attr('maxlength', '12');
            });

        } else if (params.format === 'xxx xx xxx xx') {
            $(this).on('keydown touchend', function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)  && (e.which > 105 || e.which < 96)) {
                    return false;
                }

                var curchr = this.value.length % modulo;
                var curval = $(this).val();

                if (curchr == 3 && e.which != 8 && e.which != 0) {
                    $(this).val( curval + " ");
                } else if (curchr == 6 && e.which != 8 && e.which != 0) {
                    $(this).val( curval + " ");
                } else if (curchr == 10 && e.which != 8 && e.which != 0) {
                    $(this).val( curval + " ");
                } else if ((this.value.length == 13 || this.value.length == 27) && e.which != 8 && e.which != 0){
                    $(this).val(curval + ";");
                    modulo=14;
                } else if (this.value.length == 12  && e.which != 8 && e.which != 0) modulo = 13;

                $(this).attr('maxlength', '41');
            });
            $(this).bind('paste', function (e) {
                e.preventDefault();
                var inputValue = e.originalEvent.clipboardData.getData('Text');
                if (!$.isNumeric(inputValue)) {
                    return false;
                } else {
                    inputValue = String(inputValue.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3"));
                    $(this).val(inputValue);
                    $(this).val('');
                    inputValue = inputValue.substring(0, 14);
                    $(this).val(inputValue);
                }
            });

        } else if (params.format === 'xxx') {
            $(this).on('keydown touchend', function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)  && (e.which > 105 || e.which < 96)) {
                    return false;
                }

                var curchr = this.value.length % modulo;
                var curval = $(this).val();

                if (curchr == 3 && e.which != 8 && e.which != 0) {
                    $(this).val( curval + " ");
                } else if (curchr == 6 && e.which != 8 && e.which != 0) {
                    $(this).val( curval + " ");
                } else if (curchr == 10 && e.which != 8 && e.which != 0) {
                    $(this).val( curval + " ");
                }

                $(this).attr('maxlength', '13');
            });
            $(this).bind('paste', function (e) {
                e.preventDefault();
                var inputValue = e.originalEvent.clipboardData.getData('Text');
                if (!$.isNumeric(inputValue)) {
                    return false;
                } else {
                    inputValue = String(inputValue.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3"));
                    $(this).val(inputValue);
                    $(this).val('');
                    inputValue = inputValue.substring(0, 14);
                    $(this).val(inputValue);
                }
            });

        }
    }
}(jQuery));