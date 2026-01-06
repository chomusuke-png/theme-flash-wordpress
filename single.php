<?php get_header(); ?>

<?php
while (have_posts()):
    the_post();
    
    // Contenido modular
    get_template_part('template-parts/content', 'single');

endwhile;
?>

<?php
// --- POSTS RELACIONADOS (Mantenemos la lógica aquí por ahora o podemos crear content-related.php después) ---
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
                        <img src="https://placehold.co/300x180">
                    <?php endif; ?>

                    <h3><?php the_title(); ?></h3>
                </a>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif;

wp_reset_postdata(); ?>


<?php get_footer(); ?>