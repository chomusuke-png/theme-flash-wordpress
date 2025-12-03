<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="top-header">
        <div id="datetime"></div>

        <div class="social-icons">
            <?php
            $items = json_decode(get_theme_mod('halal_social_repeater'), true);

            if (!empty($items)):
                foreach ($items as $item):
                    $icon = esc_attr($item['icon']);
                    $url = esc_url($item['url']);
                    echo "<a href='$url' target='_blank' rel='noopener'><i class='$icon'></i></a>";
                endforeach;
            endif;
            ?>
        </div>

    </div>

    <header class="main-header" id="mainHeader">
        <div class="header-left">

            <?php
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }
            ?>

            <div class="title-box">
                <h1><?php bloginfo('name'); ?></h1>
                <p><?php bloginfo('description'); ?></p>
            </div>
        </div>

        <!-- Botón hamburguesa -->
        <div class="hamburger" id="hamburgerBtn">
            <i class="fa-solid fa-bars"></i>
        </div>

        <!-- NAV DESKTOP -->
        <nav class="navbar">
            <?php
            wp_nav_menu([
                "theme_location" => "main_menu",
                "container" => "",
                "menu_class" => "",
                "items_wrap" => '<ul>%3$s</ul>'
            ]);
            ?>
        </nav>
    </header>

    <!-- MENÚ MÓVIL -->
    <nav class="mobile-menu" id="mobileMenu">
        <?php
        wp_nav_menu([
            "theme_location" => "main_menu",
            "container" => "",
            "menu_class" => "",
            "items_wrap" => '<ul>%3$s</ul>'
        ]);
        ?>
    </nav>
