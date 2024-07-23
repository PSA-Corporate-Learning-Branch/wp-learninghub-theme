<?php

wp_enqueue_style( 'wp-learning-hub-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

add_theme_support( 'post-thumbnails' );

add_filter( 'wp_enqueue_scripts', 'change_default_jquery', PHP_INT_MAX );

function change_default_jquery( ){
    wp_dequeue_script( 'jquery');
    wp_deregister_script( 'jquery');   
}