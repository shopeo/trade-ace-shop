/**
 * Document ready
 * 
 * Filter Ajax in store
 */
var shop_load = false,
    archive_page = 1,
    infinitiAjax = false,
    _scroll_to_top = false,
    _queue_trigger = {};
    
if (typeof _cookie_live === 'undefined') {
    var _cookie_live = 7;
}
    
jQuery(document).ready(function($) {
"use strict";

/**
 * Crazy Loading
 */
if ($('.tradeace-crazy-load.crazy-loading').length) {
    $('.tradeace-crazy-load.crazy-loading').removeClass('crazy-loading');
}

/**
 * Scroll load more
 */
$(window).scroll(function() {
    var scrollTop = $(this).scrollTop();
    
    if (
        $('#tradeace-wrap-archive-loadmore.tradeace-infinite-shop').length &&
        $('#tradeace-wrap-archive-loadmore.tradeace-infinite-shop').find('.tradeace-archive-loadmore').length === 1
    ) {
        var infinitiOffset = $('#tradeace-wrap-archive-loadmore').offset();
        
        if (!infinitiAjax) {
            if (scrollTop + $(window).height() >= infinitiOffset.top) {
                infinitiAjax = true;
                $('#tradeace-wrap-archive-loadmore.tradeace-infinite-shop').find('.tradeace-archive-loadmore').trigger('click');
            }
        }
    }
});

/**
 * Clone group btn for list layout
 */
clone_group_btns_product_item($);
$('body').on('tradeace_store_changed_layout_list', function() {
    clone_group_btns_product_item($);
});

/**
 * Top filter actived
 */
if ($('.tradeace-products-page-wrap').length) {
    if ($('.tradeace-products-page-wrap .tradeace-actived-filter').length <= 0) {
        $('.tradeace-products-page-wrap').prepend('<div class="tradeace-actived-filter hidden-tag"></div>');
    }
    
    var _actived_filter = get_top_filter_actived($);
    if (_actived_filter) {
        $('.tradeace-actived-filter').replaceWith(_actived_filter);
    }
    
    $('body').on('price_slider_updated', function() {
        if ($('.tradeace-actived-filter .tradeace-price-active-init').length) {
            if ($('.tradeace-products-page-wrap .tradeace-actived-filter').length <= 0) {
                $('.tradeace-products-page-wrap').prepend('<div class="tradeace-actived-filter hidden-tag"></div>');
            }
            
            var _act_content = get_top_filter_actived($);
            if (_act_content) {
                $('.tradeace-actived-filter').replaceWith(_act_content);
            }
        }
    });
}

$('body').on('tradeace_after_load_ajax_first', function() {
    /**
     * Topbar Actived filters
     */
    load_active_topbar($);
    
    /**
     * Toggle Sidebar classic
     */
    load_toggle_sidebar_classic($);
    
    /**
     * Clone Group Btn for listview
     */
    clone_group_btns_product_item($);
});

/**
 * Reload class for .tradeace-top-row-filter a.tradeace-tab-filter-topbar
 */
$('body').on('tradeace_after_load_ajax', function() {
    if ($('.tradeace-push-cat-filter.tradeace-push-cat-show').length) {
        var _this = $('.tradeace-top-row-filter a.tradeace-tab-filter-topbar');
        if ($(_this).length && !$(_this).hasClass('tradeace-push-cat-show')) {
            $(_this).addClass('tradeace-push-cat-show');
        }
    }
    
    // Ordering
    if ($('.woocommerce-ordering').length) {
        var _order = $('.woocommerce-ordering').html();
        $('.woocommerce-ordering').replaceWith('<div class="woocommerce-ordering">' + _order + '</div>');
    }
    
    /**
     * Change layout
     * 
     * @type String
     */
    if ($('.tradeace-change-layout').length) {
        var _cookie_change_layout_name = $('input[name="tradeace_archive_grid_view"]').length ? $('input[name="tradeace_archive_grid_view"]').val() : 'tradeace_archive_grid_view';
        var _cookie_change_layout = $.cookie(_cookie_change_layout_name);
        if (typeof _cookie_change_layout !== 'undefined' && $('.tradeace-change-layout.' + _cookie_change_layout).length) {
            $('.tradeace-change-layout.' + _cookie_change_layout).trigger('click');
        }
    }
});

/**
 * INIT tradeace-change-layout Change layout
 */
setTimeout(function() {
    var _cookie_change_layout_name = $('input[name="tradeace_archive_grid_view"]').length ? $('input[name="tradeace_archive_grid_view"]').val() : 'tradeace_archive_grid_view';
    var _cookie_change_layout = $.cookie(_cookie_change_layout_name);
    if (typeof _cookie_change_layout !== 'undefined' && $('.tradeace-change-layout.' + _cookie_change_layout).length) {
        $('.tradeace-change-layout.' + _cookie_change_layout).trigger('click');
    }
}, 50);

/**
 * Even change layout
 */
$('body').on('click', '.tradeace-change-layout', function() {
    var _this = $(this);
    if ($(_this).hasClass('active')) {
        return false;
    } else {
        change_layout_shop_page($, _this);
    }
});

/**
 * Igrone variation item filter
 */
$('body').on('click', '.tradeace-ignore-variation-item', function() {
    var term_id = $(this).attr('data-term_id');
    if ($('.tradeace-filter-by-variations.tradeace-filter-var-chosen[data-term_id="' + term_id + '"]').length) {
        if ($('.tradeace-has-filter-ajax').length < 1) {
            window.location.href = $('.tradeace-filter-by-variations.tradeace-filter-var-chosen[data-term_id="' + term_id + '"]').attr('href');
        } else {
            $('.tradeace-filter-by-variations.tradeace-filter-var-chosen[data-term_id="' + term_id + '"]').trigger('click');
        }
    }
});

/**
 * Igrone price filter
 */
$('body').on('click', '.tradeace-ignore-price-item', function() {
    if ($('.reset_price').length) {
        $('.reset_price').trigger('click');
    }
    
    return false;
});

/**
 * Igrone price list filter
 */
$('body').on('click', '.tradeace-ignore-price-item-list', function() {
    if ($('.tradeace-all-price .tradeace-filter-by-price-list').length) {
        $('.tradeace-all-price .tradeace-filter-by-price-list').trigger('click');
    }
    
    return false;
});

/* 
 * custom widget top bar
 * 
 */
init_tradeace_top_sidebar($);
$('body').on('click', '.tradeace-tab-filter-topbar-categories', function() {
    var _this = $(this);
    $('.filter-cat-icon-mobile').trigger('click');

    if ($(_this).attr('data-top_icon') === '0') {
        var _obj = $(_this).attr('data-widget');
        var _wrap_content = $('.tradeace-top-sidebar');

        var _act = $(_obj).hasClass('tradeace-active') ? true : false;
        $(_this).parents('.tradeace-top-row-filter').find('> li').removeClass('tradeace-active');
        $(_wrap_content).find('.tradeace-widget-wrap').removeClass('tradeace-active').slideUp(300);

        if (!_act) {
            $(_obj).addClass('tradeace-active').slideDown(300);
            $(_this).parents('li').addClass('tradeace-active');
        }
    }

    else {
        $('.site-header').find('.filter-cat-icon').trigger('click');
        if ($('.tradeace-header-sticky').length <= 0 || ($('.sticky-wrapper').length && !$('.sticky-wrapper').hasClass('fixed-already'))) {
            $('html, body').animate({scrollTop: 0}, 700);
        }
    }
    
    $('body').trigger('tradeace_init_topbar_categories');
});

/**
 * Top sidebar
 */
$('body').on('click', '.tradeace-top-row-filter a.tradeace-tab-filter-topbar', function() {
    var _this = $(this);
    top_filter_click($, _this, 'animate');
});

/**
 * Top sidebar type 2
 */
$('body').on('click', '.tradeace-toggle-top-bar-click', function() {
    var _this = $(this);
    top_filter_click_2($, _this, 'animate');
});

/**
 * Toggle Sidebar classic
 */
load_toggle_sidebar_classic($);
$('body').on('click', '.tradeace-toogle-sidebar-classic', function() {
    if ($('.tradeace-with-sidebar-classic').length) {
        var _this = $(this);
        var _show = $(_this).hasClass('tradeace-hide') ? 'show' : 'hide';
        
        /**
         * Set cookie in _cookie_live days
         */
        $.cookie('toggle_sidebar_classic', _show, {expires: _cookie_live, path: '/'});
        
        /**
         * Show sidebar
         */
        if (_show === 'show') {
            $(_this).removeClass('tradeace-hide');
            $('.tradeace-with-sidebar-classic').removeClass('tradeace-with-sidebar-hide');
        }
        
        /**
         * Hide sidebar
         */
        else {
            $(_this).addClass('tradeace-hide');
            $('.tradeace-with-sidebar-classic').addClass('tradeace-with-sidebar-hide');
        }
        
        /**
         * Refresh Carousel
         */
        if (typeof _refresh_carousel !== 'undefined') {
            clearTimeout(_refresh_carousel);
        }
        
        var _refresh_carousel = setTimeout(function() {
            $('body').trigger('tradeace_before_refresh_carousel');
            $('body').trigger('tradeace_reload_slick_slider');
            $('body').trigger('tradeace_refresh_sliders');
        }, 500);
    }
    
    return false;
});

/**
 * Filters Ajax Store
 * 
 * @type Number|min
 */
if (
    $('.tradeace-widget-store.tradeace-price-filter-slide').length &&
    $('.tradeace-widget-store.tradeace-price-filter-slide').find('.tradeace-hide-price').length &&
    !$('.tradeace-widget-store.tradeace-price-filter-slide').hasClass('hidden-tag')
) {
    $('.tradeace-widget-store.tradeace-price-filter-slide').addClass('hidden-tag');
}

/**
 * After Load Ajax Complete
 */
$('body').on('tradeace_after_loaded_ajax_complete', function() {
    if (
        $('.tradeace-widget-store.tradeace-price-filter-slide').length &&
        $('.tradeace-widget-store.tradeace-price-filter-slide').find('.tradeace-hide-price').length &&
        !$('.tradeace-widget-store.tradeace-price-filter-slide').hasClass('hidden-tag')
    ) {
        $('.tradeace-widget-store.tradeace-price-filter-slide').addClass('hidden-tag');
    }
    
    if ($('.tradeace-sort-by-action').length && $('.tradeace-sort-by-action select[name="orderby"]').length <= 0) {
        $('.tradeace-sort-by-action').addClass('hidden-tag');
    }
    
    /**
     * Compatible with Contact Form 7
     */
    if (typeof wpcf7 !== 'undefined' && $('.wpcf7 > form').length) {
        document.querySelectorAll(".wpcf7 > form").forEach(function (e) {
            return wpcf7.init(e);
        });
    }
});

var min_price = 0, max_price = 0, hasPrice = '0';
if ($('.price_slider_wrapper').length) {
    $('.price_slider_wrapper').find('input').attr('readonly', true);
    min_price = parseFloat($('.price_slider_wrapper').find('input[name="min_price"]').val()),
    max_price = parseFloat($('.price_slider_wrapper').find('input[name="max_price"]').val());
    hasPrice = ($('.tradeace_hasPrice').length) ? $('.tradeace_hasPrice').val() : '0';

    if (hasPrice === '1') {
        if ($('.reset_price').length) {
            $('.reset_price').attr('data-has_price', "1").show();
        }
        
        if ($('.price_slider_wrapper').find('button').length) {
            $('.price_slider_wrapper').find('button').show();
        }
    }
}

if ($('input[name="min-price-list"]').length) {
    min_price = parseFloat($('input[name="min-price-list"]').val());
    hasPrice = '1';
}

if ($('input[name="max-price-list"]').length) {
    max_price = parseFloat($('input[name="max-price-list"]').val());
    hasPrice = '1';
}

$('body').on('click', '.price_slider_wrapper button', function(e) {
    e.preventDefault();
    if (hasPrice === '1' && $('.tradeace-has-filter-ajax').length < 1) {
        var _obj = $(this).parents('form');
        $('input[name="tradeace_hasPrice"]').remove();
        $(_obj).submit();
    }
});

// Filter by Price Slide
$('body').on("slidestop", ".price_slider", function() {
    var _obj = $(this).parents('form');
    
    if ($('.tradeace-has-filter-ajax').length <= 0) {
        if ($(_obj).find('.tradeace-filter-price-btn').length <= 0) {
            $(_obj).submit();
        }
    } else {
        if (!shop_load) {
            if ($(_obj).find('.tradeace-filter-price-btn').length) {
                $(_obj).find('.tradeace-filter-price-btn').show();
            }
            
            if ($(_obj).find('.tradeace-filter-price-btn').length <= 0) {
                shop_load = true;
                
                $('.tradeace-value-gets input[name="min_price"]').remove();
                $('.tradeace-value-gets input[name="max_price"]').remove();

                var min = parseFloat($(_obj).find('input[name="min_price"]').val()),
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }

                if (min != min_price || max != max_price) {
                    min_price = min;
                    max_price = max;
                    hasPrice = '1';
                    if ($('.tradeace_hasPrice').length) {
                        $('.tradeace_hasPrice').val('1');
                        $('.reset_price').attr('data-has_price', "1").fadeIn(200);
                    }

                    // Call filter by price
                    var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                        _order = $('select[name="orderby"]').val(),
                        _page = false,
                        _taxid = null,
                        _taxonomy = '',
                        _url = $('#tradeace_current-slug').length <= 0 ? '' : $('#tradeace_current-slug').val();

                    if ($('#tradeace_current-slug').length <= 0 && $(_this).length) {
                        _taxid = $(_this).attr('data-id');
                        _taxonomy = $(_this).attr('data-taxonomy');
                        _url = $(_this).attr('href');
                    }

                    var _variations = tradeace_set_variations($, [], []);
                    var _hasSearch = ($('input#tradeace_hasSearch').length && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
                    var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';

                    if ($(_obj).find('.tradeace-filter-price-btn').length <= 0) {
                        _scroll_to_top = false;
                        tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
                    }
                } else {
                    shop_load = false;
                }
            }
        }

        return false;
    }
});

/**
 * Click price filter button
 */
$('body').on('click', '.tradeace-filter-price-btn', function() {
    var _obj = $(this).parents('form');
    
    if ($('.tradeace-has-filter-ajax').length <= 0) {
        $(_obj).submit();
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.tradeace-value-gets input[name="min_price"]').remove();
            $('.tradeace-value-gets input[name="max_price"]').remove();

            var min = parseFloat($(_obj).find('input[name="min_price"]').val()),
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            if (min < 0) {
                min = 0;
            }
            if (max < min) {
                max = min;
            }

            if (min != min_price || max != max_price) {
                min_price = min;
                max_price = max;
                hasPrice = '1';
                if ($('.tradeace_hasPrice').length) {
                    $('.tradeace_hasPrice').val('1');
                    $('.reset_price').attr('data-has_price', "1").fadeIn(200);
                }

                // Call filter by price
                var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _taxid = null,
                    _taxonomy = '',
                    _url = $('#tradeace_current-slug').length <= 0 ? '' : $('#tradeace_current-slug').val();

                if ($('#tradeace_current-slug').length <= 0 && $(_this).length) {
                    _taxid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = tradeace_set_variations($, [], []);
                var _hasSearch = ($('input#tradeace_hasSearch').length && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';

                _scroll_to_top = false;
                tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            } else {
                shop_load = false;
            }
        }

        return false;
    }
});

// Reset filter price
$('body').on('click', '.reset_price', function() {
    if ($('.tradeace_hasPrice').length && $('.tradeace_hasPrice').val() === '1') {
        var _obj = $(this).parents('form');
        if ($('.tradeace-has-filter-ajax').length < 1) {
            $('#min_price').remove();
            $('#max_price').remove();
            $('input[name="tradeace_hasPrice"]').remove();
            $(_obj).append('<input type="hidden" name="reset-price" value="true" />');
            $(_obj).submit();
        } else {
            if (!shop_load) {
                shop_load = true;
                
                $('.tradeace-value-gets input[name="min_price"]').remove();
                $('.tradeace-value-gets input[name="max_price"]').remove();
                
                var _min = $('#min_price').attr('data-min');
                var _max = $('#max_price').attr('data-max');
                $('.price_slider').slider('values', 0, _min);
                $('.price_slider').slider('values', 1, _max);
                $('#min_price').val(_min);
                $('#max_price').val(_max);

                var currency_pos = $('input[name="tradeace_currency_pos"]').val(),
                    full_price_min = _min,
                    full_price_max = _max;
                switch (currency_pos) {
                    case 'left':
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + _max;
                        break;
                    case 'right':
                        full_price_min = _min + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                    case 'left_space' :
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + ' ' + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + ' ' + _max;
                        break;
                    case 'right_space' :
                        full_price_min = _min + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                }

                $('.price_slider_amount .price_label span.from').html(full_price_min);
                $('.price_slider_amount .price_label span.to').html(full_price_max);

                var min = 0,
                    max = 0;

                hasPrice = '0';
                if ($('.tradeace_hasPrice').length) {
                    $('.tradeace_hasPrice').val('0');
                    $('.reset_price').attr('data-has_price', "0").fadeOut(200);
                }

                // Call filter by price
                var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _taxid = null,
                    _taxonomy = '',
                    _url = $('#tradeace_current-slug').length <= 0 ? '' : $('#tradeace_current-slug').val();

                if ($('#tradeace_current-slug').length <= 0 && $(_this).length) {
                    _taxid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = tradeace_set_variations($, [], []);
                var _hasSearch = ($('input#tradeace_hasSearch').length && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';

                _scroll_to_top = false;
                tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            }
        }
    
        return false;
    }
});

// Filter price list
$('body').on('click', '.tradeace-filter-by-price-list', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.tradeace-value-gets input[name="min_price"]').remove();
            $('.tradeace-value-gets input[name="max_price"]').remove();
            
            var _url = $(this).attr('href');
            var min = $(this).attr('data-min') ? $(this).attr('data-min') : null,
                max = $(this).attr('data-max') ? $(this).attr('data-max') : null;
                
            if (min < 0) {
                min = 0;
            }
            if (max < min) {
                max = min;
            }

            if (min != min_price || max != max_price) {
                hasPrice = '1';
            }
            
            // Call filter by price
            var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _taxid = null,
                _taxonomy = '';

            if ($(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
            }
            
            var _variations = [];
            
            var _s = $('input#tradeace_hasSearch').val(),
                _hasSearch = _s ? 1 : 0;
            
            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        } else {
            _queue_trigger 
        }
        
        return false;
    }
});

// Reset filter
$('body').on('click', '.tradeace-reset-filters-btn', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.tradeace-value-gets input').remove();
            $('input[name="tradeace_loadmore_style"]').remove();
            
            var _this = $(this),
            _taxid = $(_this).attr('data-id'),
            _taxonomy = $(_this).attr('data-taxonomy'),
            _order = false,
            _url = $(_this).attr('href'),
            _page = false;
            
            var _variations = [];
            var min = null,
                max = null;
            $('input#tradeace_hasSearch').val('');
            hasPrice = '0';
            
            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy, false, false, true);
        }
        
        return false;
    }
});

