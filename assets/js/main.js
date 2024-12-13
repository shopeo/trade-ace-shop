var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);

var wow_enable = false,
    fullwidth = 1200,
    _lightbox_variations = [],
    _count_wishlist_items = 0,
    searchProducts = null;

if (typeof _cookie_live === 'undefined') {
    var _cookie_live = 7;
}
    
/* Document ready */
jQuery(document).ready(function($) {
"use strict";

/**
 * Init Wow effect
 */
if ($('body').hasClass('tradeace-enable-wow')) {
    wow_enable = true;
    new WOW({mobile: false}).init();
}

/**
 * Before Load site
 */
if ($('#tradeace-before-load').length) {
    $('#tradeace-before-load').fadeOut(100);
    
    setTimeout(function() {
        $('#tradeace-before-load').remove();
    }, 100);
}

/**
 * Site Loaded
 */
$('body').addClass('tradeace-body-loaded');
var _hash = location.hash || null;
if (_hash) {
    if ($('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').length) {
        setTimeout(function() {
            $('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').trigger('click');
        }, 500);
    }
    
    if ($(_hash).length) {
        setTimeout(function() {
            $('body').trigger('tradeace_animate_scroll_to_top', [$, _hash, 500]);
        }, 1000);
    }
}

/**
 * Fix vertical mega menu
 */
var width_default = 200;
$('body').on('mousemove', '.vertical-menu-container .tradeace-megamenu', function() {
    var _wrap = $(this).parents('.vertical-menu-wrapper');
    var _h_vertical = $(_wrap).outerHeight();

    $(_wrap).find('.tradeace-megamenu').removeClass('tradeace-curent-hover');
    $(_wrap).addClass('tradeace-curent-hover');

    var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.tradeace-row');
    var _w_mega, _w_mega_df, _w_ss;
    var total_w = $(_row).length ? $(_row).width() : 900;

    $(_wrap).find('.tradeace-megamenu').each(function() {
        var _this = $(this);

        var current_w = $(_this).outerWidth();
        _w_mega = _w_mega_df = total_w - current_w;

        if ($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')) {
            _w_mega = _w_mega - 20;
        } else {
            if ($(_this).hasClass('cols-2')) {
                _w_mega = _w_mega / 5 * 2 + 50;
                _w_ss = width_default * 2;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-3')) {
                _w_mega = _w_mega / 5 * 3 + 50;
                _w_ss = width_default * 3;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-4')) {
                _w_mega = _w_mega / 5 * 4 + 50;
                _w_ss = width_default * 4;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
        }

        $(_this).find('>.nav-dropdown').css({'width': _w_mega});
        if ($(_this).find('>.nav-dropdown >.sub-menu').length) {
            $(_this).find('>.nav-dropdown >.sub-menu').css({'min-height': _h_vertical});
        }
    });
});

$('body').on('mouseover', '.vertical-menu-wrapper .menu-item-has-children.default-menu', function() {
    var _wrap = $(this).parents('.vertical-menu-wrapper');
    $(this).find('> .nav-dropdown > .sub-menu').css({'width': width_default});

    var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.tradeace-row');

    var _w_mega, _w_mega_df, _w_ss;
    var total_w = $(_row).length ? $(_row).width() : 900;

    $(_wrap).find('.tradeace-megamenu').each(function() {
        var _this = $(this);

        var current_w = $(_this).outerWidth();
        _w_mega = _w_mega_df = total_w - current_w;

        if ($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')) {
            _w_mega = _w_mega - 20;
        } else {
            if ($(_this).hasClass('cols-2')) {
                _w_mega = _w_mega / 5 * 2 + 50;
                _w_ss = width_default * 2;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-3')) {
                _w_mega = _w_mega / 5 * 3 + 50;
                _w_ss = width_default * 3;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-4')) {
                _w_mega = _w_mega / 5 * 4 + 50;
                _w_ss = width_default * 4;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
        }

        $(_this).find('>.nav-dropdown').css({'width': _w_mega});
    });
});

/**
 * Off Canvas Menu
 */
$('body').on('tradeace_after_load_mobile_menu', function() {
    if ($('.tradeace-off-canvas').length) {
        $('.tradeace-off-canvas').remove();
    }
});

$('body').on('click', '.tradeace-menu-off', function() {
    init_header_responsive($);
    
    if ($('#tradeace-menu-sidebar-content').length && !$('#tradeace-menu-sidebar-content').hasClass('all-screen')) {
        $('#tradeace-menu-sidebar-content').addClass('all-screen');
    }
    
    if ($('.tradeace-mobile-menu_toggle').length) {
        $('.tradeace-mobile-menu_toggle').trigger('click');
    }
});

/**
 * Init menu mobile
 */
$('body').on('click', '.tradeace-mobile-menu_toggle', function() {
    init_menu_mobile($);
    
    if ($('#mobile-navigation').length) {
        if ($('#mobile-navigation').attr('data-show') !== '1') {
            if ($('#tradeace-menu-sidebar-content').hasClass('tradeace-dark')) {
                $('.black-window').addClass('tradeace-transparent');
            }
            
            $('.black-window').show().addClass('desk-window');
            
            if ($('#tradeace-menu-sidebar-content').length && !$('#tradeace-menu-sidebar-content').hasClass('tradeace-active')) {
                $('#tradeace-menu-sidebar-content').addClass('tradeace-active');
            }
            
            $('#mobile-navigation').attr('data-show', '1');
        } else {
            $('.black-window').trigger('click');
        }
    }
});

$('body').on('click', '.tradeace-close-menu-mobile, .tradeace-close-sidebar', function() {
    $('.black-window').trigger('click');
});

/**
 * Accordion Mobile Menu
 */
$('body').on('click', '.tradeace-menu-accordion .li_accordion > a.accordion', function(e) {
    e.preventDefault();
    var ths = $(this).parent();
    var cha = $(ths).parent();
    if (!$(ths).hasClass('active')) {
        var c = $(cha).children('li.active');
        $(c).removeClass('active').children('.nav-dropdown-mobile').css({height:'auto'}).slideUp(300);
        $(ths).children('.nav-dropdown-mobile').slideDown(300).parent().addClass('active');
    } else {
        $(ths).find('>.nav-dropdown-mobile').slideUp(300).parent().removeClass('active');
    }
    return false;
});

/**
 * Accordion Element
 */
$('body').on('click', '.tradeace-accordion .li_accordion > a.accordion', function() {
    var _current = $(this);

    var _this = $(_current).parent();
    var _parent = $(_this).parent();

    if (!$(_this).hasClass('active')) {
        $(_parent).removeClass('tradeace-current-tax-parent').removeClass('current-tax-item');
        var act = $(_parent).children('li.active');
        $(act).removeClass('active').children('.children').slideUp(300);
        $(_this).addClass('active').children('.children').slideDown(300);
    }

    else {
        $(_this).removeClass('active').children('.children').slideUp(300);
    }

    return false;
});

/**
 * Close MagnificPopup
 */
$('body').on('click', '.tradeace-mfp-close', function() {
    $.magnificPopup.close();
});

var _loadingBeforeResize = setTimeout(function() {
    /**
     * Main menu Reponsive
     */
    load_responsive_main_menu($);
}, 100);

/**
 * Window Scroll - Resize
 * 
 * @type Number
 */
var headerHeight = $('#header-content').length ? $('#header-content').height() : 0;
var timeOutFixedHeader;
$(window).on('scroll', function() {
    var scrollTop = $(this).scrollTop();
    
    if ($('body').find('.tradeace-header-sticky').length && $('.sticky-wrapper').length) {
        var fix_top = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
        var _heightFixed = $('.sticky-wrapper').outerHeight();
        
        if (scrollTop > headerHeight) {
            if (typeof timeOutFixedHeader !== 'undefined') {
                clearTimeout(timeOutFixedHeader);
            }
            
            if (!$('.sticky-wrapper').hasClass('fixed-already')) {
                $('.sticky-wrapper').addClass('fixed-already');
                $('.tradeace-header-sticky').css({'margin-bottom': _heightFixed});
                if (fix_top > 0) {
                    $('.sticky-wrapper').css({top: fix_top});
                }
            }
        } else {
            $('.sticky-wrapper').removeClass('fixed-already');
            $('.tradeace-header-sticky').removeAttr('style');
            $('.sticky-wrapper').removeAttr('style');
            
            if ($('body').hasClass('rtl')) {
                $('.sticky-wrapper').css({'overflow': 'hidden'});
            
                timeOutFixedHeader = setTimeout(function() {
                    $('.sticky-wrapper').css({'overflow': 'unset'});
                }, 10);
            }
            
            _heightFixed = $('.sticky-wrapper').outerHeight();
        }
    }
    
    if ($('.tradeace-nav-extra-warp').length) {
        if (scrollTop > headerHeight) {
            if (!$('.tradeace-nav-extra-warp').hasClass('tradeace-show')) {
                $('.tradeace-nav-extra-warp').addClass('tradeace-show');
            }
        } else {
            if ($('.tradeace-nav-extra-warp').hasClass('tradeace-show')) {
                $('.tradeace-nav-extra-warp').removeClass('tradeace-show');
            }
        }
    }
    
    /* Back to Top */
    if ($('#tradeace-back-to-top').length) {
        if (typeof intervalBTT !== 'undefined' && intervalBTT) {
            clearInterval(intervalBTT);
        }
        
        var intervalBTT = setInterval(function() {
            var _height_win = $(window).height() / 2;
            if (scrollTop > _height_win) {
                if (!$('#tradeace-back-to-top').hasClass('tradeace-show')) {
                    $('#tradeace-back-to-top').addClass('tradeace-show');
                }
            } else {
                $('#tradeace-back-to-top').removeClass('tradeace-show');
            }
            
            clearInterval(intervalBTT);
        }, 100);
    }
});

$(window).on('resize', function() {
    var _mobileView = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('tradeace-in-mobile') ? true : false;

    // Fix Sidebar Mobile, Search Mobile display switch to desktop
    var desk = $('.black-window').hasClass('desk-window');
    if (!_mobileView && !desk && !_inMobile) {
        if ($('.col-sidebar').length) {
            $('.col-sidebar').removeClass('tradeace-active');
        }
        if ($('.warpper-mobile-search').length && !$('.warpper-mobile-search').hasClass('show-in-desk')) {
            $('.warpper-mobile-search').removeClass('tradeace-active');
        }
        if ($('.black-window').length) {
            $('.black-window').hide();
        }
    }
    
    /**
     * Active Filter cat top
     */
    init_top_categories_filter($);
    
    /**
     * Header Responsive
     */
    init_header_responsive($);

    /* Fix width menu vertical */
    if ($('.wide-nav .tradeace-vertical-header').length) {
        var _v_width = $('.wide-nav .tradeace-vertical-header').width();
        _v_width = _v_width < 280 ? 280: _v_width;
        $('.wide-nav .vertical-menu-container').css({'width': _v_width});
    }
    
    var _height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    if (_height_adminbar > 0 && $('#mobile-navigation').length === 1) {
        $('#tradeace-menu-sidebar-content').css({'top': _height_adminbar});
        
        if ($('#mobile-navigation').attr('data-show') === '1' && !_mobileView && $('.tradeace-menu-off').length <= 0) {
            var _scrollTop = $(window).scrollTop();
            var _headerHeight = $('#header-content').height() + 50;
            if (_scrollTop <= _headerHeight) {
                $('.black-window').trigger('click');
            }
        }
    }
    
    clearTimeout(_loadingBeforeResize);
    _loadingBeforeResize = setTimeout(function() {
        /**
         * Main menu Reponsive
         */
        load_responsive_main_menu($);
    }, 1100);
    
    clearTimeout(_positionMobileMenu);
    _positionMobileMenu = setTimeout(function() {
        position_menu_mobile($);
    }, 100);
});

var _positionMobileMenu = setTimeout(function() {
    position_menu_mobile($);
}, 100);

/**
 * Accordions
 */
$('body').on('click', '.tradeace-accordions-content .tradeace-accordion-title a', function() {
    var _this = $(this);
    var warp = $(_this).parents('.tradeace-accordions-content');
    var _global = $(warp).hasClass('tradeace-no-global') ? true : false;
    $(warp).removeClass('tradeace-accodion-first-show');
    var _id = $(_this).attr('data-id');
    var _index = false;
    if (typeof _id === 'undefined' || !_id) {
        _index = $(_this).attr('data-index');
    }
    
    var _current = _index ? $(warp).find('.' + _index) : $(warp).find('#tradeace-section-' + _id);

    if (!$(_this).hasClass('active')) {
        if (!_global) {
            $(warp).find('.tradeace-accordion-title a').removeClass('active');
            $(warp).find('.tradeace-panel.active').removeClass('active').slideUp(200);
        }
        
        $(_this).addClass('active');
        if ($(_current).length) {
            $(_current).addClass('active').slideDown(200);
        }
    } else {
        $(_this).removeClass('active');
        if ($(_current).length) {
            $(_current).removeClass('active').slideUp(200);
        }
    }

    return false;
});

/**
 * After Quick view
 */
$('body').on('tradeace_after_quickview_timeout', function() {
    init_accordion($);
    
    /**
     * VC Progress bar
     */
    if ($('.product-lightbox .vc_progress_bar .vc_bar').length) {
        $('.product-lightbox .vc_progress_bar .vc_bar').each(function() {
            var _this = $(this);
            var _per = $(_this).attr('data-percentage-value');
            $(_this).css({'width': _per + '%'});
        });
    }
});

/**
 * Tabs Content
 */
$('body').on('click', '.tradeace-tabs a', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    if (!$(_this).parent().hasClass('active')) {
        var _root = $(_this).parents('.tradeace-tabs-content');
        var _tradeace_tabs = $(_root).find('.tradeace-tabs');
        
        
        var currentTab = $(_this).attr('data-id');
        if (typeof currentTab === 'undefined' || !currentTab) {
            var _index = $(_this).attr('data-index');
            currentTab = $(_root).find('.' + _index);
        }
        
        $(_root).find('.tradeace-tabs > li').removeClass('active');
        $(_this).parent().addClass('active');
        $(_root).find('.tradeace-panel').removeClass('active').hide();
        
        if ($(currentTab).length) {
            $(currentTab).addClass('active').show();
        }

        if ($(_tradeace_tabs).hasClass('tradeace-slide-style')) {
            tradeace_tab_slide_style($, _tradeace_tabs, 500);
        }
        
        $('body').trigger('tradeace_after_changed_tab_content', [currentTab]);
    }
});

/**
 * After changed tab content
 */
$('body').on('tradeace_after_changed_tab_content', function(ev, currentTab) {
    if (wow_enable && $(currentTab).length) {
        var _delay = 10;
        var _has_slide = false;
        if ($(currentTab).find('.tradeace-slick-slider .wow').length) {
            $(currentTab).find('.tradeace-slick-slider .wow').removeClass('tradeace-visible');
            _has_slide = true;
        }
        
        $(currentTab).find('.wow').each(function() {
            var _wow = $(this);
            $(_wow).css({
                'animation-name': 'fadeInUp',
                'visibility': 'visible',
                'opacity': 0
            });
            
            if ($(_wow).hasClass())
            
            _delay += parseInt($(_wow).attr('data-wow-delay'));
            
            setTimeout(function() {
                if (_has_slide) {
                    $(_wow).addClass('tradeace-visible');
                }
                
                $(_wow).animate({
                    'opacity': 1
                }, 100);
            }, _delay);
        });
        
        $(window).trigger('resize');
    }
    
    ev.preventDefault();
});

/*********************************************************************
// ! Promo popup
/ *******************************************************************/
var et_popup_closed = $.cookie('tradeace_popup_closed');
if (et_popup_closed !== 'do-not-show' && $('.tradeace-popup').length && $('body').hasClass('open-popup')) {
    var _delayremoVal = parseInt($('.tradeace-popup').attr('data-delay'));
    _delayremoVal = !_delayremoVal ? 300 : _delayremoVal * 1000;
    var _disableMobile = $('.tradeace-popup').attr('data-disable_mobile') === 'true' ? true : false;
    var _one_time = $('.tradeace-popup').attr('data-one_time');
    
    $('.tradeace-popup').magnificPopup({
        items: {
            src: '#tradeace-popup',
            type: 'inline'
        },
        closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>',
        removalDelay: 300,
        fixedContentPos: true,
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = 'my-mfp-slide-bottom';
            },
            beforeClose: function() {
                var showagain = $('#showagain:checked').val();
                if (showagain === 'do-not-show' || _one_time === '1') {
                    $.cookie('tradeace_popup_closed', 'do-not-show', {expires: _cookie_live, path: '/'});
                }
            }
        },
        disableOn: function() {
            if (_disableMobile && $(window).width() <= 640) {
                return false;
            }
            
            return true;
        }
    });
    
    setTimeout(function() {
        $('.tradeace-popup').magnificPopup('open');
    }, _delayremoVal);
    
    $('body').on('click', '#tradeace-popup input[type="submit"]', function() {
        $(this).ajaxSuccess(function(event, request, settings) {
            if (typeof request === 'object' && request.responseJSON.status === 'mail_sent') {
                $('body').append('<div id="tradeace-newsletter-alert" class="hidden-tag"><div class="wpcf7-response-output wpcf7-mail-sent-ok">' + request.responseJSON.message + '</div></div>');

                $.cookie('tradeace_popup_closed', 'do-not-show', {expires: _cookie_live, path: '/'});
                $.magnificPopup.close();

                setTimeout(function() {
                    $('#tradeace-newsletter-alert').fadeIn(300);

                    setTimeout(function() {
                        $('#tradeace-newsletter-alert').fadeOut(500);
                    }, 2000);
                }, 300);
            }
        });
    });
}

/*
 * Compare products
 */
$('body').on('click', '.btn-compare', function() {
    var _this = $(this);
    if (!$(_this).hasClass('tradeace-compare')) {
        var _button = $(_this).parent();
        if ($(_button).find('.compare-button .compare').length) {
            $(_button).find('.compare-button .compare').trigger('click');
        }
    } else {
        var _id = $(_this).attr('data-prod');
        if (_id) {
            add_compare_product(_id, $);
        }
    }
    
    return false;
});

/**
 * Remove item from Compare
 */
$('body').on('click', '.tradeace-remove-compare', function() {
    var _id = $(this).attr('data-prod');
    if (_id) {
        remove_compare_product(_id, $);
    }
    
    return false;
});

/**
 * Remove All items from Compare
 */
$('body').on('click', '.tradeace-compare-clear-all', function() {
    remove_all_compare_product($);
    
    return false;
});

/**
 * Show Compare
 */
$('body').on('click', '.tradeace-show-compare', function() {
    load_compare($);
    
    if (!$(this).hasClass('tradeace-showed')) {
        show_compare($);
    } else {
        hide_compare($);
    }
    
    return false;
});

/**
 * Wishlist products
 */
$('body').on('click', '.btn-wishlist', function() {
    var _this = $(this);
    if (!$(_this).hasClass('tradeace-disabled')) {
        $('.btn-wishlist').addClass('tradeace-disabled');
        
        /**
         * TradeaceTheme Wishlist
         */
        if ($(_this).hasClass('btn-tradeace-wishlist')) {
            var _pid = $(_this).attr('data-prod');
            
            if (!$(_this).hasClass('tradeace-added')) {
                $(_this).addClass('tradeace-added');
                tradeace_process_wishlist($, _pid, 'tradeace_add_to_wishlist');
            } else {
                $(_this).removeClass('tradeace-added');
                tradeace_process_wishlist($, _pid, 'tradeace_remove_from_wishlist');
            }
        }
        
        /**
         * Yith WooCommerce Wishlist
         */
        else {
            if (!$(_this).hasClass('tradeace-added')) {
                $(_this).addClass('tradeace-added');

                if ($('#tmpl-tradeace-global-wishlist').length) {
                    var _pid = $(_this).attr('data-prod');
                    var _origin_id = $(_this).attr('data-original-product-id');
                    var _ptype = $(_this).attr('data-prod_type');
                    var _wishlist_tpl = $('#tmpl-tradeace-global-wishlist').html();
                    if ($('.tradeace-global-wishlist').length <= 0) {
                        $('body').append('<div class="tradeace-global-wishlist"></div>');
                    }

                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_id%%/g, _pid);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_type%%/g, _ptype);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%original_product_id%%/g, _origin_id);

                    $('.tradeace-global-wishlist').html(_wishlist_tpl);
                    $('.tradeace-global-wishlist').find('.add_to_wishlist').trigger('click');
                } else {
                    var _button = $(_this).parent();
                    if ($(_button).find('.add_to_wishlist').length) {
                        $(_button).find('.add_to_wishlist').trigger('click');
                    }
                }
            } else {
                var _pid = $(_this).attr('data-prod');
                if (_pid && $('#yith-wcwl-row-' + _pid).length && $('#yith-wcwl-row-' + _pid).find('.tradeace-remove_from_wishlist').length) {
                    $(_this).removeClass('tradeace-added');
                    $(_this).addClass('tradeace-unliked');
                    $('#yith-wcwl-row-' + _pid).find('.tradeace-remove_from_wishlist').trigger('click');

                    setTimeout(function() {
                        $(_this).removeClass('tradeace-unliked');
                    }, 1000);
                } else {
                    $('.btn-wishlist').removeClass('tradeace-disabled');
                }
            }
        }
    }
    
    return false;
});

