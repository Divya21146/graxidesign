<?php
function enqueue_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' );
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), null, true);
}  
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );

//testimonial carousel
function testimonial_carousel_shortcode() {
    ob_start();
    
    $testimonials = new WP_Query(array(
        'post_type' => 'testimonial',
    ));

    if ($testimonials->have_posts()) :
    ?>
    <div class="testimonial-carousel-wrapper">
        <div class="testimonial-carousel">
            <div class="testimonial-row"> <!-- Added a row container -->
            <?php 
            $count = 0; // Initialize a counter
            while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="testimonial-item"> 
                    <div class="testimonial-rating">
                        <?php 
                        $rating = get_field('ratings');
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fa fa-star" style="color: #f1c40f;"></i>';
                            } else {
                                echo '<i class="fa fa-star" style="color: #ccc;"></i>';
                            }
                        }
                        ?>
                    </div>
                    <div class="testimonial-feedback"><?php the_field('feedback'); ?></div>
                </div>
                <?php 
                $count++; // Increment the counter
                if ($count % 4 == 0) echo '</div><div class="testimonial-row">'; // Close and reopen row div after every 4 testimonials
                ?>
            <?php endwhile; ?>
            </div> <!-- Close the row container -->
        </div>
        <div class="testimonial-carousel-nav">
            <button class="testimonial-carousel-prev" onclick="moveTestimonialCarousel(-1)"></button>
            <button class="testimonial-carousel-next" onclick="moveTestimonialCarousel(1)"></button>
        </div>
    </div>
    <script>
        var testimonialIndex = 0;
        var testimonials = document.querySelectorAll('.testimonial-carousel .testimonial-item');
        showTestimonials(testimonialIndex);

        function showTestimonials(index) {
            for (var i = 0; i < testimonials.length; i++) {
                testimonials[i].style.display = "none";
            }
            for (var i = index; i < index + 4; i++) {
                if (testimonials[i]) {
                    testimonials[i].style.display = "block";
                }
            }
        }

        function moveTestimonialCarousel(direction) {
            testimonialIndex += direction * 4; // Increment/decrement by 4 to show the next/previous set of testimonials
            if (testimonialIndex >= testimonials.length) testimonialIndex = 0;
            if (testimonialIndex < 0) testimonialIndex = testimonials.length - (testimonials.length % 4);
            showTestimonials(testimonialIndex);
        }
    </script>
    <?php
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('testimonial_carousel', 'testimonial_carousel_shortcode');

//blogs shortcode

function blogs_archive_shortcode() {
    ob_start();
          $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'order' => 'DESC',
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); 
            ?>
            <div class="services">
                <div class="top">
                <img src="<?php echo get_field('image'); ?>" alt="image">
                <div class="category">
                    <?php
                        $categories = get_the_category();
                        foreach ($categories as $category) {
                            echo '<span>' . $category->name . '</span>';
                        }
                    ?>
                </div>
                </div>
                <h5><?php the_title(); ?></h5>
                <?php echo get_field('description'); ?>
                <a>Read More</a>
            </div>
            <?php endwhile; ?>
            <?php
        wp_reset_postdata();
    else :
        echo '<p>No posts found</p>';
    endif;
    return ob_get_clean();
}
add_shortcode('custom_blogs', 'blogs_archive_shortcode');

//page insights
function insights_shortcode() {
    ob_start();
    get_template_part('custom/insights');
    return ob_get_clean();
}
add_shortcode('custom_insights', 'insights_shortcode');

//section insight 
function section_insight() {
    ob_start();
	//services loop
          $args = array(
            'post_type' => 'insight',
            'posts_per_page' => 4,
            'post_status' => 'publish',
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); 
            ?>
            <div class="services">
                <img src="<?php echo get_field('image'); ?>" alt="image">
                <div class="content">
                <h5><?php the_title(); ?></h5>
                <?php echo get_field('description'); ?>
        </div>
            </div>
            <?php endwhile; ?>
            <?php
        wp_reset_postdata();
    else :
        echo '<p>No posts found</p>';
    endif;
    return ob_get_clean();
}
add_shortcode('section_insight', 'section_insight');

//full page career
function career_shortcode() {
    ob_start();
    get_template_part('custom/career');
    return ob_get_clean();
}
add_shortcode('custom_career', 'career_shortcode');

//section career
function section_career() {
    ob_start();
    //services loop
    $args = array(
        'post_type' => 'career',
        'posts_per_page' => 4,
        'post_status' => 'publish',
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post(); 
        ?>
        <div class="careers">
            <h5><?php the_title(); ?></h5>
            <p> <?php the_content(); ?></p>
            <button><a href="#">View Details</a></button>
        </div>
        <?php endwhile; ?>
        <?php
    wp_reset_postdata();
else :
    echo '<p>No posts found</p>';
endif;
    return ob_get_clean();
}
add_shortcode('section_career', 'section_career');

function archive_shortcode() {
    ob_start();
    get_template_part('custom/archive');
    return ob_get_clean();
}
add_shortcode('custom_archive', 'archive_shortcode');