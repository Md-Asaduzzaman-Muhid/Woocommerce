<?php get_header(); ?>
	<div class="container py-30 py-md-80">
		<div class="row">
			<div class="col-md-8 col-sm-7">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<div class="page-header mb-20 text-center">
						<h1 class="page-title wow fadeInUp"><?php the_title(); ?></h1>
					</div>

                    <?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php endwhile; ?>

				<?php else : ?>

					<h2>Post Not Found</h2>

				<?php endif; ?>
			</div> <!-- /col  -->

		<?php get_sidebar(); ?>
	</div> <!-- /row  -->
</div> <!-- /container  -->

<?php get_footer(); ?>
