<?php
defined('ABSPATH') or die();

if (get_option('tradeacetheme_imported') !== 'imported') :
    /**
     * Required Plugins
     */
    $required_plugins = tradeace_list_required_plugins();
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $keys = array_keys(get_plugins());
    if (!empty($keys)) {
        foreach ($required_plugins as $k => $plugin) {
            $file_path = $plugin['slug'];
            foreach ($keys as $key) {
                if (preg_match('|^' . $plugin['slug'] . '/|', $key)) {
                    $file_path = $key;
                    break;
                }
            }

            if (is_plugin_active($file_path)) {
                unset($required_plugins[$k]);
            }
        }
    }
    ?>
    <div class="tradeace-dashboard-demo-data">
        <h1 class="demo-data-heading">
            <img class="tradeace-logo" src="<?php echo TRADEACE_THEME_URI; ?>/assets/images/logo.png" alt="Logo" />
        </h1>
        
        <p><?php echo esc_html__("This wizard will set up your theme, install plugins, import content. It is optional & should take only a few minutes.", 'tradeace-theme'); ?></p>

        <?php
        if (!empty($required_plugins)) :
            echo '<div class="recommend-plugins">';
            
            echo '<p class="plugin-list-notice">' . esc_html__('Step 1: Install Plugins', 'tradeace-theme') . '</p>';
            
            echo '<p class="plugin-note">' . esc_html__("Let's install some essential WordPress plugins to set up your site.", 'tradeace-theme') . '</p>';
            
            $builder_array = array('elementor', 'js_composer');
            foreach ($required_plugins as $plugin) :
                if (isset($plugin['auto']) && $plugin['auto']) :
                    $required = isset($plugin['required']) && $plugin['required'] ? true : false;
                    $class = 'recommend-plugin';
                    $class .= $required ? ' required-plugin' : '';
                    $class .= !$required && isset($plugin['unchecked']) && $plugin['unchecked'] ? '' : ' selected';
                    $class .= in_array($plugin['slug'], $builder_array) ? ' builder-plugin' : '';
                    
                    echo '<a href="javascript:void(0);" class="' . $class . '" data-slug="' . $plugin['slug'] . '" data-name="' . esc_attr($plugin['name']) . '">';
                    
                    echo $plugin['name'];
                    
                    echo $required ? '<span class="require-text">' . esc_html__('Required', 'tradeace-theme') . '</span>' : '<span class="require-text">' . esc_html__('Recommend', 'tradeace-theme') . '</span>';
                    
                    echo '</a>';
                endif;
            endforeach;
            
            echo '<a href="javascript:void(0);" class="confirm-selected-plugins tradeace-disabled">' . esc_html__('CONTINUE', 'tradeace-theme') . '</a>';
            echo '</div>';
        endif;
        ?>
        <div class="main-demo-data">
            <h1 class="demo-data-heading small runing-hide">
                <?php esc_html_e('Step 2: Choose Homepage Layout', 'tradeace-theme'); ?>
            </h1>
            
            <p class="main-demo-data-notice"><?php echo esc_html__("Let's choose the homepage layout that you want to use on your website and click on the Start Import button.", 'tradeace-theme'); ?></p>
            
            <p class="main-demo-data-notice color-gray"><?php echo esc_html__("Note: Images at demo are not included in the download package and they are replaced with placeholders in demo data.", 'tradeace-theme'); ?></p>
            
            <a class="button button-primary button-hero tradeace-start-import" href="javascript:void(0);" data-permalink-option="<?php echo esc_url(admin_url('options-permalink.php')); ?>"><?php echo esc_html__('START IMPORT SAMPLE DATA', 'tradeace-theme'); ?></a>

            <div class="tradeace-select-homepage">
                <ul class="tradeace-tabs-heading">
                    <li class="tab-heading-js_composer">
                        <a href="javascript:void(0);" class="tradeace-tab-heading" data-target=".demo-homepages-wpb">
                            <?php echo esc_html__('WPBakery - Homes List', 'tradeace-theme'); ?>
                        </a>
                    </li>

                    <li class="tab-heading-elementor">
                        <a href="javascript:void(0);" class="tradeace-tab-heading" data-target=".demo-homepages-elm">
                            <?php echo esc_html__('Elementor - Homes List', 'tradeace-theme'); ?>
                        </a>
                    </li>
                </ul>

                <div class="tradeace-tabs-panel">
                    
                    <!-- Panel WPBakery -->
                    <div class="demo-homepages-wrap demo-homepages-wpb tradeace-tab-content tab-content-js_composer">
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-1" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-1.jpg" alt="Fashion 1" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-2" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-2.jpg" alt="Fashion 2" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-3" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-3.jpg" alt="Fashion 3" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-4" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-4.jpg" alt="Fashion 4" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-5" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-5.jpg" alt="Fashion 5" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-6" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-6.jpg" alt="Fashion 6" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-7" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-7.jpg" alt="Fashion 7" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-8" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-8.jpg" alt="Fashion 8" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-1" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/digital-1.jpg" alt="Digital-1" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-2" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/digital-2.jpg" alt="Digital-2" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/accessories.jpg" alt="Accessories" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="baby" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/baby.jpg" alt="Baby" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bag" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/bag.jpg" alt="Bag" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bike" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/bike.jpg" alt="Bike" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="cosmetic" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/cosmetic.jpg" alt="Cosmetic" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="face-mask" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/face-mask.jpg" alt="Face Mask" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="furniture" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/furniture.jpg" alt="Furniture" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="jewelry" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/jewelry.jpg" alt="Jewelry" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/organic.jpg" alt="Organic" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="retail" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/retail.jpg" alt="Retail" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="shoes" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/shoes.jpg" alt="Shoes" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="t-shirt" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/t-shirt.jpg" alt="T-shirt" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="pet-accessories" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/pet-accessories.jpg" alt="Pet Accessories" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/watch.jpg" alt="Watch" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch-dark" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/watch-dark.jpg" alt="Watch Dark" />
                            </a>
                        </div>
                    </div>

                    <!-- Panel Elementor -->
                    <div class="demo-homepages-wrap demo-homepages-elm tradeace-tab-content tab-content-elementor">
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-1" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-1.jpg" alt="Fashion 1" />
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-2" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-2.jpg" alt="Fashion 2" />
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-3" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-3.jpg" alt="Fashion 3" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-4" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-4.jpg" alt="Fashion 4" />
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-5" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-5.jpg" alt="Fashion 5" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-6" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-6.jpg" alt="Fashion 6" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-8" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/fashion-8.jpg" alt="Fashion 8" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-1" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/digital-1.jpg" alt="Digital-1" />
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-2" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/digital-2.jpg" alt="Digital-2" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/accessories.jpg" alt="Accessories" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="baby" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/baby.jpg" alt="Baby" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bag" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/bag.jpg" alt="Bag" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bike" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/bike.jpg" alt="Bike" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="cosmetic" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/cosmetic.jpg" alt="Cosmetic" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="face-mask" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/face-mask.jpg" alt="Face Mask" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="furniture" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/furniture.jpg" alt="Furniture" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="jewelry" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/jewelry.jpg" alt="Jewelry" />
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/organic.jpg" alt="Organic" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="retail" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/retail.jpg" alt="Retail" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="shoes" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/shoes.jpg" alt="Shoes" />
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="t-shirt" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/t-shirt.jpg" alt="T-shirt" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="christmas" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/christmas.jpg" alt="Christmas" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="pet-accessories" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/pet-accessories.jpg" alt="Pet Accessories" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/watch.jpg" alt="Watch" />
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch-dark" class="demo-homepage-item">
                                <img src="<?php echo TRADEACE_THEME_URI; ?>/admin/assets/pages/watch-dark.jpg" alt="Watch Dark" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="processing-demo-data">
                <h1 class="demo-data-heading small">
                    <?php esc_html_e('Step 3: Import Content', 'tradeace-theme'); ?>
                </h1>
                <p class="processing-notice-first"><?php echo esc_html__('Please waiting in a few minutes, The process is running...', 'tradeace-theme'); ?></p>

                <div class="process-bar-loading"><div class="process-bar-finished"></div></div>
                
                <ul class="processing-steps">
                    <li class="step processing-install-child-theme step-first" data-step="1">
                        <?php echo esc_html__('Install Trade_Ace Theme - Child', 'tradeace-theme'); ?>
                    </li>
                    <li class="step processing-data" data-step="2">
                        <?php echo esc_html__('Install Plugins', 'tradeace-theme'); ?>
                        <ul class="plugins-installed" data-url_manual="<?php echo esc_url(admin_url('themes.php?page=install-required-plugins')); ?>" data-text_error="<?php echo esc_attr__('Opp! please try to install the plugins here', 'tradeace-theme'); ?>"></ul>
                    </li>
                    <li class="step processing-data" data-step="3">
                        <?php echo esc_html__('Import Data (Media, Posts, Products, Categories...)', 'tradeace-theme'); ?> - <span class="statistic-data">0/25</span>
                    </li>
                    <li class="step processing-widgets" data-step="4">
                        <?php echo esc_html__('Import Widgets Sidebars', 'tradeace-theme'); ?>
                    </li>
                    <li class="step processing-homepage" data-step="5">
                        <?php echo esc_html__('Import Homes', 'tradeace-theme'); ?>
                    </li>
                    <li class="step processing-revsliders" data-step="6">
                        <?php echo esc_html__('Import Sliders', 'tradeace-theme'); ?>
                    </li>
                    <li class="step processing-theme-options step-end" data-step="7">
                        <?php echo esc_html__('Setup Theme Options', 'tradeace-theme'); ?>
                    </li>
                </ul>
                
                <p class="processing-notice-last tradeace-bold">
                    <?php echo esc_html__("All Done. Have fun!", 'tradeace-theme'); ?>
                </p>
                
                <p class="processing-notice-last">
                    <?php echo esc_html__("Your theme has been all setup. Enjoy your new theme.", 'tradeace-theme'); ?>
                </p>
                
                <p class="processing-notice-last"><a class="button button-primary button-hero" href="<?php echo esc_url(home_url('/')); ?>" target="_blank"><?php echo esc_html__('View your website', 'tradeace-theme'); ?></a></p>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="tradeace-dashboard-demo-data">
        <h1 class="demo-data-heading">
            <img class="tradeace-logo" src="<?php echo TRADEACE_THEME_URI; ?>/assets/images/logo.png" alt="Logo" />
        </h1>
        
        <p class="processing-notice-last tradeace-bold tradeace-block">
            <?php echo esc_html__("All Done. Have fun!", 'tradeace-theme'); ?>
        </p>

        <p class="processing-notice-last tradeace-block">
            <?php echo esc_html__("Your theme has been all setup. Enjoy your new theme.", 'tradeace-theme'); ?><br />
            <?php echo esc_html__("Demo data was imported. If you want import demo data again, You should need reset data of your site.", 'tradeace-theme'); ?>
        </p>

        <p class="processing-notice-last tradeace-block">
            <a class="button button-primary button-hero" href="<?php echo esc_url(home_url('/')); ?>" target="_blank"><?php echo esc_html__('View your website', 'tradeace-theme'); ?></a>
        </p>
    </div>
<?php
endif;
