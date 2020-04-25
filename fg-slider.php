<?php

/**
 * @wordpress-plugin
 * Plugin Name:       FremeditiGuitars - Slider
 * Description:       FremeditiGuitars - Slider - Slideshow
 * Version:           1.0.0
 * Author:            Vasilis Koutsopoulos
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fg-slider
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die();

define( 'FG_SLIDER_VERSION', '1.0.0' );
define( 'FG_SLIDER_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FG_SLIDER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'FG_SLIDER_PLUGIN_DIR_NAME', basename( FG_SLIDER_PLUGIN_DIR_PATH ) );
define( 'FG_SLIDER_PLUGIN_URL', plugins_url( FG_SLIDER_PLUGIN_DIR_NAME ) );

include 'includes/class-fg-slider.php';
include 'includes/class-fg-slider-dependencies.php';
include 'includes/class-fg-slider-post-type.php';
include 'includes/class-fg-slider-shortcodes.php';

include 'includes/slider-fields/abstract-class-fg-slider-post-type-fields.php';
include 'includes/slider-fields/class-fg-slider-option-fields.php';
include 'includes/slider-fields/class-fg-slider-slides-fields.php';

include 'includes/cmb2-fields/cmb2-ratio/cmb2-ratio.php';
include 'includes/cmb2-fields/cmb2-items-per-slide/cmb2-items-per-slide.php';

FG_Slider::getInstance()->init();