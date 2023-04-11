<?php
/**
 * Template Name: Homepage
 * Template Post Type: page
 *
 * This template is for displaying home page.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package STEP by PGC
 * @since 1.0.0
 *
 */

// Include header
get_header();


$cookie_name = 'user_status';
if(!isset($_COOKIE[$cookie_name])) {
	$current_user_status = null;
} else {
	$current_user_status = $_COOKIE[$cookie_name];
}

if(is_user_logged_in()){
	$current_user_status = 'wp-logged-in';
}


if($current_user_status == null){
	$register_visibility_class = ' register-form-visible ';
	$login_visibility_class = ' login-form-hidden ';
	$salah_status_visibility_class = ' salah-status-container-hidden ';
} elseif($current_user_status == 'Already registered user') {
	$register_visibility_class = ' register-form-hidden ';
	$login_visibility_class = ' login-form-visible ';
	$salah_status_visibility_class = ' salah-status-container-hidden ';
} elseif($current_user_status == 'wp-logged-in') { 
	$register_visibility_class = ' register-form-hidden ';
	$login_visibility_class = ' login-form-hidden ';
	$salah_status_visibility_class = ' salah-status-container-visible ';
}

?>
<section id="page-section" class="page-section homepage-from">



	<div id="register" class="<?php echo $register_visibility_class; ?>">
		<h1>Please register here</h1>

		<div id="container">
			<form method="post" name="myForm">
				<div class="single-input-container"><label for="uname">Username</label> <input type="text"
						name="uname" />
				</div>
				<div class="single-input-container"><label for="uemail">Email</label> <input id="email" type="text"
						name="uemail" /></div>
				<div class="single-input-container"><label for="upass">Password</label> <input type="password"
						name="upass" /></div>
				<input type="hidden" name="form-type" value="register" />
				<input type="submit" value="Submit" />
				<span class="user-selection-container"><a class="user-selection-button" href="#"
						data-clickid="login">Login Here</a></span>
			</form>

		</div>

	</div>

	<div id="login" class="<?php echo $login_visibility_class; ?>">
		<h1>Please login here</h1>

		<?php if($current_user_status == 'Already registered user') { ?>
		<h3>You already have an account.</h3>
		<?php } ?>

		<div id="container">
			<form method="post" name="myForm">
				<div class="single-input-container"><label for="uemail">Email</label> <input id="email" type="text"
						name="uemail" /></div>
				<div class="single-input-container"><label for="upass">Password</label> <input type="password"
						name="upass" /></div>
				<input type="hidden" name="form-type" value="login" />
				<input type="submit" value="Submit" />
				<span class="user-selection-container"><a class="user-selection-button" href="#"
						data-clickid="register">Register Here</a></span>
			</form>
		</div>

	</div>


	<div class="current-salah-status-container <?php echo $salah_status_visibility_class; ?>">
		<h1>See your Salah Records here</h1>

		<div class="current-salah-results">
			<button type="button" class="button button-secondary" data-toggle="0">
				<span class="dashicons dashicons-yes-alt"></span>
			</button>
		</div>
	</div>


	<!-- Content Start --> <?php while ( have_posts() ) { the_post();
		//Include specific template for the content.
		get_template_part( 'partials/content', 'page' );

	} ?> <div class="clear"></div>
	<div class="ts-80"></div>
	<!-- Content End -->
</section> <?php get_footer(); ?>
