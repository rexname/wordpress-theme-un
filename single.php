<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="single-layout">
            <div class="single-content">
                <header class="post-header">
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
                    <figure class="post-image">
                        <?php the_post_thumbnail('large'); ?>
                    </figure>
                <?php endif; ?>
                <div class="entry">
                    <?php the_content(); ?>
                </div>
                <footer class="post-footer">
                    <nav class="post-nav">
                        <div class="prev"><?php previous_post_link('%link','← Previous'); ?></div>
                        <div class="next"><?php next_post_link('%link','Next →'); ?></div>
                    </nav>
                </footer>

                <?php
                $more_cat_id = (!empty($cats)) ? $cats[0]->term_id : 0;
                if ($more_cat_id) {
                    $moreq = new WP_Query([
                        'posts_per_page' => 4,
                        'ignore_sticky_posts' => true,
                        'post__not_in' => [get_the_ID()],
                        'category__in' => [$more_cat_id],
                    ]);
                    if ($moreq->have_posts()) : ?>
                        <section class="category-section category-inline" aria-label="More from category">
                            <div class="category-layout">
                                <div class="category-main" style="min-width:0">
                                    <div class="category-header">
                                        <h3>More from <?php echo esc_html($cats[0]->name); ?></h3>
                                    </div>
                                    <div class="category-grid">
                                        <div class="category-cards">
                                            <?php while ($moreq->have_posts()) : $moreq->the_post(); ?>
                                                <article class="category-card">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php if (has_post_thumbnail()) { the_post_thumbnail('category-thumb'); } else { echo '<img src="https://via.placeholder.com/460x300" alt="">'; } ?>
                                                    </a>
                                                    <div class="content">
                                                        <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                                                    </div>
                                                </article>
                                            <?php endwhile; wp_reset_postdata(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endif;
                }
                ?>
            </div>
            <aside class="single-aside">
                <div class="widget-box">
                    <h4>Read More</h4>
                    <ul class="widget-list">
                        <?php
                        $related = new WP_Query([
                            'posts_per_page' => 6,
                            'ignore_sticky_posts' => true,
                            'post__not_in' => [get_the_ID()],
                            'category__in' => !empty($cats) ? [ $cats[0]->term_id ] : [],
                        ]);
                        if ($related->have_posts()) : while ($related->have_posts()) : $related->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); else : ?>
                            <li>No related articles.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </aside>
        </section>
    </article>
<?php endwhile; else : ?>
    <div class="container"><p>Article not found.</p></div>
<?php endif; ?>

<?php get_footer(); ?>
