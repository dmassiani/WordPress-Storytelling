<?php

class MacroContentHammer__post extends MacroContentHammer__kickstarter
{

	public function __construct(){
		add_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );
	}

	public function Macrocontenthammer__savedata( $post_id ) {


		$mch__posts 		= $_POST['mch__post__'];
		$mch__templates 	= $_POST['mch__template__'];
		$mch__types 	= $_POST['mch__type__'];
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
					remove_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );

					$post__mch = wp_insert_post( $mch__newpost );
					$mch__post__template = $mch__templates[ $key ];
					$mch__post__type = $mch__types[ $key ];
					
					add_post_meta( $post__mch, 'template', $mch__post__template, true ) || update_post_meta( $mch__newpost->ID, 'template', $mch__post__template );
					add_post_meta( $post__mch, 'type', $mch__post__type, true ) || update_post_meta( $mch__newpost->ID, 'type', $mch__post__type );

					// on retabli le hook sur le save post
					add_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );

			}
		}


	}

}