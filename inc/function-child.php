<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function velocity_categories()
{
    $args = array(
        'orderby' => 'name',
        'hide_empty' => false,
    );
    $cats = array(
        '' => 'Show All'
    );
    $categories = get_categories($args);
    foreach ($categories as $category) {
        $cats[$category->term_id] = $category->name;
    }
    return $cats;
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

    // Load justg_child_enqueue_parent_style after theme setup
    add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

    if (class_exists('Kirki')) :

        Kirki::add_panel('panel_toko32', [
            'priority'    => 10,
            'title'       => esc_html__('Velocity Toko 32', 'justg'),
            'description' => esc_html__('', 'justg'),
        ]);

        // section title_tagline
        Kirki::add_section('title_tagline', [
            'panel'    => 'panel_toko32',
            'title'    => __('Site Identity', 'justg'),
            'priority' => 10,
        ]);

        ///Section Color
        Kirki::add_section('section_colorvelocity', [
            'panel'    => 'panel_toko32',
            'title'    => __('Background', 'justg'),
            'priority' => 10,
        ]);
        // Kirki::add_field('justg_config', [
        //     'type'        => 'color',
        //     'settings'    => 'color_theme',
        //     'label'       => __('Theme Color', 'justg'),
        //     'description' => esc_html__('', 'justg'),
        //     'section'     => 'section_colorvelocity',
        //     'default'     => '#ffb600',
        //     'transport'   => 'auto',
        //     'output'      => [
        //         [
        //             'element'   => ':root',
        //             'property'  => '--color-theme',
        //         ],
        //         [
        //             'element'   => ':root',
        //             'property'  => '--bs-primary',
        //         ],
        //         [
        //             'element'   => '.border-color-theme',
        //             'property'  => '--bs-border-color',
        //         ],
        //         [
        //             'element'   => '.bg-theme',
        //             'property'  => 'background-color',
        //             'suffix'    => ' !important',
        //         ],
        //     ],
        // ]);
        Kirki::add_field('justg_config', [
            'type'        => 'background',
            'settings'    => 'background_themewebsite',
            'label'       => __('Website Background', 'justg'),
            'description' => esc_html__('', 'justg'),
            'section'     => 'section_colorvelocity',
            'default'     => [
                'background-color'      => 'rgba(255,255,255)',
                'background-image'      => '',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'scroll',
            ],
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root[data-bs-theme=light] body',
                ],
                [
                    'element'   => 'body',
                ],
            ],
        ]);

        ///Section Color
        Kirki::add_section('section_slider', [
            'panel'    => 'panel_toko32',
            'title'    => __('Slider Home', 'justg'),
            'priority' => 10,
        ]);
        new \Kirki\Field\Repeater(
            [
                'settings' => 'slider_repeat',
                'label'    => esc_html__('Slider Home', 'justg'),
                'section'  => 'section_slider',
                'priority' => 10,
                'row_label'    => [
                    'type'  => 'field',
                    'value' => esc_html__('Slider', 'justg'),
                ],
                'button_label' => esc_html__('"Add Slider" ', 'justg'),
                'fields'   => [
                    'imgslider'   => [
                        'type'        => 'image',
                        'label'       => esc_html__('Slider', 'justg'),
                        'description' => esc_html__('', 'justg'),
                        'default'     => '',
                    ],
                ],
            ]
        );

        // section velocity_news_section
        Kirki::add_section('velocity_news_section', [
            'panel'    => 'panel_toko32',
            'title'    => __('Velocity Home News', 'justg'),
            'priority' => 10,
        ]);
        new \Kirki\Field\Text(
            [
                'settings' => 'velocity_judul_news',
                'label'    => esc_html__('Judul', 'justg'),
                'section'  => 'velocity_news_section',
                'default'  => esc_html__('', 'justg'),
                'priority' => 10,
            ]
        );
        new \Kirki\Field\Select(
            [
                'settings'    => 'velocity_news',
                'label'       => esc_html__('Pilih Kategori:', 'justg'),
                'section'     => 'velocity_news_section',
                'default'     => '',
                'placeholder' => esc_html__('Pilih Kategori', 'justg'),
                'choices'   => velocity_categories(),
            ]
        );

        // remove panel in customizer 
        Kirki::remove_panel('global_panel');
        Kirki::remove_panel('panel_header');
        Kirki::remove_panel('panel_footer');
        Kirki::remove_panel('panel_antispam');
    // Kirki::remove_control('custom_logo');

    endif;

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');
}

if (!function_exists('justg_header_open')) {
    function justg_header_open()
    {
        echo '<header id="wrapper-header">';
        echo '<div id="wrapper-navbar" class="wrapper-fluid wrapper-navbar position-relative pb-0 p-md-0 p-2" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
        echo '</div>';
        echo '</header>';
    }
}


///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-header.php');
}

add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
    do_action('justg_the_footer_content');
    require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}
add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content()
{
    echo '<div class="px-2">';
    echo '<div class="card rounded-0 border-light border-top-0 border-bottom-0 shadow px-3 py-2 container">';
}
add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content()
{
    echo '</div>';
    echo '</div>';
}

// excerpt more
add_filter('excerpt_more', 'velocity_custom_excerpt_more');
if (!function_exists('velocity_custom_excerpt_more')) {
    function velocity_custom_excerpt_more($more)
    {
        return '...';
    }
}

// excerpt length
add_filter('excerpt_length', 'velocity_excerpt_length');
function velocity_excerpt_length($length)
{
    return 20;
}

