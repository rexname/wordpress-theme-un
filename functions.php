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

function un_search_order($q) {
    if ($q->is_main_query() && $q->is_search()) {
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';
        $q->set('post_type', 'post');
        $q->set('posts_per_page', 11);
        if ($sort === 'recent') {
            $q->set('orderby', 'date');
            $q->set('order', 'DESC');
        } elseif ($sort === 'relevant') {
            $q->set('orderby', 'relevance');
            $q->set('order', 'DESC');
        }
    }
}
add_action('pre_get_posts', 'un_search_order');

function un_category_page_size($q) {
    if ($q->is_main_query() && $q->is_category()) {
        $q->set('posts_per_page', 11);
    }
}
add_action('pre_get_posts', 'un_category_page_size');
