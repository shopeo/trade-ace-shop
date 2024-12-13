"use strict";
var _eventMore = false;

/* Functions base */
function after_load_ajax_list($, destroy_masonry) {
    var _destroy_masonry = typeof destroy_masonry !== 'undefined' ? destroy_masonry : false;
    
    /**
     * Trigger after load ajax - first event
     */
    $('body').trigger('tradeace_after_load_ajax_first', [_destroy_masonry]);
    
    /**
     * Init Top Categories
     */
    init_top_categories_filter($);
    
    /**
     * Init widgets
     */
    init_widgets($);
    
    /*
     * Parallax Breadcrumb
     */
    if (!_eventMore) {
        $('body').trigger('tradeace_parallax_breadcrum');
    }
    
    /**
     * init wishlist icons
     */
    init_wishlist_icons($);
    
    /**
     * init Compare icons
     */
    init_compare_icons($);
    
    _eventMore = false;
    
    $('body').trigger('tradeace_after_load_ajax');
}

/**
 * Tabs slide
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} exttime
 * @returns {undefined}
 */
function tradeace_tab_slide_style($, _this, exttime) {
    exttime = !exttime ? 500 : exttime;
    
    if ($(_this).find('.tradeace-slide-tab').length <= 0) {
        $(_this).append('<li class="tradeace-slide-tab"></li>');
    }
    
    var _tab = $(_this).find('.tradeace-slide-tab');
    var _act = $(_this).find('.tradeace-tab.active');
    
    if ($(_this).find('.tradeace-tab-icon').length) {
        $(_this).find('.tradeace-tab > a').css({'padding': '15px 30px'});
    }
    
    var _width_border = parseInt($(_this).css("border-top-width"));
    _width_border = !_width_border ? 0 : _width_border;
    
    var _pos = $(_act).position();
    $(_tab).show().animate({
        'height': $(_act).height() + (2*_width_border),
        'width': $(_act).width() + (2*_width_border),
        'top': _pos.top - _width_border,
        'left': _pos.left - _width_border
    }, exttime);
}

/**
 * Load Compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
var _compare_init = false;
function load_compare($) {
    if ($('#tradeace-compare-sidebar-content').length && !_compare_init) {
        _compare_init = true;
        
        if (
            typeof tradeace_ajax_params !== 'undefined' &&
            typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_load_compare');

            var _compare_table = $('.tradeace-wrap-table-compare').length ? true : false;
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    compare_table: _compare_table
                },
                beforeSend: function () {
                    
                },
                success: function (res) {
                    if (typeof res.success !== 'undefined' && res.success === '1') {
                        $('#tradeace-compare-sidebar-content').replaceWith(res.content);
                    }

                    $('.tradeace-compare-list-bottom').find('.tradeace-loader').remove();
                },
                error: function () {

                }
            });
        }
    }
}

/**
 * Add Compare
 * 
 * @param {type} _id
 * @param {type} $
 * @returns {undefined}
 */
function add_compare_product(_id, $) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_add_compare_product');
        
        var _compare_table = $('.tradeace-wrap-table-compare').length ? true : false;

        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                pid: _id,
                compare_table: _compare_table
            },
            beforeSend: function () {
                show_compare($);
                
                if ($('.tradeace-compare-list-bottom').find('.tradeace-loader').length <= 0) {
                    $('.tradeace-compare-list-bottom').append('<div class="tradeace-loader"></div>');
                }
            },
            success: function (res) {
                if (typeof res.result_compare !== 'undefined' && res.result_compare === 'success') {
                    if ($('#tradeace-compare-sidebar-content').length) {
                        if (res.mini_compare === 'no-change') {
                            load_compare($);
                        } else {
                            $('#tradeace-compare-sidebar-content').replaceWith(res.mini_compare);
                        }
                    } else {
                        if (res.mini_compare !== 'no-change' && $('.tradeace-compare-list').length) {
                            $('.tradeace-compare-list').replaceWith(res.mini_compare);
                        }
                    }
                    
                    if (res.mini_compare !== 'no-change') {
                        if ($('.tradeace-mini-number.compare-number').length) {
                            
                            $('.tradeace-mini-number.compare-number').html(convert_count_items($, res.count_compare));
                            if (res.count_compare === 0) {
                                if (!$('.tradeace-mini-number.compare-number').hasClass('tradeace-product-empty')) {
                                    $('.tradeace-mini-number.compare-number').addClass('tradeace-product-empty');
                                }
                            } else {
                                if ($('.tradeace-mini-number.compare-number').hasClass('tradeace-product-empty')) {
                                    $('.tradeace-mini-number.compare-number').removeClass('tradeace-product-empty');
                                }
                            }
                        }

                        $('.tradeace-compare-success').html(res.mess_compare);
                        $('.tradeace-compare-success').fadeIn(200);

                        if (_compare_table) {
                            $('.tradeace-wrap-table-compare').replaceWith(res.result_table);
                        }
                        
                    } else {
                        $('.tradeace-compare-exists').html(res.mess_compare);
                        $('.tradeace-compare-exists').fadeIn(200);
                    }

                    if (!$('.tradeace-compare[data-prod="' + _id + '"]').hasClass('added')) {
                        $('.tradeace-compare[data-prod="' + _id + '"]').addClass('added');
                    }

                    if (!$('.tradeace-compare[data-prod="' + _id + '"]').hasClass('tradeace-added')) {
                        $('.tradeace-compare[data-prod="' + _id + '"]').addClass('tradeace-added');
                    }

                    setTimeout(function () {
                        $('.tradeace-compare-success').fadeOut(200);
                        $('.tradeace-compare-exists').fadeOut(200);
                    }, 2000);
                }

                $('.tradeace-compare-list-bottom').find('.tradeace-loader').remove();
            },
            error: function () {

            }
        });
    }
}

/**
 * Remove Compare
 * 
 * @param {type} _id
 * @param {type} $
 * @returns {undefined}
 */
