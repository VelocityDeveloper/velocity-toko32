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

// Desain Toko 32 selalu bersidebar kiri lewat justg_right_sidebar_check() di bawah; sidebar kiri
// tema induk dimatikan supaya pilihan "Sidebar Position: left" tidak mencetak sidebar dua kali.
if (!function_exists('justg_left_sidebar_check')) {
    function justg_left_sidebar_check()
    {
    }
}

/**
 * Halaman Katalog & Profil Saya VD Store (Pengaturan VD Store > Halaman, halaman ber-[wp_store_catalog]
 * / [wp_store_profile], atau template katalog tema) selalu tampil penuh tanpa sidebar.
 */
function velocity_toko32_halaman_penuh()
{
    if (!is_page()) {
        return false;
    }
    $s = (array) get_option('wp_store_settings', []);
    foreach (['page_catalog', 'page_profile'] as $kunci) {
        if (!empty($s[$kunci]) && is_page((int) $s[$kunci])) {
            return true;
        }
    }
    $isi = (string) get_post_field('post_content', get_queried_object_id());
    return has_shortcode($isi, 'wp_store_catalog') || has_shortcode($isi, 'wp_store_profile')
        || strpos((string) get_page_template_slug(), 'katalog') !== false;
}

if (!function_exists('justg_right_sidebar_check')) {
    function justg_right_sidebar_check()
    {
        if (is_singular('fl-builder-template') || velocity_toko32_halaman_penuh()) {
            return;
        }
        if (!is_active_sidebar('main-sidebar')) {
            return;
        }
        if (is_tax(array('store_product_cat', 'brand'))) {
            echo '<div class="left-sidebar widget-area pe-md-2 col-sm-12 col-md-3 order-md-1 order-4" id="left-sidebar" role="complementary">';
            echo '<aside class="mb-3 d-none d-md-block">';
            echo do_shortcode('[wp_store_filters]');
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
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . sprintf(__('Daily Archives: <span>%s</span>', 'justg'), get_the_date()) . '</h1>';
    } elseif (is_month()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . sprintf(__('Monthly Archives: <span>%s</span>', 'justg'), get_the_date('F Y')) . '</h1>';
    } elseif (is_year()) {
        return '<h1 class="h4 fw-bold text-uppercase velocity-postheader velocity-judul colortheme">' . sprintf(__('Yearly Archives: <span>%s</span>', 'justg'), get_the_date('Y')) . '</h1>';
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
