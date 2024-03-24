<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blocksy
 */

$prefix = blocksy_manager()->screen->get_prefix();

$maybe_custom_output = apply_filters(
	'blocksy:posts-listing:canvas:custom-output',
	null
);

if ($maybe_custom_output) {
	echo $maybe_custom_output;
	return;
}

$container_class = 'ct-container';


/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
echo blocksy_output_hero_section([
	'type' => 'type-2'
]);

$section_class = '';

if (! have_posts()) {
	$section_class = 'class="ct-no-results"';
}

?>

<div class="<?php echo $container_class ?>" <?php echo wp_kses_post(blocksy_sidebar_position_attr()); ?> <?php echo blocksy_get_v_spacing() ?>>
	<section <?php echo $section_class ?> class="insight-wrapper">
    <?php
	//services loop
          $args = array(
            'post_type' => 'insight',
            'post_status' => 'publish',
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); 
            ?>
            <div class="services">
                <img src="<?php echo get_field('image'); ?>" alt="image">
                <h5><?php the_title(); ?></h5>
                <p> <?php echo get_field('description'); ?></p>
                <a>View Details</a>
            </div>
            <?php endwhile; ?>
            <?php
        wp_reset_postdata();
    else :
        echo '<p>No posts found</p>';
    endif;
    ?>
    </section>

	<?php get_sidebar(); ?>
</div>