// Filter by Taxonomy - Category
$('body').on('click', '.tradeace-filter-by-tax', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            if (!$(this).hasClass('tradeace-disable') && !$(this).hasClass('tradeace-active')) {
                shop_load = true;
                
                $('.tradeace-value-gets input').remove();
                if ($('input.tradeace-custom-cat').length) {
                    $('input.tradeace-custom-cat').val('');
                }
                
                var _this = $(this),
                    _taxid = $(_this).attr('data-id'),
                    _taxonomy = $(_this).attr('data-taxonomy'),
                    _order = $('select[name="orderby"]').val(),
                    _url = $(_this).attr('href'),
                    _page = false;

                if (_taxid) {
                    var _variations = [];
                    $('.tradeace-filter-by-variations').each(function() {
                        if ($(this).hasClass('tradeace-filter-var-chosen')) {
                            $(this).parent().removeClass('chosen tradeace-chosen');
                            $(this).removeClass('tradeace-filter-var-chosen');
                        }
                    });

                    var min = null,
                        max = null;
                    $('input#tradeace_hasSearch').val('');
                    hasPrice = '0';
                    /**
                     * Fix filter cat push in mobile.
                     */
                    if ($('.black-window-mobile.tradeace-push-cat-show').width()) {
                        $('.black-window-mobile.tradeace-push-cat-show').trigger('click');
                    }
                    
                    _scroll_to_top = false;
                    tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy);

                    if (
                        $(_this).parents('.tradeace-filter-cat-no-top-icon').length === 1 &&
                        $('.tradeace-tab-filter-topbar-categories').length
                    ) {
                        $('.tradeace-tab-filter-topbar-categories').trigger('click');
                    }
                }
            } else {
                shop_load = false;
            }
        }

        return false;
    }
});

