<?php
/*
	Plugin Name: D4 Facebook Feed
	Plugin URI: https://github.com/d4advancedmedia/
	GitHub Plugin URI: https://github.com/d4advancedmedia/D4-Facebook
	GitHub Branch: master
	Description: D4 Facebook Feed
<<<<<<< HEAD
	Version: 1.0.2
	Author: D4 Adv. Media
	License: GPL2
*/
$d4facebook_version = '1.0.2';
=======
	Version: 1.0.1
	Author: D4 Adv. Media
	License: GPL2
*/
$d4facebook_version = '1.1.0';
>>>>>>> origin/master

// Register and enqueue font-end plugin style sheets and scripts.
add_action( 'wp_enqueue_scripts', 'register_d4facebook_elements' );
function register_d4facebook_elements() {
	wp_register_style( 'd4facebook', plugins_url( 'css/d4facebook.css' , __FILE__ ), $d4facebook_version );
	wp_enqueue_style( 'd4facebook' );
	wp_register_script( 'd4facebook', plugins_url( 'js/d4facebook.js' , __FILE__ ), array( 'jquery' ), $d4facebook_version, true );
	wp_enqueue_script('d4facebook');	
}

// Register and enqueue back-end plugin style sheets and scripts.
add_action('admin_enqueue_scripts', 'd4facebook_admin_elements');
add_action('login_enqueue_scripts', 'd4facebook_admin_elements');	
function d4facebook_admin_elements() {
    wp_register_style('d4facebook-admin-theme', plugins_url('css/d4facebook-admin.css', __FILE__) );
    wp_enqueue_style('d4facebook-admin-theme' );
    wp_register_script( 'd4facebook-admin-script', plugins_url( 'js/d4facebook-admin.js' , __FILE__ ), array( 'jquery' ), $d4facebook_version, true );
	wp_enqueue_script('d4facebook-admin-script');
}

//Plugin includes
include ('config.php');
include ('lib/functions.php');
include ('lib/shortcodes.php');
#include ('lib/posttypes.php');
#include ('lib/roles.php');

?>