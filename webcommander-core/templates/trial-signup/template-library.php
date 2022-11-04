<?php 
wcc_secure_redirect(); // No Direct Access Allowed
/**
 * This page contains choose tempalte functionalities
 * @author Rabiul
 * @since 1.0.0
 */

get_header();
?>
<!-- Preloader -->
<div class="signup-preloader">
	<div class="preloader-inner">
		<div class="lds-ring-bottom"><div></div><div></div><div></div><div></div></div>
		<h2 class="preloader-title">Please wait while we set up your website.</h2>
		<div class="scrolling-text">
			<span class="scroll-text-1">1 of 3: Building the backend structure</span>
			<span class="scroll-text-2">2 of 3: Setting up the frontend element</span>
			<span class="scroll-text-3">3 of 3: Enabling site functionalities</span>
		</div>
		<p class="scrolling-text"></p>
	</div>
</div>
<?php
/**
 * webalive_before_choose_template hook
 */
do_action( 'webalive_before_choose_template' );

?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div id="primary" class="webalive-content-area">
				<main id="main" class="webalive-site-main">

					<?php
					while ( have_posts() ) : the_post();

						the_content();
					
					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</div>
<div class="lds-ring-template"><div></div><div></div><div></div><div></div></div>
<?php
/**
 * webalive_after_choose_template hook
 */
do_action( 'wcc_template_library' );

get_footer();