/* ADD PRODUCT WISHLIST NUMBER */
$('body').on('added_to_wishlist', function() {
    if (typeof tradeace_ajax_params !== 'undefined' && typeof tradeace_ajax_params.ajax_url !== 'undefined') {
        var _data = {};
        _data.action = 'tradeace_update_wishlist';
        _data.added = true;

        if ($('.tradeace-value-gets').length && $('.tradeace-value-gets').find('input').length) {
            $('.tradeace-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data[_key] = _val;
            });
        }
        
        $.ajax({
            url: tradeace_ajax_params.ajax_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function() {

            },
            success: function(res) {
                $('.wishlist_sidebar').replaceWith(res.list);
                var _sl_wishlist = (res.count).toString().replace('+', '');
                var sl_wislist = parseInt(_sl_wishlist);
                $('.tradeace-mini-number.wishlist-number').html(res.count);

                if (sl_wislist > 0) {
                    $('.tradeace-mini-number.wishlist-number').removeClass('tradeace-product-empty');
                } else if (sl_wislist === 0 && !$('.tradeace-mini-number.wishlist-number').hasClass('tradeace-product-empty')) {
                    $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                }

                if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                    if ($('.tradeace-close-notice').length) {
                        $('.tradeace-close-notice').trigger('click');
                    }

                    $('#yith-wcwl-popup-message').html(res.mess);

                    $('#yith-wcwl-popup-message').fadeIn();
                    setTimeout( function() {
                        $('#yith-wcwl-popup-message').fadeOut();
                    }, 2000);
                }

                setTimeout(function() {
                    init_wishlist_icons($, true);
                    $('.btn-wishlist').removeClass('tradeace-disabled');
                }, 350);
            },
            error: function() {
                $('.btn-wishlist').removeClass('tradeace-disabled');
            }
        });
    }
});

