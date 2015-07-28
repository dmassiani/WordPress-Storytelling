<?php


// ******************************************************
//
// Generation des metabox à l'ouverture d'un update de post
//
// ******************************************************


class Storytelling__edit
{

	public function __construct(){
		add_action( 'edit_form_after_editor', array( $this, 'Storytelling__getdata' ) );
	}

	public function Storytelling__getdata( $post ) {


		// metabox represente les metabox par groupe de template
		$metabox = [];
		$metabox_contenu = [];
		$metabox__structure = []; // structure ID des elements pour la suppression


		// ====================================================================
		//
		// on récupère les templates disponibles
		//
		// ====================================================================
		$story__structure = new Storytelling__structure();
		$editeur = new Storytelling__editors();
		$editeur->update = true;

		// on récupère les metas
		// Les metas sont tout les champs storytelling
		// --------------------------------------------------
		/*

			L'ordre des metas correspond à l'ordre des containers.
			C'est à dire qu'un user peut tout à fait modifier l'ordre 
			en inversant les metabox.

		*/
		// --------------------------------------------------
		$data = get_post_meta( $post->ID, '_story_content', true );

		// on test si WPML syncronise ou pas 
		// log_it($data);


		if( ! empty( $data ) ):


			foreach ($data as $key => $metabox):

				// --------------------------------------------------
				/*
					Les variables globales nécessaires aux métabox
					globales = pour la metabox encapsulante
				*/
				// --------------------------------------------------
				$editeur->template 		= $metabox['template'];
				$editeur->folder_type 	= $metabox['folder_type'];
				$editeur->folder 		= $metabox['folder'];
				$editeur->file 			= $metabox['file'];
				$editeur->postID 		= $post->ID;
				// --------------------------------------------------
				/*
					$fileSlugs représente la structure SLUG du fichier concerné
				*/
				// --------------------------------------------------		
				$fileStructure 		= $story__structure->Storytelling__getFileSlugs( 
					$metabox['folder_type'], 
					$metabox['folder'], 
					$metabox['file'] 
				); 

				// --------------------------------------------------
				/*
					Metabox représente les données d'une metabox Storytelling
				*/
				// --------------------------------------------------

				$dataContent 	= $metabox['content'];
				$container 		= 1000 * ( $key + 1 );
				$contentStructure = [];

				foreach ($metabox['content'] as $i => $content):

					$contentStructure[ $content['slug'] ] = [
						'ID' => $content['ID'],
						'type' => $content['type']
					];

				endforeach;


				// --------------------------------------------------
				/*
					On ouvre une nouvelle metabox
				*/
				// --------------------------------------------------
				$editeur->openMetaBox( $key );

			
				// --------------------------------------------------
				/*
					Pour chaque slug du fichier on va chercher la data correspondante.
				*/
				// --------------------------------------------------
				foreach( $fileStructure as $keyS => $slug ):


					// --------------------------------------------------
					/*
						Les variables des champs
					*/
					// --------------------------------------------------

					$editeur->slug 				= $slug;
					$editeur->container__id 	= "story__editor__" . ( $container + $keyS + 1 );
					$editeur->name 				= $story__structure->Storytelling__getNameFileSlug( $editeur->folder_type, $editeur->folder, $editeur->file, $editeur->slug );
					$slugType 					= $story__structure->Storytelling__slugType( $editeur->folder_type, $editeur->folder, $editeur->file, $editeur->slug );


					$dataID = false;
					$dataType = false;
					$dataI = false;
					$currentSlug = NULL;


					// --------------------------------------------------
					/*
						C'est ici que ça coince
					*/
					// --------------------------------------------------

					$editeur->ID 			= '';
					$editeur->content 		= '';


					if( isset( $contentStructure[ $slug ] ) ){

						$post = get_post( $contentStructure[ $slug ]['ID'] );

						$editeur->ID 			= $post->ID;
						$editeur->content 		= $post->post_content;
						$metabox__structure[] 	= $post->ID;

					}


					switch ( $slugType ) {
						case 'image':
							$editeur->images__id = $editeur->content;
							$editeur->getNewImage();
							break;

						case 'editeur':
							$editeur->getNewEditor();
							break;

						case 'title':
							$editeur->getNewTitle();
							break;

						default:
							$editeur->getNewEditor();
					}

				endforeach;

				$editeur->elementsRemove = implode(',', $metabox__structure);
				$metabox__structure = [];

				// --------------------------------------------------
				/*
					On ferme la metabox
				*/
				// --------------------------------------------------
				$editeur->closeMetaBox();
					

			endforeach;

		endif;


	}

}