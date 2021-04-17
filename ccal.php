<?php
/**
 * @package Club Calendar
 * @version 1.0.3
 */
/*
Plugin Name: Club Calendar
Description: Dies ist ein einfaches Kalenderplugin
Author: Marcel Haupt
Version: 1.0.3
Author URI: https://ehaupt.de
*/


define( 'CCAL__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CCAL__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once( CCAL__PLUGIN_DIR . 'class.ccal-widget.php' );
require_once( CCAL__PLUGIN_DIR . 'class.ccal-event.php' );
require_once( CCAL__PLUGIN_DIR . 'class.ccal-ajax.php' );
