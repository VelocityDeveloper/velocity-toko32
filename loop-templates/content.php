<?php

/**
 * Post rendering content according to caller of get_template_part
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit; ?>

<article <?php post_class('row mx-0 border p-md-2 p-2 rounded mb-3'); ?> id="post-<?php the_ID(); ?>">
    <div class="col-md-3 p-md-2 p-0">
        <?php if (has_post_thumbnail()) { ?>
            <div class="ratio ratio-1x1">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail('full', array('class' => 'w-100 mb-3')); ?>
                </a>
            </div>
        <?php } ?>
    </div>

    <div class="col-md-9 p-md-2 py-2 px-0">
        <div class="judul-posts">
            <h6>
                <a class="colortheme text-uppercase" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo the_title(); ?></a>
            </h6>
        </div>
        <div class="entry-content">
            <?php $content = get_the_content();
            $trimmed_content = wp_trim_words($content, 30);
            echo $trimmed_content; ?>
        </div>
    </div>
</article>