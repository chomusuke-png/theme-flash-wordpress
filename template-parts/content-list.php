<article class="news-item">
    <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>">
        <?php else: ?>
            <img src="https://placehold.co/400x250?text=<?php echo urlencode(get_the_title()); ?>"
                 alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
    </a>

    <div class="news-content">

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

        <h2 class="news-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="news-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </div>

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

    </div>
</article>