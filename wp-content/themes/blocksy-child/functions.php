<?php
function enqueue_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' );
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), null, true);
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
	wp_enqueue_style('owl-theme-default', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
	wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '', true);
}  
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );

//testimonial carousel
function testimonial_carousel_shortcode() {
    ob_start();
    
    $testimonials = new WP_Query(array(
        'post_type' => 'testimonial',
        'posts_per_page' => -1,
    ));

    if ($testimonials->have_posts()) :
    ?>
	<div class="testimonial-carousel-wrapper">
    	<div class="testimonial-carousel owl-carousel">
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
            <button class="testimonial-carousel-prev"></button>
            <button class="testimonial-carousel-next"></button>
        </div>
	</div>	
		<script>
        jQuery(document).ready(function($) {
             // Function to set equal height for card items
             function setEqualHeight(selector) {
                var tallestHeight = 0;
                $(selector).each(function() {
                    var currentHeight = $(this).height();
                    if (currentHeight > tallestHeight) {
                        tallestHeight = currentHeight;
                    }
                });
                $(selector).height(tallestHeight);
            }
            
            // Call the function on window load and resize
            $(window).on('load resize', function() {
                setEqualHeight('.testimonial-carousel .testimonial-item');
            });
            $('.testimonial-carousel').owlCarousel({
                items: 1,
                loop: true,
                margin: 30,
                nav: false,
                dots: false,
                responsive:{
                    0:{
                        items:2
                    },
                    768:{
                        items:4
                    }
                }
            });
			$('.testimonial-carousel-prev').click(function() {
                $('.testimonial-carousel').trigger('prev.owl.carousel');
            });
            $('.testimonial-carousel-next').click(function() {
                $('.testimonial-carousel').trigger('next.owl.carousel');
            });
        });
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