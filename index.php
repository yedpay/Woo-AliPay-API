<?php

/*
  Plugin Name: Woo-AliPay-API
  Description: Extends WooCommerce to Process Payments with AliPay's API Method.
  Version: 1.1.0
  Plugin URI: https://wordpress.org/plugins/woo-alipay-api/
  Author: Yedpay
  Author URI: https://www.yedpay.com/
  Developer: Sourabh Tejawat
  Developer URI:
  License: Under GPL2
  Note: Under Development
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

register_uninstall_hook(__FILE__, 'alipay_uninstall');

// remove stored setting when plugin uninstall
function alipay_uninstall()
{
    delete_option('woocommerce_alipayapi_settings');
}

add_action('plugins_loaded', 'woocommerce_tech_alipayapi_init', 0);

function woocommerce_tech_alipayapi_init()
{
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }

    /**
     * AliPay Payment Gateway class
     */
    include_once plugin_dir_path(__FILE__) . '/WoocommerceAlipay.php';

    /**
     * Add this Gateway to WooCommerce
     */
    function woocommerce_add_tech_alipayapi_gateway($methods)
    {
        $methods[] = 'WoocommerceAlipay';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'woocommerce_add_tech_alipayapi_gateway');
}
