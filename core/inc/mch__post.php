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
function Macrocontenthammer__savedata( $post_id ) {


	$mch__posts 		= $_POST['mch__post__'];
	$mch__templates 	= $_POST['mch__template__'];
	$user_ID 			= get_current_user_id();

	// Check if our nonce is set.
	if ( ! isset( $_POST['macrocontenthammer__nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['macrocontenthammer__nonce'], 'mch__editor' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}


	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	if( isset( $mch__posts ) && count( $mch__posts ) != 0 ){

		// on a du post alors on y va :)
		// on boucle sur les mch__post
		foreach ($mch__posts as $key => $mch__post) {
			

				$termid = get_post_meta($post_id, '_termid', true);
				if ($termid != '') {
				// it's a new record
					$update = false;
				} else {
				// it's an existing record
					$update = true;
				}


				$status = get_post_status( $post_id );
							// on ajoute une entrée, son parent, son meta groupe

				$mch__newpost = array(
					'post_title'		=> 'mch title'
				  	,'post_content'  	=> $_POST[ $mch__post ] // The full text of the post.
				  	,'post_status'    	=> $status
				  	,'post_type'      	=> 'MCH__content'
				  	,'ping_status'    	=> 'closed' 
				  	,'post_parent'    	=> $post_id
				  	,'post_author'		=> $user_ID
				  	,'comment_status' 	=> 'closed'
				);


				if( $update === true ){
					// on retrouve le content lié
					// puis array_push( $mch__newpost, 'ID' => $idoufnd );
				}

				// on supprime le hook pour éviter l'effet inception
				remove_action( 'save_post', 'Macrocontenthammer__savedata' );

				$post__mch = wp_insert_post( $mch__newpost );
				add_post_meta( $post__mch, 'template', $mch__post__template, true ) || update_post_meta( $mch__newpost->ID, 'template', $mch__post__template );

				// on retabli le hook sur le save post
				add_action( 'save_post', 'Macrocontenthammer__savedata' );

		}
	}


}