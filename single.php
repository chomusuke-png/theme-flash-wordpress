<?php get_header(); ?>

<article class="single-article">

    <?php if (has_post_thumbnail()): ?>
        <div class="single-featured">
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
        </div>
    <?php endif; ?>

    <div class="single-content-container">

        <h1 class="single-title"><?php the_title(); ?></h1>

        <div class="single-meta">
            <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
            <span><i class="fas fa-calendar"></i> <?php echo get_the_date(); ?></span>
            <span><i class="fas fa-folder"></i> <?php the_category(', '); ?></span>
        </div>

        <div class="single-content">
            <?php the_content(); ?>
        </div>

        <div class="single-tags">
            <?php the_tags('<span class="tag-item">', '</span><span class="tag-item">', '</span>'); ?>
        </div>


        <div class="single-navigation">
            <div class="prev-post"><?php previous_post_link('%link', '← Artículo Anterior'); ?></div>
            <div class="next-post"><?php next_post_link('%link', 'Siguiente Artículo →'); ?></div>
        </div>

    </div>

</article>



<?php
// --- POSTS RELACIONADOS ---
$cats = wp_get_post_categories(get_the_ID());

$related = new WP_Query([
    'category__in' => $cats,
    'post__not_in' => [get_the_ID()],
    'posts_per_page' => 3
]);

if ($related->have_posts()):
    ?>
    <section class="related-posts">
        <h2>Te puede interesar</h2>

        <div class="related-grid">
            <?php while ($related->have_posts()):
                $related->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="related-item">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('large'); ?>">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x180">
                    <?php endif; ?>

                    <h3><?php the_title(); ?></h3>
                </a>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif;

wp_reset_postdata(); ?>


<?php get_footer(); ?>