// Ordering
if ($('.woocommerce-ordering').length && $('.tradeace-has-filter-ajax').length) {
   var _order = $('.woocommerce-ordering').html();
   $('.woocommerce-ordering').replaceWith('<div class="woocommerce-ordering">' + _order + '</div>');
}

// Filter by ORDER BY
$('body').on('change', 'select[name="orderby"]', function() {
    if ($('.tradeace-has-filter-ajax').length <= 0) {
        $(this).parents('form').submit();
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.tradeace-value-gets input[name="orderby"]').remove();
            
            var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                _order = $(this).val(),
                _page = false,
                _taxid = null,
                _taxonomy = '',
                _url = $('#tradeace_current-slug').length <= 0 ? '' : $('#tradeace_current-slug').val();

            if ($('#tradeace_current-slug').length <= 0 && $(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = tradeace_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#tradeace_hasSearch').length && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';
            
            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
});

// Filter by Paging
$('body').on('click', '.tradeace-pagination-ajax .page-numbers', function() {
    if ($(this).hasClass('tradeace-current')) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                _order = $('select[name="orderby"]').val(),
                _page = $(this).attr('data-page'),
                _taxid = null,
                _taxonomy = '',
                _url = $('#tradeace_current-slug').length <= 0 ? '' : $('#tradeace_current-slug').val();
            if (_page === '1') {
                _page = false;
            }
            if ($('#tradeace_current-slug').length <= 0 && $(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = tradeace_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#tradeace_hasSearch').length  && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';

            _scroll_to_top = true;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
});

// Filter by Loadmore
$('body').on('click', '.tradeace-archive-loadmore', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            $(this).addClass('tradeace-disabled');
            archive_page = archive_page + 1;
            
            var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                _order = $('select[name="orderby"]').val(),
                _page = archive_page,
                _taxid = null,
                _taxonomy = '',
                _url = $('#tradeace_current-slug').length <= 0 ? '' : $('#tradeace_current-slug').val();
            
            if (_page == 1) {
                _page = false;
            }
            
            if ($('#tradeace_current-slug').length <= 0 && $(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = tradeace_set_variations($, [], []);
            
            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#tradeace_hasSearch').length  && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';

            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, true);
        }

        return false;
    }
});

// Filter by variations
$('body').on('click', '.tradeace-filter-by-variations', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.tradeace-value-gets input[name^="filter_"]').remove();
            $('.tradeace-value-gets input[name^="query_type_"]').remove();
            
            var _this = $('.current-tax-item > .tradeace-filter-by-tax'),
                _current = $(this),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _taxid = null,
                _taxonomy = '',
                _url = $(_current).attr('href');
            
            var _variations = tradeace_set_variations($, [], [], _current);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#tradeace_hasSearch').length  && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';

            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        }

        return false;
    }
});

/**
 * Filter By Status
 */
$('body').on('click', '.tradeace-filter-status', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
                
            var _this = $(this),
                _taxid = null,
                _taxonomy = '',
                _order = $('select[name="orderby"]').val(),
                _url = $(_this).attr('href'),
                _page = false,
                _data_status = $(_this).attr('data-filter');
            
            if ($('.tradeace-value-gets input[name="' + _data_status + '"]').length) {
                $('.tradeace-value-gets input[name="' + _data_status + '"]').remove();
            }

            $(_this).toggleClass('tradeace-active');

            var _variations = tradeace_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }

            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#tradeace_hasSearch').length  && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';
            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        }

        return false;
    }
});

/**
 * Filter By Multi Tags
 */
$('body').on('click', '.tradeace-filter-tag', function() {
    if ($('.tradeace-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
                
            var _this = $(this),
                _taxid = null,
                _taxonomy = '',
                _order = $('select[name="orderby"]').val(),
                _url = $(_this).attr('href'),
                _page = false;
            
            if ($('.tradeace-value-gets input[name="product-tags"]').length) {
                $('.tradeace-value-gets input[name="product-tags"]').remove();
            }

            $(_this).toggleClass('tradeace-active');

            var _variations = tradeace_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }

            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#tradeace_hasSearch').length  && $('input#tradeace_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#tradeace_hasSearch').val() : '';
            _scroll_to_top = false;
            tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        }

        return false;
    }
});

// Back url with Ajax Call
$(window).on('popstate', function() {
    if ($('.tradeace-has-filter-ajax').length) {
        location.reload(true);
    }
});

/* End Document Ready */
});

/**
 * Functions
 */
/**
 * Shop Ajax
 * 
 * @param {type} $
 * @param {type} _url
 * @param {type} _page
 * @param {type} _taxid
 * @param {type} _order
 * @param {type} _variations
 * @param {type} _hasPrice
 * @param {type} _min
 * @param {type} _max
 * @param {type} _hasSearch
 * @param {type} _s
 * @param {type} _this
 * @param {type} _taxonomy
 * @param {type} loadMore
 * @returns {undefined}
 */