/* REMOVE PRODUCT WISHLIST NUMBER */
$('body').on('click', '.tradeace-remove_from_wishlist', function() {
    if (typeof tradeace_ajax_params !== 'undefined' && typeof tradeace_ajax_params.ajax_url !== 'undefined') {
        var _wrap_item = $(this).parents('.tradeace-tr-wishlist-item');
        if ($(_wrap_item).length) {
            $(_wrap_item).css({opacity: 0.3});
        }

        /**
         * Support Yith WooCommercen Wishlist
         */
        if (!$(this).hasClass('btn-tradeace-wishlist')) {
            var _data = {};
            _data.action = 'tradeace_remove_from_wishlist';

            if ($('.tradeace-value-gets').length && $('.tradeace-value-gets').find('input').length) {
                $('.tradeace-value-gets').find('input').each(function() {
                    var _key = $(this).attr('name');
                    var _val = $(this).val();
                    _data[_key] = _val;
                });
            }

            var _pid = $(this).attr('data-prod_id');
            _data.remove_from_wishlist = _pid;
            _data.wishlist_id = $('.wishlist_table').attr('data-id');
            _data.pagination = $('.wishlist_table').attr('data-pagination');
            _data.per_page = $('.wishlist_table').attr('data-per-page');
            _data.current_page = $('.wishlist_table').attr('data-page');

            $.ajax({
                url: tradeace_ajax_params.ajax_url,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: _data,
                beforeSend: function() {
                    $.magnificPopup.close();
                },
                success: function(res) {
                    if (res.error === '0') {
                        $('.wishlist_sidebar').replaceWith(res.list);
                        var _sl_wishlist = (res.count).toString().replace('+', '');
                        var sl_wislist = parseInt(_sl_wishlist);
                        $('.tradeace-mini-number.wishlist-number').html(res.count);
                        if (sl_wislist > 0) {
                            $('.wishlist-number').removeClass('tradeace-product-empty');
                        } else if (sl_wislist === 0 && !$('.tradeace-mini-number.wishlist-number').hasClass('tradeace-product-empty')) {
                            $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                            $('.black-window').trigger('click');
                        }

                        if ($('.btn-wishlist[data-prod="' + _pid + '"]').length) {
                            $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('tradeace-added');

                            if ($('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').length) {
                                $('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').removeClass('added');
                            }
                        }

                        if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                            if ($('.tradeace-close-notice').length) {
                                $('.tradeace-close-notice').trigger('click');
                            }

                            $('#yith-wcwl-popup-message').html(res.mess);

                            $('#yith-wcwl-popup-message').fadeIn();
                            setTimeout( function() {
                                $('#yith-wcwl-popup-message').fadeOut();
                            }, 2000);
                        }
                    }

                    $('.btn-wishlist').removeClass('tradeace-disabled');
                },
                error: function() {
                    $('.btn-wishlist').removeClass('tradeace-disabled');
                }
            });
        }
    }
    
    return false;
});

// Target quantity inputs on product pages
$('body').find('input.qty:not(.product-quantity input.qty)').each(function() {
    var min = parseFloat($(this).attr('min'));
    if (min && min > 0 && parseFloat($(this).val()) < min) {
        $(this).val(min);
    }
});

$('body').on('click', '.plus, .minus', function() {
    // Get values
    var $qty = $(this).parents('.quantity').find('.qty'),
        form = $(this).parents('.cart'),
        button_add = $(form).length ? $(form).find('.single_add_to_cart_button') : false,
        currentVal = parseFloat($qty.val()),
        max = parseFloat($qty.attr('max')),
        min = parseFloat($qty.attr('min')),
        step = $qty.attr('step');
        
    var _old_val = $qty.val();
    $qty.attr('data-old', _old_val);
        
    // Format values
    currentVal = !currentVal ? 0 : currentVal;
    max = !max ? '' : max;
    min = !min ? 1 : min;
    if (
        step === 'any' ||
        step === '' ||
        typeof step === 'undefined' ||
        parseFloat(step) === 'NaN'
    ) {
        step = 1;
    }
    
    // Change the value Plus
    if ($(this).hasClass('plus')) {
        if (max && (max == currentVal || currentVal > max)) {
            $qty.val(max);
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', max);
            }
        } else {
            $qty.val(currentVal + parseFloat(step));
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', currentVal + parseFloat(step));
            }
        }
    }
    
    // Change the value Minus
    else {
        if (min && (min == currentVal || currentVal < min)) {
            $qty.val(min);
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', min);
            }
        } else if (currentVal > 0) {
            $qty.val(currentVal - parseFloat(step));
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', currentVal - parseFloat(step));
            }
        }
    }
    // Trigger change event
    $qty.trigger('change');
});

/**
 * Ajax search Products
 */
if (typeof search_options !== 'undefined' && typeof search_options.url !== 'undefined') {
    $('body').on('focus', '.live-search-input', function() {
        var _this = $(this);
        if (!$(_this).hasClass('tradeace-inited')) {
            $('.live-search-input').addClass('tradeace-inited');
            $('body').trigger('tradeace_live_search_products', _this);
        }
    });
    
    $('body').on('tradeace_live_search_products', function(e, _this) {
        var _urlAjax = search_options.url;
        var empty_mess = $('#tradeace-empty-result-search').html();

        var searchProducts = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: _urlAjax,
            limit: search_options.limit,
            remote: {
                url: _urlAjax + '&s=%QUERY',
                wildcard: '%QUERY'
            }
        });
        
        $('.live-search-input').typeahead({
            minLength: 3,
            hint: true,
            highlight: true,
            backdrop: {
                "opacity": 0.8,
                "filter": "alpha(opacity=80)",
                "background-color": "#eaf3ff"
            },
            searchOnFocus: true,
            callback: {
                onInit: function() {
                    searchProducts.initialize();
                },
                onSubmit: function(node, form, item, event) {
                    form.submit();
                }
            }
        },
        {
            name: 'search',
            source: searchProducts,
            display: 'title',
            displayKey: 'value',
            limit: search_options.limit * 2,
            templates: {
                empty : '<p class="empty-message tradeace-notice-empty">' + empty_mess + '</p>',
                suggestion: Handlebars.compile(search_options.template),
                pending: function(query) {
                    return '<div class="tradeace-loader tradeace-live-search-loader"></div>';
                }
            }
        });
        
        $(_this).trigger('focus');
    });
}

/**
 * Mobile Search
 */
$('body').on('click', '.mobile-search', function() {
    $('.black-window').fadeIn(200);
    
    var height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    
    if (height_adminbar > 0) {
        $('.warpper-mobile-search').css({top: height_adminbar});
    }
    
    if (!$('.warpper-mobile-search').hasClass('tradeace-active')) {
        $('.warpper-mobile-search').addClass('tradeace-active');
    }
    
    /**
     * Focus input
     * @returns {undefined}
     */
    setTimeout(function() {
        if ($('.warpper-mobile-search').find('label').length) {
            $('.warpper-mobile-search').find('label').trigger('click');
        }
    }, 1000);
});

/**
 * In Desktop Search
 * @type Boolean
 */
var _hotkeyInit = false;
$('body').on('click', '.desk-search', function(e) {
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('tradeace-disable')) {
        $(_this_click).addClass('tradeace-disable');
        var _focus_input = $(_this_click).parents('.tradeace-wrap-event-search').find('.tradeace-show-search-form');
        var _opened = $(_this_click).attr('data-open');
        
        if (_opened === '0') {
            $('#header-content').find('.tradeace-show-search-form').after('<div class="tradeace-tranparent" />');
        } else {
            $('#header-content').find('.tradeace-tranparent').remove();
        }
        
        $('.desk-search').each(function() {
            var _this = $(this);
            var _root_wrap = $(_this).parents('.tradeace-wrap-event-search');
            var _elements = $(_root_wrap).find('.tradeace-elements-wrap');
            var _search = $(_root_wrap).find('.tradeace-show-search-form');

            if (typeof _opened === 'undefined' || _opened === '0') {
                $(_this).attr('data-open', '1');
                if (!$(_search).hasClass('tradeace-show')) {
                    $(_search).addClass('tradeace-show');
                }

                $(_elements).addClass('tradeace-invisible');
            } else {
                $(_this).attr('data-open', '0');
                if ($(_search).hasClass('tradeace-show')) {
                    $(_search).removeClass('tradeace-show');
                }

                $(_elements).removeClass('tradeace-invisible');
            }
        });
        
        if (_hotkeyInit) {
            setTimeout(function() {
                $(_this_click).removeClass('tradeace-disable');
                
                if ($(_focus_input).find('label').length) {
                    $(_focus_input).find('label').trigger('click');
                }
            }, 1000);
        } else {
            $(_this_click).removeClass('tradeace-disable');
            
            /**
             * Hot keywords search
             */
            setTimeout(function() {
                _hotkeyInit = true;
                var _oldStr = '';

                if ($(_focus_input).find('input[name="s"]').length) {
                    var _inputCurrent = $(_focus_input).find('input[name="s"]');
                    _oldStr = $(_inputCurrent).val();

                    if (_oldStr !== '') {
                        $(_inputCurrent).val(_oldStr);
                    }

                    auto_fill_input_placeholder($, _inputCurrent);
                    
                    if ($(_focus_input).find('label').length) {
                        $(_focus_input).find('label').trigger('click');
                    }
                }
            }, 1000);
        }
    }
    
    e.preventDefault();
});

$('body').on('click', '.tradeace-close-search, .tradeace-tranparent', function() {
    $(this).parents('.tradeace-wrap-event-search').find('.desk-search').trigger('click');
});

$('body').on('click', '.toggle-sidebar-shop', function() {
    $('.transparent-window').fadeIn(200);
    if (!$('.tradeace-side-sidebar').hasClass('tradeace-show')) {
        $('.tradeace-side-sidebar').addClass('tradeace-show');
    }
});

/**
 * For topbar type 1 Mobile
 */
$('body').on('click', '.toggle-topbar-shop-mobile', function() {
    $('.transparent-mobile').fadeIn(200);
    if (!$('.tradeace-top-sidebar').hasClass('tradeace-active')) {
        $('.tradeace-top-sidebar').addClass('tradeace-active');
    }
});

$('body').on('click', '.toggle-sidebar', function() {
    $('.black-window').fadeIn(200);
    if ($('.col-sidebar').length && !$('.col-sidebar').hasClass('tradeace-active')) {
        $('.col-sidebar').addClass('tradeace-active');
    }
});

