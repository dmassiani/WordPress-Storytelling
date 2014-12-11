<?php
// ******************************************************
//
// Gestion des contenus
//
// ******************************************************



function get_illustration( $slug, $size ){

	global $post;
	global $mch__stories;

	if( empty( $mch__stories ) ) define_stories();
	if( empty( $mch__stories ) ) return;


	return;
}

function the_illustration( $slug = false, $size = false ){

	global $post;
	global $mch__stories;
	global $mch__current__story;

	if( empty( $mch__stories ) ) define_stories();
	if( empty( $mch__stories ) ) return;

	if( $slug === false ) return;
	if( $size === false ) $size = 'full';


	foreach( $mch__current__story['contents'] as $key => $element ){

		if( $element['slug'] === $slug ){

			$the_chapter_ID = $element['ID'];

		}

	}

	if( !empty( $the_chapter_ID ) ):
		$the__chapter = get_post( $the_chapter_ID );
		echo wp_get_attachment_image( $the__chapter->post_content, $size );

	endif;

}

function get_chapter( $slug = false ){

	global $post;
	global $mch__stories;

	if( empty( $mch__stories ) ) define_stories();
	if( empty( $mch__stories ) ) return;

	if( $slug === false ) return;

	return;
}

function the_chapter( $slug = false ){

	global $post;
	global $mch__stories;
	global $mch__current__story;

	if( empty( $mch__stories ) ) define_stories();
	if( empty( $mch__stories ) ) return;

	if( $slug === false ) return;

	foreach( $mch__current__story['contents'] as $key => $element ){

		if( $element['slug'] === $slug ){

			$the_chapter_ID = $element['ID'];

		}

	}

	if( !empty( $the_chapter_ID ) ):
		$the__chapter = get_post( $the_chapter_ID );
		echo $the__chapter->post_content;
	endif;

}

function define_stories(){

	global $post;
	global $mch__stories;

	if( empty( $post ) || !is_numeric( $post->ID ) || is_admin() ) return;

	$metas = get_post_meta( $post->ID, '_mch_content', true );

	if( ! empty( $metas ) ):

		$mch__stories = [];

		foreach ($metas as $key => $metabox):

			$template = $metas[ $key ]['template'];
			$contents = $metas[ $key ]['content'];

			$name = sanitize_title( $template );

			$mch__stories[ $name ] = array(
				'template' => $name,
				'contents' => $contents
			);

		endforeach;

	endif;

}


// fonction public d'affichage des histoires complètes
function the_story() {

	global $post;
	global $mch__stories;
	global $mch__current__story;


	if( empty( $mch__stories ) ) define_stories();


	if( empty( $mch__stories ) ) return;


	foreach ($mch__stories as $key => $story):


		$mch__current__story = $story;

		echo get_story_template( $story['template'] );

	endforeach;

}

function get_story_template( $story__name ){

	global $post;
	global $mch__stories;
	global $mch__current__story;

	if( empty( $mch__stories ) ) define_stories();
	if( empty( $mch__stories ) ) return;
	if( empty( $story__name ) ) return;

	return get_template_part( MCH_FOLDER . '/' . $story__name );

}