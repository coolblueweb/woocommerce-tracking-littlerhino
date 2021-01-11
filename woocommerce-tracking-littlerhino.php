<?php
/*
Plugin Name: WooCommerce Tracking
Plugin URI: https://littlerhino.io
Description: Including carrier tracking information within orders and order emails. Supports USPS, UPS, FedEx, DHL, and Canada Post.
Version: 1.0.1
Author: Tyler Johnson
Author URI: https://littlerhino.io
Copyright: Little Rhino
Text Domain: wc-lr-shiptrack
Copyright © 2021 Little Rhino. All Rights Reserved.
*/

/**
Disallow direct access.
**/
defined( 'ABSPATH' ) or exit;

/**
Let's make sure WooCommerce is active.
**/
if( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

/**
Set our constants.
**/
define( 'LR_SHIPTRACK_VERSION', '1.0.1' );
define( 'LR_SHIPTRACK_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'LR_SHIPTRACK_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'LR_SHIPTRACK_TXT', 'wc-lr-shiptrack' );

/**
Updates.
**/
require LR_SHIPTRACK_PATH. 'updates/plugin-update-checker.php';
$shipTrackUpdates = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/coolblueweb/woocommerce-tracking-littlerhino',
	__FILE__,
	'woocommerce-tracking-littlerhino'
);
$shipTrackUpdates->getVcsApi()->enableReleaseAssets();

/**
Load our base functions.
**/
require_once( LR_SHIPTRACK_PATH . 'inc/functions.php' );
