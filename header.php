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
        <form id="un-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
            <div class="search-bar">
                <input type="search" name="s" placeholder="Looking for something?">
                <button type="submit" class="search-btn" aria-label="Search"></button>
            </div>
            <input type="hidden" name="sort" value="recent">
            <div class="results" id="un-search-results"></div>
        </form>
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
  var form=document.getElementById('un-search-form');
  var input=form?form.querySelector('input[name=\"s\"]'):null;
  var results=document.getElementById('un-search-results');
  function render(items){
    if(!results){return}
    var html='';
    if(items&&items.length){
      var first=items[0];
      html+='<section class=\"category-section\"><div class=\"category-layout\"><div class=\"category-main\" style=\"min-width:0\"><div class=\"category-grid\">';
      var img=(first._embedded&&first._embedded['wp:featuredmedia']&&first._embedded['wp:featuredmedia'][0]&&first._embedded['wp:featuredmedia'][0].media_details&&first._embedded['wp:featuredmedia'][0].media_details.sizes&&first._embedded['wp:featuredmedia'][0].media_details.sizes.large&&first._embedded['wp:featuredmedia'][0].media_details.sizes.large.source_url)?first._embedded['wp:featuredmedia'][0].media_details.sizes.large.source_url:'https://via.placeholder.com/960x300';
      html+='<article class=\"category-hero\"><a href=\"'+first.link+'\"><img src=\"'+img+'\" alt=\"\"></a><div class=\"content\"><div class=\"title\"><a href=\"'+first.link+'\">'+first.title.rendered+'</a></div></div></article>';
      html+='<div class=\"category-cards\">';
      for(var i=1;i<items.length;i++){var it=items[i];var im=(it._embedded&&it._embedded['wp:featuredmedia']&&it._embedded['wp:featuredmedia'][0]&&it._embedded['wp:featuredmedia'][0].media_details&&it._embedded['wp:featuredmedia'][0].media_details.sizes&&it._embedded['wp:featuredmedia'][0].media_details.sizes.medium&&it._embedded['wp:featuredmedia'][0].media_details.sizes.medium.source_url)?it._embedded['wp:featuredmedia'][0].media_details.sizes.medium.source_url:'https://via.placeholder.com/460x300';html+='<article class=\"category-card\"><a href=\"'+it.link+'\"><img src=\"'+im+'\" alt=\"\"></a><div class=\"content\"><div class=\"title\"><a href=\"'+it.link+'\">'+it.title.rendered+'</a></div></div></article>'}
      if(((items.length-1)%2)!==0){html+='<article class=\"category-card placeholder\"><img src=\"https://via.placeholder.com/460x300\" alt=\"\"><div class=\"content\"><div class=\"title\">&nbsp;</div></div></article>'}
      html+='</div></div></div></div></section>';
    } else {
      html='<section class=\"category-section\"><div class=\"category-layout\"><div class=\"category-main\" style=\"min-width:0\"><h3>No results found</h3></div></div></section>';
    }
    results.innerHTML=html;
  }
  function search(q){
    if(!q||q.length<2){render([]);return}
    fetch('<?php echo esc_url(home_url('/wp-json/wp/v2/posts')); ?>?search='+encodeURIComponent(q)+'&per_page=7&_embed').then(function(r){return r.json()}).then(render).catch(function(){render([])});
  }
  if(btn&&header){
    btn.addEventListener('click',function(){
      header.classList.toggle('is-search-open');
      if(header.classList.contains('is-search-open')&&input){input.focus();}
    });
  }
  if(form&&input){
    form.addEventListener('submit',function(e){e.preventDefault();search(input.value)});
    var t;input.addEventListener('input',function(){clearTimeout(t);var v=this.value;t=setTimeout(function(){search(v)},300)});
  }
});
</script>
<main>