if ($('input[name="tradeace_cart_sidebar_show"]').length && $('input[name="tradeace_cart_sidebar_show"]').val() === '1') {
    setTimeout(function() {
        $('.cart-link').trigger('click');
    }, 300);
}

/**
 * Show mini Cart sidebar
 */
$('body').on('click', '.cart-link', function() {
    if ($('form.tradeace-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        return false;
    } else {
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('tradeace-active')) {
            $('#cart-sidebar').addClass('tradeace-active');

            if ($('#cart-sidebar').find('input[name="tradeace-mini-cart-empty-content"]').length) {
                $('#cart-sidebar').append('<div class="tradeace-loader"></div>');

                reload_mini_cart($);
            } else {
                /**
                 * notification free shipping
                 */
                init_shipping_free_notification($);
            }
        }
    }
    
    if ($('.tradeace-close-notice').length) {
        $('.tradeace-close-notice').trigger('click');
    }
});

/**
 * Compatible elementor toggle button cart sidebar
 */
$('body').on('click', '#elementor-menu-cart__toggle_button', function() {
    if ($('.elementor-menu-cart__container .elementor-menu-cart__main').length) {
        $('.elementor-menu-cart__container').remove();
    }
    
    if (!$(this).hasClass('cart-link')) {
        $(this).addClass('cart-link');
        $(this).trigger('click');
    }
});

/**
 * Wishlist icon open sidebar
 */
$('body').on('click', '.wishlist-link', function() {
    if ($(this).hasClass('wishlist-link-premium')) {
        return;
    } else {
        if ($(this).hasClass('tradeace-wishlist-link')) {
            load_wishlist($);
        }
        
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#tradeace-wishlist-sidebar').length && !$('#tradeace-wishlist-sidebar').hasClass('tradeace-active')) {
            $('#tradeace-wishlist-sidebar').addClass('tradeace-active');
        }
    }
});

$('body').on('tradeace_processed_wishlish', function() {
    if ($('.tradeace-tr-wishlist-item').length <= 0) {
        $('.black-window').trigger('click');
    }
});

$('body').on('click', '#tradeace-init-viewed', function() {
    $('.black-window').fadeIn(200).addClass('desk-window');
    
    if ($('#tradeace-viewed-sidebar').length && !$('#tradeace-viewed-sidebar').hasClass('tradeace-active')) {
        $('#tradeace-viewed-sidebar').addClass('tradeace-active');
    }
});

/**
 * Close by fog window
 */
$('body').on('click', '.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .tradeace-close-mini-compare, .tradeace-sidebar-close a, .tradeace-sidebar-return-shop, .login-register-close', function() {
    var _mobileView = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('tradeace-in-mobile') ? true : false;
    
    $('.black-window').removeClass('desk-window');
    
    if ($('#mobile-navigation').length === 1 && $('#mobile-navigation').attr('data-show') === '1') {
        if ($('#tradeace-menu-sidebar-content').length) {
            $('#tradeace-menu-sidebar-content').removeClass('tradeace-active');
        }
        
        $('#mobile-navigation').attr('data-show', '0');
        setTimeout(function() {
            $('.black-window').removeClass('tradeace-transparent');
        }, 1000);
    }
    
    if ($('.warpper-mobile-search').length) {
        $('.warpper-mobile-search').removeClass('tradeace-active');
        if ($('.warpper-mobile-search').hasClass('show-in-desk')) {
            setTimeout(function() {
                $('.warpper-mobile-search').removeClass('show-in-desk');
            }, 600);
        }
    }
    
    /**
     * Close sidebar
     */
    if ($('.col-sidebar').length && (_mobileView || _inMobile)) {
        $('.col-sidebar').removeClass('tradeace-active');
    }
    
    /**
     * Close Dokan sidebar
     */
    if ($('.dokan-store-sidebar').length) {
        $('.dokan-store-sidebar').removeClass('tradeace-active');
    }

    /**
     * Close cart sidebar
     */
    if ($('#cart-sidebar').length) {
        $('#cart-sidebar').removeClass('tradeace-active');
    }

    /**
     * Close wishlist sidebar
     */
    if ($('#tradeace-wishlist-sidebar').length) {
        $('#tradeace-wishlist-sidebar').removeClass('tradeace-active');
    }
    
    /**
     * Close viewed sidebar
     */
    if ($('#tradeace-viewed-sidebar').length) {
        $('#tradeace-viewed-sidebar').removeClass('tradeace-active');
    }
    
    /**
     * Close quick view sidebar
     */
    if ($('#tradeace-quickview-sidebar').length) {
        $('#tradeace-quickview-sidebar').removeClass('tradeace-active');
    }
    
    /**
     * Close filter categories sidebar in mobile
     */
    if ($('.tradeace-top-cat-filter-wrap-mobile').length) {
        $('.tradeace-top-cat-filter-wrap-mobile').removeClass('tradeace-show');
    }
    
    /**
     * Close sidebar
     */
    if ($('.tradeace-side-sidebar').length) {
        $('.tradeace-side-sidebar').removeClass('tradeace-show');
    }
    
    if ($('.tradeace-top-sidebar').length) {
        $('.tradeace-top-sidebar').removeClass('tradeace-active');
    }
    
    /**
     * Close login or register
     */
    if ($('.tradeace-login-register-warper').length) {
        $('.tradeace-login-register-warper').removeClass('tradeace-active');
    }
    
    /**
     * Languages
     */
    if ($('.tradeace-current-lang').length) {
        var _wrapLangs = $('.tradeace-current-lang').parents('.tradeace-select-languages');
        if ($(_wrapLangs).length) {
            $(_wrapLangs).removeClass('tradeace-active');
        }
    }
    
    /**
     * Currencies
     */
    if ($('.wcml-cs-item-toggle').length) {
        var _wrapCurrs = $('.wcml-cs-item-toggle').parents('.tradeace-select-currencies');
        if ($(_wrapCurrs).length) {
            $(_wrapCurrs).removeClass('tradeace-active');
        }
    }
    
    /**
     * Hide compare product
     */
    hide_compare($);
    
    $('body').trigger('tradeace_after_close_fog_window');

    $('.black-window, .white-window, .transparent-mobile, .transparent-window, .transparent-desktop').fadeOut(1000);
});

/**
 * ESC from keyboard
 */
$(document).on('keyup', function(e) {
    if (e.keyCode === 27) {
        $('.tradeace-tranparent').trigger('click');
        $('.tradeace-tranparent-filter').trigger('click');
        $('.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .tradeace-close-mini-compare, .tradeace-sidebar-close a, .login-register-close, .tradeace-transparent-topbar, .tradeace-close-filter-cat').trigger('click');
        $.magnificPopup.close();
    }
});

$('body').on('click', '.add_to_cart_button', function() {
    if (!$(this).hasClass('product_type_simple')) {
        var _href = $(this).attr('href');
        window.location.href = _href;
    }
});

/*
 * Single add to cart from wishlist
 */
$('body').on('click', '.tradeace_add_to_cart_from_wishlist', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id && !$(_this).hasClass('loading')) {
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _data_wishlist = {};
            
        if ($('.wishlist_table').length && $('.wishlist_table').find('#yith-wcwl-row-' + _id).length) {
            _data_wishlist = {
                from_wishlist: '1',
                wishlist_id: $('.wishlist_table').attr('data-id'),
                pagination: $('.wishlist_table').attr('data-pagination'),
                per_page: $('.wishlist_table').attr('data-per-page'),
                current_page: $('.wishlist_table').attr('data-page')
            };
        }
        
        $('body').trigger('tradeace_single_add_to_cart', [_this, _id, _quantity, _type, null, null, _data_wishlist]);
        // tradeace_single_add_to_cart($, _this, _id, _quantity, _type, null, null, _data_wishlist);
    }
    
    return false;
});

/*
 * Add to cart in quick-view Or single product
 */
$('body').on('click', 'form.cart .single_add_to_cart_button', function() {
    $('.tradeace-close-notice').trigger('click');
    
    var _flag_adding = true;
    var _this = $(this);
    var _form = $(_this).parents('form.cart');
    
    $('body').trigger('tradeace_before_click_single_add_to_cart', [_form]);
    
    if ($(_form).find('#yith_wapo_groups_container').length) {
        $(_form).find('input[name="tradeace-enable-addtocart-ajax"]').remove();
        
        if ($(_form).find('.tradeace-custom-fields input[name="tradeace_cart_sidebar"]').length) {
            $(_form).find('.tradeace-custom-fields input[name="tradeace_cart_sidebar"]').val('1');
        } else {
            $(_form).find('.tradeace-custom-fields').append('<input type="hidden" name="tradeace_cart_sidebar" value="1" />');
        }
    }
    
    var _enable_ajax = $(_form).find('input[name="tradeace-enable-addtocart-ajax"]');
    if ($(_enable_ajax).length <= 0 || $(_enable_ajax).val() !== '1') {
        _flag_adding = false;
        return;
    } else {
        var _disabled = $(_this).hasClass('disabled') || $(_this).hasClass('tradeace-ct-disabled') ? true : false;
        var _id = !_disabled ? $(_form).find('input[name="data-product_id"]').val() : false;
        if (_id && !$(_this).hasClass('loading')) {
            var _type = $(_form).find('input[name="data-type"]').val(),
                _quantity = $(_form).find('.quantity input[name="quantity"]').val(),
                _variation_id = $(_form).find('input[name="variation_id"]').length ? parseInt($(_form).find('input[name="variation_id"]').val()) : 0,
                _variation = {},
                _data_wishlist = {},
                _from_wishlist = (
                    $(_form).find('input[name="data-from_wishlist"]').length === 1 &&
                    $(_form).find('input[name="data-from_wishlist"]').val() === '1'
                ) ? '1' : '0';
                
            if (_type === 'variable' && !_variation_id) {
                _flag_adding = false;
                return false;
            } else {
                if (_variation_id > 0 && $(_form).find('.variations').length) {
                    $(_form).find('.variations').find('select').each(function() {
                        _variation[$(this).attr('name')] = $(this).val();
                    });
                    
                    if ($('.wishlist_table').length && $('.wishlist_table').find('tr#yith-wcwl-row-' + _id).length) {
                        _data_wishlist = {
                            from_wishlist: _from_wishlist,
                            wishlist_id: $('.wishlist_table').attr('data-id'),
                            pagination: $('.wishlist_table').attr('data-pagination'),
                            per_page: $('.wishlist_table').attr('data-per-page'),
                            current_page: $('.wishlist_table').attr('data-page')
                        };
                    }
                }
            }
            
            if (_flag_adding) {
                $('body').trigger('tradeace_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
            }
        }
        
        return false;
    }
});

/**
 * Click bundle add to cart
 */
$('body').on('click', '.tradeace_bundle_add_to_cart', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id) {
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _variation_id = 0,
            _variation = {},
            _data_wishlist = {};
        
        $('body').trigger('tradeace_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
        // tradeace_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist);
    }
    
    return false;
});

/**
 * Click to variation add to cart
 */
