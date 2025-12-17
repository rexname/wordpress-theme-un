<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php
$cat = get_queried_object();
$cat_id = is_category() ? $cat->term_id : 0;
$cat_name = is_category() ? $cat->name : 'Kategori';
$q = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 5,
    'ignore_sticky_posts' => true,
]);
?>

<?php if ($q->have_posts()) : ?>
<section class="category-section">
    <div class="category-layout">
        <div class="category-main" style="min-width:0">
            <div class="category-header">
                <h3><?php echo esc_html($cat_name); ?></h3>
                <a href="<?php echo esc_url(get_category_link($cat_id)); ?>">Lihat semua</a>
            </div>
            <div class="category-grid">
                <?php $q->the_post(); ?>
                <article class="category-hero">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) { the_post_thumbnail('category-hero'); } else { echo '<img src="https://via.placeholder.com/960x300" alt="">'; } ?>
                    </a>
                    <div class="content">
                        <div class="tag"><?php echo esc_html($cat_name); ?></div>
                        <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                        <?php $hex = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 28); ?>
                        <div class="excerpt"><?php echo esc_html($hex); ?></div>
                    </div>
                </article>

                <div class="category-cards">
                    <?php while ($q->have_posts()) : $q->the_post(); ?>
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
        <?php
        $aside = new WP_Query([
            'cat' => $cat_id,
            'posts_per_page' => 6,
            'post__not_in' => wp_list_pluck($q->posts, 'ID'),
            'ignore_sticky_posts' => true,
        ]);
        ?>
        <aside class="category-aside">
            <h4><?php echo esc_html($cat_name); ?> Lainnya</h4>
            <ul>
                <?php if ($aside->have_posts()) : while ($aside->have_posts()) : $aside->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </ul>
        </aside>
    </div>
</section>
<?php else : ?>
    <p>Tidak ada artikel di kategori ini.</p>
<?php endif; ?>

<?php get_footer(); ?>

