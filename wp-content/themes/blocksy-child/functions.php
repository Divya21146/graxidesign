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
                <?php
                $total_testimonials = $testimonials->post_count;
                ?>
                <div class="testimonial-carousel-dots"></div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var testimonials = document.querySelectorAll('.testimonial-carousel .testimonial-item');
                var dotsContainer = document.querySelector('.testimonial-carousel-dots');
                var totalTestimonials = <?php echo $total_testimonials; ?>;
                var testimonialsPerPage = window.innerWidth >= 1024 ? 4 : 2;
                var totalDots = Math.ceil(totalTestimonials / testimonialsPerPage);

                for (var i = 0; i < totalDots; i++) {
                    var dot = document.createElement('button');
                    dot.className = 'testimonial-carousel-dot';
                    dot.dataset.pageIndex = i;
                    dot.addEventListener('click', function() {
                        var index = parseInt(this.dataset.pageIndex);
                        var pageIndex = index * testimonialsPerPage;
                        showTestimonials(pageIndex);
                        updateActiveDot(index);
                    });
                    dotsContainer.appendChild(dot);
                }

                var testimonialIndex = 0;
                showTestimonials(testimonialIndex);
                updateActiveDot(0); // Set the initial dot as active

                function showTestimonials(index) {
                    for (var i = 0; i < testimonials.length; i++) {
                        testimonials[i].style.display = "none";
                    }
                    for (var i = index; i < index + testimonialsPerPage; i++) {
                        if (testimonials[i]) {
                            testimonials[i].style.display = "block";
                        }
                    }
                }

                function updateActiveDot(index) {
                    var dots = dotsContainer.querySelectorAll('.testimonial-carousel-dot');
                    dots.forEach(function(dot) {
                        dot.classList.remove('active');
                    });
                    dots[index].classList.add('active');
                }

                window.addEventListener('resize', function() {
                    testimonialsPerPage = window.innerWidth >= 1024 ? 4 : 2;
                    totalDots = Math.ceil(totalTestimonials / testimonialsPerPage);
                    dotsContainer.innerHTML = '';
                    for (var i = 0; i < totalDots; i++) {
                        var dot = document.createElement('button');
                        dot.className = 'testimonial-carousel-dot';
                        dot.dataset.pageIndex = i;
                        dot.addEventListener('click', function() {
                            var index = parseInt(this.dataset.pageIndex);
                            var pageIndex = index * testimonialsPerPage;
                            showTestimonials(pageIndex);
                            updateActiveDot(index);
                        });
                        dotsContainer.appendChild(dot);
                    }
                    showTestimonials(testimonialIndex);
                    updateActiveDot(0); // Reset active dot on resize
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
?>
    <div id="insight-container"></div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var container = document.getElementById('insight-container');
            var postsPerPage = window.innerWidth >= 1024 ? 4 : 2;

            fetchPosts(postsPerPage);

            window.addEventListener('resize', function() {
                postsPerPage = window.innerWidth >= 1024 ? 4 : 2;
                fetchPosts(postsPerPage);
            });

            function fetchPosts(postsPerPage) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            container.innerHTML = xhr.responseText;
                        } else {
                            console.error('Error fetching posts');
                        }
                    }
                };
                xhr.open('GET', '<?php echo admin_url('admin-ajax.php') ?>?action=get_insight_posts&posts_per_page=' + postsPerPage, true);
                xhr.send();
            }
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('section_insight', 'section_insight');

// Ajax handler for fetching insight posts
add_action('wp_ajax_get_insight_posts', 'get_insight_posts');
add_action('wp_ajax_nopriv_get_insight_posts', 'get_insight_posts');

function get_insight_posts() {
    $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 4;

    $args = array(
        'post_type' => 'insight',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="services">
                <img src="<?php echo esc_url(get_field('image')); ?>" alt="image">
                <div class="content">
                    <h5><?php the_title(); ?></h5>
                    <?php echo esc_html(get_field('description')); ?>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No posts found</p>';
    }

    $response = ob_get_clean();
    echo $response;
    wp_die();
}

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
?>
    <div id="career-container"></div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var container = document.getElementById('career-container');
            var postsPerPage = window.innerWidth >= 1024 ? 4 : 2;

            fetchCareers(postsPerPage);

            window.addEventListener('resize', function() {
                postsPerPage = window.innerWidth >= 1024 ? 4 : 2;
                fetchCareers(postsPerPage);
            });

            function fetchCareers(postsPerPage) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            container.innerHTML = xhr.responseText;
                        } else {
                            console.error('Error fetching careers');
                        }
                    }
                };
                xhr.open('GET', '<?php echo admin_url('admin-ajax.php') ?>?action=get_career_posts&posts_per_page=' + postsPerPage, true);
                xhr.send();
            }
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('section_career', 'section_career');

// Ajax handler for fetching career posts
add_action('wp_ajax_get_career_posts', 'get_career_posts');
add_action('wp_ajax_nopriv_get_career_posts', 'get_career_posts');

function get_career_posts() {
    $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 4;

    $args = array(
        'post_type' => 'career',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="careers">
                <h5><?php the_title(); ?></h5>
                <p><?php the_content(); ?></p>
                <button><a href="<?php the_permalink(); ?>">View Details</a></button>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No posts found</p>';
    }

    $response = ob_get_clean();
    echo $response;
    wp_die();
}

function archive_shortcode() {
    ob_start();
    get_template_part('custom/archive');
    return ob_get_clean();
}
add_shortcode('custom_archive', 'archive_shortcode');