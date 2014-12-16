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
				$story__titles 		= $_POST['story__title__'];
				$story__slugs 		= $_POST['story__slug__'];
				$story__metabox 	= $_POST['metabox__id'];
				$story__images 		= $_POST['story__image__id'];
				$story__ID 			= $_POST['story__ID'];


				$user_ID 			= get_current_user_id();

				// log_it($story__titles);


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
					$i__title = 0;
					$i__editor = 0;
					$i__image = 0;

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

							// log_it($key);


							// Gestion du contenu en fonction du type
							// s'il n'y a pas de contenu
							if( empty( $_POST[ $story__post ] ) )$_POST[ $story__post ]='';

							// gestion du contenu en fonction du type
							switch ( $story__types[ $key ] ) {
								case 'image':
									$story__newpost['post_content'] = $story__images[ $key ];
									$i__image++;
									break;

								case 'editor':
									$story__newpost['post_content'] = $_POST[ $story__post ];
									$i__editor++;
									break;

								case 'title':
									$story__newpost['post_content'] = $story__titles[ $i__title ];
									$i__title++;
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

	public function Storytelling__save( $post_id ) {


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
				if( !empty( $_POST['story__title__'] ) ):

				$story__titles 		= $_POST['story__title__'];

				endif;

				$user_ID 			= get_current_user_id();

				// log_it($story__titles);


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

				// if( isset( $story__posts ) && count( $story__posts ) != 0 ){
				if( isset( $story__metabox ) && count( $story__metabox ) != 0 ){

					$story__structure = new Storytelling__structure();
							
					remove_action( 'save_post', array( $this, 'Storytelling__save' ) );
					// remove_action( 'save_post', array( $this, 'Storytelling__savedata' ) );

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
					$i__title = 0;

					$metas = [];

					// new
					$key__element = 0;

					foreach ($story__metabox as $key__meta => $metabox) {

							$file 		= $story__files[ $key__meta ];
							$template 	= $story__templates[ $key__meta ];
							unset($meta__content);

							// on récupère la structure de la metabox grace au nom du fichier
							$metabox__structure = $story__structure->Storytelling__get__fileStructure( $file );
							// log_it( $metabox__structure );

							// pour chaque element de la structure on retrouve sa data
							// les elements sont théoriquement dans l'ordre.

							foreach( $metabox__structure as $key => $element ):

								// $key__element représente le numéro de l'element dans la page

								// on indique que par défaut ce n'est pas un update
								$update__content = false;

								// on regénere les data du post
								$story__newpost = array(
								  	'post_status'    	=> $status
								  	,'post_type'      	=> 'STORY__content'
								  	,'ping_status'    	=> 'closed'
								  	,'post_author'		=> $user_ID
								  	,'comment_status' 	=> 'closed'
								);

								// s'il s'agit d'un update
								if( !empty( trim($story__ID[ $key__element ]) ) ){

									// on indique à wordpress un ID pour signifier d'updater
									$story__newpost['ID'] = $story__ID[ $key__element ];
									$update__content = true;

								}

								// log_it('key element = ' . $key__element);
								// log_it($story__ID[ $key__element ]);

								// // // si story__post est vide
								// // // if( empty( $_POST[ $story__post ] ) )$_POST[ $story__post ]='';


								// gestion du contenu en fonction du type
								switch ( $element->type ) {
									case 'image':
										$story__newpost['post_content'] = $story__images[ $key__element ];
										break;

									case 'editor':
										$story__newpost['post_content'] = $_POST[ $story__posts[ $key__element ] ];
										break;

									case 'title':
										$story__newpost['post_content'] = $story__titles[ $i__title ];
										$i__title++;
										break;
								}

								log_it($story__newpost);

								if( $update__content === false){

									$story__id = wp_insert_post( $story__newpost );
									$update__meta = true;

								}else{

									wp_update_post( $story__newpost );
									$story__id = $story__newpost['ID'];
								
								}

								// log_it($story__newpost);

								$meta__content[] = array(
									'ID' => $story__id,
									'type' => $element->type,
									'slug' => $element->slug
								);

								// log_it($meta__content);

								$key__element++;

							endforeach;


							$metas[] = array( 
								'file' 			=> $file, 
								'template' 		=> $template, 
								'container' 	=> $metabox, 
								'content' 		=> $meta__content
							);



					}



					if( $update__meta === true ):
						// il y a eu un nouvel enregistrement
						update_post_meta( $post_id, '_story_content', $metas );
						log_it('jupdate le meta');
					else:
						add_post_meta( $post_id, '_story_content', $metas, true );
						log_it('jajoute un meta');
					endif;

				}

			}// fin d'empty
	// }

	}

}