<?php
/*
 * Plugin Name: Generate dinamically HTML sitemap
 * Version: 0.01
 * Plugin URI: https://github.com/sarandi-maxim/
 * Description: Build your HTML sitemap. Very simple and easy usage
 * Author: Maksym Sarandi
 * Author URI: https://github.com/sarandi-maxim
 * Requires at least: 4.9
 * Tested up to: 4.9.2
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: ag-html-sitemap
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Maksym Sarandi
 * @since 0.01
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Require plugin class
 */
require_once __DIR__ . '/includes/class-html-sitemap-generator.php';

/**
 * Init Plugin
 */
if ( is_admin() ) {
	new AG_Html_Sitemap_Builder();
}
