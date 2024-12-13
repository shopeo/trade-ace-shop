var top_bar_left_df = '';
var content_custom_df = '';

jQuery(document).ready(function($){
    "use strict";
    loadListIcons($);
    
    var text_now = $('textarea#topbar_left').val();
    $('body').on('click', '.reset_topbar_left', function(){
        if($('textarea#topbar_left').val() !== top_bar_left_df){
            var _confirm = confirm('Are you sure to reset top bar left ?');

            if(_confirm){
                $('textarea#topbar_left').val(top_bar_left_df);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.restore_topbar_left', function(){
        if(text_now !== $('textarea#topbar_left').val()){
            var _confirm = confirm('Are you sure to restore top bar left ?');

            if(_confirm){
                $('textarea#topbar_left').val(text_now);
            }
        }
        
        return false;
    });
    
    var text_content_now = $('textarea#content_custom').val();
    $('body').on('click', '.reset_content_custom', function(){
        if($('textarea#content_custom').val() !== content_custom_df){
            var _confirm = confirm('Are you sure to reset your content custom ?');

            if(_confirm){
                $('textarea#content_custom').val(content_custom_df);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.restore_content_custom', function(){
        if(text_content_now !== $('textarea#content_custom').val()){
            var _confirm = confirm('Are you sure to restore your content custom ?');

            if(_confirm){
                $('textarea#content_custom').val(text_content_now);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.toggle-choose-icon-btn', function() {
        $(this).parents('.widget-content').find('.toggle-choose-icon').toggleClass('hidden-tag');
    });
    
    $('body').on('click', '.tradeace-chosen-icon', function() {
        var _fill = $(this).attr('data-fill');
        if (_fill) {
            if ($('.tradeace-list-icons-select').length < 1) {
                $.ajax({
                    url: ajaxurl,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        action: 'tradeace_list_fonts_admin',
                        fill: _fill
                    },
                    success: function(res){
                        $('body').append(res);
                        $('body').append('<div class="tradeace-tranparent" />');
                        $('.tradeace-list-icons-select').animate({right: 0}, 300);
                    }
                });
            } else {
                $('body').append('<div class="tradeace-tranparent" />');
                $('.tradeace-list-icons-select').attr('data-fill', _fill);
                $('.tradeace-list-icons-select').animate({right: 0}, 300);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.tradeace-tranparent', function (){
        if ($('.tradeace-list-icons-select').length) {
            $('.tradeace-list-icons-select').animate({right: '-500px'}, 300);
        }
        $(this).remove();
    });
    
    // Search icons
    $('body').on('keyup', '.tradeace-input-search-icon', function (){
        searchIcons($);
    });
    
    $('body').on('click', '.tradeace-fill-icon', function (){
        var _val = $(this).attr('data-val');
        var _fill = $(this).parent().attr('data-fill');
        
        if($('#'+_fill).length) {
            $('#'+_fill).val(_val);
        }
        
        if($('input[name="'+_fill+'"]').length) {
            $('input[name="'+_fill+'"]').val(_val);
        }
        
        if($('#ico-'+_fill).length){
            $('#ico-'+_fill).html('<i class="' + _val + '"></i><a href="javascript:void(0);" class="tradeace-remove-icon" data-id="' + _fill + '"><i class="fa fa-remove"></i></a>');
        }
        
        $('.tradeace-tranparent').click();
    });
    
    $('body').on('click', '.tradeace-remove-icon', function(){
        var _fill = $(this).attr('data-id');
        
        if ($('#'+_fill).length) {
            $('#'+_fill).val('');
        }
        
        if ($('input[name="'+_fill+'"]').length) {
            $('input[name="'+_fill+'"]').val('');
        }
        
        if ($('#ico-'+_fill).length) {
            $('#ico-'+_fill).html('');
        }
    });
    
    loadColorPicker($);
    $('.widget-control-save').ajaxComplete(function(){
        loadColorPicker($);
    });
    
    $(document).ajaxComplete(function(){
        if($('input[name="section_tradeace_icon"]').length) {
            $('input[name="section_tradeace_icon"]').attr('readonly', true);
        }
    });
    
    $('body').on('change', '.tradeace-select-attr', function(){
        var _warp = $(this).parents('.widget-content');
        if ($(_warp).find('.tradeace-vari-type').val() === '1') {
            var taxonomy = $(this).val(),
                num = $(this).attr('data-num'),
                instance = $(_warp).find('.tradeace-widget-instance').attr('data-instance');
            loadColorDefault($, _warp, taxonomy, num, instance, false);
        }
        
        return true;
    });
    
    $('body').on('change', '.tradeace-vari-type', function() {
        var _warp = $(this).parents('.widget-content'),
            taxonomy = $(_warp).find('.tradeace-select-attr').val(),
            num = $(_warp).find('.tradeace-select-attr').attr('data-num'),
            instance = $(_warp).find('.tradeace-widget-instance').attr('data-instance');
        if ($(this).val() === '1') {  
            loadColorDefault($, _warp, taxonomy, num, instance, true);
        } else {
            unloadColor($, _warp);
        }
        
        return true;
    });
    
    // Option Breadcrumb
    if($('.tradeace-breadcrumb-flag-option input[type="checkbox"]').is(':checked')){
	$('.tradeace-breadcrumb-type-option').show();
        $('.tradeace-breadcrumb-align-option').show();
	if($('.tradeace-breadcrumb-type-option').find('select').val() === 'has-background'){
	    $('.tradeace-breadcrumb-bg-option').show();
            // $('.tradeace-breadcrumb-bg-lax').show();
	    loadImgOpBreadcrumb($);
	}
    }
    
    $('body').on('change', '.tradeace-breadcrumb-flag-option input[type="checkbox"]', function(){
	if($(this).is(':checked')){
	    $('.tradeace-breadcrumb-type-option').fadeIn(200);
            $('.tradeace-breadcrumb-align-option').fadeIn(200);
	    if($('.tradeace-breadcrumb-type-option').find('select').val() === 'has-background'){
		$('.tradeace-breadcrumb-bg-option').fadeIn(200);
                // $('.tradeace-breadcrumb-bg-lax').fadeIn(200);
		loadImgOpBreadcrumb($);
	    }
	} else {
	    $('.tradeace-breadcrumb-type-option').fadeOut(200);
	    $('.tradeace-breadcrumb-bg-option').fadeOut(200);
            // $('.tradeace-breadcrumb-bg-lax').fadeOut(200);
            $('.tradeace-breadcrumb-align-option').fadeOut(200);
	}
    });
    
    $('body').on('change', '.tradeace-breadcrumb-type-option select', function() {
	if ($(this).val() === 'has-background') {
	    $('.tradeace-breadcrumb-bg-option').fadeIn(200);
	    $('.tradeace-breadcrumb-color-option').fadeIn(200);
            // $('.tradeace-breadcrumb-bg-lax').fadeIn(200);
	    $('.tradeace-breadcrumb-height-option').fadeIn(200);
            $('.tradeace-breadcrumb-text-option').fadeIn(200);
	    loadImgOpBreadcrumb($);
	} else {
	    $('.tradeace-breadcrumb-bg-option').fadeOut(200);
	    $('.tradeace-breadcrumb-color-option').fadeOut(200);
            // $('.tradeace-breadcrumb-bg-lax').fadeOut(200);
	    $('.tradeace-breadcrumb-height-option').fadeOut(200);
	    $('.tradeace-breadcrumb-text-option').fadeOut(200);
	}
    });
    
    if ($('.type_promotion select').length) {
        var val_promotion = $('.type_promotion select').val();
        if (val_promotion === 'custom') {
            $('.tradeace-custom_content').show();
        } else if (val_promotion === 'list-posts') {
            $('.tradeace-list_post').show();
        }
        $('body').on('change', '.type_promotion select', function() {
            var val_promotion = $(this).val();
            if(val_promotion === 'custom'){
                $('.tradeace-custom_content').fadeIn(200);
                $('.tradeace-list_post').fadeOut(200);
            } else if(val_promotion === 'list-posts') {
                $('.tradeace-custom_content').fadeOut(200);
                $('.tradeace-list_post').fadeIn(200);
            }
        });
    }
    
    if ($('.tradeace-header-type-select input[type="radio"][name="header-type"]').length > 0) {
        var _val_header = $('.tradeace-header-type-select input[type="radio"][name="header-type"]:checked').val();
        $('.tradeace-header-type-select-' + _val_header).slideDown(200);
        
        $('body').on('click', '.tradeace-header-type-select img.of-radio-img-img', function() {
            var _val_header = $('.tradeace-header-type-select input[type="radio"][name="header-type"]:checked').val();
            $('.tradeace-header-type-select-' + _val_header).slideDown(200);
            $('.tradeace-header-type-child').each(function() {
                if(!$(this).hasClass('tradeace-header-type-select-' + _val_header)) {
                    $(this).slideUp(200);
                }
            });
        });
    }
    
    if ($('.tradeace-type-font select').length) {
        var _val_font = $('.tradeace-type-font select').val();
        $('.tradeace-type-font-' + _val_font).slideDown(200);
        
        $('body').on('change', '.tradeace-type-font select', function() {
            var _val_font = $(this).val();
            $('.tradeace-type-font-glb').slideUp(200);
            $('.tradeace-type-font-' + _val_font).slideDown(200);
        });
    }
    
    $('.tradeace-theme-option-parent select').each(function() {
        var _val = $(this).val();
        var _id = $(this).attr('id');
        $('.tradeace-' + _id + '.tradeace-theme-option-child').hide();
        $('.tradeace-' + _id + '-' + _val + '.tradeace-theme-option-child').show();
    });
    $('body').on('change', '.tradeace-theme-option-parent select', function() {
        var _val = $(this).val();
        var _id = $(this).attr('id');
        $('.tradeace-' + _id + '.tradeace-theme-option-child').slideUp(200);
        $('.tradeace-' + _id + '-' + _val + '.tradeace-theme-option-child').slideDown(200);
    });
    
    if ($('.tradeace-topbar_toggle input[type="checkbox"]').is(':checked')) {
	$('.tradeace-topbar_df-show').show();
    }
    
    $('body').on('change', '.tradeace-topbar_toggle input[type="checkbox"]', function() {
	if ($(this).is(':checked')) {
	    $('.tradeace-topbar_df-show').slideDown(200);
	} else {
	    $('.tradeace-topbar_df-show').slideUp(200);
	}
    });
    
    $('body').on('click', '.tradeace-check-intagram', function() {
        var _wrap = $(this).parents('.section');
        var _token = $(_wrap).find('input.tradeace_instagram').val();
        if (_token) {
            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'tradeace_check_instagram_token',
                    access_token: _token
                },
                success: function(res) {
                    if (res.error === '0') {
                        $(_wrap).find('.of-intagram-acc').html(res.output);
                        $(_wrap).find('input.tradeace_instagram_info').val(res.info);
                        $(_wrap).find('.tradeace-remove-intagram').removeClass('hidden-tag');
                        $(_wrap).find('.tradeace-check-intagram, .tradeace-get-intagram, input.tradeace_instagram').addClass('hidden-tag');
                    }
                }
            });
        } else {
            alert('Please Get and Enter Instagram Access Token!');
        }
    });
    
    $('body').on('click', '.tradeace-remove-intagram', function() {
        var _wrap = $(this).parents('.section');
        $(_wrap).find('input.tradeace_instagram').val('');
        $(_wrap).find('input.tradeace_instagram_info').val('');
        $(_wrap).find('.of-intagram-acc').html('');
        $(this).addClass('hidden-tag');
        $(_wrap).find('.tradeace-check-intagram, .tradeace-get-intagram, input.tradeace_instagram').removeClass('hidden-tag');
    });
    
    /* =============== End document ready !!! ================== */
});

function loadImgOpBreadcrumb($){
    if ($('.tradeace-breadcrumb-bg-option .screenshot').length && $('.tradeace-breadcrumb-bg-option #breadcrumb_bg_upload').val() !== '') {
	if ($('.tradeace-breadcrumb-bg-option .screenshot').html() === '') {
	    $('.tradeace-breadcrumb-bg-option .screenshot').html('<img class="of-option-image" src="' + $('.tradeace-breadcrumb-bg-option #breadcrumb_bg_upload').val() + '" />');
	    $('.upload_button_div .remove-image').removeClass('hide').show();
	}
    }
}

function loadColorDefault($, _warp, _taxonomy, _num, _instance, _check){
    if(_check && $(_warp).find('.tradeace_p_color').length){
        var _this = $(_warp).find('.tradeace_p_color');
        $(_this).find('input').prop('disabled', false);
        $(_this).show();
    }else{
        _instance = _instance.toLocaleString();
        $.ajax({
	    url: ajaxurl,
	    type: 'post',
	    dataType: 'html',
	    data: {
		action: 'tradeace_list_colors_admin',
                taxonomy: _taxonomy,
		num: _num,
                instance: _instance
	    },
	    success: function(res) {
                $(_warp).find('.tradeace_p_color').remove();
		$(_warp).append(res);
                loadColorPicker($);
	    }
	});
    }
}

function unloadColor($, _warp){
    var _this = $(_warp).find('.tradeace_p_color');
    $(_this).find('input').prop('disabled', true);
    $(_this).hide();
}

function loadColorPicker($){
    $('.tradeace-color-field').each(function(){
        if ($(this).parents('.wp-picker-container').length < 1) {
            $(this).wpColorPicker();
        }
    });
};

function loadListIcons($) {
    if ($('.tradeace-list-icons-select').length < 1) {
	$.ajax({
	    url: ajaxurl,
	    type: 'get',
	    dataType: 'html',
	    data: {
		action: 'tradeace_list_fonts_admin',
		fill: ''
	    },
	    success: function(res){
		$('body').append(res);
	    }
	});
    }
};

function searchIcons($){
    var _textsearch = $.trim($('.tradeace-input-search-icon').val());
    if (_textsearch === '') {
        $('.tradeace-font-icons').fadeIn(200);
    } else {
        var patt = new RegExp(_textsearch);
        $('.tradeace-font-icons').each(function (){
            var _sstext = $(this).attr('data-text');
            if (patt.test(_sstext)) {
                $(this).fadeIn(200);
            } else {
                $(this).fadeOut(200);
            }
        });
    }
}
