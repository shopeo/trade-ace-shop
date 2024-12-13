/**
 * Document ready
 * 
 * Checkout Product Page
 */
jQuery(document).ready(function($) {
"use strict";

if ($('#main-content .form-row input, #main-content .form-row select, #main-content .form-row textarea').length) {
    $('#main-content .form-row input, #main-content .form-row select, #main-content .form-row textarea').each(function() {
        var _this = $(this);
        var _form_acc = $(_this).parents('form.woocommerce-EditAccountForm').length ? true : false;
        var _wrap = $(_this).parents('.form-row');
        
        var _this_val = $(_this).val();
        
        /**
         * Add * required to placeholder
         */
        if ($(_wrap).length && $(_wrap).hasClass('validate-required') && $(_wrap).find('label[for]').length) {
            var _palace_holder = $(_this).attr('placeholder');
            
            if (_palace_holder) {
                var _rq = $(_wrap).find('label[for] .required').length ? $(_wrap).find('label[for] .required').text() : '*';
                $(_this).attr('placeholder', _palace_holder + ' ' + _rq);
            }
        }
        
        /**
         * Check actived
         */
        if (_this_val !== '' || _form_acc) {
            if ($(_wrap).length && $(_wrap).find('label[for]').length) {
                var _for = $(_wrap).find('label[for]').attr('for');
                if ($(_wrap).find('input[type="hidden"]#' + _for + ', input[type="radio"]#' + _for + ', input[type="checkbox"]#' + _for).length <= 0) {
                    if (!$(_wrap).hasClass('tradeace-actived')) {
                        $(_wrap).addClass('tradeace-actived');
                    }
                } else {
                    if (!$(_wrap).hasClass('tradeace-dffr')) {
                        $(_wrap).addClass('tradeace-dffr');
                    }
                }
            } 
        }
    });
}

$('body').on('keyup', '#main-content .form-row input, #main-content .form-row textarea', function() {
    var _this = $(this);
    var _wrap = $(_this).parents('.form-row');
    
    if ($(_wrap).length && !$(_wrap).hasClass('tradeace-dffr') && $(_wrap).find('label[for]').length) {
        if ($(_this).val() !== '') {
            if (!$(_wrap).hasClass('tradeace-actived')) {
                $(_wrap).addClass('tradeace-actived');
            }
            if ($(_wrap).find('.tradeace-error').length) {
                $(_wrap).find('.tradeace-error').remove();
            }
        } else {
            var _form_acc = $(_this).parents('form.woocommerce-EditAccountForm').length ? true : false;
            if (!_form_acc) {
                $(_wrap).removeClass('tradeace-actived');
            }
        }
    }
});

$('body').on('change', '#main-content .form-row select', function() {
    var _this = $(this);
    var _wrap = $(_this).parents('.form-row');
    
    if ($(_wrap).length && !$(_wrap).hasClass('tradeace-dffr') && $(_wrap).find('label[for]').length) {
        if ($(_this).val() !== '') {
            if (!$(_wrap).hasClass('tradeace-actived')) {
                $(_wrap).addClass('tradeace-actived');
            }
            
            if ($(_wrap).find('.tradeace-error').length) {
                $(_wrap).find('.tradeace-error').remove();
            }
        } else {
            var _form_acc = $(_this).parents('form.woocommerce-EditAccountForm').length ? true : false;
            if (!_form_acc) {
                $(_wrap).removeClass('tradeace-actived');
            }
        }
    }
});

tradeace_move_valiate_notices($);

$('body').on('checkout_error', function() {
    tradeace_move_valiate_notices($);
});

$('body').on('applied_coupon_in_checkout', function() {
    tradeace_move_valiate_notices($);
});

/* End Document Ready */
});

/**
 * Functions
 */
/**
 * Move validate notices
 * 
 * @param {type} $
 * @returns {String}
 */
function tradeace_move_valiate_notices($) {
    if ($('.woocommerce-error li').length) {
        $('.woocommerce-error li').each(function() {
            var _li = $(this);
            var _this = $(_li).attr('data-id');
            if (typeof _this !== 'undefined' && $('#' + _this).length) {
                var _wrap = $('#' + _this).parents('.form-row');
                if ($(_wrap).length) {
                    var _appent = $(_li).html();
                    if ($(_wrap).find('.tradeace-error').length) {
                        $(_wrap).find('.tradeace-error').html(_appent);
                    } else {
                        $('#' + _this).after('<span class="tradeace-error">' + _appent + '</span>');
                    }
                    
                    if (!$(_wrap).hasClass('woocommerce-invalid')) {
                        $(_wrap).removeClass('woocommerce-validated');
                        $(_wrap).addClass('woocommerce-invalid');
                    }
                    
                    $(_li).remove();
                }
            }
        });
        
        if ($('.woocommerce-error li').length) {
            $('.woocommerce-error').show();
        } else {
            $('.woocommerce-error').hide();
        }
    }
}

