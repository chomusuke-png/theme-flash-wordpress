<?php

function halalflash_styles()
{

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


    // style.css (obligatorio para WordPress, info del tema)
    wp_enqueue_style('main', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'halalflash_styles');


// ===============================
//   SCRIPTS DEL TEMA
// ===============================
function halalflash_scripts()
{
    wp_enqueue_script(
        "halalflash-js",
        get_theme_file_uri("/script.js"),
        array("jquery"),
        "1.0",
        true
    );
}
add_action("wp_enqueue_scripts", "halalflash_scripts");


// ===============================
//   Custom logo y menús
// ===============================
add_theme_support("custom-logo");
add_theme_support("menus");
add_theme_support('title-tag');


register_nav_menus([
    "main_menu" => "Menú Principal"
]);

function halal_customize_register($wp_customize)
{
    if (class_exists('WP_Customize_Control')) {

        class Halal_Repeater_Control extends WP_Customize_Control
        {
            public $type = 'halal_repeater';

            public function enqueue()
            {
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('halal-repeater', get_template_directory_uri() . '/repeater.js', ['jquery', 'jquery-ui-sortable'], false, true);
                wp_enqueue_style('halal-repeater-css', get_template_directory_uri() . '/repeater.css');
            }

            public function render_content()
            {

                $value = $this->value();
                $value = $value ? json_decode($value, true) : [];

                $icons = [
                    'fab fa-facebook-f' => 'Facebook',
                    'fab fa-instagram' => 'Instagram',
                    'fab fa-whatsapp' => 'WhatsApp',
                    'fab fa-tiktok' => 'TikTok',
                    'fas fa-envelope' => 'Email',
                    'fas fa-location-dot' => 'Ubicación',
                    'fab fa-x-twitter' => 'Twitter (X)',
                    'fab fa-youtube' => 'YouTube',
                ];
                ?>

                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                </label>

                <div class="halal-repeater-wrapper">
                    <button type="button" class="button add-social">Añadir red social</button>

                    <ul class="halal-repeater-list">
                        <?php if (!empty($value)): ?>
                            <?php foreach ($value as $item): ?>
                                <li class="halal-repeater-item">

                                    <input type="text" class="title-field" placeholder="Título del sitio"
                                        value="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>">

                                    <select class="icon-select">
                                        <option value="">Elegir icono…</option>
                                        <?php foreach ($icons as $class => $label): ?>
                                            <option value="<?php echo esc_attr($class); ?>" <?php selected($item['icon'], $class); ?>>
                                                <?php echo esc_html($label); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <input type="text" class="icon-field" placeholder="o escribe icono (fa-solid fa-user)"
                                        value="<?php echo esc_attr($item['icon']); ?>">

                                    <input type="text" class="url-field" placeholder="URL" value="<?php echo esc_attr($item['url']); ?>">

                                    <span class="drag-handle">☰</span>
                                    <button type="button" class="button remove-social">Eliminar</button>
                                </li>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <input type="hidden" class="halal-repeater-hidden" <?php $this->link(); ?>
                        value="<?php echo esc_attr($this->value()); ?>">

                </div>

                <?php
            }
        }
    }

    // Registrar la sección
    $wp_customize->add_section('halal_social_section', [
        'title' => __('Redes Sociales', 'halal-theme'),
        'priority' => 30,
    ]);

    // Setting
    $wp_customize->add_setting('halal_social_repeater', [
        'default' => '',
        'sanitize_callback' => function ($input) {
            return wp_kses_post($input);
        }
    ]);

    // Control
    $wp_customize->add_control(new Halal_Repeater_Control($wp_customize, 'halal_social_repeater', [
        'label' => __('Redes sociales dinámicas', 'halal-theme'),
        'section' => 'halal_social_section',
    ]));

    // =========================
    //  SECCIÓN: Sitios Relacionados
    // =========================
    $wp_customize->add_section('halal_related_sites_section', [
        'title' => __('Sitios Relacionados', 'halal-theme'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('halal_related_sites_repeater', [
        'default' => '',
        'sanitize_callback' => function ($input) {
            return wp_kses_post($input);
        }
    ]);

    $wp_customize->add_control(new Halal_Repeater_Control($wp_customize, 'halal_related_sites_repeater', [
        'label' => __('Sitios relacionados del footer', 'halal-theme'),
        'section' => 'halal_related_sites_section',
    ]));



}
add_action('customize_register', 'halal_customize_register');

function halalflash_register_sidebars()
{
    register_sidebar([
        'name' => 'Sidebar Principal',
        'id' => 'main_sidebar',
        'description' => 'Widgets que aparecerán en el sidebar.',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);

    register_sidebar([
        'name' => 'Footer 1',
        'id' => 'footer_1',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);
}
add_action('widgets_init', 'halalflash_register_sidebars');

// Agregar metabox para posts destacados
function halalflash_destacado_metabox()
{
    add_meta_box(
        'destacado_metabox',
        'Post Destacado',
        'halalflash_destacado_callback',
        'post',
        'side'
    );
}
add_action('add_meta_boxes', 'halalflash_destacado_metabox');

function halalflash_destacado_callback($post)
{
    wp_nonce_field('halalflash_destacado', 'destacado_nonce');
    $value = get_post_meta($post->ID, '_is_destacado', true);
    ?>
    <label>
        <input type="checkbox" name="is_destacado" value="1" <?php checked($value, '1'); ?>>
        Marcar como destacado
    </label>
    <?php
}

function halalflash_save_destacado($post_id)
{
    if (!isset($_POST['destacado_nonce']) || !wp_verify_nonce($_POST['destacado_nonce'], 'halalflash_destacado')) {
        return;
    }

    if (isset($_POST['is_destacado'])) {
        update_post_meta($post_id, '_is_destacado', '1');
    } else {
        delete_post_meta($post_id, '_is_destacado');
    }
}
add_action('save_post', 'halalflash_save_destacado');

// ================================
// CUSTOMIZER: Selección de categoría
// ================================
function halalflash_customizer($wp_customize)
{

    // Sección para la Grid
    $wp_customize->add_section('grid_noticias_section', [
        'title' => __('Grid de Noticias', 'halalflash'),
        'priority' => 30,
    ]);

    // Ajuste para guardar la categoría
    $wp_customize->add_setting('grid_categoria', [
        'default' => '',
        'sanitize_callback' => 'absint',
    ]);

    // Dropdown con las categorías existentes
    $wp_customize->add_control(new WP_Customize_Category_Control(
        $wp_customize,
        'grid_categoria_control',
        [
            'label' => __('Categoría a mostrar', 'halalflash'),
            'section' => 'grid_noticias_section',
            'settings' => 'grid_categoria',
        ]
    ));
}
add_action('customize_register', 'halalflash_customizer');


// =======================================
// CONTROL PERSONALIZADO PARA MOSTRAR CATEGORÍAS
// =======================================
if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Category_Control extends WP_Customize_Control
    {
        public $type = 'dropdown-categories';

        public function render_content()
        {
            $dropdown = wp_dropdown_categories([
                'show_option_none' => __('— Selecciona una categoría —'),
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

// ===============================
// OPCIÓN PARA MOSTRAR / OCULTAR LISTADO DE BLOG
// ===============================
function halalflash_blog_toggle($wp_customize)
{

    $wp_customize->add_section('halalflash_blog_section', array(
        'title' => __('Control del Blog', 'halalflash'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('halalflash_show_blog', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('halalflash_show_blog_control', array(
        'label' => __('Mostrar listado del blog', 'halalflash'),
        'section' => 'halalflash_blog_section',
        'settings' => 'halalflash_show_blog',
        'type' => 'checkbox',
    ));

    // ============================
    //   CANTIDAD DE POSTS EN INDEX
    // ============================
    $wp_customize->add_setting('halalflash_posts_per_page', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('halalflash_posts_per_page_control', array(
        'label' => __('Cantidad de artículos por página', 'halalflash'),
        'section' => 'halalflash_blog_section',
        'settings' => 'halalflash_posts_per_page',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 50,
            'step' => 1
        )
    ));

}
add_action('customize_register', 'halalflash_blog_toggle');

// Aplicar la cantidad personalizada de posts por página
function halalflash_modify_posts_per_page($query)
{

    // Solo modificar la query principal en el home/blog
    if (!is_admin() && $query->is_main_query() && (is_home() || is_front_page())) {

        $cantidad = get_theme_mod('halalflash_posts_per_page', 10);
        $query->set('posts_per_page', absint($cantidad));
    }
}
add_action('pre_get_posts', 'halalflash_modify_posts_per_page');