$('body').on('click', '.product_type_variation.add-to-cart-grid', function() {
    var _this = $(this);
    if (!$(_this).hasClass('tradeace-disable-ajax')) {
        if (!$(_this).hasClass('loading')) {
            var _id = $(_this).attr('data-product_id');
            if (_id) {
                var _type = 'variation',
                    _quantity = $(_this).attr('data-quantity'),
                    _variation_id = 0,
                    _variation = null,
                    _data_wishlist = {};
                    
                    if (typeof $(_this).attr('data-variation_id') !== 'undefined') {
                        _variation_id = $(_this).attr('data-variation_id');
                    }

                    if (typeof $(_this).attr('data-variation') !== 'undefined') {
                        _variation = JSON.parse($(_this).attr('data-variation'));
                    }
                    
                if (_variation) {
                    $('body').trigger('tradeace_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
                } else {
                    var _href = $(_this).attr('href');
                    window.location.href = _href;
                }
            }
        }

        return false;
    }
});

/**
 * Click select option
 */
$('body').on('click', '.product_type_variable', function() {
    if ($('body').hasClass('tradeace-quickview-on')) {
        var _this = $(this);
        
        if (!$(_this).hasClass('add-to-cart-grid')) {
            var _href = $(_this).attr('href');
            if (_href) {
                window.location.href = _href;
            }

            return;
        }
        
        else {
            if ($(_this).parents('.compare-list').length) {
                return;
            }

            else {
                if (!$(_this).hasClass('btn-from-wishlist')) {
                    
                    if ($(_this).hasClass('tradeace-before-click')) {
                        $('body').trigger('tradeace_after_click_select_option', [_this]);
                    }
                    
                    else {
                        var _parent = $(_this).parents('.tradeace-group-btns');
                        $(_parent).find('.quick-view').trigger('click');
                    }
                }
                
                /**
                 * From Wishlist
                 */
                else {
                    var _parent = $(_this).parents('.add-to-cart-wishlist');
                    if ($(_parent).length && $(_parent).find('.quick-view').length) {
                        $(_parent).find('.quick-view').trigger('click');
                    }
                }

                return false;
            }
        }
    } else {
        return;
    }
});

/**
 * After remove cart item in mini cart
 */
$('body').on('wc_fragments_loaded', function() {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length <= 0) {
        $('.black-window').trigger('click');
    }
});
// $('body').on('wc_fragments_refreshed', function() {});

$('body').on('updated_wc_div', function() {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
    
    init_tradeace_notices($);
});

/**
 * Before Add To Cart
 */
var _tradeace_clear_added_to_cart;
$('body').on('adding_to_cart', function() {
    if ($('.tradeace-close-notice').length) {
        $('.tradeace-close-notice').trigger('click');
    }

    if (typeof _tradeace_clear_added_to_cart !== 'undefined') {
        clearTimeout(_tradeace_clear_added_to_cart);
    }
});

/**
 * After Add To Cart
 */
$('body').on('added_to_cart', function(ev, fragments) {
    var _mobileView = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('tradeace-in-mobile') ? true : false;
    
    /**
     * Close quick-view
     */
    if ($('.tradeace-after-add-to-cart-popup').length <= 0) {
        $.magnificPopup.close();
    }
    
    var _event_add = $('input[name="tradeace-event-after-add-to-cart"]').length && $('input[name="tradeace-event-after-add-to-cart"]').val();
    
    /* Loading content After Add To Cart - Popup your order */
    if (_event_add === 'popup' && $('form.tradeace-shopping-cart-form').length <= 0 && $('form.woocommerce-checkout').length <= 0) {
        after_added_to_cart($);
    }
    
    /**
     * Only show Notice in cart or checkout page or Mobile
     */
    if ($('form.tradeace-shopping-cart-form').length || $('form.woocommerce-checkout').length || _mobileView || _inMobile) {
        _event_add = 'notice';
    }
   
    /**
     * Show Mini Cart Sidebar
     */
    if (_event_add === 'sidebar') {
        $('#tradeace-quickview-sidebar').removeClass('tradeace-active');
        $('#tradeace-wishlist-sidebar').removeClass('tradeace-active');
        
        setTimeout(function() {
            $('.black-window').fadeIn(200).addClass('desk-window');
            $('#tradeace-wishlist-sidebar').removeClass('tradeace-active');
            
            if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('tradeace-active')) {
                $('#cart-sidebar').addClass('tradeace-active');
            }
            
            /**
             * notification free shipping
             */
            init_shipping_free_notification($);
        }, 200);
    }
    
    /**
     * Show notice
     */
    if (_event_add === 'notice' && typeof fragments['.woocommerce-message'] !== 'undefined') {
        if ($('.tradeace-close-notice').length) {
            $('.tradeace-close-notice').trigger('click');
        }
        
        set_tradeace_notice($, fragments['.woocommerce-message']);
        
        if (typeof _tradeace_clear_added_to_cart !== 'undefined') {
            clearTimeout(_tradeace_clear_added_to_cart);
        }
        
        _tradeace_clear_added_to_cart = setTimeout(function() {
            if ($('.tradeace-close-notice').length) {
                $('.tradeace-close-notice').trigger('click');
            }
        }, 5000);
    }
    
    ev.preventDefault();
});

$('body').on('click', '.tradeace-close-magnificPopup', function() {
    $.magnificPopup.close();
});

$('body').on('change', '.tradeace-after-add-to-cart-popup input.qty', function() {
    $('.tradeace-after-add-to-cart-popup .tradeace-update-cart-popup').removeClass('tradeace-disable');
});

$('body').on('click', '.remove_from_cart_popup', function() {
    if (!$(this).hasClass('loading')) {
        $(this).addClass('loading');
        tradeace_block($('.tradeace-after-add-to-cart-wrap'));
        
        var _id = $(this).attr('data-product_id');
        if ($('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').length) {
            $('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').trigger('click');
        } else {
            window.location.href = $(this).attt('href');
        }
    }
    
    return false;
});

$('body').on('removed_from_cart', function() {
    if ($('.tradeace-after-add-to-cart-popup').length) {
        after_added_to_cart($);
    }
    
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
                    
    return false;
});

/**
 * Update cart in popup
 */
$('body').on('click', '.tradeace-update-cart-popup', function() {
    var _this = $(this);
    if ($('.tradeace-after-add-to-cart-popup').length && !$(_this).hasClass('tradeace-disable')) {
        var _form = $(this).parents('form');
        if ($(_form).find('input[name=""]').length <= 0) {
            $(_form).append('<input type="hidden" name="update_cart" value="Update Cart11" />');
        }
        $.ajax({
            type: $(_form).attr('method'),
            url: $(_form).attr('action'),
            data: $(_form).serialize(),
            dataType: 'html',
            beforeSend: function() {
                tradeace_block($('.tradeace-after-add-to-cart-wrap'));
            },
            success: function(res) {
                $(_form).find('input[name="update_cart"]').remove();
                $(_this).addClass('tradeace-disable');
            },
            complete: function() {
                reload_mini_cart($);
                after_added_to_cart($);
            }
        });
    }
    
    return false;
});

if ($('.tradeace-promotion-close').length) {
    var height = $('.tradeace-promotion-news').outerHeight();
    
    if ($.cookie('promotion') !== 'hide') {
        setTimeout(function() {
            $('.tradeace-position-relative').animate({'height': height + 'px'}, 500);
            $('.tradeace-promotion-news').fadeIn(500);
            
            if ($('.tradeace-promotion-news').find('.tradeace-post-slider').length) {
                $('.tradeace-promotion-news').find('.tradeace-post-slider').addClass('tradeace-slick-slider');
                $('body').trigger('tradeace_load_slick_slider');
            }
        }, 1000);
    } else {
        $('.tradeace-promotion-show').show();
    }
    
    $('body').on('click', '.tradeace-promotion-close', function() {
        $.cookie('promotion', 'hide', {expires: _cookie_live, path: '/'});
        $('.tradeace-promotion-show').show();
        $('.tradeace-position-relative').animate({'height': '0'}, 500);
        $('.tradeace-promotion-news').fadeOut(500);
    });
    
    $('body').on('click', '.tradeace-promotion-show', function() {
        $.cookie('promotion', 'show', {expires: _cookie_live, path: '/'});
        $('.tradeace-promotion-show').hide();
        $('.tradeace-position-relative').animate({'height': height + 'px'}, 500);
        $('.tradeace-promotion-news').fadeIn(500);
        
        if ($('.tradeace-promotion-news').find('.tradeace-post-slider').length && !$('.tradeace-promotion-news').find('.tradeace-post-slider').hasClass('tradeace-slick-slider')) {
            $('.tradeace-promotion-news').find('.tradeace-post-slider').addClass('tradeace-slick-slider');
            $('body').trigger('tradeace_load_slick_slider');
        }
        
        setTimeout(function() {
            $(window).trigger('resize');
        }, 1000);
    });
};

// Logout click
$('body').on('click', '.tradeace_logout_menu a', function() {
    if ($('input[name="tradeace_logout_menu"]').length) {
        window.location.href = $('input[name="tradeace_logout_menu"]').val();
    }
});

// Show more | Show less
$('body').on('click', '.tradeace_show_manual > a', function() {
    var _this = $(this),
        _val = $(_this).attr('data-show'),
        _li = $(_this).parent(),
        _delay = $(_li).attr('data-delay') ? parseInt($(_li).attr('data-delay')) : 100,
        _fade = $(_li).attr('data-fadein') === '1' ? true : false,
        _text_attr = $(_this).attr('data-text'),
        _text = $(_this).text();
        
    $(_this).html(_text_attr);
    $(_this).attr('data-text', _text);
    
    if (_val === '1') {
        $(_li).parent().find('.tradeace-show-less').each(function() {
            if (!_fade) {
                $(this).slideDown(_delay);
            } else {
                $(this).fadeIn(_delay);
            }
        });
        
        $(_this).attr('data-show', '0');
    } else {
        $(_li).parent().find('.tradeace-show-less').each(function() {
            if (!$(this).hasClass('tradeace-chosen') && !$(this).find('.tradeace-active').length) {
                if (!_fade) {
                    $(this).slideUp(_delay);
                } else {
                    $(this).fadeOut(_delay);
                }
            }
        });
        
        $(_this).attr('data-show', '1');
    }
});

// Login Register Form
$('body').on('click', '.tradeace-switch-register', function() {
    $('#tradeace-login-register-form .tradeace-message').html('');
    $('.tradeace_register-form, .register-form').animate({'left': '0'}, 350);
    $('.tradeace_login-form, .login-form').animate({'left': '-100%'}, 350);
    
    setTimeout(function() {
        $('.tradeace_register-form, .register-form').css({'position': 'relative'});
        $('.tradeace_login-form, .login-form').css({'position': 'absolute'});
    }, 350);
});

/**
 * Switch Login | Register forms
 */
$('body').on('click', '.tradeace-switch-login', function() {
    $('#tradeace-login-register-form .tradeace-message').html('');
    $('.tradeace_register-form, .register-form').animate({'left': '100%'}, 350);
    $('.tradeace_login-form, .login-form').animate({'left': '0'}, 350);
    
    setTimeout(function() {
        $('.tradeace_register-form, .register-form').css({'position': 'absolute'});
        $('.tradeace_login-form, .login-form').css({'position': 'relative'});
    }, 350);
});

