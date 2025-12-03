<?php get_header(); ?>

<div class="page-container">

    <main class="page-content">

        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                ?>

                <article class="page-article">

                    <!-- TÍTULO -->
                    <h1 class="page-title"><?php the_title(); ?></h1>

                    <!-- IMAGEN DESTACADA -->
                    <?php if (has_post_thumbnail()): ?>
                        <div class="page-featured">
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php endif; ?>

                    <!-- CONTENIDO -->
                    <div class="page-text">
                        <?php the_content(); ?>
                    </div>

                </article>

            <?php
            endwhile;
        else:
            ?>
            <p class="page-empty">Esta página no tiene contenido visible por ahora... misterios del universo.</p>
        <?php endif; ?>

    </main>

    <!-- SIDEBAR OPCIONAL -->
    <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
