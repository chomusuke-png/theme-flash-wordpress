<?php get_header(); ?>

<?php if ( is_home() && !is_paged() ) : ?>

<!-- NOTICIAS DESTACADAS (GRID) -->
<section class="news-grid">
    <?php
    $categoria_id = get_theme_mod('grid_categoria');

    $args = [
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    // Si el usuario eligió una categoría desde el customizer
    if (!empty($categoria_id)) {
        $args['cat'] = $categoria_id;
    }

    $destacados = new WP_Query($args);
    $pos = 0;

    if ($destacados->have_posts()):
        while ($destacados->have_posts()):
            $destacados->the_post();

            $pos++;

            if     ($pos == 1) $area = 'big';
            elseif ($pos == 2) $area = 'left1';
            elseif ($pos == 3) $area = 'left2';
            elseif ($pos == 4) $area = 'right1';
            elseif ($pos == 5) $area = 'right2';
            ?>

            <a href="<?php the_permalink(); ?>" class="news-item <?php echo $area; ?>">
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                <?php endif; ?>

                <div class="overlay">
                    <h2><?php the_title(); ?></h2>
                    <span class="date"><?php echo get_the_date(); ?></span>
                </div>
            </a>

            <?php
        endwhile;
    endif;

    wp_reset_postdata();
    ?>
</section>

<?php endif; ?>


<!-- CONTENEDOR CON SIDEBAR -->
<div class="sidebar-container">
    <div class="main-content">

        <?php if (get_theme_mod('halalflash_show_blog', true)): ?>

            <!-- LISTADO DE TODAS LAS NOTICIAS -->
            <section class="news-list">
                <?php
                if (have_posts()):
                    while (have_posts()):
                        the_post();
                        ?>
                        
                        <article class="news-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/400x250/d40000/ffffff?text=<?php echo urlencode(get_the_title()); ?>"
                                        alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                            </a>

                            <div class="news-content">

                                <!-- CATEGORÍAS -->
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)):
                                    ?>
                                    <div class="category">
                                        <?php foreach ($categories as $cat): ?>
                                            <span class="post-category"><?php echo esc_html($cat->name); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- TÍTULO -->
                                <h2 class="news-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <!-- EXTRACTO -->
                                <div class="news-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>

                                <!-- META -->
                                <div class="meta">
                                    <span class="author">
                                        <i class="fas fa-user"></i>
                                        <?php the_author(); ?>
                                    </span>
                                    <span class="date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo get_the_date('d M Y'); ?>
                                    </span>
                                </div>

                                <!-- ETIQUETAS -->
                                <?php
                                $tags = get_the_tags();
                                if (!empty($tags)):
                                    ?>
                                    <div class="tags">
                                        <?php foreach ($tags as $tag): ?>
                                            <span><?php echo esc_html($tag->name); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </article>

                        <?php
                    endwhile;
                else:
                    ?>
                    <p>Las noticias disponibles están ocultas en este momento.</p>
                    <?php
                endif;
                ?>
            </section>

            <!-- PAGINACIÓN -->
            <div class="pagination">
                <?php
                echo paginate_links([
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                    'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>',
                ]);
                ?>
            </div>

        <?php else: ?>

            <p>No hay noticias disponibles en este momento.</p>

        <?php endif; ?>

    </div>

    <!-- SIDEBAR -->
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
