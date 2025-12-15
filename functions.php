<?php
if (!defined('ABSPATH')) exit;

function un_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height' => 150,
        'width' => 120,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_image_size('hero-card', 600, 340, true);
    add_image_size('category-hero', 960, 300, true);
    add_image_size('category-thumb', 460, 300, true);
    register_nav_menus([
        'primary' => __('Primary Menu', 'un'),
    ]);
}
add_action('after_setup_theme', 'un_setup');

function un_assets() {
    $ver = wp_get_theme()->get('Version');
    wp_enqueue_style('un-style', get_stylesheet_uri(), [], $ver);
}
add_action('wp_enqueue_scripts', 'un_assets');
