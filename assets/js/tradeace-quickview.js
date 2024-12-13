/*global tradeace_params_quickview */
if (typeof _single_variations === 'undefined') {
    var _single_variations = [];
}

var _quicked_gallery = true,
    _tradeace_calling_gallery = 0,
    _tradeace_calling_countdown = 0;

(function ($, window, document, undefined) {
    /**
     * VariationForm_QickView class which handles variation forms and attributes.
     */
    var VariationForm_QickView = function ($form) {
        var self = this;

        self.$form = $form;
        self.$attributeFields = $form.find('.variations select');
        self.$singleVariation = $form.find('.single_variation');
        self.$singleVariationWrap = $form.find('.single_variation_wrap');
        self.$resetVariations = $form.find('.reset_variations');
        self.$product = $form.closest('.product');
        self.variationData = $form.data('product_variations');
        self.useAjax = false === self.variationData;
        self.xhr = false;
        self.loading = true;

        // Initial state.
        self.$singleVariationWrap.show();
        self.$form.off('.wc-variation-form');

        // Methods.
        self.getChosenAttributes = self.getChosenAttributes.bind(self);
        self.findMatchingVariations = self.findMatchingVariations.bind(self);
        self.isMatch = self.isMatch.bind(self);
        self.toggleResetLink = self.toggleResetLink.bind(self);

        // Events.
        $form.on('click.wc-variation-form', '.reset_variations', {variationForm: self}, self.onReset);
        $form.on('reload_product_variations', {variationForm: self}, self.onReload);
        $form.on('hide_variation', {variationForm: self}, self.onHide);
        $form.on('show_variation', {variationForm: self}, self.onShow);
        $form.on('click', '.single_add_to_cart_button', {variationForm: self}, self.onAddToCart);
        $form.on('reset_data', {variationForm: self}, self.onResetDisplayedVariation);
        $form.on('reset_image', {variationForm: self}, self.onResetImage);
        $form.on('change.wc-variation-form', '.variations select', {variationForm: self}, self.onChange);
        $form.on('found_variation.wc-variation-form', {variationForm: self}, self.onFoundVariation);
        $form.on('check_variations.wc-variation-form', {variationForm: self}, self.onFindVariation);
        $form.on('update_variation_values.wc-variation-form', {variationForm: self}, self.onUpdateAttributes);

        // Init after gallery.
        setTimeout(function () {
            $form.trigger('check_variations');
            $form.trigger('wc_variation_form');
            self.loading = false;
        }, 100);
    };

    /**
     * Reset all fields.
     */
    VariationForm_QickView.prototype.onReset = function (event) {
        event.preventDefault();
        event.data.variationForm.$attributeFields.val('').change();
        event.data.variationForm.$form.trigger('reset_data');
    };

    /**
     * Reload variation data from the DOM.
     */
    VariationForm_QickView.prototype.onReload = function (event) {
        var form = event.data.variationForm;
        form.variationData = form.$form.data('product_variations');
        form.useAjax = false === form.variationData;
        form.$form.trigger('check_variations');
    };

    /**
     * When a variation is hidden.
     */
    VariationForm_QickView.prototype.onHide = function (event) {
        event.preventDefault();
        event.data.variationForm.$form.find('.single_add_to_cart_button').removeClass('wc-variation-is-unavailable').addClass('disabled wc-variation-selection-needed');
        event.data.variationForm.$form.find('.woocommerce-variation-add-to-cart').removeClass('woocommerce-variation-add-to-cart-enabled').addClass('woocommerce-variation-add-to-cart-disabled');
    };

    /**
     * When a variation is shown.
     */
    VariationForm_QickView.prototype.onShow = function (event, variation, purchasable) {
        event.preventDefault();
        if (purchasable) {
            event.data.variationForm.$form.find('.single_add_to_cart_button').removeClass('disabled wc-variation-selection-needed wc-variation-is-unavailable');
            event.data.variationForm.$form.find('.woocommerce-variation-add-to-cart').removeClass('woocommerce-variation-add-to-cart-disabled').addClass('woocommerce-variation-add-to-cart-enabled');
        } else {
            event.data.variationForm.$form.find('.single_add_to_cart_button').removeClass('wc-variation-selection-needed').addClass('disabled wc-variation-is-unavailable');
            event.data.variationForm.$form.find('.woocommerce-variation-add-to-cart').removeClass('woocommerce-variation-add-to-cart-enabled').addClass('woocommerce-variation-add-to-cart-disabled');
        }
    };

    /**
     * When the cart button is pressed.
     */
    VariationForm_QickView.prototype.onAddToCart = function (event) {
        if ($(this).is('.disabled')) {
            event.preventDefault();

            if ($(this).is('.wc-variation-is-unavailable')) {
                window.alert(tradeace_params_quickview.i18n_unavailable_text);
            } else if ($(this).is('.wc-variation-selection-needed')) {
                window.alert(tradeace_params_quickview.i18n_make_a_selection_text);
            }
        }
    };

    /**
     * When displayed variation data is reset.
     */
    VariationForm_QickView.prototype.onResetDisplayedVariation = function (event) {
        var form = event.data.variationForm;
        form.$product.find('.product_meta').find('.sku').wc_reset_content();
        form.$product.find('.product_weight').wc_reset_content();
        form.$product.find('.product_dimensions').wc_reset_content();
        form.$form.trigger('reset_image');
        form.$singleVariation.slideUp(200).trigger('hide_variation');
    };

    /**
     * When the product image is reset.
     */
    VariationForm_QickView.prototype.onResetImage = function (event) {
        event.data.variationForm.$form.lightbox_wc_variations_image_update(false);
    };

    /**
     * Looks for matching variations for current selected attributes.
     */
    VariationForm_QickView.prototype.onFindVariation = function (event) {
        var form = event.data.variationForm,
            attributes = form.getChosenAttributes(),
            currentAttributes = attributes.data;

        if (attributes.count === attributes.chosenCount) {
            if (form.useAjax) {
                if (form.xhr) {
                    form.xhr.abort();
                }
                form.$form.block({message: null, overlayCSS: {background: '#fff', opacity: 0.6}});
                currentAttributes.product_id = parseInt(form.$form.data('product_id'), 10);
                currentAttributes.custom_data = form.$form.data('custom_data');
                form.xhr = $.ajax({
                    url: tradeace_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'get_variation'),
                    type: 'POST',
                    data: currentAttributes,
                    success: function (variation) {
                        if (variation) {
                            form.$form.trigger('found_variation', [variation]);
                        } else {
                            form.$form.trigger('reset_data');
                            attributes.chosenCount = 0;

                            if (!form.loading) {
                                form.$form.find('.single_variation').after('<p class="wc-no-matching-variations woocommerce-info">' + tradeace_params_quickview.i18n_no_matching_variations_text + '</p>');
                                form.$form.find('.wc-no-matching-variations').slideDown(200);
                            }
                        }
                    },
                    complete: function () {
                        form.$form.unblock();
                    }
                });
            } else {
                form.$form.trigger('update_variation_values');

                var matching_variations = form.findMatchingVariations(form.variationData, currentAttributes),
                    variation = matching_variations.shift();

                if (variation) {
                    form.$form.trigger('found_variation', [variation]);
                } else {
                    form.$form.trigger('reset_data');
                    attributes.chosenCount = 0;

                    if (!form.loading) {
                        form.$form.find('.single_variation').after('<p class="wc-no-matching-variations woocommerce-info">' + tradeace_params_quickview.i18n_no_matching_variations_text + '</p>');
                        form.$form.find('.wc-no-matching-variations').slideDown(200);
                    }
                }
            }
        } else {
            form.$form.trigger('update_variation_values');
            form.$form.trigger('reset_data');
        }

        // Show reset link.
        form.toggleResetLink(attributes.chosenCount > 0);
    };

    /**
     * Triggered when a variation has been found which matches all attributes.
     */
    VariationForm_QickView.prototype.onFoundVariation = function (event, variation) {
        var form = event.data.variationForm,
            $sku = form.$product.find('.product_meta').find('.sku'),
            $weight = form.$product.find('.product_weight'),
            $dimensions = form.$product.find('.product_dimensions'),
            $qty = form.$singleVariationWrap.find('.quantity'),
            purchasable = true,
            template = false,
            $template_html = '';
        
        if (variation.sku) {
            $sku.wc_set_content(variation.sku);
        } else {
            $sku.wc_reset_content();
        }

        if (variation.weight) {
            $weight.wc_set_content(variation.weight_html);
        } else {
            $weight.wc_reset_content();
        }

        if (variation.dimensions) {
            // Decode HTML entities.
            $dimensions.wc_set_content($.parseHTML(variation.dimensions_html)[0].data);
        } else {
            $dimensions.wc_reset_content();
        }

        form.$form.lightbox_wc_variations_image_update(variation);

        if (!variation.variation_is_visible) {
            template = tradeace_template('unavailable-variation-template');
        } else {
            template = tradeace_template('variation-template');
        }

        $template_html = tradeace_replace_template({
            variation: variation
        }, template);
        $template_html = $template_html.replace('/*<![CDATA[*/', '');
        $template_html = $template_html.replace('/*]]>*/', '');

        form.$singleVariation.html($template_html);
        form.$form.find('input[name="variation_id"], input.variation_id').val(variation.variation_id).change();

        // Hide or show qty input
        if (variation.is_sold_individually === 'yes') {
            $qty.find('input.qty').val('1').attr('min', '1').attr('max', '');
            $qty.hide();
        } else {
            $qty.find('input.qty').attr('min', variation.min_qty).attr('max', variation.max_qty);
            $qty.show();
        }

        // Enable or disable the add to cart button
        if (!variation.is_purchasable || !variation.is_in_stock || !variation.variation_is_visible) {
            purchasable = false;
        }

        // Reveal
        if ($.trim(form.$singleVariation.text())) {
            form.$singleVariation.slideDown(200).trigger('show_variation', [variation, purchasable]);
        } else {
            form.$singleVariation.show().trigger('show_variation', [variation, purchasable]);
        }
    };

    /**
     * Triggered when an attribute field changes.
     */
    VariationForm_QickView.prototype.onChange = function (event) {
        var form = event.data.variationForm;

        form.$form.find('input[name="variation_id"], input.variation_id').val('').change();
        form.$form.find('.wc-no-matching-variations').remove();

        if (form.useAjax) {
            form.$form.trigger('check_variations');
        } else {
            form.$form.trigger('woocommerce_variation_select_change');
            form.$form.trigger('check_variations');
            $(this).blur();
        }

        // Custom event for when variation selection has been changed
        form.$form.trigger('woocommerce_variation_has_changed');
    };

    /**
     * Escape quotes in a string.
     * @param {string} string
     * @return {string}
     */
    VariationForm_QickView.prototype.addSlashes = function (string) {
        string = string.replace(/'/g, '\\\'');
        string = string.replace(/"/g, '\\\"');
        return string;
    };

    /**
     * Updates attributes in the DOM to show valid values.
     */
    VariationForm_QickView.prototype.onUpdateAttributes = function (event) {
        var form = event.data.variationForm,
            attributes = form.getChosenAttributes(),
            currentAttributes = attributes.data;

        if (form.useAjax) {
            return;
        }

        // Loop through selects and disable/enable options based on selections.
        form.$attributeFields.each(function (index, el) {
            var current_attr_select = $(el),
                current_attr_name = current_attr_select.data('attribute_name') || current_attr_select.attr('name'),
                show_option_none = $(el).data('show_option_none'),
                option_gt_filter = ':gt(0)',
                attached_options_count = 0,
                new_attr_select = $('<select/>'),
                selected_attr_val = current_attr_select.val() || '',
                selected_attr_val_valid = true;

            // Reference options set at first.
            if (!current_attr_select.data('attribute_html')) {
                var refSelect = current_attr_select.clone();

                refSelect.find('option').removeAttr('disabled attached').removeAttr('selected');

                current_attr_select.data('attribute_options', refSelect.find('option' + option_gt_filter).get()); // Legacy data attribute.
                current_attr_select.data('attribute_html', refSelect.html());
            }

            new_attr_select.html(current_attr_select.data('attribute_html'));

            // The attribute of this select field should not be taken into account when calculating its matching variations:
            // The constraints of this attribute are shaped by the values of the other attributes.
            var checkAttributes = $.extend(true, {}, currentAttributes);
            checkAttributes[current_attr_name] = '';
            var variations = form.findMatchingVariations(form.variationData, checkAttributes);

            // Loop through variations.
            for (var num in variations) {
                if (typeof (variations[num]) !== 'undefined') {
                    var variationAttributes = variations[num].attributes;

                    for (var attr_name in variationAttributes) {
                        if (variationAttributes.hasOwnProperty(attr_name)) {
                            var attr_val = variationAttributes[ attr_name ],
                                variation_active = '';

                            if (attr_name === current_attr_name) {
                                if (variations[num].variation_is_active) {
                                    variation_active = 'enabled';
                                }

                                if (attr_val) {
                                    // Decode entities and add slashes.
                                    attr_val = $('<div/>').html(attr_val).text();

                                    // Attach.
                                    new_attr_select.find('option[value="' + form.addSlashes(attr_val) + '"]').addClass('attached ' + variation_active);
                                } else {
                                    // Attach all apart from placeholder.
                                    new_attr_select.find('option:gt(0)').addClass('attached ' + variation_active);
                                }
                            }
                        }
                    }
                }
            }

            // Count available options.
            attached_options_count = new_attr_select.find('option.attached').length;

            // Check if current selection is in attached options.
            if (selected_attr_val && (attached_options_count === 0 || new_attr_select.find('option.attached.enabled[value="' + form.addSlashes(selected_attr_val) + '"]').length === 0)) {
                selected_attr_val_valid = false;
            }

            // Detach the placeholder if:
            // - Valid options exist.
            // - The current selection is non-empty.
            // - The current selection is valid.
            // - Placeholders are not set to be permanently visible.
            if (attached_options_count > 0 && selected_attr_val && selected_attr_val_valid && ('no' === show_option_none)) {
                new_attr_select.find('option:first-child').remove();
                option_gt_filter = '';
            }

            // Detach unattached.
            new_attr_select.find('option' + option_gt_filter + ':not(.attached)').remove();

            // Finally, copy to DOM and set value.
            current_attr_select.html(new_attr_select.html());
            current_attr_select.find('option' + option_gt_filter + ':not(.enabled)').prop('disabled', true);

            // Choose selected value.
            if (selected_attr_val) {
                // If the previously selected value is no longer available, fall back to the placeholder (it's going to be there).
                if (selected_attr_val_valid) {
                    current_attr_select.val(selected_attr_val);
                } else {
                    current_attr_select.val('').change();
                }
            } else {
                current_attr_select.val(''); // No change event to prevent infinite loop.
            }
        });
        
        /**
         * Support Gallery images
         */
        if($('.product-lightbox').find('.tradeace-gallery-variation-supported').length) {
            if(!_quicked_gallery && typeof _lightbox_variations[0] !== 'undefined') {
                _quicked_gallery = true;
                var result = _lightbox_variations[0];
                
                /**
                 * Main image
                 */
                if(typeof result.quickview_gallery !== 'undefined') {
                    $('.tradeace-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                }

                /**
                 * Trigger after changed gallery
                 */
                $('body').trigger('tradeace_changed_gallery_variable_quickview');
            }
        }

        /**
         * Support Deal time - Countdown
         */
        if ($('.tradeace-quickview-product-deal-countdown').length) {
            $('.tradeace-quickview-product-deal-countdown').html('');
            $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
        }

        // Custom event for when variations have been updated.
        form.$form.trigger('woocommerce_update_variation_values');
    };

    /**
     * Get chosen attributes from form.
     * @return array
     */
    VariationForm_QickView.prototype.getChosenAttributes = function () {
        var data = {};
        var count = 0;
        var chosen = 0;

        this.$attributeFields.each(function () {
            var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
            var value = $(this).val() || '';

            if (value.length > 0) {
                chosen++;
            }

            count++;
            data[attribute_name] = value;
        });

        return {
            'count': count,
            'chosenCount': chosen,
            'data': data
        };
    };

    /**
     * Find matching variations for attributes.
     */
    VariationForm_QickView.prototype.findMatchingVariations = function (variations, attributes) {
        var matching = [];
        for (var i = 0; i < variations.length; i++) {
            var variation = variations[i];

            if (this.isMatch(variation.attributes, attributes)) {
                matching.push(variation);
            }
        }
        
        return matching;
    };

    /**
     * See if attributes match.
     * @return {Boolean}
     */
    VariationForm_QickView.prototype.isMatch = function (variation_attributes, attributes) {
        var match = true;
        for (var attr_name in variation_attributes) {
            if (variation_attributes.hasOwnProperty(attr_name)) {
                var val1 = variation_attributes[attr_name];
                var val2 = attributes[attr_name];
                if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
                    match = false;
                }
            }
        }
        return match;
    };

    /**
     * Show or hide the reset link.
     */
    VariationForm_QickView.prototype.toggleResetLink = function (on) {
        if (on) {
            if (this.$resetVariations.css('visibility') === 'hidden') {
                this.$resetVariations.css('visibility', 'visible').hide().fadeIn();
            }
        } else {
            this.$resetVariations.css('visibility', 'hidden');
        }
    };

    /**
     * Function to call wc_variation_form on jquery selector.
     */
    $.fn.wc_variation_form_lightbox = function () {
        new VariationForm_QickView(this);
        return this;
    };

    /**
     * Stores the default text for an element so it can be reset later
     */
    $.fn.wc_set_content = function (content) {
        if (undefined === this.attr('data-o_content')) {
            this.attr('data-o_content', this.text());
        }
        this.text(content);
    };

    /**
     * Stores the default text for an element so it can be reset later
     */
    $.fn.wc_reset_content = function () {
        if (undefined !== this.attr('data-o_content')) {
            this.text(this.attr('data-o_content'));
        }
    };

    /**
     * Stores a default attribute for an element so it can be reset later
     */
    $.fn.wc_set_variation_attr = function (attr, value) {
        if (undefined === this.attr('data-o_' + attr)) {
            this.attr('data-o_' + attr, (!this.attr(attr)) ? '' : this.attr(attr));
        }
        if (false === value) {
            this.removeAttr(attr);
        } else {
            this.attr(attr, value);
        }
    };

    /**
     * Reset a default attribute for an element so it can be reset later
     */
    $.fn.wc_reset_variation_attr = function (attr) {
        if (undefined !== this.attr('data-o_' + attr)) {
            this.attr(attr, this.attr('data-o_' + attr));
        }
    };

    /**
     * Reset the slide position if the variation has a different image than the current one
     */
    $.fn.wc_maybe_trigger_slide_position_reset = function (variation) {
        var $form = $(this),
            $product = $form.closest('.product'),
            $product_gallery = $product.find('.images'),
            reset_slide_position = false,
            new_image_id = (variation && variation.image_id) ? variation.image_id : '';

        if ($form.attr('current-image') !== new_image_id) {
            reset_slide_position = true;
        }

        $form.attr('current-image', new_image_id);

        if (reset_slide_position) {
            $product_gallery.trigger('woocommerce_gallery_reset_slide_position');
        }
    };

    /**
     * Sets product images for the chosen variation
     */
    $.fn.lightbox_wc_variations_image_update = function(variation) {
        var $form = this;
        
        if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
            /**
             * Support Gallery images
             */
            if($('.product-lightbox').find('.tradeace-gallery-variation-supported').length) {
                if (_tradeace_calling_gallery == 0) {
                    _tradeace_calling_gallery = 1;
                    var _data = {
                        'variation_id': variation.variation_id,
                        'is_purchasable': variation.is_purchasable,
                        'is_in_stock': variation.is_in_stock,
                        'main_id': typeof variation.image_id !== 'undefined' ? variation.image_id : 0,
                        'gallery': typeof variation.tradeace_gallery_variation !== 'undefined' ?
                            variation.tradeace_gallery_variation : [],
                        'show_images': $('.product-lightbox').find('.main-image-slider').attr('data-items')
                    };

                    change_gallery_variable_quickview($, _data, $form);
                }
            }
            
            else {
                _tradeace_calling_gallery = 0;
                
                var _src_large = typeof variation.image_single_page !== 'undefined' ?
                    variation.image_single_page : variation.image.url;

                $('.main-image-slider img.tradeace-first').attr('src', _src_large);
                $('.main-image-slider img.tradeace-first').removeAttr('srcset');
            }
            
            /**
             * deal time
             */
            if ($('.product-lightbox').find('.tradeace-gallery-variation-supported').length < 1 && $('.tradeace-quickview-product-deal-countdown').length) {
                if (
                    variation && variation.variation_id &&
                    variation.is_in_stock && variation.is_purchasable
                ) {
                    if (typeof _single_variations[variation.variation_id] === 'undefined' && _tradeace_calling_countdown == 0) {
                        _tradeace_calling_countdown = 1;
                        
                        if (
                            typeof tradeace_params_quickview !== 'undefined' &&
                            typeof tradeace_params_quickview.wc_ajax_url !== 'undefined'
                        ) {
                            var _urlAjax = tradeace_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_get_deal_variation');

                            $.ajax({
                                url: _urlAjax,
                                type: 'post',
                                cache: false,
                                data: {
                                    pid: variation.variation_id
                                },
                                beforeSend: function () {
                                    if (!$form.hasClass('tradeace-processing-countdown')) {
                                        $form.addClass('tradeace-processing-countdown');
                                    }
                                    
                                    $('.tradeace-quickview-product-deal-countdown').html('');
                                    $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
                                },
                                success: function (res) {
                                    _tradeace_calling_countdown = 0;
                                    
                                    $form.removeClass('tradeace-processing-countdown');

                                    if(typeof res.success !== 'undefined' && res.success === '1') {
                                        _single_variations[variation.variation_id] = res.content;
                                    } else {
                                        _single_variations[variation.variation_id] = '';
                                    }
                                    $('.tradeace-quickview-product-deal-countdown').html(_single_variations[variation.variation_id]);

                                    if(_single_variations[variation.variation_id] !== '') {
                                        /**
                                         * Trigger after changed Countdown
                                         */
                                        $('body').trigger('tradeace_load_countdown');

                                        if(!$('.tradeace-quickview-product-deal-countdown').hasClass('tradeace-show')) {
                                            $('.tradeace-quickview-product-deal-countdown').addClass('tradeace-show');
                                        }
                                    }

                                    else {
                                        $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
                                    }
                                },
                                error: function() {
                                    $form.removeClass('tradeace-processing-countdown');
                                }
                            });
                        }
                    } else {
                        $('.tradeace-quickview-product-deal-countdown').html(_single_variations[variation.variation_id]);
                        if(_single_variations[variation.variation_id] !== '') {

                            /**
                             * Trigger after changed Countdown
                             */
                            $('body').trigger('tradeace_load_countdown');

                            if(!$('.tradeace-quickview-product-deal-countdown').hasClass('tradeace-show')) {
                                $('.tradeace-quickview-product-deal-countdown').addClass('tradeace-show');
                            }
                        }

                        else {
                            $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
                        }
                        
                        _tradeace_calling_countdown = 0;
                    }
                }

                else {
                    $('.tradeace-quickview-product-deal-countdown').html('');
                    $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
                }
            }
        }
        
        else {
            $form.lightbox_wc_variations_image_reset();
        }
    };

    /**
     * Reset main image to defaults.
     */
    $.fn.lightbox_wc_variations_image_reset = function () {
        if ($('.product-lightbox').find('.tradeace-gallery-variation-supported').length) {
            if(!_quicked_gallery && typeof _lightbox_variations[0] !== 'undefined') {
                _quicked_gallery = true;
                var result = _lightbox_variations[0];
                
                /**
                 * Main image
                 */
                if(typeof result.quickview_gallery !== 'undefined') {
                    $('.tradeace-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                }
            }
        }
        
        else {
            var image_large = $('.tradeace-product-gallery-lightbox').attr('data-o_href');
            $('.main-image-slider img.tradeace-first').attr('src', image_large).removeAttr('srcset');
        }
        
        /**
         * Trigger after changed gallery
         */
        $('body').trigger('tradeace_changed_gallery_variable_quickview');
    };

    /**
     * Matches inline variation objects to chosen attributes
     * @deprecated 2.6.9
     * @type {Object}
     */
    var wc_variation_form_matcher = {
        find_matching_variations: function (product_variations, settings) {
            var matching = [];
            for (var i = 0; i < product_variations.length; i++) {
                var variation = product_variations[i];

                if (wc_variation_form_matcher.variations_match(variation.attributes, settings)) {
                    matching.push(variation);
                }
            }
            return matching;
        },
        variations_match: function (attrs1, attrs2) {
            var match = true;
            for (var attr_name in attrs1) {
                if (attrs1.hasOwnProperty(attr_name)) {
                    var val1 = attrs1[ attr_name ];
                    var val2 = attrs2[ attr_name ];
                    if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
                        match = false;
                    }
                }
            }
            return match;
        }
    };
    
    /**
     * 
     * @param {type} templateId
     * @returns {String}
     */
    var tradeace_template = function (templateId) {
        return document.getElementById('tmpl-' + templateId + '-tradeace').textContent;
    };

})(jQuery, window, document);

var _lightbox_variations,
    tradeace_quick_viewimg = false;
    
jQuery(document).ready(function($) {
    "use strict";
    
    var _tradeace_in_mobile = $('input[name="tradeace_mobile_layout"]').length ? true : false;
    
    /**
     * Quick view
     */
    var quickview_html = [],
        setMaxHeightQVPU;
        
    $('body').on('click', '.quick-view', function(e) {
        $.magnificPopup.close();

        if (
            typeof tradeace_params_quickview !== 'undefined' &&
            typeof tradeace_params_quickview.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = tradeace_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_quick_view');
            var _this = $(this);
            var _product_type = $(_this).attr('data-product_type');

            if (_product_type === 'woosb' && typeof $(_this).attr('data-href') !== 'undefined') {
                window.location.href = $(_this).attr('data-href');
            }

            else {
                var _wrap = $(_this).parents('.product-item'),
                    product_id = $(_this).attr('data-prod'),
                    _wishlist = ($(_this).attr('data-from_wishlist') === '1') ? '1' : '0';

                if ($(_wrap).length <= 0) {
                    _wrap = $(_this).parents('.item-product-widget');
                }

                if ($(_wrap).length <= 0) {
                    _wrap = $(_this).parents('.wishlist-item-warper');
                }

                if ($(_wrap).length) {
                    $(_wrap).append('<div class="tradeace-light-fog"></div><div class="tradeace-loader"></div>');
                }

                var _data = {
                    product: product_id,
                    tradeace_wishlist: _wishlist
                };

                tradeace_quick_viewimg = true;

                if ($('.tradeace-value-gets').length && $('.tradeace-value-gets').find('input').length) {
                    $('.tradeace-value-gets').find('input').each(function() {
                        var _key = $(this).attr('name');
                        var _val = $(this).val();
                        _data[_key] = _val;
                    });
                }

                var sidebar_holder = $('#tradeace-quickview-sidebar').length === 1 ? true : false;

                _data.quickview = sidebar_holder ? 'sidebar' : 'popup';

                var _callAjax = true;

                if (typeof quickview_html[product_id] !== 'undefined') {
                    _callAjax = false;
                }

                if (_callAjax) {
                    $.ajax({
                        url : _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        data: _data,
                        cache: false,
                        beforeSend: function() {
                            if (sidebar_holder) {
                                $('#tradeace-quickview-sidebar #tradeace-quickview-sidebar-content').html(
                                    '<div class="tradeace-loader"></div>'
                                );
                                $('.black-window').fadeIn(200).addClass('desk-window');
                                $('#tradeace-viewed-sidebar').removeClass('tradeace-active');

                                if ($('#tradeace-quickview-sidebar').length && !$('#tradeace-quickview-sidebar').hasClass('tradeace-active')) {
                                    $('#tradeace-quickview-sidebar').addClass('tradeace-active');
                                }
                            }

                            if ($('.tradeace-static-wrap-cart-wishlist').length && $('.tradeace-static-wrap-cart-wishlist').hasClass('tradeace-active')) {
                                $('.tradeace-static-wrap-cart-wishlist').removeClass('tradeace-active');
                            }

                            if (typeof setMaxHeightQVPU !== 'undefined') {
                                clearInterval(setMaxHeightQVPU);
                            }
                        },
                        success: function(response) {
                            quickview_html[product_id] = response;

                            // Sidebar hoder
                            if (sidebar_holder) {
                                $('#tradeace-quickview-sidebar #tradeace-quickview-sidebar-content').html('<div class="product-lightbox">' + response.content + '</div>');

                                setTimeout(function() {
                                    $('#tradeace-quickview-sidebar #tradeace-quickview-sidebar-content .product-lightbox').addClass('tradeace-loaded');
                                }, 600);
                            }

                            // Popup classical
                            else {
                                $.magnificPopup.open({
                                    mainClass: 'my-mfp-zoom-in',
                                    items: {
                                        src: '<div class="product-lightbox">' + response.content + '</div>',
                                        type: 'inline'
                                    },
                                    // tClose: $('input[name="tradeace-close-string"]').val(),
                                    closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>',
                                    callbacks: {
                                        beforeClose: function() {
                                            this.st.removalDelay = 350;
                                        },
                                        afterClose: function() {
                                            if (typeof setMaxHeightQVPU !== 'undefined') {
                                                clearInterval(setMaxHeightQVPU);
                                            }
                                        }
                                    }
                                });

                                $('.black-window').trigger('click');
                            }

                            /**
                             * Init Gallery image
                             */
                            $('body').trigger('tradeace_init_product_gallery_lightbox');

                            if ($(_this).hasClass('tradeace-view-from-wishlist')) {
                                $('.wishlist-item').animate({opacity: 1}, 500);
                                if (!sidebar_holder) {
                                    $('.wishlist-close a').trigger('click');
                                }
                            }

                            if ($(_wrap).length) {
                                $(_wrap).find('.tradeace-loader, .color-overlay, .tradeace-dark-fog, .tradeace-light-fog').remove();
                            }

                            var formLightBox = $('.product-lightbox').find('.variations_form');
                            if ($(formLightBox).length && $(formLightBox).find('.single_variation_wrap').length) {
                                $(formLightBox).find('.single_variation_wrap').hide();
                                $(formLightBox).wc_variation_form_lightbox(response.mess_unavailable);
                                $(formLightBox).find('select').change();
                                if ($(formLightBox).find('.variations select option[selected="selected"]').length) {
                                    $(formLightBox).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                                }

                                $('body').trigger('tradeace_init_ux_variation_form', formLightBox);
                            }

                            var groupLightBox = $('.product-lightbox').find('.woocommerce-grouped-product-list-item');
                            if ($(groupLightBox).length) {
                                $(groupLightBox).removeAttr('style');
                                $(groupLightBox).removeClass('wow');
                            }

                            if (!sidebar_holder) {
                                setMaxHeightQVPU = setInterval(function() {
                                    var _h_l = $('.product-lightbox .product-img').outerHeight();

                                    $('.product-lightbox .product-quickview-info').css({
                                        'max-height': _h_l,
                                        'overflow-y': 'auto'
                                    });

                                    if (!$('.product-lightbox .product-quickview-info').hasClass('tradeace-active')) {
                                        $('.product-lightbox .product-quickview-info').addClass('tradeace-active');
                                    }

                                    if (_tradeace_in_mobile) {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }, 1000);
                            }

                            add_class_btn_single_button($);

                            $('body').trigger('tradeace_after_quickview');

                            setTimeout(function() {
                                $('body').trigger('tradeace_after_quickview_timeout');
                            }, 600);

                            setTimeout(function() {
                                $(window).resize();
                            }, 800);
                        }
                    });
                } else {
                    var quicview_obj = quickview_html[product_id];

                    if (sidebar_holder) {
                        $('#tradeace-quickview-sidebar #tradeace-quickview-sidebar-content').html(
                            '<div class="tradeace-loader"></div>'
                        );
                        $('.black-window').fadeIn(200).addClass('desk-window');
                        $('#tradeace-viewed-sidebar').removeClass('tradeace-active');

                        if ($('#tradeace-quickview-sidebar').length && !$('#tradeace-quickview-sidebar').hasClass('tradeace-active')) {
                            $('#tradeace-quickview-sidebar').addClass('tradeace-active');
                        }
                    }

                    if ($('.tradeace-static-wrap-cart-wishlist').length && $('.tradeace-static-wrap-cart-wishlist').hasClass('tradeace-active')) {
                        $('.tradeace-static-wrap-cart-wishlist').removeClass('tradeace-active');
                    }

                    if (typeof setMaxHeightQVPU !== 'undefined') {
                        clearInterval(setMaxHeightQVPU);
                    }

                    // Sidebar hoder
                    if (sidebar_holder) {
                        $('#tradeace-quickview-sidebar #tradeace-quickview-sidebar-content').html('<div class="product-lightbox hidden-tag">' + quicview_obj.content + '</div>');

                        setTimeout(function() {
                            $('#tradeace-quickview-sidebar #tradeace-quickview-sidebar-content .product-lightbox').fadeIn(1000);
                        }, 600);
                    }

                    // Popup classical
                    else {
                        $.magnificPopup.open({
                            mainClass: 'my-mfp-zoom-in',
                            items: {
                                src: '<div class="product-lightbox">' + quicview_obj.content + '</div>',
                                type: 'inline'
                            },
                            // tClose: $('input[name="tradeace-close-string"]').val(),
                            closeMarkup: '<a class="tradeace-mfp-close tradeace-stclose" href="javascript:void(0);" title="' + $('input[name="tradeace-close-string"]').val() + '"></a>',
                            callbacks: {
                                beforeClose: function() {
                                    this.st.removalDelay = 350;
                                },
                                afterClose: function() {
                                    if (typeof setMaxHeightQVPU !== 'undefined') {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }
                            }
                        });

                        $('.black-window').trigger('click');
                    }

                    /**
                     * Init Gallery image
                     */
                    $('body').trigger('tradeace_init_product_gallery_lightbox');

                    if ($(_this).hasClass('tradeace-view-from-wishlist')) {
                        $('.wishlist-item').animate({opacity: 1}, 500);
                        if (!sidebar_holder) {
                            $('.wishlist-close a').trigger('click');
                        }
                    }

                    if ($(_wrap).length) {
                        $(_wrap).find('.tradeace-loader, .color-overlay, .tradeace-dark-fog, .tradeace-light-fog').remove();
                    }

                    var formLightBox = $('.product-lightbox').find('.variations_form');
                    if ($(formLightBox).length && $(formLightBox).find('.single_variation_wrap').length) {
                        $(formLightBox).find('.single_variation_wrap').hide();
                        $(formLightBox).wc_variation_form_lightbox(quicview_obj.mess_unavailable);
                        $(formLightBox).find('select').change();
                        if ($(formLightBox).find('.variations select option[selected="selected"]').length) {
                            $(formLightBox).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                        }
                        $('body').trigger('tradeace_init_ux_variation_form', formLightBox);
                    }

                    var groupLightBox = $('.product-lightbox').find('.woocommerce-grouped-product-list-item');
                    if ($(groupLightBox).length) {
                        $(groupLightBox).removeAttr('style');
                        $(groupLightBox).removeClass('wow');
                    }

                    if (!sidebar_holder) {
                        setMaxHeightQVPU = setInterval(function() {
                            var _h_l = $('.product-lightbox .product-img').outerHeight();

                            $('.product-lightbox .product-quickview-info').css({
                                'max-height': _h_l,
                                'overflow-y': 'auto'
                            });

                            if (!$('.product-lightbox .product-quickview-info').hasClass('tradeace-active')) {
                                $('.product-lightbox .product-quickview-info').addClass('tradeace-active');
                            }

                            if (_tradeace_in_mobile) {
                                clearInterval(setMaxHeightQVPU);
                            }
                        }, 1000);
                    }

                    add_class_btn_single_button($);

                    $('body').trigger('tradeace_after_quickview');

                    setTimeout(function() {
                        $('body').trigger('tradeace_after_quickview_timeout');
                    }, 600);

                    setTimeout(function() {
                        $(window).resize();
                    }, 800);
                }
            }
        }

        e.preventDefault();
    });

    /**
     * Change gallery for variation - Quick view
     */
    $('body').on('tradeace_changed_gallery_variable_quickview', function() {
        $('body').trigger('tradeace_load_slick_slider');
    });
    
    /**
     * Init gallery lightbox
     */
    $('body').on('tradeace_init_product_gallery_lightbox', function() {
        if ($('.product-lightbox').find('.tradeace-product-gallery-lightbox').length) {
            _lightbox_variations[0] = {
                'quickview_gallery': $('.product-lightbox').find('.tradeace-product-gallery-lightbox').html()
            };
        }
    });
    
    /**
     * After Close Fog Window
     */
    $('body').on('tradeace_after_close_fog_window', function() {
        tradeace_quick_viewimg = false;
    });
});

function tradeace_replace_template(data, html) {
    var variation = data.variation || {};

    if(html !== '') {
        if(typeof variation.variation_description !== 'undefined') {
            html = html.replace('{{{data.variation.variation_description}}}', variation.variation_description);
        }

        if(typeof variation.variation_description !== 'undefined') {
            html = html.replace('{{{data.variation.price_html}}}', variation.price_html);
        }

        if(typeof variation.variation_description !== 'undefined') {
            html = html.replace('{{{data.variation.availability_html}}}', variation.availability_html);
        }
    }
    
    return html;
}

/**
 * Support for Quick-view
 */
var _timeout_quickviewGallery;
function change_gallery_variable_quickview($, _data, _form) {
    _quicked_gallery = false;

    if (typeof _lightbox_variations[_data.variation_id] === 'undefined') {
        if (
            typeof tradeace_params_quickview !== 'undefined' &&
            typeof tradeace_params_quickview.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = tradeace_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'tradeace_quickview_gallery_variation');

            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    data: _data
                },
                beforeSend: function () {
                    if (!$(_form).hasClass('tradeace-processing')) {
                        $(_form).addClass('tradeace-processing');
                    }
                    
                    $('.tradeace-quickview-product-deal-countdown').html('');
                    $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');

                    if ($('.tradeace-product-gallery-lightbox').find('.tradeace-loading').length <= 0) {
                        $('.tradeace-product-gallery-lightbox').append('<div class="tradeace-loading"></div>');
                    }
                    
                    if ($('.tradeace-product-gallery-lightbox').find('.tradeace-loader').length <= 0) {
                        $('.tradeace-product-gallery-lightbox').append('<div class="tradeace-loader" style="top:45%"></div>');
                    }
                    
                    $('.tradeace-product-gallery-lightbox').css({'min-height': $('.tradeace-product-gallery-lightbox').outerHeight()});
                },
                success: function (result) {
                    _tradeace_calling_gallery = 0;
                    
                    $(_form).removeClass('tradeace-processing');
                    
                    $('.tradeace-product-gallery-lightbox').find('.tradeace-loading, .tradeace-loader').remove();

                    _lightbox_variations[_data.variation_id] = result;

                    /**
                     * Deal
                     */
                    if (typeof result.deal_variation !== 'undefined') {
                        $('.tradeace-quickview-product-deal-countdown').html(result.deal_variation);

                        if (result.deal_variation !== '') {
                            /**
                             * Trigger after changed Countdown
                             */
                            $('body').trigger('tradeace_load_countdown');
                            
                            if (!$('.tradeace-quickview-product-deal-countdown').hasClass('tradeace-show')) {
                                $('.tradeace-quickview-product-deal-countdown').addClass('tradeace-show');
                            }
                        }

                        else {
                            $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
                        }
                    } else {
                        $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
                    }

                    /**
                     * Main image
                     */
                    if (typeof result.quickview_gallery !== 'undefined') {
                        $('.tradeace-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                    }

                    if (typeof _timeout_quickviewGallery !== 'undefined') {
                        clearTimeout(_timeout_quickviewGallery);
                    }
                    
                    _timeout_quickviewGallery = setTimeout(function (){
                        $('.tradeace-product-gallery-lightbox').css({'min-height': 'auto'});
                    }, 200);

                    /**
                     * Trigger after changed gallery
                     */
                    $('body').trigger('tradeace_changed_gallery_variable_quickview');
                },
                error: function() {
                    _tradeace_calling_gallery = 0;
                    $(_form).removeClass('tradeace-processing');
                }
            });
        }
    } else {
        var result = _lightbox_variations[_data.variation_id];

        /**
         * Deal
         */
        if (typeof result.deal_variation !== 'undefined') {
            $('.tradeace-quickview-product-deal-countdown').html(result.deal_variation);

            if (result.deal_variation !== '') {
                $('body').trigger('tradeace_load_countdown');
                
                if (!$('.tradeace-quickview-product-deal-countdown').hasClass('tradeace-show')) {
                    $('.tradeace-quickview-product-deal-countdown').addClass('tradeace-show');
                }
            }

            else {
                $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
            }
        } else {
            $('.tradeace-quickview-product-deal-countdown').removeClass('tradeace-show');
        }

        /**
         * Main image
         */
        if (typeof result.quickview_gallery !== 'undefined') {
            $('.tradeace-product-gallery-lightbox').append('<div class="tradeace-loading"></div>');
            $('.tradeace-product-gallery-lightbox').append('<div class="tradeace-loader" style="top:45%"></div>');
            $('.tradeace-product-gallery-lightbox').css({'min-height': $('.tradeace-product-gallery-lightbox').height()});
            
            $('.tradeace-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
            if (typeof _timeout_changed !== 'undefined') {
                clearTimeout(_timeout_changed);
            }

            _timeout_changed = setTimeout(function() {
                $('.tradeace-product-gallery-lightbox').find('.tradeace-loader, .tradeace-loading').remove();
                $('.tradeace-product-gallery-lightbox').css({'min-height': 'auto'});
            }, 200);
        }
        
        _tradeace_calling_gallery = 0;

        /**
         * Trigger after changed gallery
         */
        $('body').trigger('tradeace_changed_gallery_variable_quickview');
    }
}
