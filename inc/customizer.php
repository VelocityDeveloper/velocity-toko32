<?php
/**
 * Pengaturan Toko 32 di Customizer bawaan WordPress (tanpa Kirki).
 *
 * Nama theme mod sama dengan versi Kirki (velocity_judul_news, velocity_news)
 * supaya nilai yang sudah tersimpan tetap terbaca. Slider Kirki (repeater
 * slider_repeat) diganti slot gambar slider_image_1..N; data slider_repeat lama
 * tetap dipakai selama slot kosong. Latar website memakai pengaturan tema induk
 * (Customizer > Background), latar Kirki lama (background_themewebsite) tetap dicetak.
 *
 * @package justg
 */

defined('ABSPATH') || exit;

const VELOCITY_TOKO32_SLIDER_SLOT = 5;

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_panel('panel_toko32', [
        'priority' => 10,
        'title'    => __('Velocity Toko 32', 'justg'),
    ]);

    // Warna
    $wp_customize->add_section('section_colorvelocity', [
        'panel'    => 'panel_toko32',
        'title'    => __('Warna', 'justg'),
        'priority' => 10,
    ]);
    $warna = [
        'velocity_toko32_warna_utama'    => [__('Warna Utama', 'justg'), __('Judul widget, tombol, harga, dan teks menu.', 'justg'), '#9e26c6'],
        'velocity_toko32_warna_sekunder' => [__('Warna Sekunder', 'justg'), __('Tombol saat disorot dan halaman aktif.', 'justg'), '#333333'],
    ];
    foreach ($warna as $id => [$label, $ket, $bawaan]) {
        $wp_customize->add_setting($id, [
            'default'           => $bawaan,
            'sanitize_callback' => 'sanitize_hex_color',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
            'label'       => $label,
            'description' => $ket,
            'section'     => 'section_colorvelocity',
        ]));
    }

    // Slider beranda
    $wp_customize->add_section('section_slider', [
        'panel'       => 'panel_toko32',
        'title'       => __('Slider Home', 'justg'),
        'description' => __('Gambar slider di halaman ber-template Home. Slot kosong dilewati.', 'justg'),
        'priority'    => 20,
    ]);
    for ($i = 1; $i <= VELOCITY_TOKO32_SLIDER_SLOT; $i++) {
        $wp_customize->add_setting("slider_image_$i", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "slider_image_$i", [
            'label'   => sprintf(__('Slider %d', 'justg'), $i),
            'section' => 'section_slider',
        ]));
    }

    // Gambar promosi di sidebar (widget [toko32_banner]).
    $wp_customize->add_section('velocity_banner_sidebar', [
        'panel'       => 'panel_toko32',
        'title'       => __('Banner Sidebar', 'justg'),
        'description' => __('Gambar promosi yang tampil lewat widget Teks berisi [toko32_banner]. Kosong = widget disembunyikan.', 'justg'),
        'priority'    => 25,
    ]);
    $wp_customize->add_setting('velocity_toko32_banner_sidebar', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'velocity_toko32_banner_sidebar', [
        'label'   => __('Gambar Banner', 'justg'),
        'section' => 'velocity_banner_sidebar',
    ]));
    $wp_customize->add_setting('velocity_toko32_banner_link', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('velocity_toko32_banner_link', [
        'label'   => __('Tautan Banner (opsional)', 'justg'),
        'section' => 'velocity_banner_sidebar',
        'type'    => 'url',
    ]);

    // Berita beranda
    $wp_customize->add_section('velocity_news_section', [
        'panel'    => 'panel_toko32',
        'title'    => __('Velocity Home News', 'justg'),
        'priority' => 30,
    ]);
    $wp_customize->add_setting('velocity_judul_news', [
        'default'           => 'Blog',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('velocity_judul_news', [
        'label'   => __('Judul', 'justg'),
        'section' => 'velocity_news_section',
        'type'    => 'text',
    ]);
    $wp_customize->add_setting('velocity_news', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('velocity_news', [
        'label'   => __('Pilih Kategori:', 'justg'),
        'section' => 'velocity_news_section',
        'type'    => 'select',
        'choices' => velocity_categories(),
    ]);
});

/**
 * URL gambar slider beranda: slot Customizer, atau data slider Kirki lama.
 */
function velocity_toko32_slider()
{
    $gambar = [];
    for ($i = 1; $i <= VELOCITY_TOKO32_SLIDER_SLOT; $i++) {
        $url = get_theme_mod("slider_image_$i", '');
        if ($url) {
            $gambar[] = $url;
        }
    }
    if (!$gambar) {
        foreach ((array) get_theme_mod('slider_repeat', []) as $baris) {
            $url = is_array($baris) ? ($baris['imgslider'] ?? '') : '';
            // Kirki bisa menyimpan id lampiran, bukan URL.
            if (is_numeric($url)) {
                $url = wp_get_attachment_url((int) $url);
            }
            if ($url) {
                $gambar[] = $url;
            }
        }
    }
    return $gambar;
}

/**
 * CSS dari pengaturan di atas. Dicetak di akhir <head> seperti Kirki dulu, supaya
 * menang atas CSS Bootstrap tema induk.
 */
add_action('wp_head', function () {
    $utama = sanitize_hex_color(get_theme_mod('velocity_toko32_warna_utama', '#9e26c6')) ?: '#9e26c6';
    $sekunder = sanitize_hex_color(get_theme_mod('velocity_toko32_warna_sekunder', '#333333')) ?: '#333333';
    $css = ':root{--velocitytoko-color-main:' . $utama . ';--velocitytoko-color-secondary:' . $sekunder . ';}'
        . '.bg-colortheme,.page-item.active .page-link{background-color:' . $utama . ';border-color:' . $utama . ';}'
        . '.bg-colortheme:hover{background-color:' . $sekunder . ';border-color:' . $sekunder . ';}'
        . '#primary-menu>li>a:hover,#primary-menu>li.current-menu-item>a,#primary-menu>li.current-menu-ancestor>a{color:' . $utama . ';}';

    $latar = get_theme_mod('background_themewebsite');
    if (is_array($latar)) {
        $aturan = [];
        foreach (['background-color', 'background-image', 'background-repeat', 'background-position', 'background-size', 'background-attachment'] as $prop) {
            $nilai = trim((string) ($latar[$prop] ?? ''));
            if ($nilai === '') {
                continue;
            }
            $aturan[] = $prop . ':' . ($prop === 'background-image' ? 'url(' . esc_url($nilai) . ')' : esc_attr($nilai));
        }
        if ($aturan) {
            $css .= 'body{' . implode(';', $aturan) . ';}';
        }
    }
    echo '<style id="velocity-toko32-customizer">' . wp_strip_all_tags($css) . '</style>' . "\n";
}, 100);