if (!function_exists('justg_right_sidebar_check')) {
    function justg_right_sidebar_check()
    {
        if (is_singular('fl-builder-template')) {
            return;
        }
        if (!is_active_sidebar('main-sidebar')) {
            return;
        }
        // if (is_singular('product')) {
        //     return;
        // }
        if (is_tax(array('merk', 'category-product'))) {
            echo '<div class="left-sidebar widget-area pe-md-2 col-sm-12 col-md-3 order-md-1 order-4" id="left-sidebar" role="complementary">';
            echo '<aside class="mb-3 d-none d-md-block">';
            echo get_velocitytoko_part('public/templates/filter');
            echo '</aside>';
            echo '</div>';
            return;
        }
        echo '<div class="left-sidebar velocity-widget widget-area px-md-0 col-sm-12 col-md-3 order-3 order-md-1" id="left-sidebar" role="complementary">';
        do_action('justg_before_main_sidebar');
        dynamic_sidebar('main-sidebar');
        do_action('justg_after_main_sidebar');
        echo '</div>';
    }
}

function velocity_title()
{
    if (is_single() || is_page()) {
        return the_title('<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">', '</h1>');
    } elseif (is_archive()) {
        return the_archive_title('<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">', '</h1>');
        return category_description();
    } elseif (is_tag()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . single_tag_title('', false) . '</h1>';
    } elseif (is_day()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . sprintf(__('Daily Archives: <span>%s</span>', THEME_NS), get_the_date()) . '</h1>';
    } elseif (is_month()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . sprintf(__('Monthly Archives: <span>%s</span>', THEME_NS), get_the_date('F Y')) . '</h1>';
    } elseif (is_year()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . sprintf(__('Yearly Archives: <span>%s</span>', THEME_NS), get_the_date('Y')) . '</h1>';
    } elseif (is_tax()) {
        $object = get_queried_object();
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . $object->name . '</h1>';
    } elseif (is_post_type_archive()) {
        $object = get_queried_object();
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . $object->label . '</h1>';
    } elseif (is_author()) {
        //the_post();
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . get_the_author() . '</h1>';
        //rewind_posts();
    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">Blog Archives</h1>';
    } elseif (is_search()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">Search Results for: "' . get_search_query() . '"</h1>';
    }
}

// archive product
remove_action('velocitytoko_product_loop', 'velocitytoko_content_product', 20);
add_action('velocitytoko_product_loop', 'velocitytoko_content_products', 30);
function velocitytoko_content_products($post)
{
    $title = wp_trim_words(get_the_title(), '5');
?>
    <article <?php post_class('col-md-4 col-6 p-2 mb-3'); ?> id="post-<?php the_ID(); ?>">
        <div class="card h-100 card-product">
            <?php echo do_shortcode("[thumbnail width='310' height='290' crop='false' upscale='true']");
            ?>
            <div class="p-3">
                <div class="my-2 text-center">
                    <a href="<?php echo get_the_permalink(); ?>"><?php echo $title; ?>...</a>
                </div>
                <div class="my-2 text-center colortheme fw-bold"><?php echo do_shortcode("[harga]"); ?></div>
                <div class="row">
                    <div class="col-md-6 col-8 p-1 text-start"><a href="<?php the_permalink(); ?>" class="p-1 btn btn-sm bg-colortheme text-white w-100">Detail</a></div>
                    <div class="col-md-6 col-4 p-1 text-end">
                        <span class="cart-arsip p-1 w-100 btn btn-sm bg-colortheme"><?php echo do_shortcode("[beli]"); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </article>
<?php
}

// single product
remove_action('velocitytoko_content_single_product', 'velocitytoko_content_single_product', 20);
add_action('velocitytoko_content_single_product', 'velocitytoko_content_single_products', 30);
function velocitytoko_content_single_products($post)
{
?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <div class="block-primary">
            <h1 class="fs-4 colortheme fw-bold mb-3">
                <?php echo do_shortcode("[vtoko-title link='true' class='colortheme ' node-cart='cartsingle']"); ?>
            </h1>
            <div class="row">
                <div class="col-md-6 col-xl-5">
                    <?php echo do_shortcode('[slider-produk width="350" height="350"]'); ?>
                </div>
                <div class="col-md">
                    <div class="mb-2">
                        <small>
                            Kategori: <?php echo velocitytoko_term_list('category-product', ",", get_the_ID()); ?>
                            | Dilihat: <?php echo do_shortcode('[view]'); ?>
                        </small>
                    </div>
                    <div class="single-harga mb-3">Harga: <?php echo do_shortcode('[harga node-cart="cartsingle"]'); ?></div>
                    <div class="mb-3"><?php echo do_shortcode('[detail-produk]'); ?></div>
                    <div class="mb-3"><?php echo do_shortcode('[beli modal="false" node-cart="cartsingle" text="true"]'); ?></div>
                    <div class="mb-3"><?php echo do_shortcode('[love text="true"]'); ?></div>
                    <div class="mb-3"><?php echo do_shortcode('[beli-lain]'); ?></div>
                    <div class="mb-3"><?php echo do_shortcode('[share]'); ?></div>
                </div>
            </div>
        </div>

        <div class="block-primary">
            <h3 class="title-single-part">Detail Produk</h3>
            <div><?php echo get_the_content(); ?></div>
        </div>

    </article><!-- #post-## -->
<?php
}
