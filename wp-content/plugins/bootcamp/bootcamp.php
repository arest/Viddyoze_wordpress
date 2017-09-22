<?php
/*
Plugin Name: Viddyoze Bootcamp
Description: Viddyoze Bootcamp plugin for retrieving quotes from Symfony app
Author: Andrea Restello
Version: 0.6
*/

define( 'BOOTCAMP_PLUGIN_VERSION', '0.6' );
define( 'BOOTCAMP_PLUGIN_URI', 'bootcamp-plugin' );

add_action('admin_menu', 'bootcamp_setup_admin_menu');
add_option('bootcamp_baseurl_option', 'http://viddyoze.dev/app_dev.php/');
add_option('bootcamp_apikey_option', '123456789abcdefghilmnopqrstuvz');
add_option('bootcamp_client_id_option', '5_5w9zn9tia8coocg00osos0ksokc0808cg04wog8k040w08ck8k');


function bootcamp_setup_admin_menu(){
        add_menu_page( 'Bootstrap Plugin Page', 'Bootcamp CRUD', 'manage_options', BOOTCAMP_PLUGIN_URI, 'bootcamp_admin_init' );
}
 

function bootcamp_admin_init(){

		update_option( 'bootcamp_plugin_url', admin_url('admin.php').'?page='.BOOTCAMP_PLUGIN_URI );
		$pluginUrl = get_option( 'bootcamp_plugin_url' );

		$authorizationUrl = get_option('bootcamp_baseurl_option').'oauth/v2/auth';
		$clientId = get_option('bootcamp_client_id_option');
		update_option('bootcamp_api_auth_url', $authorizationUrl.'?client_id='.$clientId.'&redirect_uri='.urlencode($pluginUrl).'&response_type=token');

        echo '<div id="root"></div>';
        echo '<script type="text/javascript">var baseUrl = "'.get_option('bootcamp_baseurl_option').'api";</script>';
        echo '<script type="text/javascript">var accessToken = "'.get_option('bootcamp_access_token_option').'";</script>';
        echo '<script type="text/javascript">var redirectOnAuthError = "'.$pluginUrl.'&access_token_request=1";</script>';


}

function bootcamp_admin_enqueue($hook) {
	if (is_admin() && $hook === 'toplevel_page_'.BOOTCAMP_PLUGIN_URI) {

		//Let's redirect user to auth request page
		if ( isset($_GET['access_token_request']) ) {
			update_option( 'bootcamp_access_token_option', '' ); // reset old invalid token
			wp_redirect( get_option('bootcamp_api_auth_url') );
			exit;
		}

		// Receiving a new access token from API
		if ( isset($_GET['access_token']) ) {
			$access_token = $_GET['access_token'];
			update_option( 'bootcamp_access_token_option', $access_token );
		}

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
  $vars[] = 'author_id';
  $vars[] = 'access_token';
  return $vars;
}

add_filter( 'query_vars', 'add_query_vars_filter' );

add_action('wp_enqueue_scripts', 'bootcamp_front_enqueue');
add_action('admin_enqueue_scripts', 'bootcamp_admin_enqueue');
add_action('wp_footer', 'add_base_url');
add_action( 'bootcamp_render_author', 'bootcamp_render_author' );
add_action( 'bootcamp_render_random_quote', 'bootcamp_render_random_quote' );


