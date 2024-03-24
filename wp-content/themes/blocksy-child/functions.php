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
            <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
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
            <?php endwhile; ?>
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
            if (index >= testimonials.length) {testimonialIndex = 0;}
            if (index < 0) {testimonialIndex = testimonials.length - 1;}
            for (var i = 0; i < testimonials.length; i++) {
                testimonials[i].style.display = "none";
            }
            testimonials[testimonialIndex].style.display = "block";
        }

        function moveTestimonialCarousel(direction) {
            showTestimonials(testimonialIndex += direction);
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
                <img src="<?php echo get_field('image'); ?>" alt="image">
                <div class="category">
                    <?php
                        $categories = get_the_category();
                        foreach ($categories as $category) {
                            echo '<span>' . $category->name . '</span>';
                        }
                    ?>
                </div>
                <h5><?php the_title(); ?></h5>
                <p> <?php echo get_field('description'); ?></p>
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

function insights_shortcode() {
    ob_start();
    get_template_part('custom/insights');
    return ob_get_clean();
}
add_shortcode('custom_insights', 'insights_shortcode');

function career_shortcode() {
    ob_start();
    get_template_part('custom/career');
    return ob_get_clean();
}
add_shortcode('custom_career', 'career_shortcode');

function archive_shortcode() {
    ob_start();
    get_template_part('custom/archive');
    return ob_get_clean();
}
add_shortcode('custom_archive', 'archive_shortcode');