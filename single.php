<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="post-header container">
            <h1><?php the_title(); ?></h1>
            <div class="post-meta">
                <span class="meta-author">By <?php the_author(); ?></span>
                <span class="meta-sep">·</span>
                <span class="meta-date"><?php echo esc_html(get_the_date()); ?></span>
                <?php $cats = get_the_category(); if (!empty($cats)) : ?>
                    <span class="meta-sep">·</span>
                    <span class="meta-category"><a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"><?php echo esc_html($cats[0]->name); ?></a></span>
                <?php endif; ?>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="container" style="max-width: var(--hero-max);">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="entry container">
            <?php the_content(); ?>
        </div>

        <footer class="container post-footer">
            <nav class="post-nav">
                <div class="prev"><?php previous_post_link('%link','← Previous'); ?></div>
                <div class="next"><?php next_post_link('%link','Next →'); ?></div>
            </nav>
        </footer>
    </article>
<?php endwhile; else : ?>
    <div class="container"><p>Article not found.</p></div>
<?php endif; ?>

<?php get_footer(); ?>