if ($('.tradeace-login-register-ajax').length && $('#tradeace-login-register-form').length) {
    $('body').on('click', '.tradeace-login-register-ajax', function() {
        if ($(this).attr('data-enable') === '1' && $('#customer_login').length <= 0) {
            $('#tradeace-menu-sidebar-content').removeClass('tradeace-active');
            $('#mobile-navigation').attr('data-show', '0');
            
            $('.black-window').fadeIn(200).removeClass('tradeace-transparent').addClass('desk-window');
            
            if (!$('.tradeace-login-register-warper').hasClass('tradeace-active')) {
                $('.tradeace-login-register-warper').addClass('tradeace-active');
            }
            
            return false;
        }
    });
    
    /**
     * Must login to login Ajax Popup
     */
    if ($('.must-log-in > a').length) {
        $('body').on('click', '.must-log-in a', function() {
            if ($('.tradeace-login-register-ajax').length) {
                $('.tradeace-login-register-ajax').trigger('click');
                return false;
            }
        });
    }
    
    /**
     * Login Ajax
     */
    $('body').on('click', '.tradeace_login-form .button[type="submit"][name="tradeace_login"]', function(e) {
        e.preventDefault();
        
        if (typeof tradeace_ajax_params !== 'undefined' && typeof tradeace_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.login');

            var _validate = true;
            $(_form).find('.form-row').each(function() {
                var _inputText = $(this).find('input.input-text');
                var _require = $(this).find('.required');
                if ($(_inputText).length) {
                    $(_inputText).removeClass('tradeace-error');
                    if ($(_require).length && $(_require).height() && $(_require).width() && $(_inputText).val().trim() === '') {
                        _validate = false;

                        $(_inputText).addClass('tradeace-error');
                    }
                }
            });

            if (_validate) {
                var _data = $(_form).serializeArray();
                $.ajax({
                    url: tradeace_ajax_params.ajax_url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'action': 'tradeace_process_login',
                        'data': _data,
                        'login': true
                    },
                    beforeSend: function() {
                        $('#tradeace-login-register-form #tradeace_customer_login').css({opacity: 0.3});
                        $('#tradeace-login-register-form #tradeace_customer_login').after('<div class="tradeace-loader"></div>');
                    },
                    success: function(res) {
                        $('#tradeace-login-register-form #tradeace_customer_login').css({opacity: 1});
                        $('#tradeace-login-register-form').find('.tradeace-loader').remove();
                        var _warning = (res.error === '0') ? 'tradeace-success' : 'tradeace-error';
                        $('#tradeace-login-register-form .tradeace-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                        if (res.error === '0') {
                            $('#tradeace-login-register-form .tradeace-form-content').remove();
                            window.location.href = res.redirect;
                        } else {
                            if (res._wpnonce === 'error') {
                                setTimeout(function() {
                                    var _href = false;
                                    if ($('.tradeace-login-register-ajax').length) {
                                        _href = $('.tradeace-login-register-ajax').attr('href');
                                    }
                                    
                                    if (_href) {
                                        window.location.href = _href;
                                    } else {
                                        window.location.reload();
                                    }
                                }, 2000);
                            }
                        }

                        $('body').trigger('tradeace_after_process_login');
                    }
                });
            } else {
                $(_form).find('.tradeace-error').first().focus();
            }
        }
        
        return false;
    });

    /**
     * Register Ajax
     */
    $('body').on('click', '.tradeace_register-form .button[type="submit"][name="tradeace_register"]', function(e) {
        e.preventDefault();
        
        if (typeof tradeace_ajax_params !== 'undefined' && typeof tradeace_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.register');
            var _validate = true;
            $(_form).find('.form-row').each(function() {
                var _inputText = $(this).find('input.input-text');
                var _require = $(this).find('.required');
                if ($(_inputText).length) {
                    $(_inputText).removeClass('tradeace-error');
                    if ($(_require).length && $(_require).height() && $(_require).width() && $(_inputText).val().trim() === '') {
                        _validate = false;

                        $(_inputText).addClass('tradeace-error');
                    }
                }
            });

            if (_validate) {
                var _data = $(_form).serializeArray();
                $.ajax({
                    url: tradeace_ajax_params.ajax_url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'action': 'tradeace_process_register',
                        'data': _data,
                        'register': true
                    },
                    beforeSend: function() {
                        $('#tradeace-login-register-form #tradeace_customer_login').css({opacity: 0.3});
                        $('#tradeace-login-register-form #tradeace_customer_login').after('<div class="tradeace-loader"></div>');
                    },
                    success: function(res) {
                        $('#tradeace-login-register-form #tradeace_customer_login').css({opacity: 1});
                        $('#tradeace-login-register-form').find('.tradeace-loader').remove();
                        var _warning = (res.error === '0') ? 'tradeace-success' : 'tradeace-error';
                        $('#tradeace-login-register-form .tradeace-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                        if (res.error === '0') {
                            $('#tradeace-login-register-form .tradeace-form-content').remove();
                            window.location.href = res.redirect;
                        } else {
                            if (res._wpnonce === 'error') {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        }

                        $('body').trigger('tradeace_after_process_register');
                    }
                });
            } else {
                $(_form).find('.tradeace-error').first().focus();
            }
        }
        
        return false;
    });
    
    $('body').on('keyup', '#tradeace-login-register-form input.input-text.tradeace-error', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('tradeace-error');
        }
    });
}

$('body').on('click', '.btn-combo-link', function() {
    var _width = $(window).outerWidth();
    var _this = $(this);
    var show_type = $(_this).attr('data-show_type');
    var wrap_item = $(_this).parents('.products.list');
    if (_width < 946 || $(wrap_item).length === 1) {
        show_type = 'popup';
    }
    
    switch (show_type) {
        default :
            load_combo_popup($, _this);
            break;
    }
    
    return false;
});

/**
 * Event tradeace git featured
 */
$('body').on('click', '.tradeace-gift-featured-event', function() {
    var _wrap = $(this).parents('.product-item');
    if ($(_wrap).find('.tradeace-product-grid .btn-combo-link').length === 1) {
        $(_wrap).find('.tradeace-product-grid .btn-combo-link').trigger('click');
    } else {
        if ($(_wrap).find('.tradeace-product-list .btn-combo-link').length === 1) {
            $(_wrap).find('.tradeace-product-list .btn-combo-link').trigger('click');
        }
    }
});

/**
 * Change language
 */
$('body').on('click', '.tradeace-current-lang', function() {
    var _wrap = $(this).parents('.tradeace-select-languages');
    if ($(_wrap).length) {
        if ($(_wrap).parents('#tradeace-menu-sidebar-content').length === 0) {
            if ($('.transparent-desktop').length <= 0) {
                $('body').append('<div class="transparent-desktop"></div>');
            }

            $('.transparent-desktop').fadeIn(200);
        }
        $(_wrap).toggleClass('tradeace-active');
        $('.tradeace-select-currencies').removeClass('tradeace-active');
    }

    return false;
});

/**
 * Change Currencies
 */
$('body').on('click', '.wcml-cs-item-toggle', function() {
    var _wrap = $(this).parents('.tradeace-select-currencies');
    if ($(_wrap).length) {
        if ($(_wrap).parents('#tradeace-menu-sidebar-content').length === 0) {
            if ($('.transparent-desktop').length <= 0) {
                $('body').append('<div class="transparent-desktop"></div>');
            }

            $('.transparent-desktop').fadeIn(200);
        }
        $(_wrap).toggleClass('tradeace-active');
        $('.tradeace-select-languages').removeClass('tradeace-active');
    }

    return false;
});

/**
 * Scroll tabs
 */
$('body').on('click', '.tradeace-anchor', function() {
    var _target = $(this).attr('data-target');
    if ($(_target).length) {
        animate_scroll_to_top($, _target, 1000);
    }
    
    return false;
});

/**
 * Animate Scroll To Top
 */
$('body').on('tradeace_animate_scroll_to_top', function(ev, $, _dom, _ms) {
    animate_scroll_to_top($, _dom, _ms);
    ev.preventDefault();
});

/**
 * tradeace-top-cat-filter
 */
$('body').on('click', '.filter-cat-icon', function() {
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('tradeace-disable')) {
        $(_this_click).addClass('tradeace-disable');
        $('.tradeace-elements-wrap').addClass('tradeace-invisible');
        $('#header-content .tradeace-top-cat-filter-wrap').addClass('tradeace-show');
        if ($('.tradeace-has-filter-ajax').length <= 0) {
            $('#header-content .tradeace-top-cat-filter-wrap').before('<div class="tradeace-tranparent-filter tradeace-hide-for-mobile" />');
        }
        
        setTimeout(function() {
            $(_this_click).removeClass('tradeace-disable');
        }, 600);
    }
});

$('body').on('click', '.filter-cat-icon-mobile', function() {
    var _this_click = $(this);
    var _mobileDetect = $('body').hasClass('tradeace-in-mobile') || $('input[name="tradeace_mobile_layout"]').length ? true : false;
    
    if (!$(_this_click).hasClass('tradeace-disable')) {
        $(_this_click).addClass('tradeace-disable');
        $('.tradeace-top-cat-filter-wrap-mobile').addClass('tradeace-show');
        $('.transparent-mobile').fadeIn(300);
        
        setTimeout(function() {
            $(_this_click).removeClass('tradeace-disable');
        }, 600);
        
        var _mobileView = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
        
        if ((_mobileView || _mobileDetect) && $('.tradeace-top-cat-filter-wrap-mobile').find('.tradeace-top-cat-filter').length <= 0) {
            if ($('#tradeace-main-cat-filter').length && $('#tradeace-mobile-cat-filter').length) {
                var _mobile_cats_filter = $('#tradeace-main-cat-filter').clone().html();
                $('#tradeace-mobile-cat-filter').html(_mobile_cats_filter);
                
                if (_mobileDetect) {
                    $('#tradeace-main-cat-filter').remove();
                }
            }
        }
    }
});

$('body').on('click', '.tradeace-close-filter-cat, .tradeace-tranparent-filter', function() {
    $('.tradeace-elements-wrap').removeClass('tradeace-invisible');
    $('#header-content .tradeace-top-cat-filter-wrap').removeClass('tradeace-show');
    $('.tradeace-tranparent-filter').remove();
    $('.transparent-mobile').trigger('click');
});

$('body').on('tradeace_init_topbar_categories', function() {
    init_top_categories_filter($);
});

/**
 * Show coupon in shopping cart
 */
$('body').on('click', '.tradeace-show-coupon', function() {
    if ($('.tradeace-coupon-wrap').length === 1) {
        $('.tradeace-coupon-wrap').toggleClass('tradeace-active');
        setTimeout(function() {
            $('.tradeace-coupon-wrap.tradeace-active input[name="coupon_code"]').focus();
        }, 100);
    }
});

/**
 * Topbar toggle
 */
$('body').on('click', '.tradeace-topbar-wrap .tradeace-icon-toggle', function() {
    var _wrap = $(this).parents('.tradeace-topbar-wrap');
    $(_wrap).toggleClass('tradeace-topbar-hide');
});

$('body').on('click', '.black-window-mobile', function() {
    $(this).removeClass('tradeace-push-cat-show');
    $('.tradeace-push-cat-filter').removeClass('tradeace-push-cat-show');
    $('.tradeace-products-page-wrap').removeClass('tradeace-push-cat-show');
});

