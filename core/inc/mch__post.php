<?php

// ******************************************************
//
// Enregistrement et update d'un post
//
// ******************************************************

/*

au premier enregistrement
wordpress créé deux enregistrement, un post de type publish, un autre de type revision

*/

class MacroContentHammer__post
{


	function __construct(){
		// log_it('post init');
	}

	public function Macrocontenthammer__savedata( $post_id ) {

		log_it('save data');
		// log_it($post_id);


			if( !empty( $_POST['mch__post__'] )
			&& !empty( $_POST['mch__template__'] )
			&& !empty( $_POST['mch__type__'] )
			&& !empty( $_POST['metabox__id'] )){

				$mch__posts 		= $_POST['mch__post__'];
				$mch__templates 	= $_POST['mch__template__'];
				$mch__types 		= $_POST['mch__type__'];
				$mch__metabox 		= $_POST['metabox__id'];
				$mch__images 		= $_POST['mch__image__id'];

				// log_it($mch__metabox);

				$user_ID 			= get_current_user_id();

				if( isset( $_POST['mch__ID'] ) ){
					// log_it('post exist');
					$mch__ID = $_POST['mch__ID'];
				}else{
					// log_it('post desotnexist');
				}

				if ( false !== wp_is_post_revision( $post_id ) )
				        return;

				if ( false !== wp_is_post_autosave( $post_id ) )
				        return;

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

					// log_it($mch__posts);
							
					remove_action( 'save_post', array( $this, 'Macrocontenthammer__savedata' ) );

					// on a du post alors on y va :)
					// on boucle sur les mch__post

					$update = false;
					$types = [];
					$container = '';
					$container__cache = '';
					$template = '';
					$status = get_post_status( $post_id );
					$i = 0;

					$metas = [];

					foreach ($mch__posts as $key => $mch__post) {


							// on ajoute une entrée, son parent, son meta groupe

							$mch__newpost = array(
							  	'post_status'    	=> $status
							  	,'post_type'      	=> 'MCH__content'
							  	,'ping_status'    	=> 'closed'
							  	,'post_author'		=> $user_ID
							  	,'comment_status' 	=> 'closed'
							);


							// Gestion du contenu en fonction du type
							// s'il n'y a pas de contenu
							if( empty( $_POST[ $mch__post ] ) )$_POST[ $mch__post ]='';

							// gestion du contenu en fonction du type
							switch ( $mch__types[ $key ] ) {
								case 'image':
									$mch__newpost['post_content'] = $mch__images[ $key ];
									break;

								case 'editeur':
									$mch__newpost['post_content'] = $_POST[ $mch__post ];
									break;
							}


							if( !empty( $mch__ID[ $key ] ) ){

								$mch__newpost['ID'] = $mch__ID[ $key ];
								$update = true;

							}

							if( $update === false){

								// log_it('nouveau');
								$mch__id = wp_insert_post( $mch__newpost );

							}else{

								// log_it('update');
								wp_update_post( $mch__newpost );
								$mch__id = $mch__newpost['ID'];
							
							}


							// les ID des post de la metabox
							$template = $mch__templates[ $key ];
							$container = $mch__metabox[ $key ];

							// log_it($template);

							if( $i === 0 )$container__cache = $container;

							if( (int) $container__cache != (int) $container ){

								// log_it($container);
								// log_it($container__cache);

								// log_it( $cont)
								// on change de container donc on ajoute les metas precedent
								// $i = 0;
								$metas[] = array( 'template' => $template__cache, 'container' => $container__cache, 'content' => $mch__content );

								log_it($metas);
								// on vide $types
								unset($mch__content);


							}
							
							$mch__content[] = array(
								'ID' => $mch__id,
								'type' => $mch__types[ $key ]
							);
							
							$container__cache = $container;
							$template__cache = $template;


							$i++;


					}


					$metas[] = array( 'template' => $template__cache, 'container' => $container__cache, 'content' => $mch__content );
					unset($mch__content);

					log_it($metas);
					// log_it($metas);

					add_post_meta( $post_id, '_mch_content', $metas, true ) || update_post_meta( $post_id, '_mch_content', $metas, true );
					

				}

			}// fin d'empty
	// }

	}

}