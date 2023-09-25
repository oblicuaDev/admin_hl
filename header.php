<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header>
        HEADER
    </header>
    <?php
    if (current_user_can('administrator')) {
    ?>
        <nav>
            <?php
            wp_nav_menu(
                array(
                    'menu' => 'primary',
                    'container' => '',
                    'location' => 'primary',
                    'items_wrap' => '<ul id="" class="">%3$s</ul>'
                )
            );
            ?>
        </nav>
    <?php
    }
    ?>