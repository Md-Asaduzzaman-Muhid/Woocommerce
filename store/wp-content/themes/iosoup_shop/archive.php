<?php get_header(); ?>

<section class="archive-wrapper py-30 py-md-80">
	<div class="container">
		<div class="row">
	        <div class="col-md-8 col-sm-7">
		<?php if (have_posts()) : ?>

				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<div class="page-header mb-20 text-center">
			<?php /* If this is a category archive */ if (is_category()) { ?>
				<h1 class="page-title">Archive for the <span>- <?php single_cat_title(); ?></span> </h1>

			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h1 class="page-title">Posts Tagged <span>- <?php single_tag_title(); ?></span></h1>

			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h1 class="page-title">Archive for <span>- <?php the_time('F jS, Y'); ?></span></h1>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h1 class="page-title">Archive for <span>- <?php the_time('F, Y'); ?></span></h1>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h1 class="page-title">Archive for <span>- <?php the_time('Y'); ?></span></h1>

			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h1 class="page-title">Author Archive</h1>

			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h1 class="page-title">Blog Archives</h1>

			<?php } ?>
			</div>

			<?php //include (TEMPLATEPATH . '/inc/nav.php' ); ?>

			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php wp_pagenavi(); ?>

			<?php else : ?>

				<h2>Nothing found</h2>

			<?php endif; ?>
		</div>
		<!-- End of content_left Div -->
		<?php get_sidebar(); ?>
		</div> <!-- /row  -->
	</div> <!-- /container  -->
</section>

<?php get_footer(); ?>
