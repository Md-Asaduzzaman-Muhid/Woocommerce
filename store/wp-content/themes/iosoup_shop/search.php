<?php get_header(); ?>

<div class="search-wrapper py-30 py-md-80">

    <div class="container">

        <div class="row">
			<div class="col-md-12">

				<?php if ( have_posts() ) : ?>

					<div class="page-search-form pb-20">
						<?php echo get_search_form(); ?>
					</div>
					
					<div class="page-header mb-20 text-center">
						<h1 class="page-title wow fadeInUp"><?php printf( __( 'Search Results for: %s', 'instalogic' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</div>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							get_template_part( 'template-parts/content', 'search' );
						?>

					<?php endwhile; ?>

					<?php wp_pagenavi(); ?>

				<?php else : ?>

					<!-- <h2 class="page-title">No Post Found</h2> -->
					 <?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			</div><!-- col-md-8 -->

			<?php //get_sidebar(); ?>
		</div>

    </div> <!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