function tradeace_ajax_filter($, _url, _page, _taxid, _order, _variations, _hasPrice, _min, _max, _hasSearch, _s, _this, _taxonomy, loadMore, buildUrl, reset) {
    var _reset = typeof reset === 'undefined' ? false : reset;
    var _more = typeof loadMore === 'undefined' ? false : loadMore;
    var _style_loadmore = $('#tradeace-wrap-archive-loadmore').length ? true : false;
    var _scroll_loadmore = false;
    if (_style_loadmore && $('#tradeace-wrap-archive-loadmore').hasClass('tradeace-infinite-shop')) {
        _scroll_loadmore = true;
    }
    
    var _push_cat_show = $('.tradeace-push-cat-filter.tradeace-push-cat-show').length ? '1' : '0';
    if (_push_cat_show === '1' && $('.tradeace-check-reponsive.tradeace-mobile-check').length && $('.tradeace-check-reponsive.tradeace-mobile-check').width()) {
        _push_cat_show = '0';
    }
    
    var _data = _push_cat_show === '1' ? {
        'categories-filter-show': _push_cat_show
    } : {};
    
    if ($('input[name="categories-filter-show"]').length) {
        $('input[name="categories-filter-show"]').remove();
    }
    
    var _paging_style = false;
    if (_more || _style_loadmore || $('input[name="tradeace_loadmore_style"]').length) {
        _paging_style = $('input[name="tradeace_loadmore_style"]').length ? $('input[name="tradeace_loadmore_style"]').val() : '';
    }
    
    var _top_filter = $('.tradeace-top-cat-filter').length ? true : false;
    
    /**
     * Built URL
     */
    if (_url === '' && $('input[name="tradeace_current-slug"]').length) {
        _url = $('input[name="tradeace_current-slug"]').val();
    }
    $('#tradeace-hidden-current-tax').attr({
        'href': _url,
        'data-id': _taxid,
        'data-taxonomy': _taxonomy
    });
    
    buildUrl = typeof buildUrl === 'undefined' ? true : buildUrl;
    var _h = false;
    if (buildUrl) {
        if (_url === '') {
            if (_hasSearch === 0) {
                _url = $('input[name="tradeace-shop-page-url"]').val();
            } else if (_hasSearch === 1) {
                _url = $('input[name="tradeace-base-url"]').val();
            }
        }

        if (_hasSearch != 1) {
            var patt = /\?/g;
            _h = patt.test(_url);
        }
        
        var pagestring = '';
        var _friendly = $('input[name="tradeace-friendly-url"]').length === 1 && $('input[name="tradeace-friendly-url"]').val() === '1' ? true : false;
        
        /**
         * Page request
         */
        if (_page) {
            if (_hasSearch == 1 || !_friendly) {
                pagestring = 'paged=' + _page;
            } else {
                // Paging change (friendly Url)
                var lenUrl = _url.length;
                _url += (_url.length && _url.substring(lenUrl - 1, lenUrl) !== '/') ? '/' : '';
                _url += 'page/' + _page + '/';
            }
        }
        
        /**
         * Tradeace Custom Categories
         */
        if (!_reset) {
            var _custom_cat = null;
            if ($('input.tradeace-custom-cat').length && $('input.tradeace-custom-cat').val()) {
                _custom_cat = $('input.tradeace-custom-cat').attr('name');
                var _val = encodeURI($('input.tradeace-custom-cat').val());
                _url = _url.replace('&' + _custom_cat + '=' + _val, '');
                _url = _url.replace('&' + _custom_cat + '=' + _val, '');
                _url += _h ? '&' : '?';
                _url += _custom_cat + '=' + _val;
                _h = true;

                if ($('.tradeace-value-gets').length && $('.tradeace-value-gets').find('input[name="' + _custom_cat + '"]').length) {
                    $('.tradeace-value-gets').find('input[name="' + _custom_cat + '"]').remove();
                }
            }
        }

        // Search change
        if (_hasSearch == 1) {
            _url += _h ? '&' : '?';
            _url += 's=' + encodeURI(_s) + '&page=search&post_type=product';
            _h = true;
        } else {
            if ($('.tradeace-results-blog-search').length) {
                $('.tradeace-results-blog-search').remove();
            }
            if ($('input[name="hasSearch"]').length) {
                $('input[name="hasSearch"]').remove();
            }
        }

        // Variations change
        if (_variations.length) {
            var l = _variations.length;
            
            $('.tradeace-value-gets input[name^="filter_"]').remove();
            $('.tradeace-value-gets input[name^="query_type_"]').remove();
            
            for (var i = 0; i < l; i++) {
                var _qtype = (_variations[i].type === 'or') ? '&query_type_' + _variations[i].taxonomy + '=' + _variations[i].type : '';
                _url += _h ? '&' : '?';
                _url += 'filter_' + _variations[i].taxonomy + '=' + (_variations[i].slug).toString() + _qtype;
                _h = true;
            }
        }

        // Price change
        if (_hasPrice == 1) {
            _url += _h ? '&' : '?';
            _min = _min ? _min : 0;
            _max = _max ? _max : _min;
            _url += 'min_price=' + _min + '&max_price=' + _max;
            _h = true;
        }
        
        // Status
        if ($('.tradeace-filter-status.tradeace-active').length) {
            $('.tradeace-filter-status.tradeace-active').each(function() {
                var _data_status = $(this).attr('data-filter');
                _url += _h ? '&' : '?';
                _url += _data_status + '=1';
                _h = true;
                
                if ($('.tradeace-value-gets input[name="' + _data_status + '"]').length) {
                    $('.tradeace-value-gets input[name="' + _data_status + '"]').remove();
                }
            });
        }
        
        // multi tags
        if ($('.tradeace-filter-tag.tradeace-active').length) {
            _url += _h ? '&' : '?';
            _h = true;
            _url += 'product-tags=';
            if ($('.tradeace-value-gets input[name="product-tags"]').length) {
                $('.tradeace-value-gets input[name="product-tags"]').remove();
            }
            
            var _values_filter = '';
            var _f = 0;
            $('.tradeace-filter-tag.tradeace-active').each(function() {
                var _data_filter = $(this).attr('data-filter');
                _values_filter += _f === 0 ? _data_filter : '%2C' + _data_filter;
                _f++;
            });
            
            _url += _values_filter;
        }

        // Order change
        if (_order) {
            var _dfSort = $('input[name="tradeace_default_sort"]').val();
            if (_order !== _dfSort) {
                _url += _h ? '&' : '?';
                _url += 'orderby=' + _order;
                _h = true;
            }
        }

        // Get Sidebar
        if ($('input[name="tradeace_getSidebar"]').length === 1) {
            var _sidebar = $('input[name="tradeace_getSidebar"]').val();
            _url += _h ? '&' : '?';
            _url += 'sidebar=' + _sidebar;
            _h = true;
        }
        
        /**
         * Paged with not friendly URL
         */
        if (pagestring !== '') {
            _url += _h ? '&' : '?';
            _url += pagestring;
        }
    }
    
    if (_paging_style && _paging_style !== '') {
        if (!_h && _url) {
            var patt2 = /\?/g;
            _h = patt2.test(_url);
        }
        
        _url += _h ? '&' : '?';
        _url += 'paging-style=' + _paging_style;
        _h = true;
        
        if ($('.tradeace-value-gets').find('input[name="paging-style"]').length) {
            $('.tradeace-value-gets').find('input[name="paging-style"]').remove();
        }
    }
    
    if ($('.tradeace-value-gets').length && $('.tradeace-value-gets').find('input').length) {
        $('.tradeace-value-gets').find('input').each(function() {
            var _key = $(this).attr('name');
            var _val = $(this).val();
            _data[_key] = _val;
        });
    }
    
    var _pos_top_2 = 0;
    if ($('.tradeace-top-sidebar-2.tradeace-slick-slider .slick-current').length) {
        _pos_top_2 = $('.tradeace-top-sidebar-2.tradeace-slick-slider .slick-current').attr('data-slick-index');
    }
    
    if ($('.wcfmmp-product-geolocate-search-form').length) {
        window.location.href = _url;
    } else {
        var $crazy_load = $('#tradeace-ajax-store').length && $('#tradeace-ajax-store').hasClass('tradeace-crazy-load') && $('.tradeace-archive-loadmore').length <= 0 ? true : false;
        
        $.ajax({
            url: _url,
            type: 'get',
            dataType: 'html',
            data: _data,
            cache: true,
            beforeSend: function() {
                if (!$crazy_load) {
                    if (!_scroll_loadmore && !_more) {
                        $('.tradeace-content-page-products').append('<div class="opacity-shop"></div>');
                    } else {
                        if ($('#tradeace-wrap-archive-loadmore').length && $('#tradeace-wrap-archive-loadmore').find('.tradeace-loader').length <= 0) {
                            $('#tradeace-wrap-archive-loadmore').append('<div class="tradeace-loader"></div>');
                        }
                    }
                } else {
                    if (!$('#tradeace-ajax-store').hasClass('crazy-loading')) {
                        $('#tradeace-ajax-store').addClass('crazy-loading');
                    }
                }

                if ($('.tradeace-progress-bar-load-shop').length === 1) {
                    $('.tradeace-progress-bar-load-shop .tradeace-progress-per').removeClass('tradeace-loaded');
                    $('.tradeace-progress-bar-load-shop').addClass('tradeace-loading');
                }

                if ($('.col-sidebar').length) {
                    $('.col-sidebar').append('<div class="opacity-2"></div>');
                    $('.black-window').trigger('click');
                }

                $('.tradeace-filter-by-tax').addClass('tradeace-disable').removeClass('tradeace-active');

                if ($(_this).parents('ul.children').length) {
                    $(_this).parents('ul.children').show();
                }

                var _totop = _scroll_to_top;
                _scroll_to_top = false;
                if (_totop && ($('.category-page').length || $('.tradeace-content-page-products').length)) {
                    var _pos_obj = $('.category-page').length ? $('.category-page') : $('.tradeace-content-page-products');
                    animate_scroll_to_top($, _pos_obj, 700);
                }
            },
            success: function (res) {
                var _act_widget = $('.tradeace-top-row-filter li.tradeace-active > a');

                var _act_widget_2 = false;
                if ($('.tradeace-toggle-top-bar-click').length) {
                    _act_widget_2 = $('.tradeace-toggle-top-bar-click').hasClass('tradeace-active') ? true : false;
                }

                var $html = $.parseHTML(res);

                var $mainContent = $('#tradeace-ajax-store', $html);

                _top_filter = _top_filter ? $('#tradeace-main-cat-filter', $html).html() : _top_filter;

                if (_top_filter) {
                    $('#header-content .tradeace-top-cat-filter').replaceWith(_top_filter);
                    if ($('.tradeace-top-cat-filter-wrap-mobile .tradeace-top-cat-filter').length) {
                        $('.tradeace-top-cat-filter-wrap-mobile .tradeace-top-cat-filter').replaceWith(_top_filter);
                    }
                }

                /**
                 * 
                 * @type Load Paging
                 */
                if (!_more) {
                    if ($('#header-content').length) {
                        var $headContent = $('#header-content', $html);
                        /**
                         * Replace Header
                         */
                        $('#header-content').replaceWith($headContent);
                    } else if ($('#tradeace-breadcrumb-site').length) {
                        /**
                         * Replace Breadcrumb
                         */
                        var $breadcrumb = $('#tradeace-breadcrumb-site', $html);
                        $('#tradeace-breadcrumb-site').replaceWith($breadcrumb);
                    }
                    
                    /**
                     * Replace Archive
                     */
                    $('#tradeace-ajax-store').replaceWith($mainContent);
                    
                    /**
                     * Replace Footer
                     */
                    if ($('#tradeace-footer').length) {
                        var $footContent = $('#tradeace-footer', $html);
                        $('#tradeace-footer').replaceWith($footContent);
                    }
                    
                    archive_page = 1;
                }

                /**
                 * 
                 * @type Load More
                 */
                else {
                    _eventMore = true;
                    var _append_content = $($mainContent).find('.tradeace-content-page-products ul.products').html();

                    if ($('#tradeace-ajax-store').find('.tradeace-products-masonry-isotope').length && $('.tradeace-products-masonry-isotope ul.products.grid').length) {
                        $('body').trigger('tradeace_store_insert_content_isotope', [_append_content]);
                    } else {
                        $('#tradeace-ajax-store').find('.tradeace-content-page-products ul.products').append(_append_content);
                    }

                    var $moreBtn = $('#tradeace-wrap-archive-loadmore', $html);
                    $('#tradeace-wrap-archive-loadmore').replaceWith($moreBtn);

                    if ($('.tradeace-content-page-products').find('.opacity-shop').length) {
                        $('.tradeace-content-page-products').find('.opacity-shop').remove();
                    }

                    if ($('.col-sidebar').length && $('.col-sidebar').find('.opacity-2').length) {
                        $('.col-sidebar').find('.opacity-2').remove();
                    }

                    if ($('.tradeace-progress-bar-load-shop').length) {
                        $('.tradeace-progress-bar-load-shop').removeClass('tradeace-loading');
                    }

                    if ($('#tradeace-wrap-archive-loadmore').length && $('#tradeace-wrap-archive-loadmore').find('.tradeace-loader').length) {
                        $('#tradeace-wrap-archive-loadmore').find('.tradeace-loader').remove();
                    }
                }

                $('.tradeace-filter-by-tax').removeClass('tradeace-disable');

                if (_more && $('.woocommerce-result-count').length) {
                    $('.woocommerce-result-count').html($(res).find('.woocommerce-result-count').html());
                }

                /**
                 * Build Actived Filter
                 */
                if ($('.tradeace-products-page-wrap').length) {
                    if ($('.tradeace-products-page-wrap .tradeace-actived-filter').length <= 0) {
                        $('.tradeace-products-page-wrap').prepend('<div class="tradeace-actived-filter hidden-tag"></div>');
                    }

                    var _actived_filter = get_top_filter_actived($);
                    if (_actived_filter) {
                        $('.tradeace-actived-filter').replaceWith(_actived_filter);
                    }
                }

                /**
                 * Re-build Top Sidebar Type 1
                 */
                if ($('.tradeace-top-sidebar').length && !_more) {
                    init_tradeace_top_sidebar($);

                    if ($(_act_widget).length) {
                        var _old_id = $(_act_widget).attr('data-old_id');
                        if ($('.tradeace-top-row-filter li > a[data-old_id="' + _old_id + '"]').length) {
                            var _click = $('.tradeace-top-row-filter li > a[data-old_id="' + _old_id + '"]');
                            top_filter_click($, _click, 'showhide');
                        } else {
                            var _key = $(_act_widget).attr('data-key');
                            if ($('.tradeace-top-row-filter li > a[data-key="' + _key + '"]').length) {
                                var _click = $('.tradeace-top-row-filter li > a[data-key="' + _key + '"]');
                                top_filter_click($, _click, 'showhide');
                            }
                        }
                    }
                }

                /**
                 * Re-build Top Sidebar Type 2
                 */
                if ($('.tradeace-top-sidebar-2').length && !_more) {
                    if (_act_widget_2) {
                        var _click = $('.tradeace-toggle-top-bar-click');
                        $('.tradeace-top-bar-2-content').hide();
                        top_filter_click_2($, _click, 'showhide', _pos_top_2);
                    }
                }

                /**
                 * Reload Price Slide
                 */
                if ($('.price_slider').length && !_more) {
                    var min_price = $('.price_slider_amount #min_price').data('min'),
                        max_price = $('.price_slider_amount #max_price').data('max'),
                        current_min_price = parseInt(min_price, 10),
                        current_max_price = parseInt(max_price, 10);

                    if (_hasPrice == 1) {
                        current_min_price = _min ? _min : 0;
                        current_max_price = _max ? _max : current_min_price;
                    }

                    $('.price_slider').slider({
                        range: true,
                        animate: true,
                        min: min_price,
                        max: max_price,
                        values: [current_min_price, current_max_price],
                        create: function() {
                            $('.price_slider_amount #min_price').val(current_min_price);
                            $('.price_slider_amount #max_price').val(current_max_price);
                            $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                        },
                        slide: function(event, ui) {
                            $('input#min_price').val(ui.values[0]);
                            $('input#max_price').val(ui.values[1]);

                            $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                        },
                        change: function(event, ui) {
                            $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                        }
                    });

                    if (_hasPrice == 1) {
                        $('.reset_price').attr('data-has_price', "1").show();
                        if ($('.price_slider_wrapper').find('button').length) {
                            $('.price_slider_wrapper').find('button').show();
                        }
                    }

                    $('.price_slider, .price_label').show();
                }

                var _destroy_masonry = false;
                $('body').trigger('tradeace_after_loaded_ajax_complete', [_destroy_masonry]);

                shop_load = false;
                infinitiAjax = false;
                
                /**
                 * Run _queue_trigger
                 */
                $('body').trigger('tradeace_after_shop_load_status', [_queue_trigger]);

                /**
                 * 
                 * Title Page
                 */
                var matches = res.match(/<title>(.*?)<\/title>/);
                var _title = typeof matches[1] !== 'undefined' ? matches[1] : '';
                if (_title) {
                    $('title').html(_title);
                }
                
                $('#tradeace-ajax-store').removeClass('crazy-loading');
                
                /**
                 * Fix lazy load
                 */
                setTimeout(function() {
                    if ($('img[data-lazy-src]').length) {
                        $('img[data-lazy-src]').each(function() {
                            var _this = $(this);
                            var _src_real = $(_this).attr('data-lazy-src');
                            var _srcset = $(_this).attr('data-lazy-srcset');
                            var _size = $(_this).attr('data-lazy-sizes');
                            $(_this).attr('src', _src_real);
                            $(_this).removeAttr('data-lazy-src');

                            if (_srcset) {
                                $(_this).attr('srcset', _srcset);
                                $(_this).removeAttr('data-lazy-srcset');
                            }

                            if (_size) {
                                $(_this).attr('sizes', _size);
                                $(_this).removeAttr('data-lazy-sizes');
                            }
                        });
                    }
                }, 100);
            },
            error: function () {
                $('.opacity-2').remove();
                $('.tradeace-filter-by-tax').removeClass('tradeace-disable');
                $('#tradeace-ajax-store').removeClass('crazy-loading');

                shop_load = false;
                infinitiAjax = false;
            }
        });

        if (!_more) {
            window.history.pushState(_url, '', _url);
        }
    }
}

