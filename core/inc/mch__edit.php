<?php

class MacroContentHammer__edit extends MacroContentHammer__kickstarter
{

	public function __construct(){
		// edit_post is hook for edit
		// add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
		add_action( 'edit_form_after_editor', array( $this, 'Macrocontenthammer__getdata' ) );
	}

	public function Macrocontenthammer__getdata( $post ) {
		

		// metabox represente les metabox par groupe de template
		$metabox = [];
		$n__element = 0;

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

        
        echo 'get data';

		if ( $mch_query->have_posts() ) :
			// $mch_query->the_post();
			while ( $mch_query->have_posts() ) : $mch_query->the_post();


				$template = get_post_meta( $mch_query->post->ID, 'template', true );
				echo 'get content' . $template;
				// echo 'Je suis le tezmplate ' . $template;

				// print_r($mch_query->posts);

        		// $structure = Parent::MacroContentHammer__get__template__structure( $template );
				// $structure = json_decode($templates[ $template ]);

				// print_r($structure);
	        	// $editeur->getNewContent( $template, $structure, $n__element );
	        	// $n__element++;


				// on a un type de contenu

        	endwhile;

		endif;


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