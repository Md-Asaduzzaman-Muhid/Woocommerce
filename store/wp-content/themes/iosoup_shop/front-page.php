<?php get_header(); ?>


<section class="welcome-content py-30 py-md-80">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1 class="section-title wow fadeInUp"><?php the_title();?></h1>
                <?php get_template_part( 'template-parts/content', 'page' ); ?>
                <?php endwhile; endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Feature -->
<div class="divider"></div>
<div class="feature-area pb-30 pb-md-80 bg-dark">
    <div class="container">
        <div class="row">

        <?php
            $feature_posts = get_field('feature_posts', 16);
            if(!empty($feature_posts)) { 
                foreach ($feature_posts as $value) {
        ?>

            <div class="col-sm-4">
                <div class="quicklink-box text-center wow zoomIn">
                    <div class="quicklink-thum-wrap">
                        <div class="qlink-thum">
                            <?php echo get_the_post_thumbnail( $value->ID, 'full', array( 'class' => 'img-fluid' ) ); ?>
                        </div>
                        <a href="<?php echo esc_url( get_permalink($value->ID) ); ?>" class="view-btn">View</a>
                    </div>
                    <a class="quick-title" href="<?php echo esc_url( get_permalink($value->ID) ); ?>"><?php echo $value->post_title; ?></a>
                    <?php echo wpautop(wp_trim_words( $value->post_content, 20, '...' )); ?>                    
                </div>
            </div>

        <?php 
                }
            } 
        ?>

        </div>
    </div>
</div>
<!-- Feature -->

<!-- Gallery -->
<div class="galery-area py-30 py-md-80">
    <div class="container">
        <div class="section-title text-center wow fadeInUp">GALLERY</div>
        <div>
            <?php echo do_shortcode('[unitegallery gallery]'); ?>
        </div>
    </div>
</div>
<!-- Gallery -->
<div class="divider"></div>

<div class="call-to-action py-20 py-md-40 bg-dark">
    <div class="container d-md-flex justify-content-md-between text-center text-md-left">
        <div class="text-white pb-10">We’re looking for people to join our team.   Apply for a position with us today.</div>
        <div><a href="<?php echo home_url(); ?>/jobs" class="btn btn-light font-weight-bold">Get Started</a></div>
    </div>
</div>

<!-- contact-area  -->
<div class="contact-area py-30 py-md-80">
    <div class="container">
        <div class="section-title text-center wow fadeInUp">CONTACT</div>
        <div class="text-center mb-30  wow fadeInUp">
            To contact us, please use the form provided below. <br>
            You can expect to receive a reply on the following business day.
        </div>

        <div class="row d-flex justify-content-center mb-30">
            <div class="col-md-6 wow fadeInLeft">
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

            <div class="col-md-6 wow fadeInRight">
                <?php if(!empty(get_option('insta_option_hours'))){ ?>
                    <?php echo trim(get_option('insta_option_hours')); ?>
                <?php } ?>
            </div>

        </div> <!-- row -->

        <ul class="text-center social-links mb-30 p-0">
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

        <div class="contact-form">
            <?php echo do_shortcode('[contact-form-7 id="26" title="Contact form"]'); ?>
        </div>
    </div>
</div>
<!-- /contact-area  -->

<?php get_footer(); ?>
