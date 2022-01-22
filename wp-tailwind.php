<?php 
/**
 * Plugin Name: WP TailWind
 * Description: Implementation of TailWind CSS in the WordPress plugin.
 * Author: Sarang Shahane
 * Version: 0.0.1
 * License: GPL v3
 *
 * @package wp-tailwind
 */

 /**
 * Set constants
 */
define( 'WPT_FILE', __FILE__ );
define( 'WPT_BASE', plugin_basename( WPT_FILE ) );
define( 'WPT_DIR', plugin_dir_path( WPT_FILE ) );
define( 'WPT_URL', plugins_url( '/', WPT_FILE ) );
define( 'WPT_VER', '0.0.1' );
define( 'WPT_PREFIX', 'tws' );

require_once 'classes/class-tailwind-loader.php';