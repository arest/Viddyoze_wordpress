<?php
/*
Plugin Name: Viddyoze Bootcamp
Description: Viddyoze Bootcamp plugin for retrieving quotes from Symfony app
Author: Andrea Restello
Version: 0.2
*/

define( 'BOOTCAMP_PLUGIN_VERSION', '0.2' );

add_action('admin_menu', 'bootcamp_setup_menu');
add_option('bootcamp_baseurl_option', 'http://viddyoze.dev/app_dev.php/api');
add_option('bootcamp_apikey_option', '123456789abcdefghilmnopqrstuvz');


function bootcamp_setup_menu(){
        add_menu_page( 'Bootstrap Plugin Page', 'Bootcamp CRUD', 'manage_options', 'bootstrap-plugin', 'bootcamp_init' );
}
 


function bootcamp_init(){
        echo '<div id="root"></div>';
        echo '<script type="text/javascript">var baseUrl = "'.get_option('bootcamp_baseurl_option').'";</script>';
        echo '<script type="text/javascript">var apiKey = "'.get_option('bootcamp_apikey_option').'";</script>';

}

function bootcamp_admin_enqueue($hook) {
	if (is_admin()) {
    	wp_enqueue_script('bootcamp_bundle_js', plugin_dir_url(__FILE__) . '/admin/build/static/js/bootcamp_bundle.js', null, BOOTCAMP_PLUGIN_VERSION, true);
    	wp_enqueue_style( 'bootcamp_bundle_css', plugin_dir_url(__FILE__) . '/admin/build/static/css/bootcamp_bundle.css', null, BOOTCAMP_PLUGIN_VERSION, true );
    }
}

function bootcamp_front_enqueue($hook) {
	if (!is_admin()) {
		wp_enqueue_script('bootcamp_app_random_js', plugin_dir_url(__FILE__) . '/front/js/bootcamp_random.js', null, BOOTCAMP_PLUGIN_VERSION, true);
	}
	if (!is_admin() && is_page('bootcamp-author-details')) {
		wp_enqueue_script('bootcamp_app_author_js', plugin_dir_url(__FILE__) . '/front/js/bootcamp_author.js', null, BOOTCAMP_PLUGIN_VERSION, true);

	}
}

function add_base_url() {
    $baseUrl = get_option( 'bootcamp_baseurl_option' );
    echo '<script> var bootcampBaseUrl="'.$baseUrl.'";</script>';
}

function bootcamp_front_init() {

	$labels = array(
		'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Book', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Books', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'bootcamp', $args );
}

function bootcamp_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    bootcamp_front_init();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'bootcamp_rewrite_flush' );

add_action('admin_enqueue_scripts', 'bootcamp_admin_enqueue');
add_action('wp_enqueue_scripts', 'bootcamp_front_enqueue');
add_action('wp_footer', 'add_base_url');
add_action( 'init', 'bootcamp_front_init' );

