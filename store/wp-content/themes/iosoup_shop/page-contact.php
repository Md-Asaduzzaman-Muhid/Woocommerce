<?php 
/*
Template Name: Contact
*/
get_header(); ?>

<section class="page-section py-30 py-md-80">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="page-header mb-20 text-center">
					<h1 class="page-title wow fadeInUp"><?php the_title(); ?></h1>
				</div>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>

		<hr>

		<div class="row contact-area pt-30">
			<div class="col-md-6">
				<div class="wow fadeInLeft">
					<dl>
						<dt>Address:</dt>
						<dd><?php echo nl2br(get_option('insta_option_address')); ?></dd>
					</dl>

					<?php if(!empty(get_option('insta_option_phone'))){ ?>
					<dl>
						<dt>Phone:</dt>
						<dd>
							<a href="tel:<?php echo str_replace(array('(',')',' ','-','.'), "", get_option('insta_option_phone')); ?>"> <?php echo get_option('insta_option_phone'); ?></a>
						</dd>
					</dl>
					<?php } ?>
					<?php if(!empty(get_option('insta_option_fax'))){ ?>
					<dl>
						<dt>Fax:</dt>
						<dd>
							<a href="tel:<?php echo str_replace(array('(',')',' ','-','.'), "", get_option('insta_option_fax')); ?>">
								<?php echo get_option('insta_option_fax'); ?>
							</a>
						</dd>
					</dl>
					<?php }?>
					<?php if(!empty(get_option('insta_option_email'))){ ?>
					<dl>
						<dt>Email:</dt>
						<dd>
							<a href="mailto:<?php echo trim(get_option('insta_option_email')); ?>">
								<?php echo trim(get_option('insta_option_email')); ?>
							</a>
						</dd>
					</dl>
					<?php } ?>
				</div>

				<div class="wow fadeInRight mb-15">
					<?php if(!empty(get_option('insta_option_hours'))){ ?>
						<?php echo trim(get_option('insta_option_hours')); ?>
					<?php } ?>
				</div>

				<ul class="text-center social-links mb-30 p-0 float-md-left">
					<?php if (!empty(get_option('insta_option_fb_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_fb_link'); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<?php } ?>

					<?php if (!empty(get_option('insta_option_twitter_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_twitter_link'); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<?php } ?>

					<?php if (!empty(get_option('insta_option_linkedin_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_linkedin_link'); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
					<?php } ?>

					<?php if (!empty(get_option('insta_option_pinterest_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_pinterest_link'); ?>" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
					<?php } ?>

					<?php if (!empty(get_option('insta_option_instagram_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_instagram_link'); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					<?php } ?>

					<?php if (!empty(get_option('insta_option_gplus_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_gplus_link'); ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					<?php } ?>

					<?php if (!empty(get_option('insta_option_youtube_link'))){ ?>
						<li class="wow zoomIn"><a href="<?php echo get_option('insta_option_youtube_link'); ?>" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
					<?php } ?>
				</ul>

			</div>

			<div class="col-md-6 wow fadeInRight">
				<?php echo do_shortcode('[contact-form-7 id="26" title="Contact form"]'); ?>
			</div>
		</div>
	</div>
</section>


<div class="map-area clearfix">
	
</div>

<?php get_footer(); ?>
