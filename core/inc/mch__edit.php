<?php

class MacroContentHammer__edit extends MacroContentHammer__kickstarter
{

	public function __construct(){
		// edit_post is hook for edit
		// add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
		add_action( 'edit_form_advanced', array( $this, 'Macrocontenthammer__getdata' ) );
		add_action( 'edit_page_form', array( $this, 'Macrocontenthammer__getdata' ) );
	}

	public function openMetabox( $tmpl__name, $n__metabox ){
		?>
		<div id="postbox-container-1<?=$n__metabox?>" class="postbox-container">
			
	        <div id="mch__container--template--<?=$n__metabox?>" class="meta-box-sortables ui-sortable">
	            <div id="mch__rapper--macro" class="postbox mch closed">
	                <div class="handlediv" title="Cliquer pour inverser."><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	Macro Template : <?=$tmpl__name?>
	                    </span>
	                </h3>
	                <div class="inside">

					<?php

					wp_nonce_field( 'mch__editor', 'macrocontenthammer__nonce' );
	}

	public function closeMetabox(){
		?>
	                </div>
	            </div>
	        </div>
        </div>
        <?php
	}

	public function Macrocontenthammer__getdata( $post ) {
		

		// metabox represente les metabox par groupe de template
		$metabox = [];
		$metabox_contenu = [];

		$n__element = 0;
		$start__box = 1000;
		$n__element__box = 1 + $start__box;

		$args = array(
			'post_type'  	=> 'MCH__content'
			,'order_by'		=> 'ID'
			,'order'		=> 'ASC'
			,'post_parent'	=> $post->ID
			,'meta_key'		=> 'template'
		);
		$mch_query = new WP_Query( $args );

		// echo $mch_query->found_posts;
        $editeur = new MacroContentHammer__editors();
        $templates = Parent::MacroContentHammer__register__templates();

        
        // echo 'get data';

		if ( $mch_query->have_posts() ) :
			
			// on ouvre la metabox
			// $this->openMetabox();

			$i = 0;

			while ( $mch_query->have_posts() ) : $mch_query->the_post();


				$template = get_post_meta( $mch_query->post->ID, 'template', true );

				$type = get_post_meta( $mch_query->post->ID, 'type', true );
				// echo 'get content' . $template;

				if( $i === 0 ){
					$template__cache = $template;
					array_push( $metabox, array('template' => $template, 'metabox' => array()));
					$key = $i;
				}

				if( $template__cache != $template ):
					array_push( $metabox[$key]['metabox'], $metabox_contenu);
					$metabox_contenu = [];
				else:
					$metabox_contenu[] = array(
						'type' 		=>  $type,
						'content'	=>	$mch_query->post->post_content
					);
				endif;

				$template__cache = $template;
	        	$n__element++;
	        	$i++;

        	endwhile;


		endif;

		array_push( $metabox, array('template' => $template, 'metabox' => $metabox_contenu));

		$editeur = new MacroContentHammer__editors();

		foreach ($metabox as $key => $box) {

			// chaque itération repésente une metabox
			$template = $box['template'];

			// print_r($metabox[ $key ]['template']);

			$this->openMetaBox( $template, $key );

			foreach ( $box['metabox'] as $el_key => $element) {
				// print_r($element);

				foreach ( $element as $sub_key => $content__type) {

					$name__editor = "mch__editor__" . $sub_key;

					switch ( $content__type['type'] ) {
						case 'image':
							// echo "image";
							$editeur->getNewEditor( $name__editor , $template, 'ouhou' );
							break;

						case 'content':
							// echo "content";
							$editeur->getNewImage( $name__editor , $template, 'ouhou' );
							break;

						default:
							echo "defaut : content";

					}
				}

			}

			$this->closeMetaBox();


		}

	}

}