/**
 * Set variaions
 * 
 * @param {type} $
 * @param {type} variations
 * @param {type} keys
 * @returns {unresolved}
 */
function tradeace_set_variations($, variations, keys, current) {
    var _current = typeof current !== 'undefined' ? current : null;
    if (_current) {
        var _tax = $(_current).attr('data-attr');
        var _slug = $(_current).attr('data-term_slug');
        
        if ($(_current).hasClass('tradeace-filter-var-chosen')){
            $('.tradeace-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').parent().removeClass('chosen tradeace-chosen').show();
            $('.tradeace-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').removeClass('tradeace-filter-var-chosen');
        } else {
            $('.tradeace-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').parent().addClass('chosen tradeace-chosen');
            $('.tradeace-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').addClass('tradeace-filter-var-chosen');
        }
    }
    
    $('.tradeace-filter-var-chosen').each(function() {
        var _attr = $(this).attr('data-attr'),
            _attrVal = $(this).attr('data-term_id'),
            _attrSlug = $(this).attr('data-term_slug'),
            _attrType = $(this).attr('data-type');
        var l = variations.length;
        if (keys.indexOf(_attr) === -1) {
            variations.push({
                taxonomy: _attr,
                values: [_attrVal],
                slug: [_attrSlug],
                type: _attrType
            });
            keys.push(_attr);
        } else {
            for (var i = 0; i < l; i++) {
                if (variations[i].taxonomy.length && variations[i].taxonomy === _attr) {
                    if ((variations[i].slug).indexOf(_attrSlug) === -1) {
                        variations[i].values.push(_attrVal);
                        variations[i].slug.push(_attrSlug);
                        break;
                    }
                }
            }
        }
    });

    return variations;
}