function remove_compare_product(_id, $) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_remove_compare_product');
        
        var _compare_table = $('.tradeace-wrap-table-compare').length ? true : false;

        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                pid: _id,
                compare_table: _compare_table
            },
            beforeSend: function () {
                if ($('.tradeace-compare-list-bottom').find('.tradeace-loader').length <= 0) {
                    $('.tradeace-compare-list-bottom').append('<div class="tradeace-loader"></div>');
                }
                
                if ($('table.tradeace-table-compare tr.remove-item td.tradeace-compare-view-product_' + _id).length) {
                    $('table.tradeace-table-compare').css('opacity', '0.3').prepend('<div class="tradeace-loader"></div>');
                }
            },
            success: function (res) {
                if (typeof res.result_compare !== 'undefined' && res.result_compare === 'success') {
                    if (res.mini_compare !== 'no-change' && $('#tradeace-compare-sidebar-content').length) {
                        $('#tradeace-compare-sidebar-content').replaceWith(res.mini_compare);
                    } else {
                        if (res.mini_compare !== 'no-change' && $('.tradeace-compare-list').length) {
                            $('.tradeace-compare-list').replaceWith(res.mini_compare);
                        }
                    }
                    
                    if (res.mini_compare !== 'no-change' && $('.tradeace-compare-list').length) {
                        $('.tradeace-compare[data-prod="' + _id + '"]').removeClass('added');
                        $('.tradeace-compare[data-prod="' + _id + '"]').removeClass('tradeace-added');
                        if ($('.tradeace-mini-number.compare-number').length) {
                            
                            $('.tradeace-mini-number.compare-number').html(convert_count_items($, res.count_compare));
                            if (res.count_compare === 0) {
                                if (!$('.tradeace-mini-number.compare-number').hasClass('tradeace-product-empty')) {
                                    $('.tradeace-mini-number.compare-number').addClass('tradeace-product-empty');
                                }
                            } else {
                                if ($('.tradeace-mini-number.compare-number').hasClass('tradeace-product-empty')) {
                                    $('.tradeace-mini-number.compare-number').removeClass('tradeace-product-empty');
                                }
                            }
                        }

                        $('.tradeace-compare-success').html(res.mess_compare);
                        $('.tradeace-compare-success').fadeIn(200);

                        if (_compare_table) {
                            $('.tradeace-wrap-table-compare').replaceWith(res.result_table);
                        }
                    } else {
                        $('.tradeace-compare-exists').html(res.mess_compare);
                        $('.tradeace-compare-exists').fadeIn(200);
                    }

                    setTimeout(function () {
                        $('.tradeace-compare-success').fadeOut(200);
                        $('.tradeace-compare-exists').fadeOut(200);
                        if (res.count_compare === 0) {
                            $('.tradeace-close-mini-compare').trigger('click');
                        }
                    }, 2000);
                }

                $('table.tradeace-table-compare').find('.tradeace-loader').remove();
                $('.tradeace-compare-list-bottom').find('.tradeace-loader').remove();
            },
            error: function() {

            }
        });
    }
}

/**
 * Remove All Compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
function remove_all_compare_product($) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_remove_all_compare');
        
        var _compare_table = $('.tradeace-wrap-table-compare').length ? true : false;
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                compare_table: _compare_table
            },
            beforeSend: function () {
                if ($('.tradeace-compare-list-bottom').find('.tradeace-loader').length <= 0) {
                    $('.tradeace-compare-list-bottom').append('<div class="tradeace-loader"></div>');
                }
            },
            success: function (res) {
                if (res.result_compare === 'success') {
                    if (res.mini_compare !== 'no-change' && $('.tradeace-compare-list').length) {
                        $('.tradeace-compare-list').replaceWith(res.mini_compare);
                        
                        $('.tradeace-compare').removeClass('added');
                        $('.tradeace-compare').removeClass('tradeace-added');
                        
                        if ($('.tradeace-mini-number.compare-number').length) {
                            $('.tradeace-mini-number.compare-number').html('0');
                            if (!$('.tradeace-mini-number.compare-number').hasClass('tradeace-product-empty')) {
                                $('.tradeace-mini-number.compare-number').addClass('tradeace-product-empty');
                            }
                        }

                        $('.tradeace-compare-success').html(res.mess_compare);
                        $('.tradeace-compare-success').fadeIn(200);

                        if (_compare_table) {
                            $('.tradeace-wrap-table-compare').replaceWith(res.result_table);
                        }
                    } else {
                        $('.tradeace-compare-exists').html(res.mess_compare);
                        $('.tradeace-compare-exists').fadeIn(200);
                    }

                    setTimeout(function () {
                        $('.tradeace-compare-success').fadeOut(200);
                        $('.tradeace-compare-exists').fadeOut(200);
                        $('.tradeace-close-mini-compare').trigger('click');
                    }, 1000);
                }

                $('.tradeace-compare-list-bottom').find('.tradeace-loader').remove();
            },
            error: function() {

            }
        });
    }
}

/**
 * Show compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
function show_compare($) {
    if ($('.tradeace-compare-list-bottom').length) {
        $('.transparent-window').show();
        
        if ($('.tradeace-show-compare').length && !$('.tradeace-show-compare').hasClass('tradeace-showed')) {
            $('.tradeace-show-compare').addClass('tradeace-showed');
        }
        
        if (!$('.tradeace-compare-list-bottom').hasClass('tradeace-active')) {
            $('.tradeace-compare-list-bottom').addClass('tradeace-active');
        }
    }
}

/**
 * Hide compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
function hide_compare($) {
    if ($('.tradeace-compare-list-bottom').length) {
        $('.transparent-window').fadeOut(550);
        
        if ($('.tradeace-show-compare').length && $('.tradeace-show-compare').hasClass('tradeace-showed')) {
            $('.tradeace-show-compare').removeClass('tradeace-showed');
        }
        
        $('.tradeace-compare-list-bottom').removeClass('tradeace-active');
    }
}

/**
 * Single add to cart
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} _id
 * @param {type} _quantity
 * @param {type} _type
 * @param {type} _variation_id
 * @param {type} _variation
 * @param {type} _data_wishlist
 * @returns {undefined|Boolean}
 */
