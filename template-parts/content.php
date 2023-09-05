<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image' );
	}

    ?>


	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			?>

		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);

		edit_post_link();

		// Single bottom post meta.
		twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

		if ( is_single() ) {

			get_template_part( 'template-parts/entry-author-bio' );

		}
		?>

	</div><!-- .section-inner -->

<!-- wp:paragraph -->
<p>

<?php
    // this works to add the meta content visibly to the post
	// we're explicitly inserting custom field blocks & values instead elsewhere. 
	// here we were working with meta created by Elementor in the source site 
	// handy for learning how we want to use that meta data, but not for ongoing work 
    // this should be one-time in functions.php with an init and then removed
    // Get the current post.
    $post = get_post();
    $post_id = get_the_ID();
    // Get the post meta options.
    $address_values=get_post_meta($post_id,'options', true);
    foreach ( $address_values as $key => $address_value ) {
        if ($address_value !== '' && $address_value !== NULL && $key !== 'faqs') {
            $post->post_content .= '<p>' . $key . ': ' . $address_value . '</p>';
            // $post->post_content .= '<div><strong>' . $key . '</strong>: ' . $address_value . '<br /></div>';
        }
    }
    // Update the post content.
    // this will duplicate on each view / edit if not removed 
    wp_update_post($post);
?>
</p>
<!-- /wp:paragraph -->


	<?php

	if ( is_single() ) {

        
		get_template_part( 'template-parts/navigation' );

	}

	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

		<?php
	}
	?>

</article><!-- .post -->
