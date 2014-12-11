<?php


// ******************************************************
//
// Generation des metabox à l'ouverture d'un update de post
//
// ******************************************************


class MacroContentHammer__edit
{

	public function __construct(){
		// edit_post is hook for edit
		// add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
		add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
		// add_action( 'edit_page_form', array( $this, 'Macrocontenthammer__getdata' ) );
	}

	public function Macrocontenthammer__getdata( $post ) {


		// metabox represente les metabox par groupe de template
		$metabox = [];
		$metabox_contenu = [];
		$metabox__structure = []; // structure ID des elements pour la suppression

		$n__element = 0;
		$start__box = 1000;
		$n__element__box = 1 + $start__box;


		// ====================================================================
		//
		// on récupère les templates disponibles
		//
		// ====================================================================
		// $mch_structure = new MacroContentHammer__structure();
  //       $templates = $mch_structure->MacroContentHammer__register__templates();

        // log_it( $templates );

        // on instancie les editeurs et on le passe en mode update
		$editeur = new MacroContentHammer__editors();
		$editeur->update = true;

		// on récupère les metas
		$metas = get_post_meta( $post->ID, '_mch_content', true );

		// log_it($metas);

		if( ! empty( $metas ) ):

			// for each metas
			foreach ($metas as $key => $metabox):


				// container management
				$template = $metas[ $key ]['template'];
				$container = $metas[ $key ]['container'];
				$contents = $metas[ $key ]['content'];


				// metabox ouverture
				$editeur->template = $template;
				$editeur->postID = $post->ID;
				$editeur->openMetaBox( $key );
				

					foreach ($contents as $i => $content):

						// on retrouve le post
						$mch__post = get_post( $content['ID'] );
						// log_it($mch__post);

						$metabox__structure[] = $mch__post->ID;

						$name__editor = "mch__editor__" . ( $container + $i +1);
						// log_it($name__editor);
						
						$editeur->ID = $mch__post->ID;
						$editeur->content = $mch__post->post_content;
						$editeur->name = $name__editor;
						$editeur->slug = $content['slug'];

						// log_it($mch__post->ID);

						switch ( $content['type'] ) {
							case 'image':
								$editeur->images__id = $editeur->content;
								$editeur->getNewImage();
								break;

							case 'editeur':
								$editeur->getNewEditor();
								break;

							default:
								$editeur->getNewEditor();
						}

					endforeach;


				$editeur->elementsRemove = implode(',', $metabox__structure);
				$metabox__structure = [];

				$editeur->closeMetaBox();

			endforeach;

		endif;

	}

}