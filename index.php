<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry">
                <?php the_excerpt(); ?>
            </div>
        </article>
    <?php endwhile; ?>

    <nav class="pagination">
        <?php
            the_posts_pagination([
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ]);
        ?>
    </nav>
<?php else : ?>
    <p>Tidak ada konten.</p>
<?php endif; ?>

<?php get_footer(); ?>