function tradeace_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist) {
    var _form = $(_this).parents('form.cart');
    
    if (_type === 'grouped') {
        if ($(_form).length) {
            if ($(_form).find('.tradeace-custom-fields input[name="tradeace_cart_sidebar"]').length) {
                $(_form).find('.tradeace-custom-fields input[name="tradeace_cart_sidebar"]').val('1');
            } else {
                $(_form).find('.tradeace-custom-fields').append('<input type="hidden" name="tradeace_cart_sidebar" value="1" />');
            }
            
            $(_form).submit();
        }
        
        return;
    }
    
    /**
     * Ajax add to cart
     */
    else {
        if (
            typeof tradeace_ajax_params !== 'undefined' &&
            typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_single_add_to_cart');
            
            var _data = {
                product_id: _id,
                quantity: _quantity,
                product_type: _type,
                variation_id: _variation_id,
                variation: _variation,
                data_wislist: _data_wishlist
            };
            
            if ($(_form).length) {
                if (_type === 'simple') {
                    $(_form).find('.tradeace-custom-fields').append('<input type="hidden" name="add-to-cart" value="' + _id + '" />');
                }
                
                _data = $(_form).serializeArray();
                $(_form).find('.tradeace-custom-fields [name="add-to-cart"]').remove();
            }
            
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: _data,
                beforeSend: function () {
                    $(_this).removeClass('added');
                    $(_this).removeClass('tradeace-added');
                    $(_this).addClass('loading');
                },
                success: function (res) {
                    if (res.error) {
                        if ($(_this).hasClass('add-to-cart-grid')) {
                            var _href = $(_this).attr('href');
                            window.location.href = _href;
                        } else {
                            set_tradeace_notice($, res.message);
                            $(_this).removeClass('loading');
                        }
                    } else {
                        if (typeof res.redirect !== 'undefined' && res.redirect) {
                            window.location.href = res.redirect;
                        } else {
                            var fragments = res.fragments;
                            if (fragments) {
                                $.each(fragments, function (key, value) {
                                    $(key).addClass('updating');
                                    $(key).replaceWith(value);
                                });

                                if (!$(_this).hasClass('added')) {
                                    $(_this).addClass('added');
                                }

                                if (!$(_this).hasClass('tradeace-added')) {
                                    $(_this).addClass('tradeace-added');
                                }
                            }

                            if ($('.wishlist_sidebar').length) {
                                if (typeof res.wishlist !== 'undefined') {
                                    $('.wishlist_sidebar').replaceWith(res.wishlist);

                                    setTimeout(function() {
                                        init_wishlist_icons($, true);
                                    }, 350);

                                    if ($('.tradeace-mini-number.wishlist-number').length) {
                                        var sl_wislist = parseInt(res.wishlistcount);
                                        $('.tradeace-mini-number.wishlist-number').html(convert_count_items($, sl_wislist));
                                        if (sl_wislist > 0) {
                                            $('.tradeace-mini-number.wishlist-number').removeClass('tradeace-product-empty');
                                        }
                                        else if (sl_wislist === 0 && !$('.wishlist-number').hasClass('tradeace-product-empty')) {
                                            $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                                        }
                                    }

                                    if ($('.add-to-wishlist-' + _id).length) {
                                        $('.add-to-wishlist-' + _id).find('.yith-wcwl-add-button').show();
                                        $('.add-to-wishlist-' + _id).find('.yith-wcwl-wishlistaddedbrowse').hide();
                                        $('.add-to-wishlist-' + _id).find('.yith-wcwl-wishlistexistsbrowse').hide();
                                    }
                                }
                            }

                            if ($('.page-shopping-cart').length === 1) {
                                $.ajax({
                                    url: window.location.href,
                                    type: 'get',
                                    dataType: 'html',
                                    cache: false,
                                    data: {},
                                    success: function (res) {
                                        var $html = $.parseHTML(res);

                                        if ($('.tradeace-shopping-cart-form').length === 1) {
                                            var $new_form   = $('.tradeace-shopping-cart-form', $html);
                                            var $new_totals = $('.cart_totals', $html);
                                            var $notices    = $('.woocommerce-error, .woocommerce-message, .woocommerce-info', $html);
                                            $('.tradeace-shopping-cart-form').replaceWith($new_form);

                                            if ($notices.length) {
                                                $('.tradeace-shopping-cart-form').before($notices);
                                            }
                                            $('.cart_totals').replaceWith($new_totals);

                                        } else {
                                            var $new_content = $('.page-shopping-cart', $html);
                                            $('.page-shopping-cart').replaceWith($new_content);
                                        }

                                        $(document.body).trigger('updated_cart_totals');
                                        $(document.body).trigger('updated_wc_div');
                                        $('.tradeace-shopping-cart-form').find('input[name="update_cart"]').prop('disabled', true);
                                    }
                                });
                            }

                            $(document.body).trigger('added_to_cart', [res.fragments, res.cart_hash, _this]);
                        }
                    }
                }
            });
        }
    }
    
    return false;
}

/**
 * Bundle Yith popup
 * 
 * @param {type} $
 * @param {type} _this
 * @returns {undefined}
 */
function load_combo_popup($, _this) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_combo_products');
        
        var item = $(_this).parents('.product-item');
        if (!$(_this).hasClass('tradeaceing')) {
            $('.btn-combo-link').addClass('tradeaceing');
            var pid = $(_this).attr('data-prod');
            if (pid) {
                $.ajax({
                    url: _urlAjax,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        id: pid,
                        'title_columns': 2
                    },
                    beforeSend: function () {
                        $(item).append('<div class="tradeace-loader" style="top:50%"></div>');
                        $(item).find('.product-inner').css('opacity', '0.3');
                    },
                    success: function (res) {
                        $.magnificPopup.open({
                            mainClass: 'my-mfp-slide-bottom tradeace-combo-popup-wrap',
                            closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>',
                            items: {
                                src: '<div class="row tradeace-combo-popup tradeace-combo-row comboed-row zoom-anim-dialog" data-prod="' + pid + '">' + res.content + '</div>',
                                type: 'inline'
                            },
                            removalDelay: 300,
                            callbacks: {
                                afterClose: function() {

                                }
                            }
                        });

                        $('body').trigger('tradeace_load_slick_slider');

                        setTimeout(function () {
                            $('.btn-combo-link').removeClass('tradeaceing');
                            $(item).find('.tradeace-loader').remove();
                            $(item).find('.product-inner').css('opacity', '1');
                            if (!wow_enable) {
                                $('.tradeace-combo-popup').find('.product-item').css({'visibility': 'visible'});
                            } else {
                                var _data_animate, _delay;
                                $('.tradeace-combo-popup').find('.product-item').each(function() {
                                    var _this = $(this);
                                    _data_animate = $(_this).attr('data-wow');
                                    _delay = parseInt($(_this).attr('data-wow-delay'));
                                    $(_this).css({
                                        'visibility': 'visible',
                                        'animation-delay': _delay + 'ms',
                                        'animation-name': _data_animate
                                    }).addClass('animated');
                                });
                            }
                        }, 500);
                    },
                    error: function () {
                        $('.btn-combo-link').removeClass('tradeaceing');
                    }
                });
            }
        }
    }
}

/**
 * Main menu Reponsive
 * 
 * @param {type} $
 * @returns {undefined}
 */
function load_responsive_main_menu($) {
    if ($('.tradeace-menus-wrapper-reponsive').length) {
        var _wwin = $(window).width();
        
        $('.tradeace-menus-wrapper-reponsive').each(function() {
            var _this = $(this);
            
            var _tl = _wwin/1200;
            if (_tl < 1) {
                var _x = $(_this).attr('data-padding_x');
                var _params = {'font-size': (100*_tl).toString() + '%'};
                
                if (!$('body').hasClass('tradeace-rtl')) {
                    _params['margin-right'] = (_tl*_x).toString() + 'px';
                    _params['margin-left'] = '0';
                } else {
                    _params['margin-left'] = (_tl*_x).toString() + 'px';
                    _params['margin-right'] = '0';
                }

                $(_this).find('.header-nav > li > a').css(_params);
                
                if ($(_this).find('.tradeace-title-vertical-menu').length) {
                    $(_this).find('.tradeace-title-vertical-menu').css({
                        'font-size': (100*_tl).toString() + '%'
                    });
                }
            } else {
                $(_this).find('.header-nav > li > a').removeAttr('style');
                if ($(_this).find('.tradeace-title-vertical-menu').length) {
                    $(_this).find('.tradeace-title-vertical-menu').removeAttr('style');
                }
            }
        });
    }
}

/**
 * Mobile Menu
 * 
 * @type init_menu_mobile.mini_acc|init_menu_mobile.head_menu|StringMain menu
 * @param {type} $
 * @returns {undefined}
 */
