<?php



$el_class = (trim($el_class) != '') ? ' ' . $el_class : '';
$el_class .= isset($accordion_hide_first) && $accordion_hide_first ? ' tradeace-accodion-first-hide' : '';
$el_class .= isset($accordion_layout) && $accordion_layout ? ' tradeace-' . $accordion_layout : ' tradeace-has-border';
$el_class .= isset($accordion_icon) && $accordion_icon ? ' tradeace-' . $accordion_icon : ' tradeace-plus';
if (isset($accordion_show_multi) && $accordion_show_multi) {
    $el_class .= ' tradeace-no-global';
}
$output = $this->getTemplateVariable('title');
$output .= '<div class="tradeace-accordions-content' . $el_class . '">';
    $output .= $prepareContent;
$output .= '</div>';

echo $output;
