<?php
/**
 * Salah Recorder functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Salah Recorder
 * @since 1.0.0
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function salah_recorder_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Salah Recorder, use a find and replace
		* to change 'salah-recorder' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'salah-recorder', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'salah-recorder' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'salah_recorder_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'salah_recorder_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function salah_recorder_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'salah_recorder_content_width', 640 );
}
add_action( 'after_setup_theme', 'salah_recorder_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function salah_recorder_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'salah-recorder' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'salah-recorder' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'salah_recorder_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function salah_recorder_scripts() {
	wp_enqueue_style( 'salah-recorder-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'salah-recorder-style', 'rtl', 'replace' );

	 wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'salah-recorder-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'salah-recorder-site-scripts', get_template_directory_uri() . '/js/site-scripts.js', array('jquery'), _S_VERSION, true );

	wp_register_script( 'ajax-calls',  get_template_directory_uri() . '/js/ajax-calls.js', array('jquery'), _S_VERSION, true );
	
	// Localize
	wp_localize_script(
		'ajax-calls',
		'localVars',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		)
	);

	// Enqueue ajax calls scripts
	wp_enqueue_script( 'ajax-calls' );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'salah_recorder_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Ajax calls file.
 */
require get_template_directory() . '/inc/ajax-calls.php';



add_action('init', 'my_custom_login_check');
function my_custom_login_check(){
	
	/**
	** Retrieves user input values from a POST request array and assigns them to variables with default empty string values.
	* @return array An associative array containing user input values with keys 'user', 'pass', 'email',
	*/

	$user = ( isset($_POST['uname']) ? $_POST['uname'] : '' );
	$pass = ( isset($_POST['upass']) ? $_POST['upass'] : '' );
	$email = ( isset($_POST['uemail']) ? $_POST['uemail'] : '' );
	$form_type = ( isset($_POST['form-type']) ? $_POST['form-type'] : '' );

	// Checks if form type is 'register'.
	if($form_type == 'register'){
		
		// Checks if user input values are not empty.
		if(($user != '') && ($email != '') && ($pass != '')){
			// Checks if username and email do not already exist in the database.
			if ( !username_exists( $user )  && !email_exists( $email ) ) {
				// Creates a new WordPress user and returns the user ID.
				$user_id = wp_create_user( $user, $pass, $email );
				// Checks if user creation was successful.
				if( !is_wp_error($user_id) ) {
					// Sets user role to administrator and generates authentication cookies.
					$user = new WP_User( $user_id );
					$user->set_role( 'administrator' );
					wp_set_current_user($user_id);
					wp_set_auth_cookie($user_id);

					/**
				 	*
					** Inserts default data into a custom database table for the newly created user using $wpdb object.
					** It assigns the $user_id variable to the $current_userid variable and inserts 5 rows of data,
					** including salah number, status, user ID, and current time as of user logged in.
					*
					*/

					global $wpdb;
					$current_userid =  $user_id;
					$table_name = $wpdb->prefix . 'salahs';
					for ($i = 1; $i < 6; $i++){
						date_default_timezone_set('Asia/Karachi');
						$data_array = array(
								'salah_number' => $i,
								'salah_status' => false,
								'userid'=> $user_id,
								'last_login' => current_time('mysql')
						);

						$insertResult = $wpdb->insert($table_name, $data_array, $format=NULL);
					}
					wp_redirect( home_url() );
					// exit();
				}
			} else {

				// Sets user registration status cookie.
				$cookie_name = "user_status";
				$cookie_value = "Already registered user";
				setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
			}
		}
	// Checks if form type is 'login'.
	} else if($form_type == 'login'){
		// Authenticates user credentials using wordpress default function because we need hash check for password
		$current_login_status = wp_authenticate($email, $pass);
		if(!$current_login_status->errors){
			// Sets current user and authentication cookies.
			wp_set_current_user($current_login_status->data->ID);
			wp_set_auth_cookie($current_login_status->data->ID);

			$user_id = $current_login_status->data->ID;

			// Retrieves last login time for the user from the database.
			global $wpdb;
			$table_name = $wpdb->prefix . 'salahs';
			$last_login = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT last_login FROM $table_name WHERE userid = %d AND salah_number = 1",
					$user_id
				)
			);

			/**
			** Set timezone to Asia/Karachi and get current time in mysql format.
			** Convert the last login time and current time to timestamp and then to date format.
			* @param string $last_login The last login time.
			* @return array The date in Y-m-d format for last login time and current time.
			**/
			$current_time1 = $last_login;
			date_default_timezone_set('Asia/Karachi');
			$current_time2 = current_time('mysql');

			$timestamp1 = strtotime($current_time1);
			$timestamp2 = strtotime($current_time2);

			// $date1 = date('Y-m-d', strtotime('-1 day', $timestamp1));
			$date1 = date('Y-m-d', $timestamp1);
			$date2 = date('Y-m-d', $timestamp2);

			if ($date1 != $date2) {

				// Updates the `salah_status` column to 0 for all the `salah_numbers` in the `salahs` table for the current user.
				$table_name = $wpdb->prefix . 'salahs';
				$user_id = get_current_user_id();
				date_default_timezone_set('Australia/Sydney');
				$current_time = current_time('mysql');
				for ($i = 1; $i <= 5; $i++) {
					$wpdb->update(
						$table_name,
						array('salah_status' => 0),
						array('userid' => $user_id, 'salah_number' => $i),
						array('%s'),
						array('%d', '%d')
					);
				}
				/**
				** Updates the last login time for a user in the database for all five prayer times.
				* @global wpdb $wpdb WordPress database object.
				 */
				$user_id = get_current_user_id();
				$current_time = current_time('mysql');
				for ($i = 1; $i <= 5; $i++) {
					$wpdb->update(
						$table_name,
						array('last_login' => $current_time),
						array('userid' => $user_id, 'salah_number' => $i),
						array('%s'),
						array('%d', '%d')
					);
				}
				$wpdb->print_error();
			} else {

				// Updates the last_login column of the `salahs` table with the current time for the user currently logged in for each of the five daily prayers.
				$table_name = $wpdb->prefix . 'salahs';
				$user_id = get_current_user_id();
				date_default_timezone_set('Asia/Karachi');
				$current_time = current_time('mysql');
				for ($i = 1; $i <= 5; $i++) {
					$wpdb->update(
						$table_name,
						array('last_login' => $current_time),
						array('userid' => $user_id, 'salah_number' => $i),
						array('%s'),
						array('%d', '%d')
					);
				}
			}

			wp_redirect( home_url() );

			// exit();
		} else {
			// log any errors that occur during the login process to the PHP error log.
				foreach($current_login_status->errors as $error) {
				error_log($error[0]);
			}
		}
		
	}
}



/**
** Redirects user to home page after logging out of WordPress.
*/
add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}


/**

** Creates a new table for storing salah data using the WordPress database class.
* @global wpdb $wpdb WordPress database class instance.
* @param string $table_name The name of the table to create.
* @param string $charset_collate The charset and collation of the table.
* @param string $sql The SQL query for creating the table with specified columns and keys.
**Includes the upgrade.php file and uses the dbDelta function to compare the SQL query to the existing table schema and modify the table accordingly.
*/

add_action("after_switch_theme", "salah_user_saved_values");

function salah_user_saved_values() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'salahs';

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		userid mediumint(9) NOT NULL,
		salah_number smallint(5) NOT NULL,
		salah_status BOOLEAN NOT NULL DEFAULT FALSE,
		last_login VARCHAR(255),
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $sql );

}
