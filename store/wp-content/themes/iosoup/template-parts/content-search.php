<article id="post-<?php the_ID(); ?>" <?php post_class('entry-post-box content-search-item wow fadeInUp pb-30 mb-30'); ?>>

    <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

    <div class="entry clearfix">
        <?php the_excerpt(); ?>
    </div>

    <div class="text-left">
        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-secondary">Read more...</a>
    </div>

</article><!-- #post-## -->
