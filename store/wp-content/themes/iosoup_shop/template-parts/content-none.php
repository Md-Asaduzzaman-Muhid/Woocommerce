<article id="post-<?php the_ID(); ?>" <?php post_class('not-found'); ?>>

	<h2 class="page-title wow fadeInUp"><?php _e( 'Oops! Nothing Found', 'instalogic' ); ?></h2>

	<div class="page-content wow fadeInUp">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'instalogic' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'instalogic' ); ?></p>
			<div class="page-search-form wow fadeInUp pb-20">
				<?php echo get_search_form(); ?>
			</div>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'instalogic' ); ?></p>

			<div class="page-search-form wow fadeInUp pb-20">
				<?php echo get_search_form(); ?>
			</div>

		<?php endif; ?>

	</div><!-- .page-content -->

</article><!-- .no-results -->
