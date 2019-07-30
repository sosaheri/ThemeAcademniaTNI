<?php
/**
 *
 * @package   GS_WPPosts
 * @author    Golam Samdani <samdani1997@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.gsamdani.com
 * @copyright 2016 Golam Samdani
 *
 * @wordpress-plugin
 * Plugin Name:           GS Posts Grid Lite
 * Plugin URI:            https://www.gsamdani.com/wordpress-plugins
 * Description:           Best Responsive WordPress Posts Grid Plugin to display Posts elegantly. Using GS Posts Grid plugin you can present latest posts in various views like Grid, Horizontal, List, Card, Table, Gray, Slider, Popup, Filter, Masonry & Justified Gallery. Display anywhere at your site using shortcode like [gs_wpposts theme=”gs_wppost_grid_1″] GS Posts Grid plugin packed with necessary controlling options & 30+ different themes to present latest posts elegantly with eye catching effects. Check details shortcode examples and documentation at <a href="http://posts-grid.gsamdani.com">GS Posts Grid PRO Demos & Docs</a>
 * Version:               1.1
 * Author:                Golam Samdani
 * Author URI:            https://www.gsamdani.com
 * Text Domain:           gswpposts
 * License:               GPL-2.0+
 * License URI:           http://www.gnu.org/licenses/gpl-2.0.txt
 */


if( ! defined( 'GSWPPOSTS_HACK_MSG' ) ) define( 'GSWPPOSTS_HACK_MSG', __( 'Sorry cowboy! This is not your place', 'gswppost' ) );

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( GSWPPOSTS_HACK_MSG );

/**
 * Defining constants
 */
if( ! defined( 'GSWPPOSTS_VERSION' ) ) define( 'GSWPPOSTS_VERSION', '1.1' );
if( ! defined( 'GSWPPOSTS_MENU_POSITION' ) ) define( 'GSWPPOSTS_MENU_POSITION', 31 );
if( ! defined( 'GSWPPOSTS_PLUGIN_DIR' ) ) define( 'GSWPPOSTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if( ! defined( 'GSWPPOSTS_PLUGIN_URI' ) ) define( 'GSWPPOSTS_PLUGIN_URI', plugins_url( '', __FILE__ ) );
if( ! defined( 'GSWPPOSTS_FILES_DIR' ) ) define( 'GSWPPOSTS_FILES_DIR', GSWPPOSTS_PLUGIN_DIR . 'gs-wpposts-files' );
if( ! defined( 'GSWPPOSTS_FILES_URI' ) ) define( 'GSWPPOSTS_FILES_URI', GSWPPOSTS_PLUGIN_URI . '/gs-wpposts-files' );

require_once GSWPPOSTS_FILES_DIR . '/gs-plugins/gs-plugins.php';
require_once GSWPPOSTS_FILES_DIR . '/gs-plugins/gs-plugins-free.php';
require_once GSWPPOSTS_FILES_DIR . '/gs-plugins/gs-wppost-help.php';
require_once GSWPPOSTS_FILES_DIR . '/includes/gs_wpposts_shortcode.php';
require_once GSWPPOSTS_FILES_DIR . '/gs_wpposts_scripts.php';
require_once GSWPPOSTS_FILES_DIR . '/admin/class.settings-api.php';
require_once GSWPPOSTS_FILES_DIR . '/admin/gs_wpposts_options_config.php';


// Add new image sizes
add_image_size( 'gs-square-thumb', 420, 420, true );
add_image_size( 'gs-masonry-thumb', 420, 0, true );

if ( ! function_exists('gs_posts_grid_pro_link') ) {
	function gs_posts_grid_pro_link( $gsPostGrid_links ) {
		$gsPostGrid_links[] = '<a class="gs-pro-link" href="https://www.gsamdani.com/product/wordpress-posts-grid" target="_blank">Go Pro!</a>';
		$gsPostGrid_links[] = '<a href="https://www.gsamdani.com/wordpress-plugins" target="_blank">GS Plugins</a>';
		return $gsPostGrid_links;
	}
	add_filter( 'plugin_action_links_' .plugin_basename(__FILE__), 'gs_posts_grid_pro_link' );
}