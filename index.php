<?php
/**
 * Plugin Name: My Gutenberg Block
 * Plugin URI: https://aarontweeton.com
 * Description: My sad attempt at creating a WordPress Gutenberg block.
 * Version: 1.0.0.
 * Author: Aaron Tweeton
 * 
 * @package mygutenberg
 */

defined('ABSPATH') || exit;

/**
 * Load translations (if any) for the plugin from the /languages/ folder.
 * 
 * @link https://developer.wordpress.org/reference/functions/load_plugin_textdomain/
 */
add_action( 'init', 'mygutenberg_load_textdomain' );

function mygutenberg_load_textdomain() {
	load_plugin_textdomain( 'mygutenberg', false, basename( __DIR__ ) . '/languages' );
}

/** 
 * Add custom "Podkit" block category
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/filters/block-filters/#managing-block-categories
 */
add_filter( 'block_categories', 'mygutenberg_block_categories', 10, 2 );

function mygutenberg_block_categories( $categories, $post ) {
	if ( $post->post_type !== 'post' ) {
		return $categories;
	}
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'mygutenberg',
				'title' => __( 'My Gutenberg Blocks', 'mygutenberg' ),
				'icon'  => 'microphone',
			),
		)
	);
}

/**
 * Registers all block assets so that they can be enqueued through the Block Editor in
 * the corresponding context.
 *
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-registration/
 */
add_action( 'init', 'mygutenberg_register_block' );

function mygutenberg_register_block() {
    wp_register_script(
        'mygutenberg-editor-script',
        plugins_url( '/build/index.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . '/build/index.js' )
    );
 
    wp_register_style(
        'mygutenberg-editor-styles',
        plugins_url( '/build/editor.css', __FILE__ ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( __FILE__ ) . '/build/editor.css' )
    );
 
    wp_register_style(
        'mygutenberg-front-end-styles',
        plugins_url( '/build/style.css', __FILE__ ),
        array( ),
        filemtime( plugin_dir_path( __FILE__ ) . '/build/style.css' )
    );

	// Array of block created in this plugin.
	$blocks = [
		'mygutenberg/my-block'
	];
	
	// Loop through $blocks and register each block with the same script and styles.
	foreach( $blocks as $block ) {
		register_block_type( $block, array(
			'editor_script' => 'mygutenberg-editor-script',
			'editor_style' => 'mygutenberg-editor-styles',
			'style' => 'mygutenberg-front-end-styles',
		) );	  
	}

	if ( function_exists( 'wp_set_script_translations' ) ) {
	/**
	 * Adds internationalization support. 
	 * 
	 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/internationalization/
	 * @link https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
	 */
	wp_set_script_translations( 'mygutenberg-editor-script', 'mygutenberg', plugin_dir_path( __FILE__ ) . '/languages' );
	}

    
}