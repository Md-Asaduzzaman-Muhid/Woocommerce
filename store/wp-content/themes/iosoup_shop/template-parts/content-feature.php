<?php
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-feature.php',
    'sort_column' => 'post_date', 
    'sort_order' => 'desc'
));
?>
<section class="feature-area">
    <?php 
    $i = 0;
    foreach($pages as $page){ 
                
        $page_data = get_post($page->ID);
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($page->ID) );

        $wow_class_left = 'wow fadeInRight';
        $wow_class_right = 'wow fadeInLeft';

        if(($i % 2) == 0) {
            $wow_class_left = 'wow fadeInLeft';
            $wow_class_right = 'wow fadeInRight';
        }
    ?>
        <div class="feature-item">
            <span class="item-bg <?php echo $wow_class_right; ?>" style="background-image:url(<?php echo $feat_image; ?>)"></span>
            <div class="container">
                <div class="feature-item-content <?php echo $wow_class_left; ?>">
                    <h2>
                        <?php 
                            $page_title = $page_data->post_title; 
                            $exp = explode(" ", $page_title);
                            $first_name = $exp[0];
                            unset($exp[0]);
                            $last_name = implode(" ", $exp);
                        ?>
                        <span><?php echo $first_name; ?></span>
                        <?php echo $last_name; ?>
                    </h2>
                    <p>
                        <?php echo $page_data->post_content; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /feature-item -->
        <?php $i++;  } ?>
</section>
<!-- /feature-area -->