function init_menu_mobile($) {
    if ($('#tradeace-menu-sidebar-content .tradeace-menu-for-mobile').length <= 0) {
        var _mobileDetect = $('input[name="tradeace_mobile_layout"]').length ? true : false;
        
        var _mobile_menu = '';

        if ($('.tradeace-to-menu-mobile').length) {
            $('.tradeace-to-menu-mobile').each(function() {
                var _this = $(this);
                _mobile_menu += $(_this).html();
                if (_mobileDetect) {
                    $(_this).remove();
                }
            });
        }

        else if ($('.header-type-builder .header-nav').length) {
            $('.header-type-builder .header-nav').each(function() {
                _mobile_menu += $(this).html();
            });
        }

        /**
         * Vertical menu in header
         */
        if ($('.tradeace-vertical-header .vertical-menu-wrapper').length){
            var ver_menu = $('.tradeace-vertical-header .vertical-menu-wrapper').html();
            var ver_menu_title = $('.tradeace-vertical-header .tradeace-title-vertical-menu').html();
            var ver_menu_warp = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-parent-item default-menu root-item tradeace-menu-none-event li_accordion"><a href="javascript:void(0);">' + ver_menu_title + '</a><div class="nav-dropdown-mobile"><ul class="sub-menu">' + ver_menu + '</ul></div></li>';
            
            if ($('.tradeace-vertical-header').hasClass('tradeace-focus-menu')) {
                _mobile_menu = ver_menu_warp + _mobile_menu;
            } else {
                _mobile_menu += ver_menu_warp;
            }
            
            if (_mobileDetect) {
                $('.tradeace-vertical-header').remove();
            }
        }

        /**
         * Heading
         */
        if ($('#heading-menu-mobile').length === 1) {
            _mobile_menu = '<li class="menu-item root-item menu-item-heading">' + $('#heading-menu-mobile').html() + '</li>' + _mobile_menu;
            
            if (_mobileDetect) {
                $('#heading-menu-mobile').remove();
            }
        }

        /**
         * Vertical Menu in content page
         */
        if ($('.tradeace-shortcode-menu.vertical-menu').length) {
            $('.tradeace-shortcode-menu.vertical-menu').each(function() {
                var _this = $(this);
                var ver_menu_sc = $(_this).find('.vertical-menu-wrapper').html();
                var ver_menu_title_sc = $(_this).find('.section-title').html();
                
                if (!$('#tradeace-menu-sidebar-content').hasClass('tradeace-light-new')) {
                    ver_menu_title_sc = '<h5 class="menu-item-heading margin-top-35 margin-bottom-10">' + ver_menu_title_sc + '</h5>';
                } else {
                    ver_menu_title_sc = '<a href="javascript:void(0);">' + ver_menu_title_sc + '</a>';
                }
                
                var ver_menu_warp_sc = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-parent-item default-menu root-item tradeace-menu-none-event li_accordion">' + ver_menu_title_sc + '<div class="nav-dropdown-mobile"><ul class="sub-menu">' + ver_menu_sc + '</ul></div></li>';
                
                _mobile_menu += ver_menu_warp_sc;
                
                if (_mobileDetect) {
                    $(_this).remove();
                }
            });
        }
        
        /**
         * Topbar menu
         */
        if ($('.tradeace-topbar-menu').length) {
            _mobile_menu += $('.tradeace-topbar-menu').html();
            
            if (_mobileDetect) {
                $('.tradeace-topbar-menu').remove();
            }
        }

        /**
         * Mobile account
         */
        if ($('#mobile-account').length === 1) {
            if ($('#tradeace-menu-sidebar-content').hasClass('tradeace-light-new') && $('#mobile-account').find('.tradeace-menu-item-account').length) {
                _mobile_menu += '<li class="menu-item root-item menu-item-account menu-item-has-children root-item">' + $('#mobile-account').find('.tradeace-menu-item-account').html() + '</li>';
            } else {
                _mobile_menu += '<li class="menu-item root-item menu-item-account">' + $('#mobile-account').html() + '</li>';
            }
            
            if (_mobileDetect) {
                $('#mobile-account').remove();
            }
        }

        /**
         * Switch language
         */
        var switch_lang = '';
        if ($('.header-switch-languages').length === 1) {
            switch_lang = $('.header-switch-languages').html();
            if (_mobileDetect) {
                $('.header-switch-languages').remove();
            }
        }

        if ($('.header-multi-languages').length) {
            switch_lang = $('.header-multi-languages').html();
            if (_mobileDetect) {
                $('.header-multi-languages').remove();
            }
        }

        if ($('#tradeace-menu-sidebar-content').hasClass('tradeace-light-new')) {
            _mobile_menu = '<ul id="mobile-navigation" class="header-nav tradeace-menu-accordion tradeace-menu-for-mobile">' + _mobile_menu + switch_lang + '</ul>';
        } else {
            _mobile_menu = '<ul id="mobile-navigation" class="header-nav tradeace-menu-accordion tradeace-menu-for-mobile">' + switch_lang + _mobile_menu + '</ul>';
        }

        if ($('#tradeace-menu-sidebar-content #mobile-navigation').length) {
            $('#tradeace-menu-sidebar-content #mobile-navigation').replaceWith(_mobile_menu);
        } else {
            $('#tradeace-menu-sidebar-content .tradeace-mobile-nav-wrap').append(_mobile_menu);
        }
        
        var _nav = $('#tradeace-menu-sidebar-content #mobile-navigation');
        
        if ($(_nav).find('.tradeace-select-currencies').length) {
            var _currency = $(_nav).find('.tradeace-select-currencies');
            var _class = $(_currency).find('.wcml_currency_switcher').attr('class');
            _class += ' menu-item-has-children root-item li_accordion';
            var _currencyObj = $(_currency).find('.wcml-cs-active-currency').clone();
            $(_currencyObj).addClass(_class);
            $(_currencyObj).find('.wcml-cs-submenu').addClass('sub-menu');
            
            $(_nav).find('.tradeace-select-currencies').replaceWith(_currencyObj);
        }

        $(_nav).find('.root-item > a').removeAttr('style');
        $(_nav).find('.nav-dropdown').attr('class', 'nav-dropdown-mobile').removeAttr('style');
        $(_nav).find('.nav-column-links').addClass('nav-dropdown-mobile');

        /**
         * Fix for tradeace-core not active.
         */
        $(_nav).find('.sub-menu').each(function() {
            if (!$(this).parent('.nav-dropdown-mobile').length) {
                $(this).wrap('<div class="nav-dropdown-mobile"></div>');
            }
        });

        $(_nav).find('.nav-dropdown-mobile').find('.sub-menu').removeAttr('style');
        $(_nav).find('hr.hr-tradeace-megamenu').remove();
        $(_nav).find('li').each(function(){
            if ($(this).hasClass('menu-item-has-children')){
                $(this).addClass('li_accordion');
                if ($(this).hasClass('current-menu-ancestor') || $(this).hasClass('current-menu-parent')){
                    $(this).addClass('active');
                    $(this).prepend('<a href="javascript:void(0);" class="accordion"></a>');
                } else {
                    $(this).prepend('<a href="javascript:void(0);" class="accordion"></a>').find('>.nav-dropdown-mobile').hide();
                }
            }
        });
        
        $(_nav).find('a').removeAttr('style');
        
        $('body').trigger('tradeace_after_load_mobile_menu');
    }
}

