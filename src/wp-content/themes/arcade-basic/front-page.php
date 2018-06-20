<?php
/**
 * The front page template.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @since 1.0.0
 */
get_header();

global $paged;
$bavotasan_theme_options = bavotasan_theme_options();

if ( 2 > $paged ) {
	// Display jumbo headline is the option is set
	if ( is_active_sidebar( 'jumbo-headline' ) || ! empty( $bavotasan_theme_options['jumbo_headline_title'] ) ) {
	?>
	<div class="home-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
					if ( is_active_sidebar( 'jumbo-headline' ) ) {
						dynamic_sidebar( 'jumbo-headline' );
					} else {
						?>
						<div class="home-jumbotron jumbotron">
							<h2><?php echo apply_filters( 'the_title', html_entity_decode( $bavotasan_theme_options['jumbo_headline_title'] ) ); ?></h2>
							<p><?php echo wp_kses_post( html_entity_decode( $bavotasan_theme_options['jumbo_headline_text'] ) ); ?></p>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
	}

	// Display home page top widgetized area
	if ( is_active_sidebar( 'home-page-top-area' ) ) {
		?>
		<div id="home-page-widgets">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'home-page-top-area' ); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
if ( 'page' == get_option('show_on_front') ) { ?>
  <div id="news">
    <h2>ニュース</h2>
    <?php
    $loop = new WP_Query(array('post_type' => 'news', 'posts_per_page' => 3));
    while($loop->have_posts()):
    $loop->the_post(); ?>
    <div id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
      <p class="tgNewsList"><span class="post-date"><?php the_time("Y年m月j日") ?></span>
      <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
      <?php the_title(); ?></a></p>
    </div>
    <?php endwhile;
      wp_reset_postdata();
    ?>
  </div>
<?php
	include( get_page_template() );
} else {
?>
	<div class="container">
		<div class="row">
			<div id="primary" <?php bavotasan_primary_attr(); ?>>
                <?php
				if ( have_posts() ) {
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;

					the_posts_navigation();
				} else {
					if ( current_user_can( 'edit_posts' ) ) {
						// Show a different message to a logged-in user who can add posts.
						?>
						<article id="post-0" class="post no-results not-found">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'arcade-basic' ); ?></h1>

							<div class="entry-content description clearfix">
								<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'arcade-basic' ), admin_url( 'post-new.php' ) ); ?></p>
							</div><!-- .entry-content -->
						</article>
						<?php
					} else {
						get_template_part( 'template-parts/content', 'none' );
					} // end current_user_can() check
				}
				?>
			</div><!-- #primary.c8 -->
			<?php get_sidebar(); ?>
		</div>
	</div>

<?php
}
get_footer(); ?>