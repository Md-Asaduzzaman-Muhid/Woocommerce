<?php get_header(); ?>

<section class="page-section py-30 py-md-80">
	<div class="container">
		<div class="row">
			<div class="col-md-12">				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<div class="page-header text-center">
					<h1 class="page-title wow fadeInUp"><?php the_title(); ?></h1>
				</div>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
