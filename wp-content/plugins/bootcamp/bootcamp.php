<?php
/*
Plugin Name: Viddyoze Bootcamp
Description: Viddyoze Bootcamp plugin for retrieving quotes from Symfony app
Author: Andrea Restello
Version: 0.1
*/

 add_action('admin_menu', 'bootcamp_setup_menu');
 add_option('bootcamp_baseurl_option', 'http://viddyoze.dev/api');
 add_option('bootcamp_apikey_option', '1234567890');


function bootcamp_setup_menu(){
        add_menu_page( 'Test Plugin Page', 'Bootcamp CRUD', 'manage_options', 'test-plugin', 'test_init' );
}
 


function test_init(){
        echo '<div id="root"></div>';
        echo '<script type="text/javascript">var baseUrl = "'.get_option('bootcamp_baseurl_option').'";</script>';
        echo '<script type="text/javascript">var apiKey = "'.get_option('bootcamp_apikey_option').'";</script>';

}

function my_enqueue($hook) {
    wp_enqueue_script('react_js', plugin_dir_url(__FILE__) . '/admin/build/static/js/main.fc2137be.js');
    wp_enqueue_style( 'react_css', plugin_dir_url(__FILE__) . '/admin/build/static/css/main.65027555.css' );
}

add_action('admin_enqueue_scripts', 'my_enqueue');


?>

<script type="text/javascript"></script>