<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php
$hero_bg = '';
$hero_text = '';
$hero_footer = '';
$sticky = get_option('sticky_posts');
if (!empty($sticky)) {
    $hq = new WP_Query([
        'post__in' => $sticky,
        'posts_per_page' => 1,
        'ignore_sticky_posts' => true,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
} else {
    $hq = new WP_Query([
        'posts_per_page' => 1,
        'ignore_sticky_posts' => true,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
}
if ($hq->have_posts()) {
    $hq->the_post();
    $hero_bg = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: '';
    $hero_text = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 30);
    $cat = get_the_category();
    $author = get_the_author();
    if (!empty($cat)) {
        $hero_footer = $author . ' — ' . $cat[0]->name;
    } else {
        $hero_footer = $author;
    }
    wp_reset_postdata();
}
if (!$hero_text) {
    $tagline = get_bloginfo('description');
    $hero_text = $tagline ? $tagline : 'Welcome to your WordPress site.';
}
?>

<section class="main-hero">
    <div class="hero-quote" style="<?php echo $hero_bg ? 'background-image:url(' . esc_url($hero_bg) . ');' : ''; ?>">
        <blockquote>
            <p>
                <?php echo esc_html($hero_text); ?>
            </p>
            <footer>
                <strong><?php bloginfo('name'); ?></strong><br>
                <?php echo esc_html($hero_footer ?: parse_url(home_url('/'), PHP_URL_HOST)); ?>
            </footer>
        </blockquote>
        <?php
        if (function_exists('the_custom_logo') && has_custom_logo()) {
            the_custom_logo();
        } else {
            echo '<img src="https://via.placeholder.com/120x150" alt="">';
        }
        ?>
    </div>

    <div class="hero-stories">
        <?php
        $grid_ids = [];
        $stories = new WP_Query([
            'posts_per_page' => 4,
            'ignore_sticky_posts' => true,
        ]);
        if ($stories->have_posts()) :
            while ($stories->have_posts()) : $stories->the_post();
                $grid_ids[] = get_the_ID(); ?>
                <article class="story" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('hero-card'); ?></a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>"><img src="https://via.placeholder.com/600x340" alt=""></a>
                    <?php endif; ?>
                    <div class="story-content">
                        <?php $cat = get_the_category(); ?>
                        <div class="title-row">
                            <?php if (!empty($cat)) { echo '<span class="tag">' . esc_html($cat[0]->name) . '</span>'; } ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        </div>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata();
        else : ?>
            <article class="story">
                <img src="https://via.placeholder.com/600x340" alt="">
                <div class="story-content">
                    <span class="tag">Info</span>
                    <h3>No recent articles yet</h3>
                </div>
            </article>
        <?php endif; ?>
    </div>

    <aside class="hero-headlines">
        <h4>Headlines</h4>
        <ul>
            <?php
            $heads_args = [
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC',
                'ignore_sticky_posts' => true,
            ];
            if (!empty($grid_ids)) {
                $heads_args['post__not_in'] = $grid_ids;
            }
            $heads = new WP_Query($heads_args);
            if ($heads->have_posts()) :
                while ($heads->have_posts()) : $heads->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; wp_reset_postdata();
            else : ?>
                <li>No headlines yet.</li>
            <?php endif; ?>
        </ul>
    </aside>
</section>

<section class="category-section">
    <?php
    $cat = get_categories([
        'orderby' => 'count',
        'order' => 'DESC',
        'number' => 1,
    ]);
    $cat_id = !empty($cat) ? $cat[0]->term_id : 0;
    $cat_name = !empty($cat) ? $cat[0]->name : '';
    $q = new WP_Query([
        'cat' => $cat_id,
        'posts_per_page' => 5,
        'ignore_sticky_posts' => true,
    ]);
    ?>
    <?php if ($q->have_posts()) : ?>
        <div class="category-layout">
        <div class="category-main" style="min-width:0">
            <div class="category-header">
                <h3>Featured</h3>
            </div>
            <div class="category-grid">
            <?php $q->the_post(); ?>
            <article class="category-hero">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) { the_post_thumbnail('category-hero'); } else { echo '<img src="https://via.placeholder.com/960x300" alt="">'; } ?>
                </a>
                <div class="content">
                    <div class="tag"><?php echo esc_html($cat_name ?: 'Category'); ?></div>
                    <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                    <?php $hero_excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 28); ?>
                    <div class="excerpt"><?php echo esc_html($hero_excerpt); ?></div>
                </div>
            </article>

            <div class="category-cards">
                <?php $cards_count = 0; while ($q->have_posts()) : $q->the_post(); $cards_count++; ?>
                    <article class="category-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) { the_post_thumbnail('category-thumb'); } else { echo '<img src="https://via.placeholder.com/460x300" alt="">'; } ?>
                        </a>
                        <div class="content">
                            <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                        </div>
                    </article>
                <?php endwhile; if ($cards_count % 2 !== 0) : ?>
                    <article class="category-card placeholder"><img src="https://via.placeholder.com/460x300" alt=""><div class="content"><div class="title">&nbsp;</div></div></article>
                <?php endif; wp_reset_postdata(); ?>
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
            <div class="category-widgets">
                <div class="widget-box">
                    <h4>Latest in <?php echo esc_html($cat_name ?: 'Category'); ?></h4>
                    <ul class="widget-list">
                        <?php if ($aside->have_posts()) : while ($aside->have_posts()) : $aside->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </li>
                        <?php endwhile; wp_reset_postdata(); else : ?>
                            <li>No articles yet.</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php
                $interviews = new WP_Query([
                    'posts_per_page' => 4,
                    'ignore_sticky_posts' => true,
                    'post__not_in' => wp_list_pluck($q->posts, 'ID'),
                    'category_name' => 'interview',
                ]);
                if (!$interviews->have_posts()) {
                    $interviews = new WP_Query([
                        'posts_per_page' => 4,
                        'ignore_sticky_posts' => true,
                        'post__not_in' => wp_list_pluck($q->posts, 'ID'),
                    ]);
                }
                ?>
                <div class="widget-box">
                    <h4>Highlights</h4>
                    <ul class="widget-list thumbnails">
                        <?php if ($interviews->have_posts()) : while ($interviews->have_posts()) : $interviews->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>" class="thumb">
                                    <?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail'); } else { echo '<img src="https://via.placeholder.com/64x64" alt="">'; } ?>
                                </a>
                                <a href="<?php the_permalink(); ?>" class="title-small"><?php the_title(); ?></a>
                            </li>
                        <?php endwhile; wp_reset_postdata(); else : ?>
                            <li>No highlights yet.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>
        </div>
    <?php endif; ?>
</section>

<section class="category-section all-categories">
    <?php
    $all_cats = get_categories([
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);
    if (!empty($all_cats)) :
        foreach ($all_cats as $acat) :
            $cq = new WP_Query([
                'cat' => $acat->term_id,
                'posts_per_page' => 5,
                'ignore_sticky_posts' => true,
            ]);
            if ($cq->have_posts()) : ?>
            <div class="category-layout">
                <div class="category-main" style="min-width:0">
                    <div class="category-header">
                        <h3><a href="<?php echo esc_url(get_category_link($acat->term_id)); ?>"><?php echo esc_html($acat->name); ?></a></h3>
                        <a href="<?php echo esc_url(get_category_link($acat->term_id)); ?>">View all</a>
                    </div>
                    <div class="category-grid">
                        <?php $cq->the_post(); ?>
                        <article class="category-hero">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) { the_post_thumbnail('category-hero'); } else { echo '<img src="https://via.placeholder.com/960x300" alt="">'; } ?>
                            </a>
                            <div class="content">
                                <div class="tag"><?php echo esc_html($acat->name); ?></div>
                                <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                                <?php $hex = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 28); ?>
                                <div class="excerpt"><?php echo esc_html($hex); ?></div>
                            </div>
                        </article>
                        <div class="category-cards">
                            <?php $cards_count = 0; while ($cq->have_posts()) : $cq->the_post(); $cards_count++; ?>
                                <article class="category-card">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) { the_post_thumbnail('category-thumb'); } else { echo '<img src="https://via.placeholder.com/460x300" alt="">'; } ?>
                                    </a>
                                    <div class="content">
                                        <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                                    </div>
                                </article>
                            <?php endwhile; if ($cards_count % 2 !== 0) : ?>
                                <article class="category-card placeholder"><img src="https://via.placeholder.com/460x300" alt=""><div class="content"><div class="title">&nbsp;</div></div></article>
                            <?php endif; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
                <?php
                $aside = new WP_Query([
                    'cat' => $acat->term_id,
                    'posts_per_page' => 6,
                    'post__not_in' => wp_list_pluck($cq->posts, 'ID'),
                    'ignore_sticky_posts' => true,
                ]);
                ?>
                <aside class="category-aside">
                    <h4>More from <?php echo esc_html($acat->name); ?></h4>
                    <ul>
                        <?php if ($aside->have_posts()) : while ($aside->have_posts()) : $aside->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </ul>
                </aside>
            </div>
            <?php endif; 
        endforeach;
    else : ?>
        <div class="category-layout">
            <div class="category-main" style="min-width:0">
                <div class="category-header"><h3>Kategori belum tersedia</h3></div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
