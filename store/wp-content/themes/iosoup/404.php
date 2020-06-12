<?php get_header(); ?>

<div class="py-30 py-md-80">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header mb-20 text-center">
					<h1 class="page-title wow fadeInUp"><?php _e( 'Oops! That page can&rsquo;t be found', 'instalogic' ); ?></h1>
				</div>

				<div class="error-box">
		            <div class="error-text-left wow zoomIn">
		                <div class="error-number">404</div>
		                <span>PAGE NOT FOUND</span>
		            </div>

		            <div class="error-text-right text-center wow fadeInUp">
		                <div class="ops">Opps!</div>
		                <p>The link you followed is either outdated, inaccurate, or the server has been instructed not to let you have it.</p>
		                <a href="<?php echo home_url(); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-long-arrow-left mr-10" aria-hidden="true"></i> Go to Home</a>
		            </div>
		        </div>

			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
