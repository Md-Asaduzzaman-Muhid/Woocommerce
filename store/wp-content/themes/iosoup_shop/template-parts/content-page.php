<article id="page-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>

    <div class="entry clearfix wow fadeInUp">
    	<!-- <?php if ( has_post_thumbnail() ) {  ?>
            <div class="entry-thumbnail">
                <?php  the_post_thumbnail('full' , array('class' => 'img-responsive center-block')); ?>
            </div>
        <?php  } ?> -->

        <?php the_content(); ?>

    </div>

    <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

</article>
