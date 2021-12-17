<?php
/**
 * Plugin Name:     Base Block
 * Plugin URI:      https://github.com/pbrocks/base-block
 * Description:     Example block written with ESNext standard and JSX support – build step required.
 * Version:         0.1.1
 * Author:          pbrocks
 * Author URI:      https://github.com/pbrocks
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     base-block
 *
 * @package         create-block
 */

/**
 * Here we are checking that WordPress is loaded and denying browsers any direct access to the code. Functionality of this plugin's code and only be realized by running the plugin through WordPress.
 */
defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

register_activation_hook( __FILE__, 'base_block_install' );
function base_block_install() {
	  set_transient( 'base_block_activated', true, 30 );
}


add_action( 'plugins_loaded', 'base_block_php_initialization' );
/**
 * Initialize php files
 *
 * @since 4.0
 */
function base_block_php_initialization() {
	/**
		   * Include all php files in /inc directory.
		   */
	if ( file_exists( __DIR__ . '/inc' ) && is_dir( __DIR__ . '/inc' ) ) {
		foreach ( glob( __DIR__ . '/inc/*.php' ) as $filename ) {
			require $filename;
		}
	}

	/**
	 * Include all php files in /inc/classes directory.
	 */
	if ( file_exists( __DIR__ . '/inc/classes' ) && is_dir( __DIR__ . '/inc/classes' ) ) {
		foreach ( glob( __DIR__ . '/inc/classes/*.php' ) as $filename ) {
			require $filename;
		}
	}
}

add_action( 'plugins_loaded', 'base_block_load_textdomain' );
/**
 * Setup WordPress localization support
 *
 * @since 4.0
 */
function base_block_load_textdomain() {
	  load_plugin_textdomain( 'base-block', false, basename( dirname( __FILE__ ) ) . '/languages' );
}


/**
 * Show action links on the plugin screen.
 *
 * @param    mixed $links Plugin Action links
 *
 * @return    array
 *
 * @since 4.0
 */
function base_block_plugin_action_links( $links ) {
	$action_links = array(
		'getting_started' => '<a href="' . esc_url( admin_url( 'index.php?page=base-block-dashboard.php' ) ) . '" title="' . esc_attr__( 'Get started with base-block', 'base-block' ) . '">' . esc_html__( 'Getting Started', 'base-block' ) . '</a>',
	);
	return array_merge( $action_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'base_block_plugin_action_links' );
/**
 * Show row meta on the plugin screen.
 *
 * @param    mixed $links Plugin Row Meta
 * @param    mixed $file  Plugin Base file
 *
 * @return    array
 *
 * @since  4.0
 */
function base_block_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'base-block.php' ) !== false ) {
		$new_links = array(
			'<a href="' . esc_url( 'https://github.com/pbrocks/base-block' ) . '" title="' . esc_attr( __( 'View Documentation', 'base-block' ) ) . '">' . __( 'Docs', 'base-block' ) . '</a>',
			'<a href="' . esc_url( 'https://github.com/pbrocks/base-block' ) . '" title="' . esc_attr( __( 'Visit Customer Support Forum', 'base-block' ) ) . '">' . __( 'Support', 'base-block' ) . '</a>',
		);
		$links     = array_merge( $links, $new_links );
	}
	return $links;
}

add_filter( 'plugin_row_meta', 'base_block_plugin_row_meta', 10, 2 );
/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function create_block_base_block_block_init() {
	  $dir = __DIR__;

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "base-block/initial" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'create-block-base-block-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_set_script_translations( 'create-block-base-block-block-editor', 'base-block' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-base-block-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-base-block-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'base-block/initial',
		array(
			'editor_script' => 'create-block-base-block-block-editor',
			'editor_style'  => 'create-block-base-block-block-editor',
			'style'         => 'create-block-base-block-block',
		)
	);
}
add_action( 'init', 'create_block_base_block_block_init' );
