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

class Storytelling__post
{


	function __construct(){
		// log_it('post init');
	}

	public function Storytelling__savedata( $post_id ) {


			if( !empty( $_POST['story__post__'] )
			&& !empty( $_POST['story__template__'] )
			&& !empty( $_POST['story__type__'] )
			&& !empty( $_POST['story__slug__'] )
			&& !empty( $_POST['metabox__id'] )){

				$story__posts 		= $_POST['story__post__'];
				$story__templates 	= $_POST['story__template__'];
				$story__types 		= $_POST['story__type__'];
				$story__files 		= $_POST['story__file__'];
				$story__slugs 		= $_POST['story__slug__'];
				$story__metabox 	= $_POST['metabox__id'];
				$story__images 		= $_POST['story__image__id'];
				$story__ID 			= $_POST['story__ID'];


				$user_ID 			= get_current_user_id();


				if ( false !== wp_is_post_revision( $post_id ) )
				        return;

				if ( false !== wp_is_post_autosave( $post_id ) )
				        return;

				// Check if our nonce is set.
				if ( ! isset( $_POST['storytelling__nonce'] ) ) {
					return;
				}

				// Verify that the nonce is valid.
				if ( ! wp_verify_nonce( $_POST['storytelling__nonce'], 'story__editor' ) ) {
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

				if( isset( $story__posts ) && count( $story__posts ) != 0 ){

					// log_it($story__posts);
							
					remove_action( 'save_post', array( $this, 'Storytelling__savedata' ) );

					// on a du post alors on y va :)
					// on boucle sur les story__post

					$update__content = false;
					$update__meta = true;

					
					$container = '';
					$container__cache = '';
					$file = '';
					$file__cache = '';
					$template = '';
					$template_cache = '';

					$types = [];

					$status = get_post_status( $post_id );
					$i = 0;

					$metas = [];

					foreach ($story__posts as $key => $story__post) {

							$update__content = false;

							// log_it($story__post);

							// on ajoute une entrée, son parent, son meta groupe

							$story__newpost = array(
							  	'post_status'    	=> $status
							  	,'post_type'      	=> 'STORY__content'
							  	,'ping_status'    	=> 'closed'
							  	,'post_author'		=> $user_ID
							  	,'comment_status' 	=> 'closed'
							);


							// Gestion du contenu en fonction du type
							// s'il n'y a pas de contenu
							if( empty( $_POST[ $story__post ] ) )$_POST[ $story__post ]='';

							// gestion du contenu en fonction du type
							switch ( $story__types[ $key ] ) {
								case 'image':
									$story__newpost['post_content'] = $story__images[ $key ];
									break;

								case 'editor':
									$story__newpost['post_content'] = $_POST[ $story__post ];
									break;
							}

							// log_it($story__ID[ $key ]);

							if( !empty( trim($story__ID[ $key ]) ) ){

								$story__newpost['ID'] = $story__ID[ $key ];
								$update__content = true;

								// log_it('cest un update');

							}else{
								// log_it('ce nest pas un update');
							}



							if( $update__content === false){

								// log_it('nouveau');
								$story__id = wp_insert_post( $story__newpost );
								$update__meta = true;

							}else{

								// log_it($story__newpost);

								wp_update_post( $story__newpost );
								$story__id = $story__newpost['ID'];
							
							}


							// les ID des post de la metabox
							$template = $story__templates[ $key ];
							$container = $story__metabox[ $key ];
							$file = $story__files[ $key ];

							if( $i === 0 )$container__cache = $container;

							if( (int) $container__cache != (int) $container ){

								$metas[] = array( 'file' => $file__cache, 'template' => $template__cache, 'container' => $container__cache, 'content' => $story__content );

								unset($story__content);

							}

							$story__content[] = array(
								'ID' => $story__id,
								'type' => $story__types[ $key ],
								'slug' => $story__slugs[ $key ]
							);
							
							$container__cache = $container;
							$template__cache = $template;
							$file__cache = $file;


							$i++;


					}


					$metas[] = array( 'file' => $file__cache, 'template' => $template__cache, 'container' => $container__cache, 'content' => $story__content );
					unset($story__content);

					// log_it($metas);

					if( $update__meta === true ):
						// il y a eu un nouvel enregistrement
						update_post_meta( $post_id, '_story_content', $metas );
					else:
						add_post_meta( $post_id, '_story_content', $metas, true );
					endif;

				}

			}// fin d'empty
	// }

	}

}