/**
 * position Mobile menu
 * 
 * @param {type} $
 * @returns {undefined}
 */
function position_menu_mobile($) {
    if ($('#tradeace-menu-sidebar-content').length) {
        if ($('#mobile-navigation').length && $('#mobile-navigation').attr('data-show') !== '1') {
            $('#tradeace-menu-sidebar-content').removeClass('tradeace-active');
                
            var _h_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;

            if (_h_adminbar > 0) {
                $('#tradeace-menu-sidebar-content').css({'top': _h_adminbar});
            }
        }
    }
}

/**
 * Resize Menu Vertical
 * 
 * @param {type} $
 * @returns {undefined}
 */
function resize_megamenu_vertical($) {
    if ($('.wide-nav .tradeace-vertical-header').length) {
        var _v_width = $('.wide-nav .tradeace-vertical-header').width();
        _v_width = _v_width < 280 ? 280: _v_width;
        $('.wide-nav .vertical-menu-container').css({'width': _v_width});
        if ($('.wide-nav .vertical-menu-container.tradeace-allways-show').length) {
            $('.wide-nav .vertical-menu-container.tradeace-allways-show').addClass('tradeace-active');
        }
    }
}

/**
 * Top categories filter
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_top_categories_filter($) {
    if ($('.tradeace-top-cat-filter').length) {
        var _act;
        var _obj;

        $('.tradeace-top-cat-filter').each(function() {
            var _this_filter = $(this);
            var _root_item = $(_this_filter).find('.root-item');
            _act = false;
            _obj = null;
            if ($(_root_item).length) {

                $(_root_item).each(function() {
                    var _this = $(this);
                    if ($(_this).hasClass('active')) {
                        $(_this).addClass('tradeace-current-top');
                        _obj =  $(_this);
                        _act = true;
                    }
                    
                    $(_this).find('.children .tradeace-current-note').remove();
                });

                if (!_act) {
                    $(_root_item).each(function() {
                        var _this = $(this);
                        if ($(_this).hasClass('cat-parent') && !_act) {
                            $(_this).addClass('tradeace-current-top');
                            _obj =  $(_this);
                            _act = true;
                        }
                    });
                }

                if (_obj !== null) {
                    var init_width = $(_obj).width();
                    if (init_width) {
                        var _pos = $(_obj).position();
                        var _note_act = $(_obj).parents('.tradeace-top-cat-filter').find('.tradeace-current-note');
                        $(_note_act).css({'visibility': 'visible', 'width': init_width, 'left': _pos.left, top: ($(_obj).height() - 1)});
                    }
                }
            }
        });
    }
}

/**
 * hover top categories filter
 * 
 * @param {type} $
 * @returns {undefined}
 */
function hover_top_categories_filter($) {
    $('body').on('mouseover', '.tradeace-top-cat-filter .root-item', function() {
        var _obj = $(this),
            _wrap = $(_obj).parents('.tradeace-top-cat-filter');
            
        $(_wrap).find('.root-item').removeClass('tradeace-current-top');
        $(_obj).addClass('tradeace-current-top');

        var _pos = $(_obj).position();
        var _note_act = $(_wrap).find('> .tradeace-current-note');
        
        $(_note_act).css({
            'visibility': 'visible',
            'width': $(_obj).width(),
            'left': _pos.left,
            top: ($(_obj).height() - 1)
        });
        
        return false;
    });
}

/**
 * hover top child categories filter
 * 
 * @param {type} $
 * @returns {undefined}
 */
function hover_chilren_top_catogories_filter($) {
    $('body').on('mouseover', '.tradeace-top-cat-filter .children .cat-item', function() {
        var _obj = $(this),
            _wrap = $(_obj).parent('.children');
        var _note_act = $(_wrap).find('>.tradeace-current-note');
        
        if ($(_note_act).length <= 0) {
            $(_wrap).prepend('<li class="tradeace-current-note" />');
            _note_act = $(_wrap).find('>.tradeace-current-note');
        }
        
        $(_wrap).find('.cat-item').removeClass('tradeace-current-child');
        $(_obj).addClass('tradeace-current-child');

        var _pos = $(_obj).position();
        $(_note_act).css({
            'visibility': 'visible',
            'width': $(_obj).width(),
            'left': _pos.left,
            top: ($(_obj).height() - 1)
        });
        
        return false;
    });
}

/**
 * Init Mini Wishlist Icon
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_mini_wishlist($) {
    if ($('input[name="tradeace_wishlist_cookie_name"]').length) {
        var _wishlistArr = get_wishlist_ids($);
        if (_wishlistArr.length) {
            if ($('.tradeace-mini-number.wishlist-number').length) {
                var sl_wislist = _wishlistArr.length;
                $('.tradeace-mini-number.wishlist-number').html(convert_count_items($, sl_wislist));
                
                if (sl_wislist > 0) {
                    $('.tradeace-mini-number.wishlist-number').removeClass('tradeace-product-empty');
                }
                
                if (sl_wislist === 0 && !$('.wishlist-number').hasClass('tradeace-product-empty')) {
                    $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                }
            }
        }
    }
}

/**
 * init Wishlist icons
 * 
 * @param {type} $
 * @param {type} init
 * @returns {undefined}
 */
