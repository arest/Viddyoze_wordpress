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


class BootcampQuotes
{
	protected $baseUrl;

	public function __construct() {
		$this->baseUrl = get_option( 'bootcamp_baseurl_option' );
		$this->apiKey = get_option( 'bootcamp_apikey_option' );
	}

	public function renderAuthorQuotes() {
		$authorId = get_query_var('author_id');
		$url = $this->baseUrl.'/author/'.$authorId.'/quotes';
		$request = wp_remote_get( $url, [
			'timeout' => 120,
			'blocking' => false,
			'headers'     => [
				'Accept' => 'application/json'
			],
		]);

		if ( is_array( $request ) ) {
			$json = json_decode( $request['body'], true);
  			return $json;
		}
	}

	public function renderRandomQuote() {

		$url = $this->baseUrl.'/quote/random?apikey='.$this->apiKey;
		$response = wp_remote_get( $url );

		if ( is_array( $response ) ) {
  			$body = $response['body'];
  			$json = json_decode( $body, true);


  			if (isset($json['content'])) {
  				echo $json['content'];
  			}
		}
	}
}

function bootcamp_render_author() {
	$renderer = new BootcampQuotes();
	return $renderer->renderAuthorQuotes();
}

function bootcamp_render_random_quote() {
	$renderer = new BootcampQuotes();
	return $renderer->renderRandomQuote();
}

function add_query_vars_filter( $vars ){
  $vars[] = "author_id";
  return $vars;
}

add_filter( 'query_vars', 'add_query_vars_filter' );

add_action('admin_enqueue_scripts', 'bootcamp_admin_enqueue');
add_action('wp_enqueue_scripts', 'bootcamp_front_enqueue');
add_action('wp_footer', 'add_base_url');
add_action( 'bootcamp_render_author', 'bootcamp_render_author' );
add_action( 'bootcamp_render_random_quote', 'bootcamp_render_random_quote' );


