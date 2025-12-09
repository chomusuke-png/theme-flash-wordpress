<?php

function theme_enqueue_assets() {
    $css = get_template_directory_uri() . '/assets/css/';

    wp_enqueue_style('reset', $css . 'reset.css');
    wp_enqueue_style('globals', $css . 'globals.css');
    wp_enqueue_style('header', $css . 'header.css');
    wp_enqueue_style('navbar', $css . 'navbar.css');
    wp_enqueue_style('sticky', $css . 'sticky.css');
    wp_enqueue_style('grid', $css . 'grid.css');
    wp_enqueue_style('posts-list', $css . 'posts-list.css');
    wp_enqueue_style('pagination', $css . 'pagination.css');
    wp_enqueue_style('button-top', $css . 'button-top.css');
    wp_enqueue_style('footer', $css . 'footer.css');
    wp_enqueue_style('single', $css . 'single.css');
    wp_enqueue_style('related', $css . 'related.css');
    wp_enqueue_style('sidebar', $css . 'sidebar.css');
    wp_enqueue_style('responsive', $css . 'responsive.css');
    wp_enqueue_style('page', $css . 'page.css');

    wp_enqueue_style('main', get_stylesheet_uri());

    // Scripts
    wp_enqueue_script(
        "theme-js",
        get_theme_file_uri("/script.js"),
        array("jquery"),
        "1.0",
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

// ===============================
//   Custom logo y menús
// ===============================
add_theme_support("custom-logo");
add_theme_support("menus");
add_theme_support('title-tag');

register_nav_menus([
    "main_menu" => "Menú Principal"
]);

function theme_customize_register($wp_customize) {
    if (class_exists('WP_Customize_Control')) {

        class Custom_Repeater_Control extends WP_Customize_Control {
            public $type = 'custom_repeater';
            // Variable para almacenar los iconos permitidos
            public $choices = [];

            public function enqueue() {
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('custom-repeater-js', get_template_directory_uri() . '/repeater.js', ['jquery', 'jquery-ui-sortable'], false, true);
                wp_enqueue_style('custom-repeater-css', get_template_directory_uri() . '/repeater.css');
            }

            public function render_content() {
                $value = $this->value();
                $value = $value ? json_decode($value, true) : [];
                
                // Codificamos los iconos en JSON para pasarlos al JS
                $icons_json = htmlspecialchars(json_encode($this->choices), ENT_QUOTES, 'UTF-8');
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                </label>
                
                <div class="custom-repeater-wrapper" data-icons="<?php echo $icons_json; ?>">
                    <button type="button" class="button add-item">Añadir elemento</button>

                    <ul class="custom-repeater-list">
                        <?php if (!empty($value)): ?>
                            <?php foreach ($value as $item): ?>
                                <li class="custom-repeater-item">
                                    <input type="text" class="title-field" placeholder="Título" value="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>">
                                    
                                    <select class="icon-select">
                                        <option value="">Elegir icono…</option>
                                        <?php foreach ($this->choices as $class => $label): ?>
                                            <option value="<?php echo esc_attr($class); ?>" <?php selected(isset($item['icon']) ? $item['icon'] : '', $class); ?>>
                                                <?php echo esc_html($label); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <input type="text" class="icon-field" placeholder="Icono manual (ej: fa-solid fa-user)" value="<?php echo esc_attr(isset($item['icon']) ? $item['icon'] : ''); ?>">
                                    <input type="text" class="url-field" placeholder="URL" value="<?php echo esc_attr(isset($item['url']) ? $item['url'] : ''); ?>">

                                    <span class="drag-handle">☰</span>
                                    <button type="button" class="button remove-item">Eliminar</button>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <input type="hidden" class="custom-repeater-hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>">
                </div>
                <?php
            }
        }
    }

    // --- LISTAS DE ICONOS DEFINIDAS AQUÍ ---
    
    // 1. Iconos para Redes Sociales (TikTok, Insta, etc.)
    $social_icons = [
        'fab fa-facebook-f'   => 'Facebook',
        'fab fa-instagram'    => 'Instagram',
        'fab fa-tiktok'       => 'TikTok',
        'fab fa-whatsapp'     => 'WhatsApp',
        'fab fa-x-twitter'    => 'X (Twitter)',
        'fab fa-youtube'      => 'YouTube',
        'fab fa-linkedin-in'  => 'LinkedIn',
        'fas fa-envelope'     => 'Email (Correo)',
        'fas fa-phone'        => 'Teléfono',
    ];

    // 2. Iconos para Sitios Relacionados (Genéricos)
    $related_icons = [
        'fa-solid fa-newspaper' => 'Noticia / Diario',
        'fa-solid fa-building'  => 'Empresa / Edificio',
        'fa-solid fa-globe'     => 'Sitio Web / Globo',
        'fa-solid fa-link'      => 'Enlace',
        'fa-solid fa-check'     => 'Verificado',
    ];


    // --- SECCIÓN: REDES SOCIALES ---
    $wp_customize->add_section('social_links_section', [
        'title' => __('Redes Sociales', 'theme-domain'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('social_links_data', [
        'default' => '',
        'sanitize_callback' => function ($input) { return wp_kses_post($input); }
    ]);

    // Pasamos $social_icons a 'choices'
    $wp_customize->add_control(new Custom_Repeater_Control($wp_customize, 'social_links_data', [
        'label' => __('Redes sociales dinámicas', 'theme-domain'),
        'section' => 'social_links_section',
        'choices' => $social_icons, 
    ]));


    // --- SECCIÓN: SITIOS RELACIONADOS ---
    $wp_customize->add_section('related_sites_section', [
        'title' => __('Sitios Relacionados', 'theme-domain'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('related_sites_data', [
        'default' => '',
        'sanitize_callback' => function ($input) { return wp_kses_post($input); }
    ]);

    // Pasamos $related_icons a 'choices'
    $wp_customize->add_control(new Custom_Repeater_Control($wp_customize, 'related_sites_data', [
        'label' => __('Enlaces del footer', 'theme-domain'),
        'section' => 'related_sites_section',
        'choices' => $related_icons,
    ]));


    // --- SECCIÓN: GRID DE NOTICIAS ---
    $wp_customize->add_section('grid_news_section', [
        'title' => __('Grid de Noticias', 'theme-domain'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('grid_category_id', [
        'default' => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control(new WP_Customize_Category_Control(
        $wp_customize,
        'grid_category_control',
        [
            'label' => __('Categoría a mostrar', 'theme-domain'),
            'section' => 'grid_news_section',
            'settings' => 'grid_category_id',
        ]
    ));

    // --- SECCIÓN: BLOG ---
    $wp_customize->add_section('blog_settings_section', array(
        'title' => __('Control del Blog', 'theme-domain'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('show_blog_list', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('show_blog_list_control', array(
        'label' => __('Mostrar listado del blog', 'theme-domain'),
        'section' => 'blog_settings_section',
        'settings' => 'show_blog_list',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('home_posts_per_page', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('home_posts_per_page_control', array(
        'label' => __('Artículos por página', 'theme-domain'),
        'section' => 'blog_settings_section',
        'settings' => 'home_posts_per_page',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1)
    ));

}
add_action('customize_register', 'theme_customize_register');


// 4. REGISTRO DE SIDEBARS
// -----------------------------------------------------------------
function theme_register_sidebars() {
    register_sidebar([
        'name' => 'Sidebar Principal',
        'id' => 'main_sidebar',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);

    register_sidebar([
        'name'          => 'Barra Superior (Header)',
        'id'            => 'top_header_widget',
        'description'   => 'Widget al centro de la barra roja superior.',
        'before_widget' => '<div id="%1$s" class="top-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="screen-reader-text">',
        'after_title'   => '</span>',
    ]);

    register_sidebar([
        'name' => 'Footer 1',
        'id' => 'footer_1',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);

    register_sidebar([
        'name' => 'Footer 2',
        'id' => 'footer_2',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);

    register_sidebar([
        'name' => 'Footer 3',
        'id' => 'footer_3',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);
}
add_action('widgets_init', 'theme_register_sidebars');


// 5. METABOX Y OTROS
function theme_featured_post_metabox() {
    add_meta_box('featured_metabox', 'Post Destacado', 'theme_featured_post_callback', 'post', 'side');
}
add_action('add_meta_boxes', 'theme_featured_post_metabox');

function theme_featured_post_callback($post) {
    wp_nonce_field('theme_featured_action', 'featured_nonce');
    $value = get_post_meta($post->ID, '_is_featured', true);
    ?>
    <label>
        <input type="checkbox" name="is_featured" value="1" <?php checked($value, '1'); ?>>
        Marcar como destacado
    </label>
    <?php
}

function theme_save_featured_post($post_id) {
    if (!isset($_POST['featured_nonce']) || !wp_verify_nonce($_POST['featured_nonce'], 'theme_featured_action')) return;
    if (isset($_POST['is_featured'])) {
        update_post_meta($post_id, '_is_featured', '1');
    } else {
        delete_post_meta($post_id, '_is_featured');
    }
}
add_action('save_post', 'theme_save_featured_post');

function theme_modify_home_query($query) {
    if (!is_admin() && $query->is_main_query() && (is_home() || is_front_page())) {
        $cantidad = get_theme_mod('home_posts_per_page', 10);
        $query->set('posts_per_page', absint($cantidad));
    }
}
add_action('pre_get_posts', 'theme_modify_home_query');

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Category_Control extends WP_Customize_Control {
        public $type = 'dropdown-categories';
        public function render_content() {
            $dropdown = wp_dropdown_categories([
                'show_option_none' => __('— Selecciona —', 'theme-domain'),
                'orderby' => 'name',
                'hide_empty' => false,
                'name' => '_customize-dropdown-categories-' . $this->id,
                'selected' => $this->value(),
                'echo' => false
            ]);
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown);
            echo '<label><span class="customize-control-title">' . esc_html($this->label) . '</span></label>';
            echo $dropdown;
        }
    }
}