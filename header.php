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
                    echo '<img src="https://via.placeholder.com/48" alt="">';
                }
                ?>
                <div class="un-text"><?php bloginfo('name'); ?></div>
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
