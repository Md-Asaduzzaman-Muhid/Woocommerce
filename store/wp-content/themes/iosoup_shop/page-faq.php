<?php 
/*
Template Name: Faq 
*/
get_header(); ?>

<section class="page-section py-30 py-md-60">
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>

		<?php
			$args = array( 
			'post_type' => 'faq', 
			'posts_per_page' => -1, 
			'orderby' => 'menu_order', 
			'order' => 'ASC' );
			$loop = new WP_Query( $args );
			$i = 1;
		?>
			<div id="faqAccordion" class="accordion-wrapper wow fadeInUp">

			<?php while ( $loop->have_posts() ) : $loop->the_post();
			
			?>
			<div class="card faq-item">
				<div class="faq-title-header" id="heading-<?php echo get_the_ID(); ?>">
					<a class="faq-title" data-toggle="collapse" data-target="#collapse-<?php echo get_the_ID(); ?>" aria-expanded="<?php echo $i == 1 ? 'true' : 'false'; ?>" href="#collapse-<?php echo get_the_ID(); ?>" aria-controls="collapse-<?php echo get_the_ID(); ?>">
						<i></i><?php the_title(); ?>
					</a>
				</div>

				<div id="collapse-<?php echo get_the_ID(); ?>" class="collapse <?php echo $i == 1 ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo get_the_ID(); ?>" data-parent="#faqAccordion">
					<div class="card-body">
					<?php the_content(); ?>
					</div>
				</div>
			</div>

			<?php $i++; endwhile; ?>
		</div> <!-- accordion -->

	</div>
</section>
				
<?php get_footer(); ?>