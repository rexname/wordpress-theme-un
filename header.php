<?php if (!defined('ABSPATH')) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="header-inner">
        <div class="header-left">
            <div class="un-logo">
                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '"><img src="https://via.placeholder.com/48" alt=""></a>';
                }
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="un-text"><?php bloginfo('name'); ?></a>
            </div>
            <div class="divider"></div>
            <div class="site-title">
                <strong><?php echo esc_html(get_bloginfo('description')); ?></strong>
            </div>
        </div>

        <div class="header-right">
            <div class="search-icon"></div>
            <span>SEARCH</span>
        </div>
    </div>
    <div class="site-search">
        <?php get_search_form(); ?>
    </div>
</header>
<nav class="site-nav clearfix">
    <div class="nav-inner">
        <div class="navbar-nav">
        <?php
        $exclude_id = 0;
        $uncat = get_category_by_slug('uncategorized');
        if ($uncat && isset($uncat->term_id)) { $exclude_id = (int)$uncat->term_id; }
        $cats = get_categories([
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 1,
            'exclude' => $exclude_id,
            'parent' => 0,
        ]);
        foreach ($cats as $c) {
            echo '<a href="' . esc_url(get_category_link($c->term_id)) . '" class="nav-pill">' . esc_html($c->name) . '</a>';
        }
        ?>
        </div>
    </div>
</nav>
<script>
document.addEventListener('DOMContentLoaded',function(){
  var btn=document.querySelector('.header-right');
  var header=document.querySelector('.site-header');
  if(btn&&header){
    btn.addEventListener('click',function(){
      header.classList.toggle('is-search-open');
      var input=header.querySelector('.site-search input[type="search"]');
      if(header.classList.contains('is-search-open')&&input){input.focus();}
    });
  }
});
</script>
<main>
