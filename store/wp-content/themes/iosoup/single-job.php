<?php get_header(); ?>
    <div class="container py-30 py-md-80">
        <div class="row">
            <div class="col-md-12">
                <?php if (have_posts()) : while (have_posts()) : the_post(); 
                    $no_of_vacancies = get_field('no_of_vacancies', get_the_ID());
                    $deadline = get_field('deadline', get_the_ID());
                ?>
                    
                    <article id="page-<?php the_ID(); ?>" <?php post_class('page-content single-content wow fadeInUp'); ?>>
                        <ul class="job-info list-inline">
                            <?php if(!empty($no_of_vacancies)){ ?>                            
                            <li>No. of Vacancies: <strong><?php echo $no_of_vacancies; ?></strong></li>
                            <?php } ?>
                            <?php if(!empty($deadline)){ ?>
                            <li>Deadline: <strong><?php echo $deadline; ?></strong></li>
                            <?php } ?>
                            <li class="btn-apply">Apply</li>
                        </ul>
                        <?php the_content(); ?>
                    </article>
                    <hr>
                    <div class="pt-30 wow fadeInUp" id="apply-job-form">
                        <h3 class="text-center mb-30">Apply This Job</h3>
                        <div class="px-md-100">
                            <?php echo do_shortcode('[contact-form-7 id="39" title="Application Form"]'); ?>
                        </div>
                    </div>

                <?php endwhile; ?>

                <?php else : ?>
                    <h2>Post Not Found</h2>
                <?php endif; ?>
            </div> <!-- /col  -->
        </div> <!-- /row  -->
    </div> <!-- /container  -->
    
<?php get_footer(); ?>
