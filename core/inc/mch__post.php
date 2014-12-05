<?php
// function prfx_meta_save( $post_id ) {
 
//     // Checks save status
//     $is_autosave = wp_is_post_autosave( $post_id );
//     $is_revision = wp_is_post_revision( $post_id );
//     $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
//     // Exits script depending on save status
//     if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
//         return;
//     }
 
//     // Checks for input and sanitizes/saves if needed
//     if( isset( $_POST[ 'meta-text' ] ) ) {

//     	print_r($_POST);
//         // update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
//     }
 
// }
// add_action( 'save_post', 'prfx_meta_save' );
// add_action( 'edit_post', 'prfx_meta_save' );

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

	// /*
	//  * We need to verify this came from our screen and with proper authorization,
	//  * because the save_post action can be triggered at other times.
	//  */

	// // Check if our nonce is set.
	// if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
	// 	return;
	// }

	// // Verify that the nonce is valid.
	// if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
	// 	return;
	// }

	// // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	// if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	// 	return;
	// }

	// // Check the user's permissions.
	// if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

	// 	if ( ! current_user_can( 'edit_page', $post_id ) ) {
	// 		return;
	// 	}

	// } else {

	// 	if ( ! current_user_can( 'edit_post', $post_id ) ) {
	// 		return;
	// 	}
	// }

	// /* OK, it's safe for us to save the data now. */
	
	// // Make sure that it is set.
	// if ( ! isset( $_POST['myplugin_new_field'] ) ) {
	// 	return;
	// }

	// // Sanitize user input.
	// $my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

	// // Update the meta field in the database.


	// all post are on this : mch__post__[]
	// and for all value have an input !

	$content = wpautop( $_POST['mch__editor__1'], $br = 1 );
	update_post_meta( $post_id, '_my_meta_value_key', $content );
}