function init_wishlist_icons($, init) {
    var _init = typeof init === 'undefined' ? false : init;
    
    /**
     * TradeaceTheme Wishlist
     */
    if ($('input[name="tradeace_wishlist_cookie_name"]').length) {
        var _wishlistArr = get_wishlist_ids($);
        if (_wishlistArr.length) {
            $('.btn-wishlist').each(function() {
                var _this = $(this);
                var _prod = $(_this).attr('data-prod');

                if (_wishlistArr.indexOf(_prod) !== -1) {
                    if (!$(_this).hasClass('tradeace-added')) {
                        $(_this).addClass('tradeace-added');
                    }

                    if (!$(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').addClass('added');
                    }
                }

                else if (_init) {
                    if ($(_this).hasClass('tradeace-added')) {
                        $(_this).removeClass('tradeace-added');
                    }

                    if ($(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').removeClass('added');
                    }
                }
            });
        }
    }
    
    /**
     * support Yith WooCommerce Wishlist
     */
    else {
    
        if (
            $('.wishlist_sidebar .wishlist_table').length ||
            $('.wishlist_sidebar .tradeace_yith_wishlist_premium-wrap .wishlist_table').length
        ) {
            var _wishlistArr = [];
            if ($('.wishlist_sidebar .wishlist_table .tradeace-tr-wishlist-item').length) {
                $('.wishlist_sidebar .wishlist_table .tradeace-tr-wishlist-item').each(function() {
                    _wishlistArr.push($(this).attr('data-row-id'));
                });
            }

            if ($('.wishlist_sidebar .tradeace_yith_wishlist_premium-wrap .wishlist_table tbody tr').length) {
                $('.wishlist_sidebar .tradeace_yith_wishlist_premium-wrap .wishlist_table tbody tr').each(function() {
                    _wishlistArr.push($(this).attr('data-row-id'));
                });
            }

            $('.btn-wishlist').each(function() {
                var _this = $(this);
                var _prod = $(_this).attr('data-prod');

                if (_wishlistArr.indexOf(_prod) !== -1) {
                    if (!$(_this).hasClass('tradeace-added')) {
                        $(_this).addClass('tradeace-added');
                    }

                    if (!$(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').addClass('added');
                    }
                }

                else if (_init) {
                    if ($(_this).hasClass('tradeace-added')) {
                        $(_this).removeClass('tradeace-added');
                    }

                    if ($(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').removeClass('added');
                    }
                }
            });
        }
    }
}

/**
 * init Compare icons
 * 
 * @param {type} $
 * @param {type} _init
 * @returns {undefined}
 */
function init_compare_icons($, _init) {
    var init = typeof _init !== 'undefined' ? _init : false;
    var _comparetArr = get_compare_ids($);
    
    if (init && $('.tradeace-mini-number.compare-number').length) {
        var _slCompare = _comparetArr.length;
        $('.tradeace-mini-number.compare-number').html(convert_count_items($, _slCompare));
        
        if (_slCompare <= 0) {
            if (!$('.tradeace-mini-number.compare-number').hasClass('tradeace-product-empty')) {
                $('.tradeace-mini-number.compare-number').addClass('tradeace-product-empty');
            }
        } else {
            $('.tradeace-mini-number.compare-number').removeClass('tradeace-product-empty');
        }
    }

    if (_comparetArr.length && $('.btn-compare').length) {
        $('.btn-compare').each(function() {
            var _this = $(this);
            var _prod = $(_this).attr('data-prod');

            if (_comparetArr.indexOf(_prod) !== -1) {
                if (!$(_this).hasClass('added')) {
                    $(_this).addClass('added');
                }
                if (!$(_this).hasClass('tradeace-added')) {
                    $(_this).addClass('tradeace-added');
                }
            } else {
                $(_this).removeClass('added');
                $(_this).removeClass('tradeace-added');
            }
        });
    }
}

/**
 * Auto fill text to input
 * 
 * @param {type} $
 * @param {type} _input
 * @param {type} index
 * @returns {undefined}
 */
function auto_fill_input_placeholder($, _input, index) {
    var _index = typeof index !== 'undefined' ? index : 0;
    if (_index === 0) {
        $(_input).trigger('focus');
    }
    
    if (!$(_input).hasClass('tradeace-placeholder')) {
        $(_input).addClass('tradeace-placeholder');
        var _place = $(_input).attr('placeholder');
        $(_input).attr('data-placeholder', _place);
    }
    
    var str = $(_input).attr('data-suggestions');
    
    if (str && _index <= str.length) {
        if (!$(_input).hasClass('tradeace-filling')) {
            $(_input).addClass('tradeace-filling');
        }
        
        $(_input).attr('placeholder', str.substr(0, _index++));
        
        setTimeout(function() {
            auto_fill_input_placeholder($, _input, _index);
        }, 90);
    } else {
        if (!$(_input).hasClass('tradeace-done')) {
            $(_input).addClass('tradeace-done');
        }
        
        $(_input).removeClass('tradeace-filling');
        
        setTimeout(function() {
            reverse_fill_input_placeholder($, _input);
        }, 400);
    }
}

/**
 * Reverse fill text to input
 * 
 * @param {type} $
 * @param {type} _input
 * @param {type} index
 * @returns {undefined}
 */
function reverse_fill_input_placeholder($, _input, index) {
    var _str = $(_input).attr('data-suggestions');
    var _index = typeof index !== 'undefined' ? index : (_str ? _str.length : 0);
    if (_index > 0) {
        $(_input).attr('placeholder', _str.substr(0, _index--));
        
        setTimeout(function() {
            reverse_fill_input_placeholder($, _input, _index);
        }, 20);
    } else {
        var _place = $(_input).attr('data-placeholder');
        $(_input).attr('placeholder', _place);
    }
}

/**
 * LOCK HOVER Add to cart
 * 
 * @param {type} $
 * @param {type} reset
 * @returns {undefined}
 */
function init_content_product_addtocart($, reset) {
    var _reset = typeof reset === 'undefined' ? false : reset;
    
    if (_reset) {
        $('.tradeace-product-more-hover').removeClass('tradeace-inited');
    }
    
    if ($('.tradeace-product-more-hover .add-to-cart-grid, .tradeace-product-more-hover .quick-view').length) {
        var toggleWidth = $('input[name="tradeace-toggle-width-add-to-cart"]').length ? parseInt($('input[name="tradeace-toggle-width-add-to-cart"]').val()) : 100;
        if (!toggleWidth) {
            toggleWidth = 100;
        }
        
        $('.tradeace-product-more-hover .add-to-cart-grid, .tradeace-product-more-hover .quick-view').each(function() {
            var _this = $(this);
            var _wrap = $(_this).parents('.tradeace-product-more-hover');
            if (!$(_wrap).hasClass('tradeace-inited')) {
                if ($(_this).width() < toggleWidth) {
                    $(_wrap).find('.quick-view .tradeace-icon').removeClass('hidden-tag');
                    $(_wrap).find('.quick-view .tradeace-text').addClass('hidden-tag');
                    
                    $(_wrap).find('.add-to-cart-grid .tradeace-icon').show();
                    $(_wrap).find('.add-to-cart-grid .tradeace-text').hide();
                } else {
                    $(_wrap).find('.quick-view .tradeace-icon').addClass('hidden-tag');
                    $(_wrap).find('.quick-view .tradeace-text').removeClass('hidden-tag');
                    
                    $(_wrap).find('.add-to-cart-grid .tradeace-icon').hide();
                    $(_wrap).find('.add-to-cart-grid .tradeace-text').show();
                }
                
                $(_wrap).addClass('tradeace-inited');
            }
        });
    }
}

/**
 * Event after added to cart
 * Popup Your Order
 * 
 * @param {type} $
 * @returns {undefined}
 */
function after_added_to_cart($) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_after_add_to_cart');
        
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                'tradeace_action': 'tradeace_after_add_to_cart'
            },
            beforeSend: function () {
                
            },
            success: function (response) {
                if (response.success === '1') {
                    if ($('.tradeace-after-add-to-cart-popup').length) {
                        $('.tradeace-after-add-to-cart-popup .tradeace-after-add-to-cart-wrap').html(response.content);
                        if ($('.tradeace-after-add-to-cart-popup .tradeace-slick-slider').length) {
                            after_load_ajax_list($, false);
                        }
                    }
                    else {
                        $.magnificPopup.open({
                            items: {
                                src: '<div class="tradeace-after-add-to-cart-popup tradeace-bot-to-top"><div class="tradeace-after-add-to-cart-wrap">' + response.content + '</div></div>',
                                type: 'inline'
                            },
                            // tClose: $('input[name="tradeace-close-string"]').val(),
                            closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>',
                            callbacks: {
                                open: function() {
                                    if ($('.tradeace-after-add-to-cart-popup .tradeace-slick-slider').length) {
                                        after_load_ajax_list($, false);
                                    }
                                },
                                beforeClose: function() {
                                    this.st.removalDelay = 350;
                                }
                            }
                        });
                    }

                    setTimeout(function() {
                        $('.after-add-to-cart-shop_table').addClass('shop_table');
                        $('.tradeace-table-wrap').addClass('tradeace-active');
                    }, 100);
                    
                    $('.black-window').trigger('click');
                } else {
                    $.magnificPopup.close();
                }
                
                $('.tradeace-after-add-to-cart-wrap').removeAttr('style');
                $('.tradeace-after-add-to-cart-wrap').removeClass('processing');
                
                setTimeout(function() {
                    init_shipping_free_notification($);
                }, 300);
            },
            error: function () {
                $.magnificPopup.close();
            }
        });
    }
}

