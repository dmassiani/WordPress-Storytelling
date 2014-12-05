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


	$mch__posts 		= $_POST['mch__post__[]'];
	$mch__templates 	= $_POST['mch__template__[]'];

	if( isset( $mch__posts ) && count( $mch__posts ) != 0 ){

		// on a du post alors on y va :)
		// on boucle sur les mch__post
		foreach ($mch__posts as $key => $mch__post) {

			// Check if our nonce is set.
			if ( ! isset( $_POST['macrocontenthammer__nonce'] ) ) {
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
			

			// post name == $mch_post
			// post value content = $_POST[ $mch_post ]
				$mch__post__content = sanitize_text_field( $_POST[ $mch_post ] );
			// post template
				$mch__post__template = sanitize_text_field( $mch__templates[ $key ] );


			// ok, everything is right 

				// Sanitize user input.

				// all post are on this : mch__post__[]
				// and for all value have an input !

				// pour toutes les entrées
					// on test si c'est un update
						// si c'est un update je dois avoir l'id dans les hidden

// les editeurs sont dans l'ordre grace à mch__editeur__NUMBER

						// si ce n'est pas un update
							// on capte le status du post parent
				$status = get_post_status( $post_id );
							// on ajoute une entrée, son parent, son meta groupe

				$mch__newpost = array(
				  //'ID'              => [ <post id> ] // Are you updating an existing post?
				  'post_content'  	=> $mch__post__content // The full text of the post.
				  ,'post_status'    => $status
				  ,'post_type'      => 'MCH__content'
				  ,'ping_status'    => 'closed' // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
				  ,'post_parent'    => $post_id
				  ,'comment_status' => 'closed' // Default is the option 'default_comment_status', or 'closed'.
				  // ,'tax_input'      => [ array( <taxonomy> => <array | string> ) ] // For custom taxonomies. Default empty.
				);  

				// wp_set_object_terms($mch__newpost->ID, 'cars', 'types', true);
				update_post_meta( $mch__newpost->ID, 'template', $mch__post__template );



		}
	}


}