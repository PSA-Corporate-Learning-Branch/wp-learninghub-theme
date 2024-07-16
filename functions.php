<?php

wp_enqueue_style( 'wp-learning-hub-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

add_theme_support( 'post-thumbnails' );