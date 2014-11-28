<?php

/*
Plugin Name: Adapter Gravity Add-On
Plugin URI: www.ryankienstra.com/adapter-gravity-add-on
Description: Add-on for Gravity Forms, with options for inline display, placeholders, and showing at the end of every post. To use, click "Forms" in the left menu of your admin screen. Scroll over one of your forms, and click "Form Settings." Scroll down to "Form Layout." You'll see a new option for "Label placement": "In placeholder." You'll also see options to "Display at the bottom of every single-post page" and "Display form horizontally." 

Version: 1.0.0
Author: Ryan Kienstra
Author URI: www.ryankienstra.com
License: GPL2
*/

define( 'AGA_PLUGIN_SLUG' , 'adapter-gravity-add-on' ) ; 
define( 'AGA_PLUGIN_VERSION' , '1.0.0' ) ;

add_action( 'plugins_loaded' , 'load_aga_textdomain' ) ;
function load_aga_textdomain() { 
	load_plugin_textdomain( 'adapter-gravity-add-on' , false , basename( dirname( __FILE__ ) ) . '/languages' ) ;
}

add_action( 'plugins_loaded' , 'aga_get_included_files' ) ;
function aga_get_included_files() {
	$included_files = array(
		'class-aga-form' , 'class-aga-setting' , 'aga-gravity-settings' , 'aga-controller' 
	) ;
	foreach( $included_files as $file ) {
		include_once( plugin_dir_path( __FILE__ ) . "includes/{$file}.php" ) ; 
	}
}

add_action( 'gform_enqueue_scripts' , 'aga_maybe_enqueue_gravity_scripts' ) ;
function aga_maybe_enqueue_gravity_scripts() {
	$do_enqueue = apply_filters( 'aga_do_enqueue_css' , true ) ;
	if ( $do_enqueue ) { 
		wp_enqueue_style( AGA_PLUGIN_VERSION . '-gravity-style' , plugins_url( '/css/aga-gravity.css' , __FILE__ ) , array() , AGA_PLUGIN_VERSION ) ;
	}
}