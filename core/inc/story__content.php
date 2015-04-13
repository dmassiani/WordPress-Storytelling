<?php
// ******************************************************
//
// Gestion des contenus
//
// ******************************************************


function get_illustration( $slug, $size ){

	global $post;
	global $story__stories;

	if( empty( $story__stories ) ) define_stories();
	if( empty( $story__stories ) ) return;


	return;
}

function the_illustration( $slug = false, $size = false ){

	global $post;
	global $story__stories;
	global $story__current__story;

	if( empty( $story__stories ) ) define_stories();
	if( empty( $story__stories ) ) return;

	if( $slug === false ) return;
	if( $size === false ) $size = 'full';


	foreach( $story__current__story['contents'] as $key => $element ){

		if( $element['slug'] === $slug ){

			$the_chapter_ID = $element['ID'];

		}

	}

	if( !empty( $the_chapter_ID ) ):
		
		$the__chapter = get_post( $the_chapter_ID );
		echo wp_get_attachment_image( $the__chapter->post_content, $size );

	endif;

}

function the_marker( $slug = false ){

	global $post;
	global $story__stories;
	global $story__current__story;

	if( empty( $story__stories ) ) define_stories();
	if( empty( $story__stories ) ) return;

	if( $slug === false ) return;

	foreach( $story__current__story['contents'] as $key => $element ){

		if( $element['slug'] === $slug ){

			$the_chapter_ID = $element['ID'];

		}

	}

	if( !empty( $the_chapter_ID ) ):
		$the__chapter = get_post( $the_chapter_ID );
		echo $the__chapter->post_content;
	endif;

}
function the_chapter_title( $slug = false ){

	the_marker( $slug );

}
function once_upon_a_time( $slug = false ){

	the_marker( $slug );

}

function get_chapter( $slug = false ){

	global $post;
	global $story__stories;

	if( empty( $story__stories ) ) define_stories();
	if( empty( $story__stories ) ) return;

	if( $slug === false ) return;

	return;
}

function the_chapter( $slug = false ){

	global $post;
	global $story__stories;
	global $story__current__story;

	if( empty( $story__stories ) ) define_stories();
	if( empty( $story__stories ) ) return;

	if( $slug === false ) return;

	foreach( $story__current__story['contents'] as $key => $element ){

		if( $element['slug'] === $slug ){

			$the_chapter_ID = $element['ID'];

		}

	}

	if( !empty( $the_chapter_ID ) ):
		$the__chapter = get_post( $the_chapter_ID );
		echo apply_filters('the_content', $the__chapter->post_content );
	endif;

}

function define_stories(){

	global $post;
	global $story__stories;

	if( empty( $post ) || !is_numeric( $post->ID ) || is_admin() ) return;

	$metas = get_post_meta( $post->ID, '_story_content', true );

	if( ! empty( $metas ) ):

		$story__stories = [];

		foreach ($metas as $key => $metabox):

			$file	  		= $metas[ $key ]['file'];
			$folder_type	= $metas[ $key ]['folder_type'];
			$folder	  		= $metas[ $key ]['folder'];
			$contents 		= $metas[ $key ]['content'];

			$story__stories[] = array(
				'folder_type' 		=> $folder_type,
				'folder' 			=> $folder,
				'file' 				=> $file,
				'contents' 			=> $contents
			);

		endforeach;

	endif;

}


// fonction public d'affichage des histoires complètes
function the_story() {

	global $post;
	global $story__stories;
	global $story__current__story;


	if( empty( $story__stories ) ) define_stories();


	if( empty( $story__stories ) ) return;

	// log_it($story__stories);

	foreach ($story__stories as $key => $story):


		$story__current__story = $story;

    	if( $story['folder_type'] === 'plugin' ){
    		$folder = STORY_DEFAULT_TEMPLATE .'/'. $story['folder'];
    	}else{
    		$folder = get_template_directory() . '/' . STORY_FOLDER .'/'. $story['folder'];
    	}

    	// $file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );

		// remove php extension
		$info = pathinfo( $folder .'/'. $story['file'] );
		$name = $info['filename'];
		$folder = $story['folder'];
		$folder_type = $story['folder_type'];

		// log_it($info);

		// log_it(get_story_template( $name, $folder, $folder_type ));
		echo get_story_template( $name, $folder, $folder_type );

	endforeach;

}

function get_story_template( $story__name, $folder, $folder_type ){

	global $post;
	global $story__stories;
	global $story__current__story;

	if( empty( $story__stories ) ) define_stories();
	if( empty( $story__stories ) ) return;
	if( empty( $story__name ) ) return;

	// log_it( $folder . '/' . $story__name );

	// log_it($folder);

	if( $folder_type === 'theme' ){
		// log_it('storytelling/' . $folder .'/'. $story__name);
		return get_template_part(  'storytelling/' . $folder .'/'. $story__name );
	}else{
		// log_it('plugin');
		return storytelling__locate__template( $story__name, STORY_DIR . '/templates/' . $folder .'/' );
	}

}

// extra function to load template in plugin folder
/**
*Extend WP Core get_template_part() function to load files from the within Plugin directory defined by PLUGIN_DIR_PATH constant
* * Load the page to be displayed 
* from within plugin files directory only 
* * @uses storytelling__load__template() function 
* * @param $slug * @param null $name 
*/ 

function storytelling__locate__template($slug, $location,  $name = null) {

	// log_it($slug);

	do_action("storytelling__locate__template_{$slug}", $slug, $name);

	$templates = array();
	if (isset($name))
	    $templates[] = "{$slug}-{$name}.php";

	$templates[] = "{$slug}.php";

	storytelling__load__template($templates, $location, true, false);

}

/* Extend locate_template from WP Core 
* Define a location of your plugin file dir to a constant in this case = PLUGIN_DIR_PATH 
* Note: PLUGIN_DIR_PATH - can be any folder/subdirectory within your plugin files 
*/ 

function storytelling__load__template($template_names, $location, $load = false, $require_once = true ) 
{ 
	$located = ''; 
	foreach ( (array) $template_names as $template_name ) { 
		if ( !$template_name ) continue; 

		/* search file within the PLUGIN_DIR_PATH only */ 
		if ( file_exists( $location . $template_name)) { 
			$located = $location . $template_name; 
			break; 
		} 
	}

	if ( $load && '' != $located )
	    load_template( $located, $require_once );

	return $located;
}
