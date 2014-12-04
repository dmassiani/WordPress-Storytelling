<?php
/**
 * @package Macro Content Hammer
 */
/*
Plugin Name: Macro Content Hammer
Plugin URI: http://macrocontenthammer.com/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from comment and trackback spam</strong>. It keeps your site protected from spam even while you sleep. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="http://akismet.com/get/">Sign up for an Akismet API key</a>, and 3) Go to your Akismet configuration page, and save your API key.
Version: 1.0
Author: David Massiani
Author URI: http://davidmassiani.com
License: GPLv2 or later
Text Domain: macrocontenthammer
*/

// Folder name
define ( 'MCH_VERSION', '3.5' );
define ( 'MCH_OPTION',  'simple-taxonomy' );
define ( 'MCH_FOLDER',  'micro-templates' );

define ( 'MCH_URL', plugins_url('', __FILE__) );
define ( 'MCH_DIR', dirname(__FILE__) );


add_action( 'plugins_loaded', 'initMacroContentHammer' );
function initMacroContentHammer() {
	global $MCHammer;
	// Load translations
	add_action( 'save_post', 'myplugin_save_meta_box_data' );
	add_action( 'edit_post', 'myplugin_save_meta_box_data' );
	load_plugin_textdomain ( 'macro-content-hammer', false, basename(rtrim(dirname(__FILE__), '/')) . '/core/languages' );
}

class MacroContentHammer__Plugin
{

	// =============================================
	// templates is for register all templates available
	// =============================================

	public $templates = [];

	// ==================================================
	// include all php needed
	// ==================================================

    public function __construct()
    {


        include_once MCH_DIR . '/core/inc/mch__database.php';
        include_once MCH_DIR . '/core/inc/mch__interfaceConstructor.php';
        include_once MCH_DIR . '/core/inc/mch__getEditor.php';
        include_once MCH_DIR . '/core/inc/mch__ajax.php';

        // $templates = [];
		// global $templates;

		add_action('init', array($this, 'init'), 1);
    }

    // ============================================================
    // Register JS plugins
    // ============================================================

    public function MacroContentHammer__registerPlugins(){
		// register js
		wp_enqueue_media();
		$scripts = array();

		$scripts[] = array(
			'handle'	=> 'macroContentHammer',
			'src'		=> MCH_URL . '/front/js/MacroContentHammer.js',
			'deps'		=> array('jquery')
		);

		foreach( $scripts as $script )
		{
			wp_enqueue_script( $script['handle'], $script['src'], $script['deps'] );
		}
    }

    // ============================================================
    // Register CSS Styles
    // ============================================================

    public function MacroContentHammer__registerStyles(){
		// register styles
		$styles = array();
		
		$styles[] = array(
			'handle'	=> 'macroContentHammer',
			'src'		=> MCH_URL . '/front/css/MacroContentHammer.css'
		);
		
		foreach( $styles as $style )
		{
			wp_enqueue_style( $style['handle'], $style['src'] );
		}
    }

    // ============================================================
    // Register Ajax
    // ============================================================

    public function MacroContentHammer__registerAjax(){

		add_action("wp_ajax_MacroContentHammer__getNewMacro", "MacroContentHammer__getNewMacro");
		add_action("wp_ajax_nopriv_MacroContentHammer__getNewMacro", "MacroContentHammer__getNewMacro");

		add_action("wp_ajax_MacroContentHammer__getTotalMchPost", "MacroContentHammer__getTotalMchPost");
		add_action("wp_ajax_nopriv_MacroContentHammer__getTotalMchPost", "MacroContentHammer__getTotalMchPost");

    }

    // ============================================================
    // Load Templates
    // ============================================================

    public function MacroContentHammer__registerTemplates(){

		// use file data to get name and template
		$folder = get_template_directory() . '/' . MCH_FOLDER;
		$listFiles = scandir( $folder );

		$defaultHeader = array(
			'TemplateName' => 'Template Name', 
			'Structure' => 'Structure', 
			'Description' => 'Description'
		);

		foreach ($listFiles as &$value) {
			$file_parts = pathinfo( $value );


			if( $file_parts['extension'] === "php" ){

				$default = get_file_data( $folder . '/' . $value,  $defaultHeader );

				$tJson = array(					
					'name'			=> 		$default[ 'TemplateName' ], 
					'description'	=> 		$default[ 'Description' ],
					'structure'		=> 		$default[ 'Structure' ]
				);

				// echo json_encode( $tJson );
				$this->templates[] = json_encode( $tJson );

			}

		}
		 
    	return $this->templates;

    }

    public function MacroContentHammer__templateCountElement( $tmpl ){

    	// INUSED

		$folder = get_template_directory() . '/' . MCH_FOLDER;

		$default = get_file_data( $folder . '/' . $tmpl .'.php',  $defaultHeader );

		$structure = explode(',', $default[ 'Structure' ]);

		return count( $structure );

    }


    // ============================================================
    // Init MCH
    // ============================================================

    public function init(){

    	// add register plugins
    	$this->MacroContentHammer__registerPlugins();
    	$this->MacroContentHammer__registerStyles();
    	$this->MacroContentHammer__registerAjax();

    	// add content (button)
        $interface = new MacroContentHammer__interface();

        // init database
        $database = new MacroContentHammer__database();

    }

}


function MacroContentHammer__CanTouchThis()
{
	global $cantouchthis;
	
	if( !isset($cantouchthis) )
	{
		$cantouchthis = new MacroContentHammer__Plugin();
	}
	
	return $cantouchthis;
}


// initialize
$cantouchthis = MacroContentHammer__CanTouchThis();


// function prfx_meta_save( $post_id ) {
 
//     // Checks save status
//     $is_autosave = wp_is_post_autosave( $post_id );
//     $is_revision = wp_is_post_revision( $post_id );
//     $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
//     // Exits script depending on save status
//     if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
//         return;
//     }
 
//     // Checks for input and sanitizes/saves if needed
//     if( isset( $_POST[ 'meta-text' ] ) ) {

//     	print_r($_POST);
//         // update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
//     }
 
// }
// add_action( 'save_post', 'prfx_meta_save' );
// add_action( 'edit_post', 'prfx_meta_save' );

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

	// /*
	//  * We need to verify this came from our screen and with proper authorization,
	//  * because the save_post action can be triggered at other times.
	//  */

	// // Check if our nonce is set.
	// if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
	// 	return;
	// }

	// // Verify that the nonce is valid.
	// if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
	// 	return;
	// }

	// // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	// if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	// 	return;
	// }

	// // Check the user's permissions.
	// if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

	// 	if ( ! current_user_can( 'edit_page', $post_id ) ) {
	// 		return;
	// 	}

	// } else {

	// 	if ( ! current_user_can( 'edit_post', $post_id ) ) {
	// 		return;
	// 	}
	// }

	// /* OK, it's safe for us to save the data now. */
	
	// // Make sure that it is set.
	// if ( ! isset( $_POST['myplugin_new_field'] ) ) {
	// 	return;
	// }

	// // Sanitize user input.
	// $my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

	// // Update the meta field in the database.
	$content = wpautop( $_POST['mch__editor__1'], $br = 1 );
	update_post_meta( $post_id, '_my_meta_value_key', $content );
}