$('body').on('click', '.tradeace-widget-show-more a.tradeace-widget-toggle-show', function() {
    var _showed = $(this).attr('data-show');
    var _text = '';
    
    if (_showed === '0') {
        _text = $('input[name="tradeace-widget-show-less-text"]').length ? $('input[name="tradeace-widget-show-less-text"]').val() : 'Less -';
        $(this).attr('data-show', '1');
        $('.tradeace-widget-toggle.tradeace-widget-show-less').addClass('tradeace-widget-show');
    } else {
        _text = $('input[name="tradeace-widget-show-more-text"]').length ? $('input[name="tradeace-widget-show-more-text"]').val() : 'More +';
        $(this).attr('data-show', '0');
        $('.tradeace-widget-toggle.tradeace-widget-show-less').removeClass('tradeace-widget-show');
    }
    
    $(this).html(_text);
});

$('body').on('click', '.tradeace-mobile-icons-wrap .tradeace-toggle-mobile_icons', function() {
    $(this).parents('.tradeace-mobile-icons-wrap').toggleClass('tradeace-hide-icons');
});

/**
 * Buy Now for Quick view and single product page
 */
$('body').on('click', 'form.cart .tradeace-buy-now', function() {
    if (!$(this).hasClass('tradeace-waiting')) {
        $(this).addClass('tradeace-waiting');
        
        var _form = $(this).parents('form.cart');
        if ($(_form).find('.single_add_to_cart_button.disabled').length) {
            $(this).removeClass('tradeace-waiting');
            $(_form).find('.single_add_to_cart_button.disabled').trigger('click');
        } else {
            if ($(_form).find('input[name="tradeace_buy_now"]').length) {
                if ($('input[name="tradeace-enable-addtocart-ajax"]').length) {
                    $('input[name="tradeace-enable-addtocart-ajax"]').val('0');
                }
                $(_form).find('input[name="tradeace_buy_now"]').val('1');
                $(_form).find('.single_add_to_cart_button').trigger('click');
            }
        }
    }
    
    return false;
});

/**
 * Toggle Widget
 */
$('body').on('click', '.tradeace-toggle-widget', function() {
    var _this = $(this);
    var _widget = $(_this).parents('.widget');
    var _key = $(_widget).attr('id');
    
    if ($(_widget).length && $(_widget).find('.tradeace-open-toggle').length) {
        var _hide = $(_this).hasClass('tradeace-hide');
        if (!_hide) {
            $(_this).addClass('tradeace-hide');
            $(_widget).find('.tradeace-open-toggle').slideUp(200);
            $.cookie(_key, 'hide', {expires: 7, path: '/'});
        } else {
            $(_this).removeClass('tradeace-hide');
            $(_widget).find('.tradeace-open-toggle').slideDown(200);
            $.cookie(_key, 'show', {expires: 7, path: '/'});
        }
    }
});

$('body').on('click', '.woocommerce-notices-wrapper .tradeace-close-notice', function() {
    var _this = $(this).parents('.woocommerce-notices-wrapper');
    $(_this).html('');
});

$('body').on('mouseover', '.product-item', function() {
    var _this = $(this);
    var _toggle = $('input[name="tradeace-toggle-width-product-content"]').length ? parseInt($('input[name="tradeace-toggle-width-product-content"]').val()) : 180;
    
    if ($(_this).outerWidth() < _toggle) {
        if (
            $(_this).find('.add-to-cart-grid').length &&
            !$(_this).find('.add-to-cart-grid').hasClass('tradeace-disabled-hover')
        ) {
            $(_this).find('.add-to-cart-grid').addClass('tradeace-disabled-hover');
        }
        
        if (
            $(_this).find('.tradeace-sc-pdeal-countdown')  &&
            !$(_this).find('.tradeace-sc-pdeal-countdown').hasClass('tradeace-countdown-small')) {
            $(_this).find('.tradeace-sc-pdeal-countdown').addClass('tradeace-countdown-small');
        }
    } else {
        if ($(_this).find('.add-to-cart-grid').length) {
            $(_this).find('.add-to-cart-grid').removeClass('tradeace-disabled-hover');
        }
        
        if ($(_this).find('.tradeace-sc-pdeal-countdown')) {
            $(_this).find('.tradeace-sc-pdeal-countdown').removeClass('tradeace-countdown-small');
        }
    }
});

/**
 * Bar icons bottom in mobile detect
 */
if ($('.tradeace-bottom-bar-icons').length) {
    if ($('.top-bar-wrap-type-1').length) {
        $('body').addClass('tradeace-top-bar-in-mobile');
    }
    
    if ($('.toggle-topbar-shop-mobile, .tradeace-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar').length || ($('.dokan-single-store').length && $('.dokan-store-sidebar').length)) {
        $('.tradeace-bot-item.tradeace-bot-item-sidebar').removeClass('hidden-tag');
    } else {
        $('.tradeace-bot-item.tradeace-bot-item-search').removeClass('hidden-tag');
    }
    
    var col = $('.tradeace-bottom-bar-icons .tradeace-bot-item').length - $('.tradeace-bottom-bar-icons .tradeace-bot-item.hidden-tag').length;;
    if (col) {
        $('.tradeace-bottom-bar-icons').addClass('tradeace-' + col.toString() + '-columns');
    }
    
    $('.tradeace-bottom-bar-icons').addClass('tradeace-active');
    
    $('body').css({'padding-bottom': $('.tradeace-bottom-bar-icons').outerHeight()});
    
    /**
     * Event sidebar in bottom mobile layout
     */
    $('body').on('click', '.tradeace-bot-icon-sidebar', function() {
        $('.toggle-topbar-shop-mobile, .tradeace-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar, .toggle-sidebar-dokan').trigger('click');
    });
    
    /**
     * Event cart sidebar in bottom mobile layout
     */
    $('body').on('click', '.botbar-cart-link', function() {
        if ($('.cart-link').length) {
            $('.cart-link').trigger('click');
        }
    });
    
    /**
     * Event search in bottom mobile layout
     */
    $('body').on('click', '.botbar-mobile-search', function() {
        if ($('.mobile-search').length) {
            $('.mobile-search').trigger('click');
        }
    });
    
    /**
     * Event Wishlist sidebar in bottom mobile layout
     */
    $('body').on('click', '.botbar-wishlist-link', function() {
        if ($('.wishlist-link').length) {
            $('.wishlist-link').trigger('click');
        }
    });
}

/**
 * notification free shipping
 */
setTimeout(function() {
    init_shipping_free_notification($);
}, 1000);

/**
 * Hover product-item in Mobile
 */
$('body').on("touchstart", '.product-item', function() {
    $('.product-item').removeClass('tradeace-mobile-hover');
    if (!$(this).hasClass('tradeace-mobile-hover')) {
        $(this).addClass('tradeace-mobile-hover');
    }
});

/**
 * GDPR Notice
 */
// $.cookie('tradeace_gdpr_notice', '0', {expires: 30, path: '/'});
if ($('.tradeace-cookie-notice-container').length) {
    var tradeace_gdpr_notice = $.cookie('tradeace_gdpr_notice');
    if (typeof tradeace_gdpr_notice === 'undefined' || !tradeace_gdpr_notice || tradeace_gdpr_notice === '0') {
        setTimeout(function() {
            $('.tradeace-cookie-notice-container').addClass('tradeace-active');
        }, 1000);
    }
    
    $('body').on('click', '.tradeace-accept-cookie', function() {
        $.cookie('tradeace_gdpr_notice', '1', {expires: 30, path: '/'});
        $('.tradeace-cookie-notice-container').removeClass('tradeace-active');
    });
}

/**
 * Remove title attribute of menu item
 */
$('body').on('mousemove', '.menu-item > a', function() {
    if ($(this).attr('title')) {
        $(this).removeAttr('title');
    }
});

/**
 * Captcha register form
 */
if ($('#tmpl-captcha-field-register').length) {
    $('body').on('click', '.tradeace-reload-captcha', function() {
        var _time = $(this).attr('data-time');
        var _key = $(this).attr('data-key');
        _time = parseInt(_time) + 1;
        $(this).attr('data-time', _time);
        var _form = $(this).parents('form');
        $(_form).find('.tradeace-img-captcha').attr('src', '?tradeace-captcha-register=' + _key + '&time=' + _time);
    });

    var _count_captcha;
    if ($('.tradeace-reload-captcha').length) {
        _count_captcha = parseInt($('.tradeace-reload-captcha').first().attr('data-key'));
    } else {
        _count_captcha = 0;
    }
    var _captcha_row = $('#tmpl-captcha-field-register').html();
    if (_captcha_row) {
        $('.tradeace-form-row-captcha').each(function() {
            _count_captcha = _count_captcha + 1;
            var _row = _captcha_row.replace(/{{key}}/g, _count_captcha);
            $(this).replaceWith(_row);
        });
    }

    $('body').on('tradeace_after_load_static_content', function() {
        if ($('.tradeace-form-row-captcha').length) {
            if ($('.tradeace-reload-captcha').length) {
                _count_captcha = parseInt($('.tradeace-reload-captcha').first().attr('data-key'));
            } else {
                _count_captcha = 0;
            }
            $('.tradeace-form-row-captcha').each(function() {
                _count_captcha = _count_captcha + 1;
                var _row = _captcha_row.replace(/{{key}}/g, _count_captcha);
                $(this).replaceWith(_row);
            });
        }
    });

    $('body').on('tradeace_after_process_register', function() {
        if ($('.tradeace_register-form').find('.tradeace-error').length) {
            $('.tradeace_register-form').find('.tradeace-reload-captcha').trigger('click');
            $('.tradeace_register-form').find('.tradeace-text-captcha').val('');
        }
    });
}

/**
 * Back to Top
 */
$('body').on('click', '#tradeace-back-to-top', function() {
    $('html, body').animate({scrollTop: 0}, 800);
});

/**
 * After loaded ajax store
 */
$('body').on('tradeace_after_loaded_ajax_complete', function(e, destroy_masonry) {
    after_load_ajax_list($, destroy_masonry);
    resize_megamenu_vertical($);
    load_responsive_main_menu($);
    init_header_responsive($);
    init_accordion($);
});

/**
 * Compatible with FancyProductDesigner
 */
$('body').on('modalDesignerClose', function(ev) {
    setTimeout(function() {
        if ($('.tradeace-single-product-thumbnails .tradeace-wrap-item-thumb').length) {
            var _src = $('.woocommerce-product-gallery__image img').attr('src');
            $('.tradeace-single-product-thumbnails .tradeace-wrap-item-thumb:first-child img').attr('src', _src);
            $('.tradeace-single-product-thumbnails .tradeace-wrap-item-thumb:first-child img').removeAttr('srcset');
        }
    }, 100);
});

/**
 * Single Product Add to cart
 */
$('body').on('tradeace_single_add_to_cart', function(_ev, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist) {
    tradeace_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist);
    
    _ev.preventDefault();
});

/**
 * Change Countdown for variation - Quick view
 */
$('body').on('tradeace_changed_countdown_variable_single', function() {
    $('body').trigger('tradeace_load_countdown');
});

/**
 * Update Quantity mini cart
 */
