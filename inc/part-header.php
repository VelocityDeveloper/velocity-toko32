<div class="card rounded-0 border-light border-top-0 border-bottom-0 shadow container">
    <div class="vlogo-container">
        <div class="container position-relative h-100">
            <div class="bg-vlogo"></div>
        </div>
    </div>

    <div class="py-2 header-container">
        <div class="row text-center align-items-center py-0 m-0">
            <div class="col-md-4 p-0 text-md-start">
                <?php $sitelogo = velocitytheme_option('custom_logo'); ?>
                <div class="position-relative">
                    <?php if ($sitelogo) : ?>
                        <a href="<?php get_home_url(); ?>">
                            <img src="<?php echo wp_get_attachment_image_url($sitelogo, 'full'); ?>" alt="Site Logo" loading="lazy">
                        </a>
                    <?php endif;  ?>
                </div>
            </div>
            <div class="col-md-4 p-0"><?php echo do_shortcode('[vd-search]'); ?></div>
            <div class="col-md-4 profile-icons p-0">
                <div class="d-flex float-md-end">
                    <div class="p-2"><?php echo do_shortcode('[cart]'); ?></div>
                    <div class="p-2"><?php echo do_shortcode('[profile]'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-0 rounded-0 border-light border-top-0 border-bottom-0 shadow container">
    <nav id="main-navi" class="navbar navbar-expand-md d-block navbar-light  bg-theme p-0" aria-labelledby="main-nav-label">

        <div class="menu-header text-start d-md-none position-relative" data-bs-theme="dark">

            <button class="navbar-toggler p-0 m-2 rounded-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>

        </div>

        <div class="menu-styles bg-theme">
            <div class="pb-0">

                <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

                    <div class="offcanvas-header justify-content-end">
                        <button type="button" class="btn-close btn-close-dark text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div><!-- .offcancas-header -->

                    <!-- The WordPress Menu goes here -->
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'container_class' => 'offcanvas-body',
                            'container_id'    => '',
                            'menu_class'      => 'navbar-nav navbar-light justify-content-md-start justify-content-start flex-md-wrap flex-grow-1',
                            'fallback_cb'     => '',
                            'menu_id'         => 'primary-menu',
                            'depth'           => 4,
                            'walker'          => new justg_WP_Bootstrap_Navwalker(),
                        )
                    ); ?>

                </div><!-- .offcanvas -->
            </div>

    </nav><!-- .site-navigation -->
</div>