/**
 * Reload MiniCart
 * 
 * @param {type} $
 * @returns {undefined}
 */
function reload_mini_cart($) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_reload_fragments');
        
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                time: new Date().getTime()
            },
            success: function (data) {
                if (data && data.fragments) {

                    $.each(data.fragments, function(key, value) {
                        if ($(key).length) {
                            $(key).replaceWith(value);
                        }
                    });

                    if (typeof $supports_html5_storage !== 'undefined' && $supports_html5_storage) {
                        sessionStorage.setItem(
                            wc_cart_fragments_params.fragment_name,
                            JSON.stringify(data.fragments)
                        );
                        set_cart_hash(data.cart_hash);

                        if (data.cart_hash) {
                            set_cart_creation_timestamp();
                        }
                    }

                    $(document.body).trigger('wc_fragments_refreshed');
                    
                    /**
                     * notification free shipping
                     */
                    init_shipping_free_notification($);
                }

                $('#cart-sidebar').find('.tradeace-loader').remove();
            },
            error: function () {
                $(document.body).trigger('wc_fragments_ajax_error');
                $('#cart-sidebar').find('.tradeace-loader').remove();
            }
        });
    }
}

/**
 * Init Shipping free notification
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_shipping_free_notification($) {
    if ($('.tradeace-total-condition').length) {
        $('.tradeace-total-condition').each(function() {
            if (!$(this).hasClass('tradeace-active')) {
                $(this).addClass('tradeace-active');
                var _per = $(this).attr('data-per');
                $(this).find('.tradeace-total-condition-hint, .tradeace-subtotal-condition').css({'width': _per + '%'});
            }
        });
    }
}

/**
 * Init Widgets Toggle
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_widgets($) {
    if ($('.widget').length && !$('body').hasClass('tradeace-disable-toggle-widgets')) {
        $('.widget').each(function() {
            var _this = $(this);
            if (!$(_this).hasClass('tradeace-inited')) {

                var _key = $(_this).attr('id');

                var _title = '';

                if ($(_this).find('.widget-title').length) {
                    _title = $(_this).find('.widget-title').clone();
                    $(_this).find('.widget-title').remove();
                }

                if (_key && _title !== '') {
                    var _cookie = $.cookie(_key);
                    var _a_toggle = '<a href="javascript:void(0);" class="tradeace-toggle-widget"></a>';
                    var _wrap = '<div class="tradeace-open-toggle"></div>';
                    if (_cookie === 'hide') {
                        _a_toggle = '<a href="javascript:void(0);" class="tradeace-toggle-widget tradeace-hide"></a>';
                        _wrap = '<div class="tradeace-open-toggle widget-hidden"></div>';
                    }
                    
                    $(_this).wrapInner(_wrap);
                    
                    $(_this).prepend(_a_toggle);
                    $(_this).prepend(_title);
                }

                $(_this).addClass('tradeace-inited');
            }
        });
    }
}

/**
 * init Notices
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_tradeace_notices($) {
    if ($('.woocommerce-notices-wrapper').length) {
        $('.woocommerce-notices-wrapper').each(function() {
            if ($(this).find('*').length && $(this).find('.tradeace-close-notice').length <= 0) {
                $(this).append('<a class="tradeace-close-notice" href="javascript:void(0);"></a>');
            }
        });
    }
}

/**
 * set Notice
 * 
 * @param {type} $
 * @param {type} content
 * @returns {undefined}
 */
function set_tradeace_notice($, content) {
    if ($('.woocommerce-notices-wrapper').length <= 0) {
        $('body').append('<div class="woocommerce-notices-wrapper"></div>');
    }

    $('.woocommerce-notices-wrapper').html(content);
    init_tradeace_notices($);
}

/**
 * 
 * @param {type} $
 * @returns {undefined}get Compare ids
 */
function get_compare_ids($) {
    if ($('input[name="tradeace_woocompare_cookie_name"]').length) {
        var _cookie_compare = $('input[name="tradeace_woocompare_cookie_name"]').val();
        var _pids = $.cookie(_cookie_compare);
        if (_pids) {
            _pids = _pids.replace('[','').replace(']','').split(",").map(String);
            
            if (_pids.length === 1 && !_pids[0]) {
                return [];
            }
        }
        
        return typeof _pids !== 'undefined' && _pids.length ? _pids : [];
    } else {
        return [];
    }
}

/**
 * 
 * @param {type} $
 * @returns {undefined}get Compare ids
 */
function get_wishlist_ids($) {
    if ($('input[name="tradeace_wishlist_cookie_name"]').length) {
        var _cookie_wishlist = $('input[name="tradeace_wishlist_cookie_name"]').val();
        var _pids = $.cookie(_cookie_wishlist);
        if (_pids) {
            _pids = _pids.replace('[', '').replace(']', '').split(",").map(String);
            
            if (_pids.length === 1 && !_pids[0]) {
                return [];
            }
        }
        
        return typeof _pids !== 'undefined' && _pids.length ? _pids : [];
    } else {
        return [];
    }
}

/**
 * Load Wishlist
 */
