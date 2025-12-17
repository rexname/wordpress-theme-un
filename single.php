<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('container'); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="entry">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('large'); } ?>
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; else : ?>
    <div class="container"><p>Artikel tidak ditemukan.</p></div>
<?php endif; ?>

<?php get_footer(); ?>

