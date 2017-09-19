<?php
/*
Plugin Name: Viddyoze Bootcamp
Description: Viddyoze Bootcamp plugin for retrieving quotes from Symfony app
Author: Andrea Restello
Version: 0.1
*/

 add_action('admin_menu', 'bootcamp_setup_menu');
 
function bootcamp_setup_menu(){
        add_menu_page( 'Test Plugin Page', 'Bootcamp CRUD', 'manage_options', 'test-plugin', 'test_init' );
}
 
function test_init(){
        echo '<div id="root"></div>';
}
 
?>