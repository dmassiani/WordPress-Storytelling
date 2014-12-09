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
		$mch_structure = new MacroContentHammer__structure();
        $templates = $mch_structure->MacroContentHammer__register__templates();

        // on instancie les editeurs et on le passe en mode update
		$editeur = new MacroContentHammer__editors();
		$editeur->update = true;

		// ====================================================================
		//
		// on récupère tout les post MCH_content avec comme parent le post
		//
		// ====================================================================
		$args = array(
			'post_type'  	=> 'MCH__content'
			,'order_by'		=> 'ID'
			,'order'		=> 'ASC'
			,'post_parent'	=> $post->ID
			,'posts_per_page'=> -1
			,'meta_key'		=> 'mch__template'
		);
		$mch_query = new WP_Query( $args );
		// echo $mch_query->found_posts;
		// print_r($mch_query);

        
		// ====================================================================
		//
		// s'il y a des posts
		//
		// ====================================================================
		if ( $mch_query->have_posts() ) :


			$i = 0;
			$tmpl = 0;

			// ====================================================================
			//
			// pour chaque post
			//
			// ====================================================================
			$previous__container = '';
			// $debug = get_post_meta( $post->ID, 'debug', true );
			// echo $debug;

			while ( $mch_query->have_posts() ) : $mch_query->the_post();


				$template = get_post_meta( $mch_query->post->ID, 'mch__template', true );
				$type = get_post_meta( $mch_query->post->ID, 'mch__type', true );
				$container = get_post_meta( $mch_query->post->ID, 'mch__container', true );

				if( $i === 0 ){

					$previous__container = $container;
					$metabox[$tmpl]['template'] = $template;
					$metabox[$tmpl]['container'] = $container;

				}

				if( $previous__container != $container ):

					$metabox[$tmpl]['metabox'] = $metabox_contenu;
				
					$tmpl++;

					$metabox[$tmpl]['template'] = $template;
					$metabox[$tmpl]['container'] = $container;

					$metabox_contenu = [];


				else:
	        		$i++;
				endif;


				$metabox_contenu[] = array(
					'ID'		=>  $mch_query->post->ID,
					'type' 		=>  $type,
					'content'	=>	$mch_query->post->post_content
				);


				$previous__container = $container;

	        	$n__element++;

        	endwhile;

			// array_push( $metabox, array('template' => $template, 'metabox' => array()));
			$metabox[$tmpl]['template'] = $template;
			$metabox[$tmpl]['container'] = $container;
			$metabox[$tmpl]['metabox'] = $metabox_contenu;

			// print_r($metabox);

			foreach ($metabox as $key => $box) {

				// chaque itération repésente une metabox
				$template = $box['template'];
				$container = $box['container'];

				// print_r($metabox[ $key ]['container']);

				$editeur->template = $template;
				$editeur->openMetaBox( $key );

				foreach ( $box['metabox'] as $el_key => $element) {

						$metabox__structure[] = $element['ID'];

						$name__editor = "mch__editor__" . ( $container + $el_key +1);	
						
						$editeur->ID = $element['ID'];
						$editeur->content = $element['content'];
						$editeur->name = $name__editor;



						switch ( $element['type'] ) {
							case 'image':
								$editeur->images__id = $element['content'];
								$editeur->getNewImage();
								break;

							case 'editeur':
								$editeur->getNewEditor();
								break;

							default:
								$editeur->getNewEditor();
						}


				}

				$editeur->elementsRemove = implode(',', $metabox__structure);
				$editeur->postID = $post->ID;
				$editeur->closeMetaBox();
				$metabox__structure = [];


			}


		endif;

	}

}