$('body').on('change', '.mini-cart-item .qty', function() {
    if (
        typeof tradeace_ajax_params !== 'undefined' &&
        typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_quantity_mini_cart');
        var _input = $(this);
        var _wrap = $(_input).parents('.mini-cart-item');
        var _hash = $(_input).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var _max = parseFloat($(_input).attr('max'));
        if (!_max) {
            _max = false;
        }
        
        var _quantity = parseFloat($(_input).val());
        
        var _old_val = parseFloat($(_input).attr('data-old'));
        if (!_old_val) {
            _old_val = _quantity;
        }
        
        if (_max > 0 && _quantity > _max) {
            $(_input).val(_max);
            _quantity = _max;
        }
        
        if (_old_val !== _quantity) {
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    hash: _hash,
                    quantity: _quantity
                },
                beforeSend: function () {
                    if (!$(_wrap).hasClass('tradeace-loading')) {
                        $(_wrap).addClass('tradeace-loading');
                    }

                    if ($(_wrap).find('tradeace-loader').length <= 0) {
                        $(_wrap).append('<div class="tradeace-loader"></div>');
                    }
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
                    $('#cart-sidebar').find('.tradeace-loading').removeClass('tradeace-loading');
                }
            });
        }
    }
});

if ($('.tradeace-trigger-click').length) {
    setTimeout(function() {
        $('.tradeace-trigger-click').trigger('click');
    }, 100);
}

$('.row ~ br, .columns ~ br, .columns ~ p').remove();
/**
 * For Header Builder Icon menu mobile switcher
 */
if ($('.header-type-builder').length && $('.tradeace-nav-extra-warp').length <= 0) {
    $('body').append('<div class="tradeace-nav-extra-warp tradeace-show"><div class="desktop-menu-bar"><div class="mini-icon-mobile"><a href="javascript:void(0);" class="tradeace-mobile-menu_toggle bar-mobile_toggle"><span class="fa fa-bars"></span></a></div></div></div>');
}

/**
 * Delay Click yith wishlist
 */
if ($('.tradeace_yith_wishlist_premium-wrap').length && $('.tradeace-wishlist-count.wishlist-number').length) {
    $(document).ajaxComplete(function() {
        setTimeout(function() {
            $('.tradeace_yith_wishlist_premium-wrap').each(function() {
                var _this = $(this);
                if (!$(_this).parents('.wishlist_sidebar').length) {
                    var _countWishlist = $(_this).find('.wishlist_table tbody tr .wishlist-empty').length ? '0' : $(_this).find('.wishlist_table tbody tr').length;
                    $('.tradeace-mini-number.wishlist-number').html(_countWishlist);

                    if (_countWishlist === '0') {
                        $('.tradeace-mini-number.wishlist-number').addClass('tradeace-product-empty');
                    }
                }
            });
        }, 300);
    }).ajaxError(function() {
        console.log('Error with wishlist premium.');
    });
}

/**
 * Load Content Static Blocks
 */
if (
    typeof tradeace_ajax_params !== 'undefined' &&
    typeof tradeace_ajax_params.wc_ajax_url !== 'undefined'
) {
    var _urlAjaxStaticContent = tradeace_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_ajax_static_content');

    var _data_static_content = {};
    var _call_static_content = false;

    if ($('input[name="tradeace_yith_wishlist_actived"]').length) {
        _data_static_content['reload_yith_wishlist'] = '1';
        _call_static_content = true;
    }

    if ($('input[name="tradeace-caching-enable"]').length && $('input[name="tradeace-caching-enable"]').val() === '1') {
        if ($('.tradeace-login-register-ajax').length) {
            _data_static_content['reload_my_account'] = '1';
            _call_static_content = true;
        }

        if ($('.tradeace-hello-acc').length) {
            _data_static_content['reload_login_register'] = '1';
            _call_static_content = true;
        }
    }

    if (_call_static_content) {
        if ($('.tradeace-value-gets').length && $('.tradeace-value-gets').find('input').length) {
            $('.tradeace-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data_static_content[_key] = _val;
            });
        }

        $.ajax({
            url: _urlAjaxStaticContent,
            type: 'post',
            data: _data_static_content,
            cache: false,
            success: function(result) {
                if (typeof result !== 'undefined' && result.success === '1') {
                    $.each(result.content, function(key, value) {
                        if ($(key).length) {
                            $(key).replaceWith(value);

                            if (key === '#tradeace-wishlist-sidebar-content') {
                                init_wishlist_icons($);
                            }
                        }
                    });
                }

                $('body').trigger('tradeace_after_load_static_content');
            }
        });
    }
}

/**
 * Fix vertical mega menu
 */
if ($('.vertical-menu-wrapper').length) {
    $('.vertical-menu-wrapper').attr('data-over', '0');

    $('.vertical-menu-container').each(function() {
        var _this = $(this);
        var _h_vertical = $(_this).height();
        $(_this).find('.tradeace-megamenu >.nav-dropdown').each(function() {
            $(this).find('>.sub-menu').css({'min-height': _h_vertical});
        });
    });
}

/**
 * Add class btn fullwidth for add to cart in single product - quick view
 */
add_class_btn_single_button($);

$(".gallery a[href$='.jpg'], .gallery a[href$='.jpeg'], .featured-item a[href$='.jpeg'], .featured-item a[href$='.gif'], .featured-item a[href$='.jpg'], .page-featured-item .slider > a, .page-featured-item .page-inner a > img, .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").parent().magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: '<div class="tradeace-loader"></div>',
    tClose: $('input[name="tradeace-close-string"]').val(),
    mainClass: 'my-mfp-zoom-in',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
});

/**
 * Fix width menu vertical
 */
resize_megamenu_vertical($);

/**
 * Accordions
 */
init_accordion($);

/**
 * Tabs Slide
 */
if ($('.tradeace-tabs.tradeace-slide-style').length) {
    $('.tradeace-slide-style').each(function() {
        var _this = $(this);
        tradeace_tab_slide_style($, _this, 500);
    });

    $(window).resize(function() {
        $('.tradeace-slide-style').each(function() {
            var _this = $(this);
            tradeace_tab_slide_style($, _this, 50);
        });
    });
}

if ($('.tradeace-active').length) {
    $('.tradeace-active').each(function() {
        if ($(this).parents('.tradeace-show-less').length === 1) {
            $(this).parents('.tradeace-show-less').show();
        }
    });
}

/**
 * Retina logo
 */
if ($('.tradeace-logo-retina').length) {
    var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
    if (pixelRatio > 1) {
        var _image_width, _image_height;
        var _src_retina = '';

        var _init_retina = setInterval(function() {
            $('.tradeace-logo-retina img').each(function() {
                var _this = $(this);

                if (!$(_this).hasClass('tradeace-inited') && !$(_this).hasClass('logo_sticky') && !$(_this).hasClass('logo_mobile') && $(_this).width() && $(_this).height()) {
                    if (typeof _src_retina === 'undefined' || _src_retina === '') {
                        _src_retina = $(_this).attr('data-src-retina');
                    }

                    if (typeof _src_retina !== 'undefined' && _src_retina !== '') {
                        var _fix_size = $(_this).parents('.tradeace-no-fix-size-retina').length === 1 ? false : true;
                        _image_width = _image_height = 'auto';

                        if (_fix_size) {
                            var _w = parseInt($(_this).attr('width'));
                            _image_width = _w ? _w : $(_this).width();

                            var _h = parseInt($(this).attr('height'));
                            _image_height = _h ? _h : $(_this).height();
                        }

                        if ((_image_width && _image_height) || _image_width === 'auto') {
                            $(_this).css("width", _image_width);
                            $(_this).css("height", _image_height);

                            $(_this).attr('src', _src_retina);
                            $(_this).removeAttr('srcset');
                        }

                        $(_this).addClass('tradeace-inited');
                    }
                }

                if ($('.tradeace-logo-retina img').length === $('.tradeace-logo-retina img.tradeace-inited').length) {
                    clearInterval(_init_retina);
                }
            });
        }, 50);
    }
}

/**
 * tradeace-top-cat-filter
 */
init_top_categories_filter($);
hover_top_categories_filter($);
hover_chilren_top_catogories_filter($);

/**
 * init Mini wishlist icon
 */
init_mini_wishlist($);

/**
 * init wishlist icon
 */
init_wishlist_icons($);

/**
 * init Compare icons
 */
init_compare_icons($, true);

/**
 * init Widgets
 */
init_widgets($);

/**
 * Notice Woocommerce
 */
if (!$('body').hasClass('woocommerce-cart')) {
    $('.woocommerce-notices-wrapper').each(function() {
        var _this = $(this);
        setTimeout(function() {
            if ($(_this).find('a').length <= 0) {
                $(_this).html('');
            }

            if ($(_this).find('.woocommerce-message').length) {
                $(_this).find('.woocommerce-message').each(function() {
                    if ($(this).find('a').length <= 0) {
                        $(this).fadeOut(200);
                    }
                });
            }
        }, 3000);
    });
}

init_tradeace_notices($);

/**
 * Header Responsive
 */
init_header_responsive($);

/**
 * Check wpadminbar
 */
if ($('#wpadminbar').length) {
    $("head").append('<style media="screen">#wpadminbar {position: fixed !important;}</style>');

    var _mobileView = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
    var _inMobile = $('body').hasClass('tradeace-in-mobile') ? true : false;

    var height_adminbar = $('#wpadminbar').height();
    $('#cart-sidebar, #tradeace-wishlist-sidebar, #tradeace-viewed-sidebar, #tradeace-quickview-sidebar, .tradeace-top-cat-filter-wrap-mobile, .tradeace-side-sidebar').css({'top' : height_adminbar});

    if (_mobileView || _inMobile) {
        $('.col-sidebar').css({'top' : height_adminbar});
    }

    $(window).resize(function() {
        _mobileView = $('.tradeace-check-reponsive.tradeace-switch-check').length && $('.tradeace-check-reponsive.tradeace-switch-check').width() === 1 ? true : false;
        height_adminbar = $('#wpadminbar').height();

        $('#cart-sidebar, #tradeace-wishlist-sidebar, #tradeace-viewed-sidebar, #tradeace-quickview-sidebar, .tradeace-top-cat-filter-wrap-mobile, .tradeace-side-sidebar').css({'top' : height_adminbar});

        if (_mobileView || _inMobile) {
            $('.col-sidebar').css({'top' : height_adminbar});
        }
    });
}

$(window).trigger('scroll').trigger('resize');

/**
 * Check if a node is blocked for processing.
 *
 * @param {JQuery Object} $node
 * @return {bool} True if the DOM Element is UI Blocked, false if not.
 */
var tradeace_is_blocked = function($node) {
    return $node.is('.processing') || $node.parents('.processing').length;
};

/**
 * Block a node visually for processing.
 *
 * @param {JQuery Object} $node
 */
var tradeace_block = function($node) {
    if (!tradeace_is_blocked($node)) {
        var $color = $('body').hasClass('tradeace-dark') ? '#000' : '#fff';
        
        $node.addClass('processing').block({
            message: null,
            overlayCSS: {
                background: $color,
                opacity: 0.6
            }
        });
    }
};

/**
 * Unblock a node after processing is complete.
 *
 * @param {JQuery Object} $node
 */
var tradeace_unblock = function($node) {
    $node.removeClass('processing').unblock();
};

/* End Document Ready */
});
