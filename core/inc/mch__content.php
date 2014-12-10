<?php
// ******************************************************
//
// Gestion des contenus
//
// ******************************************************

class MacroContentHammer__content
{

	public function __construct(){

		//add_action( 'the_post', array( $this, 'MacroContentHammer__extractContent' ) );
		add_filter('the_content', array( $this, 'MacroContentHammer__extractContent' ));
		
	}

	public function MacroContentHammer__extractContent( $post ){


    return "Whew !".$post;

	}
}

function get_story( $story__name, $post_id = false, $template ){
	return 'mop';
}

function the_story( $story__name, $post_id = false, $template ) {

	$value = get_story($story__name, $post_id, $template );
	
	echo $value;
}