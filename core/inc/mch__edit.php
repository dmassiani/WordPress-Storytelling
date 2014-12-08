<?php


// ******************************************************
//
// Generation des metabox à l'ouverture d'un update de post
//
// ******************************************************


class MacroContentHammer__edit extends MacroContentHammer__kickstarter
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

		$n__element = 0;
		$start__box = 1000;
		$n__element__box = 1 + $start__box;


		// ====================================================================
		//
		// on récupère les templates disponibles
		//
		// ====================================================================
        $templates = Parent::MacroContentHammer__register__templates();


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
			,'posts_per_page'=>-1
			,'meta_key'		=> 'template'
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

			while ( $mch_query->have_posts() ) : $mch_query->the_post();


				$template = get_post_meta( $mch_query->post->ID, 'template', true );
				$type = get_post_meta( $mch_query->post->ID, 'type', true );
				$container = get_post_meta( $mch_query->post->ID, 'container', true );
				// echo $template;
				// echo $template;

				// nombre de contenu du template :


				if( $i === 0 ){

					$previous__container = $container;
					$metabox[$tmpl]['template'] = $template;
					$metabox[$tmpl]['container'] = $container;

				}

				if( $previous__container != $container ):

					$metabox[$tmpl]['metabox'] = $metabox_contenu;
				
					$tmpl++;

					// array_push( $metabox[$key]['metabox'], $metabox_contenu);
					$metabox[$tmpl]['template'] = $template;
					$metabox[$tmpl]['container'] = $container;

					$metabox_contenu = [];


				else:
	        		$i++;
				endif;


				$metabox_contenu[] = array(
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

			$editeur = new MacroContentHammer__editors();

			// print_r($metabox);

			foreach ($metabox as $key => $box) {

				// chaque itération repésente une metabox
				$template = $box['template'];
				$container = $box['container'];

				// print_r($metabox[ $key ]['container']);

				$editeur->openMetaBox( $template, $key );

				foreach ( $box['metabox'] as $el_key => $element) {
					// print_r($element);

						// $name__editor = "mch__editor__" . $container;

						// $this->element__id = $container + ( $el_key + 1 );

						$name__editor = "mch__editor__" . ( $container + $el_key +1);	
						
						// echo $content__type['type'];

						switch ( $element['type'] ) {
							case 'image':
								// echo "image";
								$editeur->getNewImage( $name__editor , $template, $element['content'] );
								break;

							case 'content':
								// echo "content";
								$editeur->getNewEditor( $name__editor , $template, $element['content'] );
								break;

							default:
								$editeur->getNewEditor( $name__editor , $template, $element['content'] );
								// echo "defaut : content";

						}


				}

				$editeur->closeMetaBox();


			}


		endif;

	}

}