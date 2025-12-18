</main>
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-cats">
            <?php
            $exclude_id = 0;
            $uncat = get_category_by_slug('uncategorized');
            if ($uncat && isset($uncat->term_id)) { $exclude_id = (int)$uncat->term_id; }
            $cats = get_categories([
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => 1,
                'exclude' => $exclude_id,
            ]);
            foreach ($cats as $c) {
                echo '<a href="' . esc_url(get_category_link($c->term_id)) . '" class="footer-cat">' . esc_html($c->name) . '</a>';
            }
            ?>
        </div>
        <p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
