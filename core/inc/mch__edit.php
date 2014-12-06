<?php

class MacroContentHammer__edit extends MacroContentHammer__kickstarter
{

	public function __construct(){
		// edit_post is hook for edit
		// add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
		add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
	}

	public function openMetabox( $tmpl__name ){
		?>
		<div id="postbox-container-1<?=$nEditeur?>" class="postbox-container">
			
	        <div id="mch__container--template--<?=$nEditeur?>" class="meta-box-sortables ui-sortable">
	            <div id="mch__rapper--macro" class="postbox mch closed">
	                <div class="handlediv mch" title="Cliquer pour inverser."><br></div>
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

				// $new__editor = "mch__editor__" . $n__element;

				$template = get_post_meta( $mch_query->post->ID, 'template', true );
				$type = get_post_meta( $mch_query->post->ID, 'type', true );
				// echo 'get content' . $template;

				if( $i === 0 ){
					$template__cache = $template;
				}

				if( $template__cache != $template ):
					// on a changé de template
						// on incremente le nombre de box
						// $n__element__box++;
					// on ferme la metabox
					// $this->closeMetabox();
					// on ouvre une metabox
					// $this->openMetabox();

					// on ajoute $metabox_contenu à metabox

					$metabox[] = $metabox_contenu;

					// on reset metabox_contenu

					$metabox_contenu = [];
				else:
					// on ajoute le contenu à la metabox contenu
					$metabox_contenu[] = array(
						'type' 		=>  $type,
						'content'	=>	$mch_query->post->post_content
					);

				endif;

				$template__cache = $template;
				// echo 'Je suis le tezmplate ' . $template;

				// print_r($mch_query->post->post_content);

        		// $structure = Parent::MacroContentHammer__get__template__structure( $template );
				// $structure = json_decode($templates[ $template ]);

				// print_r($structure);
	        	// $editeur->getNewContent( $template, $structure, $n__element );
	        	$n__element++;
	        	$i++;


				// on a un type de contenu

        	endwhile;

        	// on ferme la metabox
			// $this->closeMetabox();

		endif;

		print_r($metabox);


		/*
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
					remove_action( 'save_post', 'Macrocontenthammer__savedata' );

					$post__mch = wp_insert_post( $mch__newpost );
					add_post_meta( $post__mch, 'template', $mch__post__template, true ) || update_post_meta( $mch__newpost->ID, 'template', $mch__post__template );

		*/

		// get post mch_content where post_parent == post_id group by post meta template order by id asc



	}

}