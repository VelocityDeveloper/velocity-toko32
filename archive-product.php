<?php

/**
 * The template for displaying archive product
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package velocity toko
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('justg_container_type', 'container');
?>

<div class="wrapper" id="archive-wrapper">

    <div class="p-0 <?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <main class="site-main" id="main">

                <?php

                if (have_posts()) {
                ?>
                    <header class="page-header block-primary">
                        <?php velocity_title(); ?>
                    </header><!-- .page-header -->

                <?php
                    echo '<div class="mb-3 text-end d-md-none">';
                    echo get_velocitytoko_part('public/templates/filter');
                    echo '</div>';

                    // Start the loop.
                    echo '<div class="row m-0">';
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: velocitytoko_product_loop.
                         *
                         * @hooked velocitytoko_content_product - 20
                         */
                        do_action('velocitytoko_product_loop');
                    }
                    echo '</div>';
                } else {
                    /**
                     * Hook: velocitytoko_product_loop_empty.
                     *
                     * @hooked velocitytoko_product_loop_empty - 20
                     */
                    do_action('velocitytoko_product_loop_empty');
                }
                ?>
                <!-- Display the pagination component. -->
                <?php velocitytoko_pagination(); ?>
            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
