<?php
/**
 * Ajax related functions
 *
 * @link https://codex.wordpress.org/AJAX#Ajax_in_WordPress
 *
 * @package PGC Prospective 2023
 * @since 1.0.0
 *
 */

 
function salah_ajax_function()
{
	$response = array();
	$element_status = $element_position = $html = null;
	if (isset($_POST['items'][0])) {
		$element_status = $_POST['items'][0];
		$new_current_status = !$element_status;
	} else {
		$element_status = null;
	}

	if (isset($_POST['items'][1])) {
		$element_position = $_POST['items'][1];
	} else {
		$element_position = null;
	}



	if($element_status != '' && $element_position != ''){
		// Change the current value for selected salah.
		global $wpdb;
		$current_userid =  wp_get_current_user()->id;

		$table_name = $wpdb->prefix . 'salahs';

		$data_array = array(
			'salah_status' => $new_current_status ,
		);

		$where_clause = array(
			'salah_number' => $element_position,
			'userid' => $current_userid
		);

		$wpdb->update( $table_name, $data_array, $where_clause );

	}
	
	$response['current_userid'] = $current_userid;
	$response['passed_status'] = $element_status;
	$response['new_current_status'] = $new_current_status;
	$response['element_position'] = $element_position;
	$response['query_error'] = $wpdb->last_error;
	$response['query_last'] = $wpdb->last_query;
	
	echo json_encode( $response );
	wp_die();
}
add_action( 'wp_ajax_nopriv_salah_ajax_function', 'salah_ajax_function' );
add_action( 'wp_ajax_salah_ajax_function', 'salah_ajax_function' );
