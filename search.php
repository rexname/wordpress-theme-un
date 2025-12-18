<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php
$displayed_ids = [];
?>

<?php if (have_posts()) : ?>
<section class="category-section">
    <div class="category-layout">
        <div class="category-main" style="min-width:0">
            <div class="category-header">
                <h3>Search results</h3>
            </div>
            <div class="category-grid">
                <?php the_post(); $displayed_ids[] = get_the_ID(); $cats = get_the_category(); $tag_name = (!empty($cats) ? $cats[0]->name : 'Result'); ?>
                <article class="category-hero">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) { the_post_thumbnail('category-hero'); } else { echo '<img src="https://via.placeholder.com/960x300" alt="">'; } ?>
                    </a>
                    <div class="content">
                        <div class="tag"><?php echo esc_html($tag_name); ?></div>
                        <div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                        <?php $hex = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 28); ?>
                        <div class="excerpt"><?php echo esc_html($hex); ?></div>
                    </div>
                </article>

                <div class="category-cards">
                    <?php $cards_count = 0; while (have_posts()) : the_post(); $displayed_ids[] = get_the_ID(); $cards_count++; ?>
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
                    <?php endif; ?>
                </div>
            </div>
            <nav class="pagination" aria-label="Pagination">
                <?php
                the_posts_pagination([
                    'mid_size' => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                    'screen_reader_text' => 'Posts navigation',
                ]);
                ?>
            </nav>
        </div>
        <aside class="category-aside">
            <div class="category-widgets">
            <div class="search-box widget-box">
                <h4>Search</h4>
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <input type="search" name="s" placeholder="Type keywords" value="<?php echo esc_attr(get_search_query()); ?>">
                    <select name="sort">
                        <option value="recent" <?php selected($_GET['sort'] ?? '', 'recent'); ?>>Most recent entries</option>
                        <option value="relevant" <?php selected($_GET['sort'] ?? '', 'relevant'); ?>>Most relevant entries</option>
                    </select>
                    <div class="actions">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
            </div>
            </div>
        </aside>
    </div>
</section>
<?php else : ?>
    <section class="category-section">
        <div class="category-layout">
            <div class="category-main" style="min-width:0"><h3>No results found</h3></div>
            <aside class="category-aside">
                <div class="search-box">
                    <h4>Search</h4>
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                        <input type="search" name="s" placeholder="Type keywords" value="<?php echo esc_attr(get_search_query()); ?>">
                        <select name="sort">
                            <option value="recent" <?php selected($_GET['sort'] ?? '', 'recent'); ?>>Most recent entries</option>
                            <option value="relevant" <?php selected($_GET['sort'] ?? '', 'relevant'); ?>>Most relevant entries</option>
                        </select>
                        <div class="actions">
                            <button type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </aside>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>