/**
 * _act_content
 * @param {type} $
 * @returns {String}
 */
function get_top_filter_actived($) {
    var _act_content = '<div class="tradeace-actived-filter">';
    var _hasActive = false;
    
    if ($('.tradeace-widget-has-active').length) {
        $('.tradeace-widget-has-active').each(function() {
            var _this = $(this);
            var _title = $(_this).find('.widget-title').length ? $(_this).find('.widget-title').html() : '';
            
            // variations
            var _widget_act = $(_this).find('.tradeace-filter-var-chosen').length ? true : false;
            if (_widget_act) {
                _hasActive = true;
                
                _act_content += '<div class="tradeace-wrap-active-top">';
                _act_content += _title ? '<span class="tradeace-active-title">' + _title + '</span>' : '';
                
                $(_this).find('.tradeace-filter-var-chosen').each(function() {
                    var term_id = $(this).attr('data-term_id');
                    var term_slug = $(this).attr('data-term_slug');
                    var _attr = $(this).attr('data-attr');
                    var _type = $(this).attr('data-type');
                    
                    var _class_item = 'tradeace-ignore-variation-item';
                    _class_item += $(this).hasClass('tradeace-filter-color') ? ' tradeace-ignore-color-item' : '';
                    _class_item += $(this).hasClass('tradeace-filter-image') ? ' tradeace-ignore-image-item' : '';
                    _class_item += $(this).hasClass('tradeace-filter-brand-item') ? ' tradeace-ignore-brand-item' : '';
                    
                    var _item = '<a href="javascript:void(0);" class="' + _class_item + '" data-term_id="' + term_id + '" data-term_slug="' + term_slug + '" data-attr="' + _attr + '" data-type="' + _type + '">' + $(this).html() + '</a>';
                    _act_content += '<span class="tradeace-active-item">' + _item + '</span>';
                });
                
                _act_content += '</div>';
            }
            
            // Filter Status
            if ($(_this).find('.tradeace-filter-status.tradeace-active').length) {
                _hasActive = true;

                _act_content += '<div class="tradeace-wrap-active-top">';
                _act_content += _title ? '<span class="tradeace-active-title">' + _title + '</span>' : '';
                
                $(_this).find('.tradeace-filter-status.tradeace-active').each(function() {
                    var _href = $(this).attr('href');
                    var _data_filter = $(this).attr('data-filter');
                    
                    var _item = '<a href="' + _href + '" class="tradeace-ignore-filter-global tradeace-filter-status tradeace-ignore-filter-status" data-filter="' + _data_filter + '">' + $(this).html() + '</a>';
                    
                    _act_content += '<span class="tradeace-active-item">' + _item + '</span>';
                });

                _act_content += '</div>';
            }
            
            // Tradeace Price Slide
            var _price_act = $(_this).find('.tradeace_hasPrice[name="tradeace_hasPrice"]').length ? true : false;
            if (_price_act && $(_this).find('.tradeace_hasPrice[name="tradeace_hasPrice"]').val() === '1') {
                _hasActive = true;
                
                var _price_label = '';
                if ($(_this).find('.price_label .from').length) {
                    _price_label += $(_this).find('.price_label .from').html();
                }
                
                if ($(_this).find('.price_label .to').length) {
                    _price_label += _price_label !== '' ? ' &mdash; ' : '';
                    _price_label += $(_this).find('.price_label .to').html();
                }
                
                var _class_price = _price_label !== '' ? 'tradeace-wrap-active-top' : 'tradeace-price-active-init hidden-tag';
                
                _act_content += '<div class="' + _class_price + '">';
                
                if (_price_label !== '') {
                    _act_content += _title ? '<span class="tradeace-active-title">' + _title + '</span>' : '';

                    var _item = '<a href="javascript:void(0);" class="tradeace-ignore-price-item">' + _price_label + '</a>';
                    _act_content += '<span class="tradeace-active-item">' + _item + '</span>';
                }
                
                _act_content += '</div>';
            }
            
            // Filter List
            if ($(_this).find('.tradeace-price-filter-list .tradeace-active').length) {
                
                var _active_price_list = $(_this).find('.tradeace-price-filter-list .tradeace-active');
                if (!$(_active_price_list).hasClass('tradeace-all-price')) {
                    _hasActive = true;

                    _act_content += '<div class="tradeace-wrap-active-top">';

                    var _price_label = $(_this).find('.tradeace-price-filter-list .tradeace-active').find('.tradeace-filter-price-text').html();

                    _act_content += _title ? '<span class="tradeace-active-title">' + _title + '</span>' : '';

                    var _item = '<a href="javascript:void(0);" class="tradeace-ignore-price-item-list">' + _price_label + '</a>';
                    _act_content += '<span class="tradeace-active-item">' + _item + '</span>';

                    _act_content += '</div>';
                }
            }
            
            // Filter Tags
            if ($(_this).find('.tradeace-filter-tag.tradeace-active').length) {
                _hasActive = true;

                _act_content += '<div class="tradeace-wrap-active-top">';
                _act_content += _title ? '<span class="tradeace-active-title">' + _title + '</span>' : '';
                
                $(_this).find('.tradeace-filter-tag.tradeace-active').each(function() {
                    var _href = $(this).attr('href');
                    var _data_filter = $(this).attr('data-filter');
                    
                    var _item = '<a href="' + _href + '" class="tradeace-ignore-filter-global tradeace-filter-tag tradeace-ignore-filter-tags" data-filter="' + _data_filter + '">' + $(this).html() + '</a>';
                    
                    _act_content += '<span class="tradeace-active-item">' + _item + '</span>';
                });

                _act_content += '</div>';
            }
        });
    }
    
    // Reset btn
    if (_hasActive && $('.tradeace-widget-has-active .tradeace-reset-filters-btn').length) {
        _act_content += '<div class="tradeace-wrap-active-top">';
        
        $('.tradeace-widget-has-active .tradeace-reset-filters-btn').addClass('tradeace-reset-filters-top');
        $('.tradeace-widget-has-active .tradeace-reset-filters-btn').wrap('<div class="tradeace-reset-filters-btn-wrap"></div>');
        
        var _reset_text = $('.tradeace-widget-has-active .tradeace-reset-filters-btn-wrap').html();
        _act_content += _reset_text;
        _act_content += '</div>';
        
        // $('.tradeace-widget-has-active .tradeace-reset-filters-btn').parents('.tradeace-widget-has-active').remove();
    }
    
    _act_content += '</div>';
    
    return _hasActive ? _act_content : '';
}

/**
 * Active Topbar
 * @param {type} $
 * @returns {undefined}
 */
function load_active_topbar($) {
    if ($('.tradeace-tab-filter-topbar').length) {
        $('.tradeace-tab-filter-topbar').each(function() {
            var _this = $(this);
            var _widget = $(_this).attr('data-widget');
            if ($(_widget).length) {
                if (
                    $(_widget).find('.tradeace-filter-var-chosen').length ||
                    ($(_widget).find('input[name="tradeace_hasPrice"]').length && $(_widget).find('input[name="tradeace_hasPrice"]').val() === '1')
                ) {
                    if (!$(_this).hasClass('tradeace-active')) {
                        $(_this).addClass('tradeace-active');
                    }
                } else {
                    $(_this).removeClass('tradeace-active');
                }
            }
        });
    }
    
    $('.tradeace-tranparent-filter').trigger('click');
    $('.transparent-mobile').trigger('click');
}

