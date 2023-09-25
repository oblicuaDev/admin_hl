<?php

/*
@package gamedugg
========================
ADMIN EQUEUE FUNCTIONS
========================
*/

function gamedugg_admin_scripts($hook)
{

    wp_register_style('gamedugg_admin', get_template_directory_uri() . '/css/gamedugg.admin.css', array(), '1.0.2', 'all');
    wp_enqueue_style('gamedugg_admin');

    wp_enqueue_media();

    wp_register_script('gamedugg_admin_script', get_template_directory_uri() . '/js/gamedugg.admin.js', array('jquery'), '1.0.2', true);
    wp_enqueue_script('gamedugg_admin_script');
}

add_action('admin_enqueue_scripts', 'gamedugg_admin_scripts');

/*

========================
FRONT-END EQUEUE FUNCTIONS
========================
*/

function gamedugg_load_scripts()
{

    wp_register_style('front_styles', get_template_directory_uri() . '/css/custom.css', array(), '1.0.2', 'all');
    wp_enqueue_style('front_styles');

    wp_register_script('front_script', get_template_directory_uri() . '/js/custom.js', array(), '1.0.2', true);
    wp_enqueue_script('front_script');
}



add_action('wp_enqueue_scripts', 'gamedugg_load_scripts');
