<?php
defined('ABSPATH') or die(); // Exit if accessed directly
if (!function_exists('tradeace_get_style_primary_color')) :

    function tradeace_get_style_primary_color($color_primary = '', $return = true) {
        if (trim($color_primary) == '') {
            return '';
        }
        
        $color_primary_darken = tradeace_pattern_color($color_primary, -0.08);
        
        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override primary color */
            body .primary-color,
            body a:hover,
            body a:focus,
            body p a:hover,
            body p a:focus,
            body .add-to-cart-grid .cart-icon strong,
            body .navigation-paging a,
            body .navigation-image a,
            body .logo a,
            body li.mini-cart .cart-icon strong,
            body .mini-cart-item .cart_list_product_price,
            body .remove:hover i,
            body .support-icon,
            body .shop_table.cart td.product-name a:hover,
            body #order_review .cart-subtotal .woocommerce-Price-amount,
            body #order_review .order-total .woocommerce-Price-amount,
            body #order_review .woocommerce-shipping-totals .woocommerce-Price-amount,
            body .cart_totals .order-total td,
            body a.shipping-calculator-button:hover,
            body .widget_layered_nav li a:hover,
            body .widget_layered_nav_filters li a:hover,
            body .copyright-footer span,
            body #menu-shop-by-category li.active.menu-parent-item .nav-top-link::after,
            body .bread.tradeace-breadcrumb-has-bg .row .breadcrumb-row a:hover,
            body .bread.tradeace-breadcrumb-has-bg .columns .breadcrumb-row a:hover,
            body .group-blogs .blog_info .post-date span,
            body .header-type-1 .header-nav .nav-top-link:hover,
            body .widget_layered_nav li:hover a,
            body .widget_layered_nav_filters li:hover a,
            body .remove .pe-7s-close:hover,
            body .absolute-footer .left .copyright-footer span,
            body .service-block .box .title .icon,
            body .service-block.style-3 .box .service-icon,
            body .service-block.style-2 .service-icon,
            body .service-block.style-1 .service-icon,
            body .contact-information .contact-text strong,
            body .nav-wrapper .root-item a:hover,
            body .group-blogs .blog_info .read_more a:hover,
            body #top-bar .top-bar-nav li.color a,
            body .mini-cart .cart-icon:hover:before,
            body .absolute-footer li a:hover,
            body .tradeace-recent-posts li .post-date,
            body .tradeace-recent-posts .read-more a,
            body .shop_table .remove-product .pe-7s-close:hover,
            body .absolute-footer ul.menu li a:hover,
            body .tradeace-pagination.style-1 .page-number li span.current,
            body .tradeace-pagination.style-1 .page-number li a.current,
            body .tradeace-pagination.style-1 .page-number li a.tradeace-current,
            body .tradeace-pagination.style-1 .page-number li a:hover,
            body #vertical-menu-wrapper li.root-item:hover > a,
            body .widget.woocommerce li.cat-item a.tradeace-active,
            body .widget.widget_recent_entries ul li a:hover,
            body .widget.widget_recent_comments ul li a:hover,
            body .widget.widget_meta ul li a:hover,
            body .widget.widget_categories li a.tradeace-active,
            body .widget.widget_archive li a.tradeace-active,
            body .tradeace-filter-by-cat.tradeace-active,
            body .product-info .stock.in-stock,
            body #tradeace-footer .tradeace-contact-footer-custom h5,
            body #tradeace-footer .tradeace-contact-footer-custom h5 i,
            body .group-blogs .tradeace-blog-info-slider .tradeace-post-date,
            body li.menu-item.tradeace-megamenu > .nav-dropdown > ul > li.menu-item a:hover,
            body .tradeace-tag-cloud a.tradeace-active:hover,
            body .html-text i,
            body .header-nav .active .nav-top-link,
            body ul li .nav-dropdown > ul > li:hover > a,
            body ul li .nav-dropdown > ul > li:hover > a:before,
            body ul li .nav-dropdown > ul > li .nav-column-links > ul > li a:hover,
            body ul li .nav-dropdown > ul > li .nav-column-links > ul > li:hover > a:before,
            body .topbar-menu-container > ul > li > a:hover,
            body .header-account ul li a:hover,
            body .header-icons > li a:hover i,
            body .tradeace-title span.tradeace-first-word,
            body .tradeace-sc-pdeal.tradeace-sc-pdeal-block .tradeace-sc-p-img .images-popups-gallery a.product-image .tradeace-product-label-stock .label-stock,
            body .tradeace-sc-pdeal.tradeace-sc-pdeal-block .tradeace-sc-p-info .tradeace-sc-p-title h3 a:hover,
            body #tradeace-footer .tradeace-footer-contact .wpcf7-form label span.your-email:after,
            body .tradeace-nav-sc-menu .menu-item a:hover,
            body .tradeace-static-sidebar .tradeace-wishlist-title:hover,
            body .tradeace-static-sidebar .button-in-wishlist:hover,
            body .tradeace-static-sidebar .mini-cart-info a:hover,
            body .tradeace-login-register-warper #tradeace-login-register-form .tradeace-switch-form a,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a > i,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a > i,
            body .current-menu-item > a.tradeace-title-menu,
            body .product-item .info .name:hover,
            body .tradeace-item-meta .tradeace-widget-title:hover,
            body.tradeace-dark .product-item .info .name:hover,
            body.tradeace-dark .tradeace-item-meta .tradeace-widget-title:hover,
            body .tradeace-compare-list-bottom .tradeace-compare-mess,
            body .tradeace-labels-filter-top .tradeace-labels-filter-accordion .tradeace-top-row-filter > li.tradeace-active a,
            body .tradeace-wrap-slick-slide-products-title .tradeace-slide-products-title-item.slick-current > a,
            body .tradeace-accordions-content .tradeace-accordion-title a.active,
            body .widget.widget_product_categories li a:hover,
            body .widget.woocommerce.widget_product_categories li a:hover,
            body .widget.widget_product_categories li.current-tax-item > a,
            body .widget.woocommerce.widget_product_categories li.current-tax-item > a,
            body .widget.widget_product_categories li.current-tax-item .children a:hover,
            body .widget.woocommerce.widget_product_categories li.current-tax-item .children a:hover,
            body .widget li a:hover,
            body .tradeace-products-special-deal.tradeace-products-special-deal-multi-2 .tradeace-list-stock-status span,
            body .tradeace-after-add-to-cart-subtotal-price,
            body .tradeace-total-condition-desc .woocommerce-Price-amount,
            body .woocommerce-table--order-details tfoot tr:last-child td > .amount,
            body .woocommerce-MyAccount-navigation.tradeace-MyAccount-navigation .woocommerce-MyAccount-navigation-link a:hover:before,
            body .topbar-menu-container ul ul li a:hover,
            body .shop_table tbody .product-subtotal,
            body .grid-product-category .tradeace-item-wrap:hover .tradeace-view-more i,
            body .tradeace-slide-style li.active a,
            body #dokan-store-listing-filter-wrap .right .toggle-view .active,
            body .tradeace-product-content-tradeace_label-wrap .tradeace-product-content-child > a:focus,
            body .tradeace-product-content-tradeace_label-wrap .tradeace-product-content-child > a:visited,
            body .tradeace-product-content-tradeace_label-wrap .tradeace-product-content-child > a:hover,
            body .tradeace-product-content-tradeace_label-wrap .tradeace-product-content-child > a.tradeace-active,
            body .tradeace-color-small-square .tradeace-attr-ux-color.selected,
            body .tradeace-color-small-square .tradeace-attr-ux-color:hover,
            body .tradeace-label-small-square-1 .tradeace-attr-ux-label.selected,
            body .tradeace-label-small-square-1 .tradeace-attr-ux-label:hover,
            body .tradeace-labels-filter-top .tradeace-top-row-filter li a.tradeace-active:before,
            body .tradeace-products-special-deal .product-deal-special-title:hover,
            body .tradeace-tab-push-cats.tradeace-push-cat-show
            {
                color: <?php echo esc_attr($color_primary); ?>;
            }
            .blog_shortcode_item .blog_shortcode_text h3 a:hover,
            .widget-area ul li a:hover,
            h1.entry-title a:hover,
            .progress-bar .bar-meter .bar-number,
            .product-item .info .name a:hover,
            .wishlist_table td.product-name a:hover,
            .product-list .info .name:hover,
            .product-info .compare:hover,
            .product-info .compare:hover:before,
            .product-info .yith-wcwl-add-to-wishlist:hover:before,
            .product-info .yith-wcwl-add-to-wishlist:hover a,
            .product-info .yith-wcwl-add-to-wishlist:hover .feedback,
            .menu-item.tradeace-megamenu > .nav-dropdown > ul > li.menu-item a:hover:before,
            rev-btn.tradeace-Button
            {
                color: <?php echo esc_attr($color_primary); ?> !important;
            }
            /* BACKGROUND */
            body .tradeace_hotspot,
            body .label-new.menu-item a:after,
            body .text-box-primary,
            body .navigation-paging a:hover,
            body .navigation-image a:hover,
            body .next-prev-nav .prod-dropdown > a:hover,
            body .widget_product_tag_cloud a:hover,
            body .tradeace-tag-cloud a.tradeace-active,
            body a.button.trans-button:hover,
            body .product-img .product-bg,
            body #submit:hover,
            body button:hover,
            body .button:hover,
            body input[type="submit"]:hover,
            body .post-item:hover .post-date,
            body .blog_shortcode_item:hover .post-date,
            body .group-slider .sliderNav a:hover,
            body .support-icon.square-round:hover,
            body .entry-header .post-date-wrapper,
            body .entry-header .post-date-wrapper:hover,
            body .comment-inner .reply a:hover,
            body .header-nav .nav-top-link::before,
            body .sliderNav a span:hover,
            body .shop-by-category h3.section-title,
            body .custom-footer-1 .tradeace-hr,
            body .products.list .yith-wcwl-add-button:hover,
            body .shop-by-category .widget-title,
            body .rev_slider_wrapper .type-label-2,
            body .tradeace-hr.primary-color,
            body .pagination-centered .page-numbers a:hover,
            body .pagination-centered .page-numbers span.current,
            body .tradeace-mini-number,
            body .load-more::before,
            body .products-arrow .next-prev-buttons .icon-next-prev:hover,
            body .widget_price_filter .ui-slider .ui-slider-handle:after,
            body .tradeace-classic-style.tradeace-classic-2d.tradeace-tab-primary-color li.active a,
            body .tradeace-classic-style.tradeace-classic-2d.tradeace-tab-primary-color li:hover a,
            body .collapses.active .collapses-title a:before,
            body .title-block span:after,
            body .tradeace-login-register-warper #tradeace-login-register-form a.login-register-close:hover i:before,
            body .products-group.tradeace-combo-slider .product-item.grid .tradeace-product-bundle-btns .quick-view:hover,
            body .header-type-1 .tradeace-header-icons-type-1 .header-icons > li.tradeace-icon-mini-cart a .icon-tradeace-cart-3,
            body .header-type-1 .tradeace-header-icons-type-1 .header-icons > li.tradeace-icon-mini-cart a:hover .icon-tradeace-cart-3,
            body .header-type-1 .tradeace-header-icons-type-1 .header-icons > li.tradeace-icon-mini-cart a .icon-tradeace-cart-3:hover:before,
            body .search-dropdown.tradeace-search-style-3 .tradeace-show-search-form .search-wrapper form .tradeace-icon-submit-page:before,
            body .tradeace-search-space.tradeace-search-style-3 .tradeace-show-search-form .search-wrapper form .tradeace-icon-submit-page:before,
            body #cart-sidebar .btn-mini-cart .button,
            body .tradeace-gift-featured-wrap .tradeace-gift-featured-event:hover,
            body #tradeace-popup .wpcf7 input[type="button"],
            body #tradeace-popup .wpcf7 input[type="submit"],
            body .tradeace-products-special-deal .product-special-deals .product-deal-special-progress .deal-progress .deal-progress-bar,
            body .tradeace-product-grid .add-to-cart-grid,
            body .tradeace-product-grid .add_to_cart_text,
            body .tradeace-progress-bar-load-shop .tradeace-progress-per,
            body #tradeace-footer .footer-contact .btn-submit-newsletters,
            body #tradeace-footer .footer-light-2 .footer-contact .btn-submit-newsletters,
            body .easypin-marker > .tradeace-marker-icon-wrap .tradeace-marker-icon-bg,
            body .easypin-marker > .tradeace-marker-icon-wrap .tradeace-action-effect,
            body .vertical-menu.tradeace-shortcode-menu .section-title,
            body .tp-bullets.custom .tp-bullet.selected:after,
            body #submit.small.tradeace-button-banner,
            body button.small.tradeace-button-banner,
            body .button.small.tradeace-button-banner,
            body input[type="submit"].small.tradeace-button-banner,
            body .tradeace-menu-vertical-header,
            body .tradeace-single-product-stock .tradeace-product-stock-progress .tradeace-product-stock-progress-bar,
            body .tradeace-quickview-view-detail,
            html body.tradeace-in-mobile #top-bar .topbar-mobile-text,
            body .tradeace-subtotal-condition,
            body .tradeace-pagination.style-2 .page-numbers span.current,
            body .tradeace-pagination.style-2 .page-numbers a.current,
            body .tradeace-pagination.style-2 .page-numbers a.tradeace-current,
            body .tradeace-classic-style.tradeace-classic-2d.tradeace-tabs-no-border.tradeace-tabs-radius li.active a,
            body .tradeace-meta-categories,
            body .woocommerce-pagination ul li .page-numbers.current,
            body .slick-dots li.slick-active,
            body table.tradeace-info-size-guide thead td,
            body a:hover .tradeace-comment-count,
            body .tradeace-close-sidebar:hover,
            body .tradeace-sidebar-close a:hover,
            body .tradeace-close-menu-mobile:hover,
            body .tradeace-top-cat-filter-wrap-mobile .tradeace-close-filter-cat:hover,
            body .tradeace-item-img .quick-view:hover,
            body .widget_price_filter .price_slider_wrapper .reset_price:hover:before,
            body .tradeace-product-status-widget .tradeace-filter-status.tradeace-active:before,
            html body.tradeace-dark .tradeace-hoz-buttons .tradeace-product-grid .btn-wishlist:hover,
            html body.tradeace-dark .tradeace-hoz-buttons .tradeace-product-grid .quick-view:hover,
            html body.tradeace-dark .tradeace-hoz-buttons .tradeace-product-grid .btn-compare:hover,
            html body.tradeace-dark .tradeace-hoz-buttons .tradeace-product-grid .btn-link:hover
            {
                background-color: <?php echo esc_attr($color_primary); ?>;
            }
            body #cart-sidebar .btn-mini-cart .button:hover,
            body .product-info .cart .single_add_to_cart_button:hover,
            body #cart-sidebar.style-1 a.tradeace-sidebar-return-shop:hover,
            body #tradeace-wishlist-sidebar.style-1 a.tradeace-sidebar-return-shop:hover,
            body #tradeace-popup .wpcf7 input[type="button"]:hover,
            body #tradeace-popup .wpcf7 input[type="submit"]:hover,
            body #tradeace-footer .footer-light-2 .footer-contact .btn-submit-newsletters:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .add-to-cart-grid:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .btn-wishlist:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .quick-view:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .btn-compare:hover,
            body .tradeace-product-content-select-wrap .tradeace-product-content-child .tradeace-toggle-content-attr-select .tradeace-attr-ux-item.tradeace-active
            {
                background-color: <?php echo esc_attr($color_primary_darken); ?>;
            }
            body .product-item .tradeace-product-grid .add-to-cart-grid:hover .add_to_cart_text
            {
                color: #fff;
            }
            .button.trans-button.primary,
            button.primary-color,
            .newsletter-button-wrap .newsletter-button,
            body .easypin-marker > .tradeace-marker-icon-wrap .tradeace-marker-icon-bg:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .add-to-cart-grid:hover
            {
                background-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            /* BORDER COLOR */
            body .text-bordered-primary,
            body .navigation-paging a,
            body .navigation-image a,
            body .post.sticky,
            body .next-prev-nav .prod-dropdown > a:hover,
            body .iosSlider .sliderNav a:hover span,
            body .woocommerce-checkout form.login,
            body li.mini-cart .cart-icon strong,
            body .post-date,
            body .remove:hover i,
            body .support-icon.square-round:hover,
            body .widget_price_filter .ui-slider .ui-slider-handle,
            body h3.section-title span,
            body .social-icons .icon.icon_email:hover,
            body .button.trans-button.primary,
            body .seam_icon .seam,
            body .border_outner,
            body .pagination-centered .page-numbers a:hover,
            body .pagination-centered .page-numbers span.current,
            body .products.list .yith-wcwl-wishlistexistsbrowse a,
            body .products-arrow .next-prev-buttons .icon-next-prev:hover,
            body .search-dropdown .tradeace-show-search-form .search-wrapper form .tradeace-icon-submit-page,
            body .tradeace-search-space .tradeace-show-search-form .search-wrapper form .tradeace-icon-submit-page,
            body .products-group.tradeace-combo-slider .product-item.grid .tradeace-product-bundle-btns .quick-view:hover,
            body .tradeace-table-compare tr.stock td span,
            body .tradeace-classic-style.tradeace-classic-2d.tradeace-tab-primary-color li.active a,
            body .tradeace-classic-style.tradeace-classic-2d.tradeace-tab-primary-color li:hover a,
            body .tradeace-slide-style li.tradeace-slide-tab,
            body .tradeace-wrap-table-compare .tradeace-table-compare tr.stock td span,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a:before,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a:before,
            body #cart-sidebar .btn-mini-cart .button,
            body .tradeace-gift-featured-wrap .tradeace-gift-featured-event:hover,
            body .group-btn-in-list .add-to-cart-grid:hover .add_to_cart_text,
            body .tradeace-title.hr-type-vertical .tradeace-wrap,
            body #tradeace-footer .footer-contact .btn-submit-newsletters,
            body .easypin-marker > .tradeace-marker-icon-wrap .tradeace-marker-icon-bg,
            body .easypin-marker > .tradeace-marker-icon-wrap .tradeace-marker-icon,
            body .vertical-menu.tradeace-shortcode-menu .section-title,
            body .tradeace-products-special-deal.tradeace-products-special-deal-multi-2 .tradeace-main-special,
            body .tradeace-slider-deal-vertical-extra-switcher.tradeace-nav-4-items .slick-slide.slick-current .item-deal-thumb,
            body .tradeace-slider-deal-vertical-extra-switcher.tradeace-nav-4-items .slick-slide:hover .item-deal-thumb,
            body .tradeace-accordions-content .tradeace-accordion-title a.active:before,
            body .tradeace-accordions-content .tradeace-accordion-title a.active:after,
            body .tradeace-color-small-square .tradeace-attr-ux-color.selected,
            body .tradeace-color-small-square .tradeace-attr-ux-color:hover,
            body .tradeace-label-small-square-1 .tradeace-attr-ux-label.selected,
            body .tradeace-label-small-square-1 .tradeace-attr-ux-label:hover,
            body .tradeace-color-big-square .tradeace-attr-ux-color.selected,
            body .tradeace-label-big-square .tradeace-attr-ux-label.selected,
            body .tradeace-image-square-caption .tradeace-attr-ux-image.selected,
            body .comment-inner .reply a:hover,
            body .tradeace-close-sidebar:hover,
            body .tradeace-sidebar-close a:hover,
            body .tradeace-close-menu-mobile:hover,
            body .tradeace-top-cat-filter-wrap-mobile .tradeace-close-filter-cat:hover,
            body .tradeace-item-img .quick-view:hover,
            body .tradeace-anchor.active,
            body .tradeace-tab-push-cats.tradeace-push-cat-show i,
            body .tradeace-hoz-buttons .tradeace-product-grid .add-to-cart-grid:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .btn-wishlist:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .quick-view:hover,
            body .tradeace-hoz-buttons .tradeace-product-grid .btn-compare:hover,
            body .widget_price_filter .price_slider_wrapper .reset_price:hover:before,
            body .tradeace-product-content-select-wrap .tradeace-product-content-child .tradeace-toggle-content-attr-select .tradeace-attr-ux-item.tradeace-active,
            body .tradeace-product-status-widget .tradeace-filter-status:hover:before,
            body .tradeace-product-status-widget .tradeace-filter-status.tradeace-active:before
            {
                border-color: <?php echo esc_attr($color_primary); ?>;
            }
            body #cart-sidebar.style-1 a.tradeace-sidebar-return-shop:hover,
            body #tradeace-wishlist-sidebar.style-1 a.tradeace-sidebar-return-shop:hover,
            body #cart-sidebar .btn-mini-cart .button:hover,
            body .product-info .cart .single_add_to_cart_button:hover
            {
                border-color: <?php echo esc_attr($color_primary_darken); ?>;
            }
            .promo .sliderNav span:hover,
            .remove .pe-7s-close:hover
            {
                border-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            .collapsing.categories.list li:hover,
            #menu-shop-by-category li.active
            {
                border-left-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            body .tradeace-slider-deal-vertical-extra-switcher.tradeace-nav-4-items .item-slick.slick-current:before
            {
                border-right-color: <?php echo esc_attr($color_primary); ?>;
            }
            html body.tradeace-rtl .tradeace-slider-deal-vertical-extra-switcher.tradeace-nav-4-items .item-slick.slick-current:after
            {
                border-left-color: <?php echo esc_attr($color_primary); ?>;
            }
            body button,
            body .button,
            body #submit,
            body a.button,
            body p a.button,
            body input#submit,
            body .add_to_cart,
            body .checkout-button,
            body .dokan-btn-theme,
            body a.dokan-btn-theme,
            body input#place_order,
            body form.cart .button,
            body .form-submit input,
            body input[type="submit"],
            body .btn-mini-cart .button,
            body #payment .place-order input,
            body .footer-type-2 input.button,
            body input[type="submit"].dokan-btn-theme,
            body #tradeace-footer .btn-submit-newsletters,
            body .tradeace-table-compare .add-to-cart-grid,
            body .tradeace-static-sidebar .tradeace-sidebar-return-shop,
            body .tradeace-tab-primary-color .tradeace-classic-style li:hover a,
            body .tradeace-tab-primary-color .tradeace-classic-style li.active a,
            body .product-deal-special-buttons .tradeace-product-grid .add-to-cart-grid .add_to_cart_text
            {
                background-color: <?php echo esc_attr($color_primary); ?>;
                border-color: <?php echo esc_attr($color_primary); ?>;
                color: #FFF;
            }
            body button:hover,
            body .button:hover,
            body a.button:hover,
            body * button:hover,
            body * .button:hover,
            body * #submit:hover,
            body p a.button:hover,
            body input#submit:hover,
            body .add_to_cart:hover,
            body input#submit:hover,
            body .checkout-button:hover,
            body .dokan-btn-theme:hover,
            body a.dokan-btn-theme:hover,
            body input#place_order:hover,
            body form.cart .button:hover,
            body .form-submit input:hover,
            body * input[type="submit"]:hover,
            body .btn-mini-cart .button:hover,
            body #payment .place-order input:hover,
            body .footer-type-2 input.button:hover,
            body .tradeace-reset-filters-top:hover:before,
            body .tradeace-ignore-price-item:hover:before,
            body .tradeace-ignore-variation-item:hover:before,
            body input[type="submit"].dokan-btn-theme:hover,
            body .tradeace-table-compare .add-to-cart-grid:hover,
            body .tradeace-static-sidebar .tradeace-sidebar-return-shop:hover,
            body .product-list .product-img .quick-view.fa-search:hover,
            body .product-deal-special-buttons .tradeace-product-grid .add-to-cart-grid:hover .add_to_cart_text
            {
                background-color: <?php echo esc_attr($color_primary_darken); ?>;
                border-color: <?php echo esc_attr($color_primary_darken); ?>;
                color: #FFF;
            }
            /* End Primary color =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return tradeace_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for main menu
 */
if (!function_exists('tradeace_get_style_main_menu_color')) :

    function tradeace_get_style_main_menu_color(
        $bg_color = '',
        $text_color = '',
        $text_color_hover = '',
        $return = true
    ) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override main menu color =========================================== */
        <?php if ($bg_color != '') : ?>
                body .tradeace-bg-dark,
                body .header-type-4 .tradeace-elements-wrap-bg
                {
                    background-color: <?php echo ($bg_color != '') ? esc_attr($bg_color) : 'transparent'; ?>;
                }
                <?php
                $bg_color = strtolower($bg_color);
                if ($bg_color !== '#fff' && $bg_color !== '#ffffff' && $bg_color !== 'white') : ?>
                    body .header-type-4 .tradeace-elements-wrap-bg
                    {
                        border-top: none;
                        border-bottom: none;
                    }
                <?php 
                endif;
            endif;

            if ($text_color != '') :
                ?>
                body .nav-wrapper .root-item > a,
                body .nav-wrapper .root-item:hover > a,
                body .nav-wrapper .root-item.current-menu-ancestor > a,
                body .nav-wrapper .root-item.current-menu-item > a,
                body .nav-wrapper .root-item:hover > a:hover,
                body .nav-wrapper .root-item.current-menu-ancestor > a:hover,
                body .nav-wrapper .root-item.current-menu-item > a:hover,
                body .tradeace-bg-dark .nav-wrapper .root-item > a,
                body .tradeace-bg-dark .nav-wrapper .root-item:hover > a,
                body .tradeace-bg-dark .nav-wrapper .root-item.current-menu-ancestor > a,
                body .tradeace-bg-dark .nav-wrapper .root-item.current-menu-item > a,
                body .tradeace-bg-wrap .tradeace-vertical-header h5.section-title
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                body .nav-wrapper .root-item:hover > a:after,
                body .nav-wrapper .root-item.current-menu-ancestor > a:after,
                body .nav-wrapper .root-item.current-menu-item > a:after,
                body .tradeace-bg-dark .nav-wrapper .root-item:hover > a:after,
                body .tradeace-bg-dark .nav-wrapper .root-item.current-menu-ancestor > a:after,
                body .tradeace-bg-dark .nav-wrapper .root-item.current-menu-item > a:after
                {
                    border-color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') : ?>

            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return tradeace_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for header
 */
if (!function_exists('tradeace_get_style_header_color')) :

    function tradeace_get_style_header_color(
        $bg_color = '',
        $text_color = '',
        $text_color_hover = '',
        $return = true
    ) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override header color =========================================== */
            <?php if ($bg_color != '') : ?>
                body #masthead,
                body .mobile-menu .tradeace-td-mobile-icons .tradeace-mobile-icons-wrap.tradeace-absolute-icons .tradeace-header-icons-wrap,
                body .tradeace-header-sticky.tradeace-header-mobile-layout.tradeace-header-transparent .sticky-wrapper.fixed-already #masthead
                {
                    background-color: <?php echo esc_attr($bg_color); ?>;
                }
                body .tradeace-header-mobile-layout.tradeace-header-transparent #masthead
                {
                    background-color: transparent;
                }
            <?php
        endif;

        if ($text_color != '') :
            ?>
                body #masthead .header-icons > li a,
                body .mini-icon-mobile .tradeace-icon,
                body .tradeace-toggle-mobile_icons,
                body #masthead .follow-icon a i,
                body #masthead .tradeace-search-space .tradeace-show-search-form .search-wrapper form .tradeace-icon-submit-page:before,
                body #masthead .tradeace-search-space .tradeace-show-search-form .tradeace-close-search,
                body #masthead .tradeace-search-space .tradeace-show-search-form .search-wrapper form input[name="s"]
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                .mobile-menu .tradeace-td-mobile-icons .tradeace-toggle-mobile_icons .tradeace-icon
                {
                    border-color: transparent !important;
                }
                <?php
            endif;

            if ($text_color_hover != '') :
                ?>
                body #masthead .header-icons > li a:hover i,
                body #masthead .mini-cart .cart-icon:hover:before,
                body #masthead .follow-icon a:hover i
                {
                    color: <?php echo esc_attr($text_color_hover); ?>;
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return tradeace_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for TOP BAR
 */
if (!function_exists('tradeace_get_style_topbar_color')) :

    function tradeace_get_style_topbar_color(
        $bg_color = '',
        $text_color = '',
        $text_color_hover = '',
        $return = true
    ) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override topbar color =========================================== */
            <?php if ($bg_color != '') : ?>
                body #top-bar,
                body .tradeace-topbar-wrap.tradeace-topbar-toggle .tradeace-icon-toggle
                {
                    background-color: <?php echo esc_attr($bg_color); ?>;
                }
                body #top-bar,
                body .tradeace-topbar-wrap.tradeace-topbar-toggle .tradeace-icon-toggle
                {
                    border-color: <?php echo esc_attr($bg_color); ?>;
                }
            <?php
            endif;

            if ($text_color != '') : ?>
                body #top-bar,
                body #top-bar .topbar-menu-container .wcml-cs-item-toggle,
                body #top-bar .topbar-menu-container > ul > li:after,
                body #top-bar .topbar-menu-container > ul > li > a,
                body #top-bar .left-text,
                body .tradeace-topbar-wrap.tradeace-topbar-toggle .tradeace-icon-toggle
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') :
                ?>
                body #top-bar .topbar-menu-container .wcml-cs-item-toggle:hover,
                body #top-bar .topbar-menu-container > ul > li > a:hover,
                body .tradeace-topbar-wrap.tradeace-topbar-toggle .tradeace-icon-toggle:hover
                {
                    color: <?php echo esc_attr($text_color_hover); ?>;
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return tradeace_convert_css($css);
        }
    }

endif;

/**
 * CSS override Add more width site
 */
if (!function_exists('tradeace_get_style_plus_wide_width')) :

    function tradeace_get_style_plus_wide_width($max_width = '', $return = true) {
        if ($max_width == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start Override Max-width screen site */
            <?php if ($max_width != '') : ?>
                <?php if (TRADEACE_ELEMENTOR_ACTIVE) : ?>body #main-content .elementor-section.elementor-section-boxed > .elementor-container,<?php endif; ?>
                html body .row,
                html body.boxed #wrapper,
                html body.boxed .nav-wrapper .tradeace-megamenu.fullwidth > .nav-dropdown
                {
                    max-width: <?php echo $max_width; ?>px;
                }
                html body.boxed #wrapper .row,
                html body.boxed .nav-wrapper .tradeace-megamenu.fullwidth > .nav-dropdown > ul
                {
                    max-width: <?php echo $max_width - 50; ?>px;
                }
                @media only screen and (min-width: 52.96552em) {
                    html body.dokan-store #main-content {
                        max-width: <?php echo $max_width; ?>px;
                    }
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return tradeace_convert_css($css);
        }
    }

endif;

/**
 * CSS Override Font style
 */
if (!function_exists('tradeace_get_font_style_rtl')) :
    function tradeace_get_font_style_rtl (
        $type_font_select = '',
        $type_headings = '',
        $type_texts = '',
        $type_nav = '',
        $type_banner = '',
        $type_price = '',
        $custom_font = ''
    ) {
    
        if ($type_font_select == '') {
            return '';
        }

        ob_start();
        ?><style><?php
        
        if ($type_font_select == 'custom' && $custom_font) :
            ?>
                body.tradeace-rtl,
                body.tradeace-rtl p,
                body.tradeace-rtl h1,
                body.tradeace-rtl h2,
                body.tradeace-rtl h3,
                body.tradeace-rtl h4,
                body.tradeace-rtl h5,
                body.tradeace-rtl h6,
                body.tradeace-rtl #top-bar,
                body.tradeace-rtl .nav-dropdown,
                body.tradeace-rtl .top-bar-nav a.nav-top-link,
                body.tradeace-rtl .megatop > a,
                body.tradeace-rtl .root-item > a,
                body.tradeace-rtl .tradeace-tabs a,
                body.tradeace-rtl .service-title,
                body.tradeace-rtl .price .amount,
                body.tradeace-rtl .tradeace-banner,
                body.tradeace-rtl .tradeace-banner h1,
                body.tradeace-rtl .tradeace-banner h2,
                body.tradeace-rtl .tradeace-banner h3,
                body.tradeace-rtl .tradeace-banner h4,
                body.tradeace-rtl .tradeace-banner h5,
                body.tradeace-rtl .tradeace-banner h6
                {
                    font-family: "<?php echo esc_attr(ucwords($custom_font)); ?>", helvetica, arial, sans-serif;
                }
            <?php
        elseif ($type_font_select == 'google') :
            if ($type_headings != '') :
                ?>
                    body.tradeace-rtl .service-title,
                    body.tradeace-rtl .tradeace-tabs a,
                    body.tradeace-rtl h1,
                    body.tradeace-rtl h2,
                    body.tradeace-rtl h3,
                    body.tradeace-rtl h4,
                    body.tradeace-rtl h5,
                    body.tradeace-rtl h6
                    {
                        font-family: "<?php echo esc_attr($type_headings); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;
            
            if ($type_texts != '') :
                ?>
                    body.tradeace-rtl,
                    body.tradeace-rtl p,
                    body.tradeace-rtl #top-bar,
                    body.tradeace-rtl .nav-dropdown,
                    body.tradeace-rtl .top-bar-nav a.nav-top-link
                    {
                        font-family: "<?php echo esc_attr($type_texts); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;

            if ($type_nav != '') :
                ?>
                    body.tradeace-rtl .megatop > a,
                    body.tradeace-rtl .root-item a,
                    body.tradeace-rtl .tradeace-tabs a,
                    body.tradeace-rtl .topbar-menu-container .header-multi-languages a
                    {
                        font-family: "<?php echo esc_attr($type_nav); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;

            if ($type_banner != '') :
                ?>
                    body.tradeace-rtl .tradeace-banner,
                    body.tradeace-rtl .tradeace-banner h1,
                    body.tradeace-rtl .tradeace-banner h2,
                    body.tradeace-rtl .tradeace-banner h3,
                    body.tradeace-rtl .tradeace-banner h4,
                    body.tradeace-rtl .tradeace-banner h5,
                    body.tradeace-rtl .tradeace-banner h6
                    {
                        font-family: "<?php echo esc_attr($type_banner); ?>", helvetica, arial, sans-serif;
                        letter-spacing: 0px;
                    }
                <?php
            endif;

            if ($type_price != '') :
                ?>
                    body.tradeace-rtl .price,
                    body.tradeace-rtl .amount
                    {
                        font-family: "<?php echo esc_attr($type_price); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;
        endif; ?></style><?php
        $css = ob_get_clean();

        return tradeace_convert_css($css);
    }
endif;

/**
 * CSS Override Font style
 */
if (!function_exists('tradeace_get_font_style')) :
    function tradeace_get_font_style (
        $type_font_select = '',
        $type_headings = '',
        $type_texts = '',
        $type_nav = '',
        $type_banner = '',
        $type_price = '',
        $custom_font = '',
        $imprtant = false
    ) {
    
        if ($type_font_select == '') {
            return '';
        }

        ob_start();
        ?><style>
        <?php
        if ($type_font_select == 'custom' && $custom_font) :
            ?>
                body,
                p,
                h1, h2, h3, h4, h5, h6,
                #top-bar,
                .nav-dropdown,
                .top-bar-nav a.nav-top-link,
                .megatop > a,
                .root-item > a,
                .tradeace-tabs a,
                .service-title,
                .price .amount,
                .tradeace-banner,
                .tradeace-banner h1,
                .tradeace-banner h2,
                .tradeace-banner h3,
                .tradeace-banner h4,
                .tradeace-banner h5,
                .tradeace-banner h6
                {
                    font-family: "<?php echo esc_attr(ucwords($custom_font)); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                }
            <?php
        elseif ($type_font_select == 'google') :
            if ($type_headings != '') :
                ?>
                    .service-title,
                    .tradeace-tabs a,
                    h1, h2, h3, h4, h5, h6
                    {
                        font-family: "<?php echo esc_attr($type_headings); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;
            
            if ($type_texts != '') :
                ?>
                    p,
                    body,
                    #top-bar,
                    .nav-dropdown,
                    .top-bar-nav a.nav-top-link
                    {
                        font-family: "<?php echo esc_attr($type_texts); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;

            if ($type_nav != '') :
                ?>
                    .megatop > a,
                    .root-item a,
                    .tradeace-tabs a,
                    .topbar-menu-container .header-multi-languages a
                    {
                        font-family: "<?php echo esc_attr($type_nav); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;

            if ($type_banner != '') :
                ?>
                    .tradeace-banner,
                    .tradeace-banner h1,
                    .tradeace-banner h2,
                    .tradeace-banner h3,
                    .tradeace-banner h4,
                    .tradeace-banner h5,
                    .tradeace-banner h6
                    {
                        font-family: "<?php echo esc_attr($type_banner); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                        letter-spacing: 0px;
                    }
                <?php
            endif;

            if ($type_price != '') :
                ?>
                    .price,
                    .amount
                    {
                        font-family: "<?php echo esc_attr($type_price); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;
        endif; ?></style><?php
        $css = ob_get_clean();

        return tradeace_convert_css($css);
    }
endif;

// **********************************************************************// 
// ! Dynamic - css
// **********************************************************************//
add_action('wp_enqueue_scripts', 'tradeace_add_dynamic_css', 999);
if (!function_exists('tradeace_add_dynamic_css')) :

    function tradeace_add_dynamic_css() {
        global $tradeace_upload_dir;
        
        if (!isset($tradeace_upload_dir)) {
            $tradeace_upload_dir = wp_upload_dir();
            $GLOBALS['tradeace_upload_dir'] = $tradeace_upload_dir;
        }
        
        $dynamic_path = $tradeace_upload_dir['basedir'] . '/tradeace-dynamic';
        
        if (is_file($dynamic_path . '/dynamic.css')) {
            global $tradeace_opt;
            $version = isset($tradeace_opt['tradeace_dynamic_t']) ? $tradeace_opt['tradeace_dynamic_t'] : null;
            
            // Dynamic Css
            wp_enqueue_style('tradeace-style-dynamic', tradeace_remove_protocol($tradeace_upload_dir['baseurl']) . '/tradeace-dynamic/dynamic.css', array('tradeace-style'), $version, 'all');
        }
    }

endif;

// **********************************************************************// 
// ! Dynamic - Page override primary color - css
// **********************************************************************//
add_action('wp_enqueue_scripts', 'tradeace_page_override_style', 1000);
if (!function_exists('tradeace_page_override_style')) :
    function tradeace_page_override_style() {
        if (!wp_style_is('tradeace-style-dynamic')) {
            return;
        }

        global $post, $tradeace_opt, $content_width;
        $post_type = isset($post->post_type) ? $post->post_type : false;
        $is_page = 'page' === $post_type ? true : false;
        $object_id = $is_page ? $post->ID : false;
        
        if (!$is_page) {
            /**
             * Shop Page
             */
            if (TRADEACE_WOO_ACTIVED) {
                $is_shop = is_shop();
                $is_product_taxonomy = is_product_taxonomy();
                $is_product_category = is_product_category();
                $object_id = ($is_shop || $is_product_taxonomy) && !$is_product_category ? wc_get_page_id('shop') : 0;

                $is_page = $object_id ? true : false;
            }
            
            /**
             * Page post
             */
            
            if (!$is_page && tradeace_check_blog_page()) {
                $object_id = get_option('page_for_posts');
                $is_page = $object_id ? true : false;
            }
        }
        
        $dinamic_css = '';
        if ($is_page && $object_id) {

            /**
             * color_primary
             */
            $flag_override_color = get_post_meta($object_id, '_tradeace_pri_color_flag', true);
            $color_primary_css = $page_css = '';
            if ($flag_override_color) :
                $color_primary = get_post_meta($object_id, '_tradeace_pri_color', true);
                $color_primary_css = $color_primary ? tradeace_get_style_primary_color($color_primary) : '';
            endif;

            /**
             * color for header
             */
            $bg_color = get_post_meta($object_id, '_tradeace_bg_color_header', true);
            $text_color = get_post_meta($object_id, '_tradeace_text_color_header', true);
            $text_color_hover = get_post_meta($object_id, '_tradeace_text_color_hover_header', true);
            $page_css .= tradeace_get_style_header_color($bg_color, $text_color, $text_color_hover);

            /**
             * color for top bar
             */
            if (!isset($tradeace_opt['topbar_show']) || $tradeace_opt['topbar_show']) {
                $bg_color = get_post_meta($object_id, '_tradeace_bg_color_topbar', true);
                $text_color = get_post_meta($object_id, '_tradeace_text_color_topbar', true);
                $text_color_hover = get_post_meta($object_id, '_tradeace_text_color_hover_topbar', true);
                $page_css .= tradeace_get_style_topbar_color($bg_color, $text_color, $text_color_hover);
            }

            /**
             * color for main menu
             */
            $bg_color = get_post_meta($object_id, '_tradeace_bg_color_main_menu', true);
            $text_color = get_post_meta($object_id, '_tradeace_text_color_main_menu', true);
            $text_color_hover = get_post_meta($object_id, '_tradeace_text_color_hover_main_menu', true);
            $page_css .= tradeace_get_style_main_menu_color($bg_color, $text_color, $text_color_hover);

            /**
             * Add width to site
             */
            $max_width = '';
            $plus_option = get_post_meta($object_id, '_tradeace_plus_wide_option', true);
            switch ($plus_option) {
                case '1':
                    $plus_width = get_post_meta($object_id, '_tradeace_plus_wide_width', true);
                    break;

                case '-1':
                    $plus_width = 0;
                    break;

                case '':
                default :
                    $plus_width = '';
                    break;
            }
            
            if ($plus_width !== '' && (int) $plus_width >= 0) {
                $content_width = !isset($content_width) ? 1200 : $content_width;
                $max_width = ($content_width + (int) $plus_width);
            }
            
            $page_css .= tradeace_get_style_plus_wide_width($max_width);
            
            /**
             * Font style
             */
            $type_font_select = get_post_meta($object_id, '_tradeace_type_font_select', true);
            
            $type_headings = '';
            $type_texts = '';
            $type_nav = '';
            $type_banner = '';
            $type_price = '';
            $custom_font = '';

            if ($type_font_select == 'google') {
                $type_headings = get_post_meta($object_id, '_tradeace_type_headings', true);
                $type_texts = get_post_meta($object_id, '_tradeace_type_texts', true);
                $type_nav = get_post_meta($object_id, '_tradeace_type_nav', true);
                $type_banner = get_post_meta($object_id, '_tradeace_type_banner', true);
                $type_price = get_post_meta($object_id, '_tradeace_type_price', true);
            }

            if ($type_font_select == 'custom') {
                $custom_font = get_post_meta($object_id, '_tradeace_custom_font', true);
            }
            
            $font_css = tradeace_get_font_style(
                $type_font_select,
                $type_headings,
                $type_texts,
                $type_nav,
                $type_banner,
                $type_price,
                $custom_font,
                true
            );

            $dinamic_css = $color_primary_css . $page_css . $font_css;
        }
        
        /**
         * Override primary color for root category product
         */
        else {
            $root_cat_id = tradeace_get_root_term_id();
            if ($root_cat_id) {
                $color_primary = get_term_meta($root_cat_id, 'cat_primary_color', true);
                $dinamic_css = $color_primary ? tradeace_get_style_primary_color($color_primary) : '';
                
                /**
                 * Font style
                 */
                $type_font_select = get_term_meta($root_cat_id, 'type_font', true);
                
                $type_headings = '';
                $type_texts = '';
                $type_nav = '';
                $type_banner = '';
                $type_price = '';
                $custom_font = '';
                
                if ($type_font_select == 'google') {
                    $type_headings = get_term_meta($root_cat_id, 'headings_font', true);
                    $type_texts = get_term_meta($root_cat_id, 'texts_font', true);
                    $type_nav = get_term_meta($root_cat_id, 'nav_font', true);
                    $type_banner = get_term_meta($root_cat_id, 'banner_font', true);
                    $type_price = get_term_meta($root_cat_id, 'price_font', true);
                }
                
                if ($type_font_select == 'custom') {
                    $custom_font = get_term_meta($root_cat_id, 'custom_font', true);
                }
                
                $font_css = tradeace_get_font_style(
                    $type_font_select,
                    $type_headings,
                    $type_texts,
                    $type_nav,
                    $type_banner,
                    $type_price,
                    $custom_font,
                    true
                );
                
                $dinamic_css .= $font_css;
            }
        }
        
        /**
         * Css inline override
         */
        if ($dinamic_css != '') {
            wp_add_inline_style('tradeace-style-dynamic', $dinamic_css);
        }
    }
endif;
