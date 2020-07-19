<?php
/*
 Template Name: Career
 */
get_header(); ?>

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
				<?php
					$args = array( 'post_type' => 'job', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'DESC' );
					$loop = new WP_Query( $args );
					$i = 1;
				?>

				<?php if ($loop->have_posts()) : ?>
				<div class="table-responsive  wow fadeInUp">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:30px" class="text-center">SL</th>
							<th>Job Title</th>
							<th style="width:150px" class="text-center">No. of Vacancies </th>
							<th style="width:180px" class="text-center">Deadline</th>
						</tr>
					</thead>
					<tbody>
				<?php while ( $loop->have_posts() ) : $loop->the_post();
					$no_of_vacancies = get_field('no_of_vacancies', get_the_ID());
					$deadline = get_field('deadline', get_the_ID());
				?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
						<td class="text-center"><?php echo $no_of_vacancies; ?></td>
						<td class="text-center"><?php echo $deadline; ?></td>
					</tr>
				<?php $i++;  endwhile; ?>
				</tbody>
			</table>
			</div>
        <?php else : ?>
        <div class="text-center font-large">No current postings however if you would like to reach out to us, email your resume at <a href="mailto:career@demo.com">career@demo.com</a>.</div>
        <?php endif; ?>

			</div>
		</div>
	</div>
</section>


<?php get_footer(); ?>
