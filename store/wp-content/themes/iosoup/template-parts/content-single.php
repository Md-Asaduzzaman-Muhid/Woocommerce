<article id="page-<?php the_ID(); ?>" <?php post_class('page-content single-content'); ?>>

    <div class="entry clearfix wow fadeInUp">

        <?php the_content(); ?>

        <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

    </div>

    <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

</article>
