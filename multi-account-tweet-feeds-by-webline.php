<?php
/**
 * Plugin Name: Multi Account Tweet Feeds by Webline
 * Plugin URI: http://www.weblineindia.com/
 * Description: A Simple plugin to show latest Tweets from a multiple Twitter accounts in the same sidebar widget,post,page or text widget content.
 * Version: 1.0.7
 * Author: weblineindia
 * Author URI: http://www.weblineindia.com/
 * License: GPL
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );

$plugin_data = get_plugin_data( __FILE__ );

define( 'MATF_VERSION', $plugin_data['Version'] );
define( 'MATF_DEBUG', FALSE );
define( 'MATF_PATH', plugin_dir_path( __FILE__ ) );
define( 'MATF_URL', plugins_url( '', __FILE__ ) );
define( 'MATF_PLUGIN_FILE', basename( __FILE__ ) );
define( 'MATF_PLUGIN_DIR', plugin_basename( dirname( __FILE__ ) ) );
define( 'MATF_ADMIN_DIR', MATF_PATH . 'admin' );
define( 'MATF_PUBLIC_DIR', 'public' );
define( 'MATF_PUBLIC', MATF_PATH . MATF_PUBLIC_DIR );

// Adding Hook Class
require_once ( MATF_PUBLIC . '/hook.php' );

require_once ( MATF_PUBLIC . '/multi-account-tweet-feeds.php' );

require_once( MATF_ADMIN_DIR . '/multi-account-tweet-feeds-settings.php' );

require_once( MATF_PUBLIC . '/multi-account-tweet-feeds-shortcode.php' );
