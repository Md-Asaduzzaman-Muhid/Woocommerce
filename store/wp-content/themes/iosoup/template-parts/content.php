<article <?php post_class('entry-post-box wow fadeInUp') ?> id="post-<?php the_ID(); ?>" >

    <h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

    <div class="entry-meta">
        <span class="entry-date">
            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php the_time('jS F, Y'); ?>
        </span>

        <span class="entry-category">
            <i class="fa fa-tags" aria-hidden="true"></i> <?php the_category( ' ' ); ?>
        </span>

    </div>

    <div class="entry clearfix">
        <?php the_excerpt(); ?>
    </div>

    <div class="text-left">
        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary">Read more...</a>
    </div>

</article>
