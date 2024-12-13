<?php

/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Section
 */

if (!defined('ABSPATH')) {
    die('-1');
}

global $tradeace_current_layout;

$atts = vc_map_get_attributes($this->getShortcode(), $atts);

$class_tab = array('vc_tta-panel tradeace-panel hidden-tag');
$class_acc = array('tradeace-accordion hidden-tag');
if ((WPBakeryShortCode_VC_Tta_Section::$self_count == 0)) {
    $class_tab[] = 'active first';
    $class_acc[] = 'active first';
}

if ($atts['el_class'] != '') {
    $class_tab[] = $atts['el_class'];
    $class_acc[] = $atts['el_class'];
}

$this->resetVariables($atts, $content);
WPBakeryShortCode_VC_Tta_Section::$self_count++;
WPBakeryShortCode_VC_Tta_Section::$section_info[] = $atts;

$isPageEditable = vc_is_page_editable();
$tab_id = $this->getTemplateVariable('tab_id');

$class_tab[] = 'tradeace-section-' . esc_attr($tab_id);
$class_tab_str = implode(' ', $class_tab);
$class_acc_str = implode(' ', $class_acc);

$output = '';

if ($tradeace_current_layout == 'accordion') :
    $output .= '<div class="tradeace-accordion-title">';
    $output .= '<a class="' . $class_acc_str . '" data-index="tradeace-section-' . esc_attr($tab_id) . '" href="javascript:void(0);" rel="nofollow">' . $this->getTemplateVariable('title') . '</a>';
    $output .= '</div>';
endif;

$output .= '<div class="' . $class_tab_str . '">';
$output .= $this->getTemplateVariable('content');
$output .= '</div>';

return $output;