/**
 * Toggle Sidebar classic
 */
function load_toggle_sidebar_classic($) {
    if ($('.tradeace-with-sidebar-classic').length && $('.tradeace-toogle-sidebar-classic').length) {
        var toggle_show = $.cookie('toggle_sidebar_classic');
        if (toggle_show === 'hide') {
            $('.tradeace-toogle-sidebar-classic').addClass('tradeace-hide');
            $('.tradeace-with-sidebar-classic').addClass('tradeace-with-sidebar-hide');
        } else {
            $('.tradeace-toogle-sidebar-classic').removeClass('tradeace-hide');
            $('.tradeace-with-sidebar-classic').removeClass('tradeace-with-sidebar-hide');
        }

        setTimeout(function() {
            $('body').trigger('tradeace_after_toggle_sidebar_classic_timeout');
        }, 500);
    }
    
    if ($('.tradeace-with-sidebar-classic').length) {
        if ($('.tradeace-with-sidebar-classic .tradeace-filter-wrap > .columns').length && $('.tradeace-with-sidebar-classic .col-sidebar.right').length) {
            $('.tradeace-with-sidebar-classic .tradeace-filter-wrap > .columns').each(function() {
                if (!$(this).hasClass('right')) {
                    $(this).addClass('right');
                }
            });
        }
        
        if (!$('.tradeace-with-sidebar-classic').hasClass('tradeace-inited')) {
            $('.tradeace-with-sidebar-classic').addClass('tradeace-inited');
        }
    }
}

/**
 * Render top bar shop page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_tradeace_top_sidebar($) {
    if ($('.tradeace-top-sidebar').length) {
        var wk = 0;

        var top_row = '<ul class="tradeace-top-row-filter">';

        if ($('input[name="tradeace-labels-filter-text"]').length && $('input[name="tradeace-labels-filter-text"]').val() !== '') {
            top_row += '<li><span class="tradeace-labels-filter-text">' + $('input[name="tradeace-labels-filter-text"]').val() + '</span></li>';
        }

        var rows = '';
        if ($('.tradeace-top-sidebar').find('.tradeace-close-sidebar-wrap').length) {
            rows += $('.tradeace-top-sidebar').find('.tradeace-close-sidebar-wrap').html();
        }
        rows += '<div class="row tradeace-show tradeace-top-sidebar-off-canvas">';
        var _title, _rss;
        var _stt = 1;
        var _limit = parseInt($('input[name="tradeace-limit-widgets-show-more"]').val());
        _limit = (!_limit || _limit < 0) ? 999999 : _limit;
        var _show_more = false;
        $('.tradeace-top-sidebar').find('>.widget').each(function() {
            var _this = $(this);
            
            
            var _widget_act = $(_this).find('.tradeace-filter-var-chosen').length ? true : false;
            if ($(_this).find('input[name="tradeace_hasPrice"]').length && $(_this).find('input[name="tradeace_hasPrice"]').val() === '1') {
                _widget_act = true;
            }

            var _class_act = _widget_act ? ' tradeace-active' : '';
            if ($(_this).find('.widget-title').length) {
                _title = $(_this).find('.widget-title').html();
                _rss = '';
                if ($(_this).find('.widget-title').find('a').length) {
                    _title = '';
                    $(_this).find('.widget-title').find('a').each(function() {
                        if ($(this).find('img').length) {
                            _rss += $(this).html();
                        } else {
                            _title += $(this).html();
                        }
                    });
                }
            } else {
                _title = '...';
            }

            var _widget_key = 'tradeace-widget-key-' + wk.toString();
            var _old_id = $(_this).attr('id');
            var _class_row = '';
            var _filter_push_cat = false;

            var _li_class = _stt <= _limit ? ' tradeace-widget-show' : ' tradeace-widget-show-less';

            if ($(_this).find('.tradeace-widget-filter-cats-topbar').length) {
                if ($('.tradeace-push-cat-filter').length === 1) {
                    _filter_push_cat = true;
                    _class_act += ' tradeace-tab-push-cats';
                    _li_class += ' tradeace-widget-categories';
                    $('.tradeace-push-cat-filter').html($(_this).wrap('<div>').parent().html());
                } else {
                    _class_act += ' tradeace-tab-filter-cats';
                    _class_row += ' tradeace-widget-cat-wrap';
                }
            }

            var _icon_before = _filter_push_cat ? '<i class="pe-7s-note2"></i>' : '';
            var _icon_after = !_filter_push_cat ? '<i class="pe-7s-angle-down"></i>' : '';

            var _reset_btn = $(_this).find('.tradeace-reset-filters-btn').length ? true : false;
            if (_reset_btn) {
                _li_class += ' tradeace-widget-reset-filter tradeace-widget-has-active';
                _stt = _stt-1;
            }

            top_row += '<li class="tradeace-widget-toggle' + _li_class + '">';
            if (!_reset_btn) {
                top_row += '<a class="tradeace-tab-filter-topbar' + _class_act + '" href="javascript:void(0);" title="' + _title + '" data-widget="#' + _widget_key + '" data-key="' + wk + '" data-old_id="' + _old_id + '">' + _icon_before + _rss + _title + _icon_after + '</a>';
            }
            else {
                top_row += $(_this).find('.tradeace-reset-filters-btn').wrap('<div>').parent().html();
            }
            top_row += '</li>';

            if (!_filter_push_cat && $(_this).find('.tradeace-reset-filters-btn').length <= 0) {
                rows += '<div class="large-12 columns tradeace-widget-wrap' + _class_row + '" id="' + _widget_key + '" data-old_id="' + _old_id + '">';
                rows += $(_this).wrap('<div>').parent().html();
                rows += '</div>';
            }

            if (_stt > _limit) {
                _show_more = true;
            }

            wk++;
            _stt++;
        });

        if (_show_more) {
            top_row += '<li class="tradeace-widget-show-more">';
            top_row += '<a class="tradeace-widget-toggle-show" href="javascript:void(0);" data-show="0">' + $('input[name="tradeace-widget-show-more-text"]').val() + '</a>';
            top_row += '</li>';
        }

        if ($('.showing_info_top').length) {
            top_row += '<li class="last">';
            top_row += '<div class="showing_info_top">';
            top_row += $('.showing_info_top').html();
            top_row += '</div></li>';
        }

        top_row += '</ul>';
        rows += '</div>';
        
        $('.tradeace-top-sidebar').html(rows).removeClass('hidden-tag');
        $('.tradeace-labels-filter-accordion').html(top_row);
        $('.tradeace-labels-filter-accordion').addClass('tradeace-inited');

        /**
         * Show | Hide price filter
         */
        if ($('.tradeace-top-sidebar .tradeace-filter-price-widget-wrap').length) {
            $('.tradeace-top-sidebar .tradeace-filter-price-widget-wrap').each(function() {
                var _wrap_price_hide = $(this).parents('.tradeace-widget-wrap');
                
                if ($(this).hasClass('tradeace-hide-price')) {
                    if ($(_wrap_price_hide).length) {
                        var _tabtop = $(_wrap_price_hide).attr('id');
                        if ($('.tradeace-tab-filter-topbar[data-widget="#' + _tabtop + '"]').parents('.tradeace-widget-toggle').length) {
                            $('.tradeace-tab-filter-topbar[data-widget="#' + _tabtop + '"]').parents('.tradeace-widget-toggle').hide();
                        }
                        
                        $(_wrap_price_hide).addClass('hidden-tag');
                    }
                }
            });
        }
    }
}

/**
 * Click top filter
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} type
 * @returns {undefined}
 */
function top_filter_click($, _this, type) {
    if (!$(_this).hasClass('tradeace-tab-push-cats')) {
        var _obj = $(_this).attr('data-widget');
        var _wrap_content = $('.tradeace-top-sidebar');

        var _act = $(_obj).hasClass('tradeace-active') ? true : false;
        $(_this).parents('.tradeace-top-row-filter').find('> li').removeClass('tradeace-active');
        $(_wrap_content).find('.tradeace-widget-wrap').removeClass('tradeace-active').slideUp(350);
        if (type === 'animate') {
            $(_wrap_content).find('.tradeace-widget-wrap').removeClass('tradeace-active').slideUp(350);
        } else {
            $(_wrap_content).find('.tradeace-widget-wrap').removeClass('tradeace-active').hide();
        }

        if (!_act) {
            if (type === 'animate') {
                $(_obj).addClass('tradeace-active').slideDown(350);
            } else {
                $(_obj).addClass('tradeace-active').show();
            }
            $(_this).parents('li').addClass('tradeace-active');
        }

        if ($(_this).hasClass('tradeace-tab-filter-cats')) {
            $('body').trigger('tradeace_init_topbar_categories');
        }
    } else {
        $(_this).toggleClass('tradeace-push-cat-show');
        $('.tradeace-push-cat-filter').toggleClass('tradeace-push-cat-show');
        $('.tradeace-products-page-wrap').toggleClass('tradeace-push-cat-show');
        $('.black-window-mobile').toggleClass('tradeace-push-cat-show');
        
        setTimeout(function() {
            $('body').trigger('tradeace_after_push_cats_timeout');
        }, 1000);
    }
}

