<?php get_header(); ?>
<main class="py-30 py-md-80 blog-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-7">
				<div class="page-header mb-20 text-center">
					<h1 class="page-title wow fadeInUp">Blog</h1>
				</div>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php wp_pagenavi(); ?>

				<?php else : ?>

					<h2>No post found!</h2>

				<?php endif; ?>
			</div> <!-- /col  -->

		<?php get_sidebar(); ?>
	</div> <!-- /row  -->
</div> <!-- /container  -->
</main>

<?php get_footer(); ?>
