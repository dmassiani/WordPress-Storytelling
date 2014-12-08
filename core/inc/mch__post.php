<?php

// ******************************************************
//
// Enregistrement et update d'un post
//
// ******************************************************

class MacroContentHammer__post extends MacroContentHammer__kickstarter
{

	public function __construct(){
		add_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );
	}

	public function Macrocontenthammer__savedata( $post_id ) {


		if( !empty( $_POST['mch__post__'] )
		&& !empty( $_POST['mch__template__'] )
		&& !empty( $_POST['mch__type__'] )
		&& !empty( $_POST['metabox__id'] )){

			$mch__posts 		= $_POST['mch__post__'];
			$mch__templates 	= $_POST['mch__template__'];
			$mch__types 		= $_POST['mch__type__'];
			$mch__metabox 		= $_POST['metabox__id'];

			if( isset( $_POST['mch__ID'] ) ){
				log_it('post exist');
				$mch__ID = $_POST['mch__ID'];
			}else{
				log_it('post desotnexist');
			}

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
					

						$status = get_post_status( $post_id );
						$update = false;
						// on ajoute une entrée, son parent, son meta groupe

						if( empty( $_POST[ $mch__post ] ) )$_POST[ $mch__post ]='';

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



						if( !empty( $mch__ID[ $key ] ) ){
							log_it('key exist');
							$mch__newpost['ID'] = $mch__ID[ $key ];
							$update = true;
							add_post_meta( $post_id, 'debug', $mch__ID[ $key ], true ) || 
							update_post_meta( $post_id, 'debug', $mch__ID[ $key ] );
						}else{
							log_it('key doesnt exist');
						}

						log_it($mch__newpost);


						remove_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );




									$mch__post__template = $mch__templates[ $key ];
									$mch__post__type = $mch__types[ $key ];
									$mch__post__metabox = $mch__metabox[ $key ];
									

									if( $update === false){
										$post__mch = wp_insert_post( $mch__newpost );
									}else{
										$post__mch = wp_update_post( $mch__newpost );
									}


									add_post_meta( $post__mch, 'template', $mch__post__template, true ) 
									|| update_post_meta( $mch__newpost['ID'], 'template', $mch__post__template );

									add_post_meta( $post__mch, 'type', $mch__post__type, true ) 
									|| update_post_meta( $mch__newpost['ID'], 'type', $mch__post__type );

									add_post_meta( $post__mch, 'container', $mch__post__metabox, true ) 
									|| update_post_meta( $mch__newpost['ID'], 'container', $mch__post__metabox );


						// on retabli le hook sur le save post
						add_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );



				}
			}

		}// fin d'empty

	}

}