/**
 * Render top bar 2 shop page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_tradeace_top_sidebar_2($, _start) {
    var start = typeof _start !== 'undefined' && _start ? _start : false;
    
    if ($('.tradeace-top-sidebar-2').length) {
        var _wrap = $('.tradeace-top-sidebar-2');
        
        if (!$(_wrap).hasClass('tradeace-slick-slider')) {
            $(_wrap).addClass('tradeace-slick-slider');
            $(_wrap).addClass('tradeace-slick-nav');
        }
        
        $(_wrap).attr('data-autoplay', 'false');
        $(_wrap).attr('data-switch-custom', '480');
        
        var _width = $(window).width();
        var _tab = parseInt($(_wrap).attr('data-switch-tablet'));
        var _desk = parseInt($(_wrap).attr('data-switch-desktop'));
        _tab = !_tab ? 768 : _tab;
        _desk = !_desk ? 1130 : _desk;
        
        var _cols = parseInt($(_wrap).attr('data-columns'));
        var _cols_tab = parseInt($(_wrap).attr('data-columns-tablet'));
        var _cols_small = parseInt($(_wrap).attr('data-columns-small'));
        
        _cols = !_cols ? 4 : _cols;
        _cols_tab = !_cols_tab ? 3 : _cols_tab;
        _cols_small = !_cols_small ? 2 : _cols_small;
        
        var _count = $(_wrap).find('.tradeace-widget-store').length;
        
        /**
         * Check start in Desktop
         */
        if (_width >= _desk && _count <= _cols) {
            start = 0;
        }
        
        /**
         * Check start in Tablet
         */
        if (_width < _desk && _width >= _cols_tab && _count <= _cols_tab) {
            start = 0;
        }
        
        /**
         * Check start in Mobile
         */
        if (_width < _cols_tab && _count <= _cols_small) {
            start = 0;
        }
        
        /**
         * Set start
         */
        if (start) {
            $(_wrap).attr('data-start', start);
        }
        
        /**
         * init Slick Slider
         */
        $('body').trigger('tradeace_load_slick_slider');
    }
}

/**
 * Toggle Top Side bar type 2
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} type
 * @returns {undefined}
 */
function top_filter_click_2($, _this, type, _start) {
    if ($('.tradeace-top-bar-2-content').length) {
        var _act = $(_this).hasClass('tradeace-active') ? true : false;
        
        if (!_act) {
            var start = typeof _start !== 'undefined' && _start ? _start : false;
            
            if (type === 'animate') {
                $('.tradeace-top-bar-2-content').addClass('tradeace-active').slideDown(350);
                
                setTimeout(function() {
                    init_tradeace_top_sidebar_2($, start);
                }, 350);
            } else {
                $('.tradeace-top-bar-2-content').addClass('tradeace-active').show();
                init_tradeace_top_sidebar_2($, start);
                
                setTimeout(function() {
                    $(window).trigger('resize');
                }, 10);
            }
                
            $(_this).addClass('tradeace-active');
        }
        
        else {
            if (type === 'animate') {
                $('.tradeace-top-bar-2-content').removeClass('tradeace-active').slideUp(350);
            } else {
                $('.tradeace-top-bar-2-content').removeClass('tradeace-active').fadeOut(350);
            }
            
            $(_this).removeClass('tradeace-active');
        }
    }
}


/**
 * Change layout Grid | List shop page
 * 
 * @param {type} $
 * @param {type} _this
 * @returns {undefined}
 */
function change_layout_shop_page($, _this) {
    var value_cookie, item_row, class_items;
    var _cookie_name = $('input[name="tradeace_archive_grid_view"]').length ? $('input[name="tradeace_archive_grid_view"]').val() : 'tradeace_archive_grid_view';
    var _old_cookie = $.cookie(_cookie_name);
    var _destroy = _old_cookie !== 'list' ? false : true;
    if ($(_this).hasClass('productList')) {
        value_cookie = 'list';
        _destroy = true;
        $('.tradeace-content-page-products .products').removeClass('grid').addClass('list');
        
        $('body').trigger('tradeace_store_changed_layout_list');
    } else {
        var columns = $(_this).attr('data-columns');
        class_items = 'products grid';

        switch (columns) {
            case '2' :
                item_row = 2;
                value_cookie = 'grid-2';
                class_items += ' large-block-grid-2';
                break;
            case '3' :
                item_row = 3;
                value_cookie = 'grid-3';
                class_items += ' large-block-grid-3';
                break;
            
            case '5' :
                item_row = 5;
                value_cookie = 'grid-5';
                class_items += ' large-block-grid-5';
                break;
                
            case '6' :
                item_row = 5;
                value_cookie = 'grid-6';
                class_items += ' large-block-grid-6';
                break;
                
            case '4' :
            default :
                item_row = 4;
                value_cookie = 'grid-4';
                class_items += ' large-block-grid-4';
                break;
        }

        var count = $('.tradeace-content-page-products .products').find('.product-warp-item').length;
        if (count > 0) {
            var _wrap_all = $('.tradeace-content-page-products .products');
            var _col_small = $(_wrap_all).attr('data-columns_small');
            var _col_medium = $(_wrap_all).attr('data-columns_medium');
            
            switch (_col_small) {
                case '2' :
                    class_items += ' small-block-grid-2';
                    break;
                case '1' :
                default :
                    class_items += ' small-block-grid-1';
                    break;
            }
            
            switch (_col_medium) {
                case '3' :
                    class_items += ' medium-block-grid-3';
                    break;
                case '4' :
                    class_items += ' medium-block-grid-4';
                    break;
                case '2' :
                default :
                    class_items += ' medium-block-grid-2';
                    break;
            }
            
            $('.tradeace-content-page-products .products').attr('class', class_items);
        }
        
        $('body').trigger('tradeace_store_changed_layout_grid', [columns, class_items]);
    }

    $(".tradeace-change-layout").removeClass("active");
    $(_this).addClass("active");
    $.cookie(_cookie_name, value_cookie, {expires: _cookie_live, path: '/'});
    
    $('body').trigger('tradeace_before_change_view');
    
    setTimeout(function() {
        $('body').trigger('tradeace_before_change_view_timeout', [_destroy]);
    }, 500);
}

/**
 * clone group btn loop products
 * 
 * @param {type} $
 * @returns {undefined}
 */
function clone_group_btns_product_item($) {
    var _list = $('.products').length && $('.products').hasClass('list') ? true : false;
    
    if (_list && $('.tradeace-content-page-products .product-item').length) {
        $('.tradeace-content-page-products .product-item').each(function() {
            var _wrap = $(this);
            var _this = $(_wrap).find('.tradeace-btns-product-item');
            
            if (!$(_wrap).hasClass('tradeace-list-cloned')) {
                $(_wrap).addClass('tradeace-list-cloned');
                
                if ($(_wrap).find('.group-btn-in-list').length <= 0) {
                    $(_wrap).append('<div class="group-btn-in-list tradeace-group-btns hidden-tag"></div>');
                }
                    
                var _place = $(_wrap).find('.group-btn-in-list');
                var _html = '';
                var _price = '';
                if ($(_wrap).find('.price-wrap').length) {
                    _price = $(_wrap).find('.price-wrap').html();
                } else if ($(_wrap).find('.price').length) {
                    _price = $(_wrap).find('.price').clone().wrap('<div class="price-wrap"></div>').parent().html();
                }

                _html += _price !== '' ? '<div class="price-wrap">' + _price + '</div>' : '';

                if ($(_wrap).find('.tradeace-list-stock-wrap').length) {
                    _html += $(_wrap).find('.tradeace-list-stock-wrap').html();
                    $(_wrap).find('.tradeace-list-stock-wrap').remove();
                }
                
                if ($(_this).length && $(_place).length) {
                    _html += $(_this).html();
                    $(_place).html(_html);
                    if ($(_place).find('.btn-link').length) {
                        $(_place).find('.btn-link').each(function() {
                            if (
                                $(this).find('.tradeace-icon-text').length <= 0 &&
                                $(this).find('.tradeace-icon').length &&
                                $(this).attr('data-icon-text')
                            ) {
                                $(this).find('.tradeace-icon').after(
                                    '<span class="tradeace-icon-text">' +
                                        $(this).attr('data-icon-text') +
                                    '</span>'
                                );
                            }
                        });
                    }
                }
            }
        }); 
    }
}
