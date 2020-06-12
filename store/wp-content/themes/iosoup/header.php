<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
<title><?php wp_title(''); ?> </title>

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon.png" type="image/x-icon" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<header class="header">

		<nav class="navbar navbar-expand-md navbar-light bg-light">
			<div class="container">
				<div class="logo wow bounceInDown">
					<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>">
					</a>
				</div>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'top-menu',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'mainNavigation',
						'menu_class'      => 'navbar-nav ml-auto'
					)
				); ?>
			</div>
		</nav>

	</header> <!-- /header -->

	<?php
		if(is_front_page()){
			get_template_part( 'template-parts/content', 'banner' );
		} else {
			get_template_part( 'template-parts/content-inner', 'banner' );
		}
	?>

	<div class="pre-header clearfix">
		<div class="container d-flex justify-content-between align-items-center">
			<ul class="mb-0 list-inline d-inline-block call-info py-15">
				<li><a href="tel:<?php echo str_replace(array('(',')',' ','-','.'), "", get_option('insta_option_phone')); ?>"><i class="fa fa-phone" aria-hidden="true"></i> <span><?php echo str_replace(array('(',')',' ','-','.'), "", get_option('insta_option_phone')); ?></span></a></li>
				<li><a href="mailto:<?php echo trim(get_option('insta_option_email')); ?>"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Email Us!</span></a></li>
			</ul>

			<div class="py-15">
			<a target="_blank" title="Click for the Business Review of Concept Insulation Inc., a TBD in Calgary AB" href="https://www.bbb.org/calgary/business-reviews/insulation-contractors/concept-insulation-in-calgary-ab-90705#sealclick"><img alt="Click for the BBB Business Review of this TBD in Calgary AB" style="border: 0;" src="https://seal-calgary.bbb.org/seals/blue-seal-96-50-whitetxt-conceptinsulationinc-90705.png" /></a>

			</div>

			<ul class="list-inline text-center social-links mb-0 d-inline-block py-15">
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
	</div>	<!-- /pre-header -->
	
	<?php custom_breadcrumbs(); ?>
