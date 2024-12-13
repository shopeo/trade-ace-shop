<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ABSPATH')) {
    die('-1');
}

$title_top = $this->getTemplateVariable('title');
$content = '';

if (WPBakeryShortCode_VC_Tta_Section::$section_info) :
    $alignment_class = $alignment ? ' text-' . $alignment : '';
    $el_class = (trim($el_class) != '') ? ' ' . $el_class : '';
    $tabs_slide = (isset($tabs_display_type) && $tabs_display_type == 'slide') ? true : false;
    $class_tabable = ' margin-bottom-15';
    $class_ul_tab = 'tradeace-tabs';
    $class_a_click = 'tradeace-a-tab';
    $tab_bg = array();
    $class_title = false;
    $tab_color = $tab_color_text = array();
    
    if ($tabs_slide) :
        $class_ul_tab .= ' tradeace-slide-style';
    else :
        $tabs_type = !isset($tabs_display_type) ? '2d-no-border' : $tabs_display_type;
        switch ($tabs_type) :
            case '2d':
                $tabs_type_class = ' tradeace-classic-2d';
                break;
            
            case '3d':
                $tabs_type_class = ' tradeace-classic-3d';
                break;
            
            case '2d-has-bg':
                $style_title = '';
                
                if ($title_top) {
                    if ($alignment !== 'center') {
                        $class_title = 'tradeace-title-absolute';
                        $class_title .= $alignment == 'left' ? ' text-right' : ' text-left';
                    }
                }
                
                $tabs_type_class = ' tradeace-classic-2d tradeace-tabs-no-border tradeace-tabs-has-bg';
                $class_tabable = ' margin-bottom-10';
                $class_tabable .= $alignment == 'left' ? ' mobile-text-right' : ' mobile-text-left';
                $tabs_bg_color = (!isset($tabs_bg_color) || $tabs_bg_color == '') ?
                    'transparent' : $tabs_bg_color;
                
                $tabs_type_class .= 'transparent' == $tabs_bg_color ? ' tradeace-tabs-bg-transparent' : '';
                if ($tabs_bg_color != 'transparent') {
                    $tab_bg[] = 'background-color: ' . $tabs_bg_color;
                }
                
                if (isset($tabs_text_color) && $tabs_text_color != '') {
                    $tab_color[] = 'color: ' . $tabs_text_color;
                    $tab_color_text[] = 'border-color: ' . $tabs_text_color;
                    $class_a_click .= ' tradeace-custom-text-color';
                    
                    if ($class_title) {
                        $style_title = ' style="color: ' . $tabs_text_color . '"';
                    }
                }
                
                if ($class_title && $tabs_bg_color !== 'transparent') {
                    $class_title .= ' tradeace-has-padding';
                }
                
                $title_top = $class_title ? '<div class="' . esc_attr($class_title) . '"' . $style_title . '>' . $title_top . '</div>' : $title_top;
                
                break;
                
            case '2d-radius':
                $tabs_type_class = ' tradeace-classic-2d tradeace-tabs-no-border tradeace-tabs-radius';
                break;
            
            case '2d-radius-dashed':
                $tabs_type_class = ' tradeace-classic-2d tradeace-tabs-radius-dashed';
                break;
            
            case '2d-no-border':
            default:
                $tabs_type_class = ' tradeace-classic-2d tradeace-tabs-no-border';
                break;
            
        endswitch;
        
        $class_ul_tab .= ' tradeace-classic-style' . $tabs_type_class;
    endif;
    
    $class_tabable .= $alignment_class ? $alignment_class : '';
    
    $content .= '<div class="tradeace-tabs-content' . esc_attr($el_class) . '">';
    $content .= '<div class="tradeace-tabs-wrap' . esc_attr($class_tabable) . '">';
    $content .= '<ul class="' . esc_attr($class_ul_tab) . '"' . (!empty($tab_bg) ? ' style="' . implode(';', $tab_bg) . '"' : '') . '>';
    
    foreach (WPBakeryShortCode_VC_Tta_Section::$section_info as $k => $v):
        $custom_icon = false;
        if (trim($v["section_tradeace_icon"]) !== '') {
            $v['add_icon'] = 'true';
            $custom_icon = true;
        }
        $title = esc_html($v['title']);
        $icon = '';
        if ($v['add_icon'] == 'true') {
            $icon = 'tradeace-tab-icon ';
            $icon .= !$custom_icon ?
                $v['i_icon_' . $v['i_type']] : 'padding-bottom-15 ' . $v["section_tradeace_icon"];
            
            switch ($v['i_position']) {
                case 'right':
                    $title = $title . '<i class="' . $icon . '"></i>';
                    break;
                case 'left':
                default :
                    $title = '<i class="' . $icon . '"></i>' . $title;
                    break;
            }
        }
        
        $class_item = 'tradeace-tab';
        $class_item .= $k == 0 ? ' active first' : '';
        $class_item .= ($k + 1) == WPBakeryShortCode_VC_Tta_Section::$self_count ? ' last' : '';
        $tradeace_attr = ' class="' . $class_item . '"';
        $tradeace_attr .= !empty($tab_color) ? ' style="' . implode(';', $tab_color) . '"' : '';
        $content .= '<li' . $tradeace_attr . '>';
        $content .= '<a href="javascript:void(0);" data-index="tradeace-section-' . esc_attr($v['tab_id']) . '" class="' . esc_attr($class_a_click) . '"' . (!empty($tab_color_text) ? ' style="' . implode(';', $tab_color_text) . '"' : '') . ' rel="nofollow">' . $title . '</a></li>';
    endforeach;
    
    $content .= '</ul>';
    $content .= '</div>';
    $content .= '<div class="tradeace-panels">';
    $content .= $prepareContent; // Content
    $content .= '</div>';
    $content .= '</div>';
endif;

$output = $title_top . $content;

echo $output;