var _wishlist_init = false;
function load_wishlist($) {
    if ($('#tradeace-wishlist-sidebar-content').length && !_wishlist_init) {
        _wishlist_init = true;
        
        if (
            typeof tradeace_ajax_params !== 'undefined' &&
            typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_load_wishlist');
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {},
                beforeSend: function () {
                    
                },
                success: function (res) {
                    if (typeof res.success !== 'undefined' && res.success === '1') {
                        $('#tradeace-wishlist-sidebar-content').replaceWith(res.content);
                        
                        if ($('.tradeace-tr-wishlist-item.item-invisible').length) {
                            var _remove = [];
                            $('.tradeace-tr-wishlist-item.item-invisible').each(function() {
                                var product_id = $(this).attr('data-row-id');
                                if (product_id) {
                                    _remove.push(product_id);
                                }
                                
                                $(this).remove();
                            });
                            
                            var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_remove_wishlist_hidden');
                            
                            $.ajax({
                                url: _urlAjax,
                                type: 'post',
                                dataType: 'json',
                                cache: false,
                                data: {
                                    product_ids: _remove
                                },
                                beforeSend: function () {

                                },
                                success: function (response) {
                                    if (typeof response.success !== 'undefined' && response.success === '1') {
                                        var sl_wislist = parseInt(response.count);
                                        $('.tradeace-mini-number.wishlist-number').html(convert_count_items($, sl_wislist));
                                        if (sl_wislist > 0) {
                                            $('.tradeace-mini-number.wishlist-number').removeClass('tradeace-product-empty');
                                        }
                                        else if (sl_wislist === 0 && !$('.tradeace-mini-number.wishlist-number').hasClass('tradeace-product-empty')) {
                                            $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                                        }
                                    }
                                },
                                error: function () {

                                }
                            });
                        }
                    }
                },
                error: function () {

                }
            });
        }
    }
}

/**
 * Add wishlist item TradeaceTheme Wishlist
 * @param {type} $
 * @param {type} _pid
 * @returns {undefined}
 */
var _tradeace_clear_notice_wishlist;
function tradeace_process_wishlist($, _pid, _action) {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', _action);
        
        var _data = {
            product_id: _pid
        };
        
        if ($('.widget_shopping_wishlist_content').length) {
            _data['show_content'] = '1';
        }
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function () {
                if ($('.tradeace-close-notice').length) {
                    $('.tradeace-close-notice').trigger('click');
                }
                
                if (typeof _tradeace_clear_notice_wishlist !== 'undefined') {
                    clearTimeout(_tradeace_clear_notice_wishlist);
                }
            },
            success: function (res) {
                if (typeof res.success !== 'undefined' && res.success === '1') {
                    var sl_wislist = parseInt(res.count);
                    $('.tradeace-mini-number.wishlist-number').html(convert_count_items($, sl_wislist));
                    if (sl_wislist > 0) {
                        $('.tradeace-mini-number.wishlist-number').removeClass('tradeace-product-empty');
                    }
                    else if (sl_wislist === 0 && !$('.tradeace-mini-number.wishlist-number').hasClass('tradeace-product-empty')) {
                        $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                    }
                    
                    if (_action === 'tradeace_add_to_wishlist') {
                        $('.btn-wishlist[data-prod="' + _pid + '"]').each(function() {
                            if (!$(this).hasClass('tradeace-added')) {
                                $(this).addClass('tradeace-added');
                            }
                        });
                    }
                    
                    if (_action === 'tradeace_remove_from_wishlist') {
                        $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('tradeace-added');
                    }
                    
                    if ($('.widget_shopping_wishlist_content').length && typeof res.content !== 'undefined' && res.content) {
                        $('.widget_shopping_wishlist_content').replaceWith(res.content);
                    }

                    if (typeof res.mess !== 'undefined' && res.mess) {
                        set_tradeace_notice($, res.mess);
                    }

                    _tradeace_clear_notice_wishlist = setTimeout(function() {
                        if ($('.tradeace-close-notice').length) {
                            $('.tradeace-close-notice').trigger('click');
                        }
                    }, 5000);
                    
                    $('body').trigger('tradeace_processed_wishlish', [_pid, _action]);
                }
                
                $('.btn-wishlist').removeClass('tradeace-disabled');
            },
            error: function () {
                $('.btn-wishlist').removeClass('tradeace-disabled');
            }
        });
    }
}

/**
 * Convert Count Items
 * 
 * @param {type} number
 * @returns {String}
 */
function convert_count_items($, number) {
    var _number = parseInt(number);
    if ($('input[name="tradeace_less_total_items"]').length && $('input[name="tradeace_less_total_items"]').val() === '1') {
        return _number > 9 ? '9+' : _number.toString();
    } else {
        return _number.toString();
    }
}

/**
 * add class single product button add to cart
 * 
 * @param {type} $
 * @returns {undefined}
 */
function add_class_btn_single_button($) {
    if ($('.cart input[type="hidden"][name="quantity"]').length) {
        $('.cart input[type="hidden"][name="quantity"]').each(function() {
            var _wrap = $(this).parents('.cart');
            if ($(_wrap).find('.single_add_to_cart_button').length) {
                $(_wrap).find('.single_add_to_cart_button').addClass('tradeace-fullwidth');
            }
        });
    }
}

/**
 * Animate Scroll to Top
 * 
 * @param {type} $
 * @param {type} _dom
 * @param {type} _ms
 * @returns {undefined}
 */
function animate_scroll_to_top($, _dom, _ms) {
    var ms = typeof _ms === 'undefined' ? 500 : _ms;
    var _pos_top = 0;
    if (typeof _dom !== 'undefined' && _dom && $(_dom).length) {
        _pos_top = $(_dom).offset().top;
    }

    if (_pos_top) {
        if ($('body').find('.tradeace-header-sticky').length && $('.sticky-wrapper').length) {
            _pos_top = _pos_top - 100;
        }

        if ($('#wpadminbar').length) {
            _pos_top = _pos_top - $('#wpadminbar').height();
        }
        
        _pos_top = _pos_top - 10;
    }

    $('html, body').animate({scrollTop: _pos_top}, ms);
}

/**
 * init accordion
 */
function init_accordion($) {
    if ($('.tradeace-accordions-content .tradeace-accordion-title a').length) {
        $('.tradeace-accordions-content').each(function() {
            if (!$(this).hasClass('tradeace-inited')) {
                $(this).addClass('tradeace-inited');
                
                if ($(this).hasClass('tradeace-accodion-first-hide')) {
                    $(this).find('.tradeace-accordion.first').removeClass('active');
                    $(this).find('.tradeace-panel.first').removeClass('active');
                    $(this).removeClass('tradeace-accodion-first-hide');
                } else {
                    $(this).find('.tradeace-panel.first.active').slideDown(200);
                }
            }
        });
    }
}

/**
 * init Header Responsive
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_header_responsive($) {
    if ($('#tmpl-tradeace-responsive-header').length && ($('.tradeace-menu-off').length || ($('.tradeace-mobile-check').length && $('.tradeace-mobile-check').width()))) {
        if ($('#masthead').length && $('#masthead').find('.header-responsive').length <= 0) {
            var _header = $('#tmpl-tradeace-responsive-header').html();
            if (_header !== '') {
                $('#masthead').prepend(_header);
            }
        }
    }
}
