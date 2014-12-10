<?php
/**
 * @package Macro Content Hammer
 */
/*
Plugin Name: Story Telling
Plugin URI: http://storytelling.io/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from comment and trackback spam</strong>. It keeps your site protected from spam even while you sleep. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="http://akismet.com/get/">Sign up for an Akismet API key</a>, and 3) Go to your Akismet configuration page, and save your API key.
Version: 1.0
Author: David Massiani
Author URI: http://davidmassiani.com
License: GPLv2 or later
Text Domain: macrocontenthammer
*/

// Folder name
define ( 'MCH_VERSION', '1.0' );
define ( 'MCH_OPTION',  'simple-taxonomy' );
define ( 'MCH_FOLDER',  'micro-templates' );

define ( 'MCH_URL', plugins_url('', __FILE__) );
define ( 'MCH_DIR', dirname(__FILE__) );


if(!function_exists('log_it')){
 function log_it( $message ) {
   if( WP_DEBUG === true ){
     if( is_array( $message ) || is_object( $message ) ){
       error_log( print_r( $message, true ) );
     } else {
       error_log( $message );
     }
   }
 }
}


if( !class_exists('MacroContentHammer__kickstarter') ):

class MacroContentHammer__kickstarter
{

	public $templates = [];
	
    public $mch__ajax;
    public $mch__metabox;
    public $mch__database;
    public $mch__post;
    public $mch__edit;
    public $mch__structure;
    public $mch__utility;

	public $name = "MCH__content";

	public function __construct(){

		load_textdomain('macrocontenthammmer', MCH_DIR . 'lang/mch-' . get_locale() . '.mo');

		add_action('init', array($this, 'init'), 1);

	}

    public function init(){

		register_post_type( $this->name ,
			array(
				'labels' => array(
				'name' => __( $this->name ),
				'singular_name' => __( $this->name )
			),
			'public' => false,
			'has_archive' => false,
			)
		);
		
	    remove_post_type_support( $this->name, 'title' );

    	// log_it('init');

    	$this->MacroContentHammer__include__front__class();
    	$this->mch__content = new MacroContentHammer__content();

    	if ( is_admin() ) {

    		$this->MacroContentHammer__include__admin__class();

    	// ===================================================
    	// 
    	// add register plugins and styles
    	// 
    	// ===================================================

    		$this->MacroContentHammer__register__plugins();
    		$this->MacroContentHammer__register__styles();

    	// =================================================
    	//
    	// instanciation
    	//
    	// =================================================


    		// init ajax
        	$this->mch__ajax = new MacroContentHammer__ajax();
	    	// init metabox selector
	        $this->mch__metabox = new MacroContentHammer__metabox();
	        // init database
	        $this->mch__database = new MacroContentHammer__database();
	        // init post
	        $this->mch__post = new MacroContentHammer__post();
	        // init edit
	        $this->mch__edit = new MacroContentHammer__edit();
	        // init structure
	        $this->mch__structure = new MacroContentHammer__structure();
	        // init structure
	        $this->mch__utility = new MacroContentHammer__utility();

	       	add_action( 'save_post', array( $this->mch__post, 'Macrocontenthammer__savedata' ) );

	    }

    }

    public function MacroContentHammer__include__admin__class(){
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__database.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__metabox.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__editors.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__ajax.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__post.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__edit.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__remover.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__structure.php';
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__utility.php';
    }
    public function MacroContentHammer__include__front__class(){
		include_once plugin_dir_path(__FILE__). '/core/inc/mch__content.php';
    }


    // ============================================================
    // Register JS plugins
    // ============================================================

    public function MacroContentHammer__register__plugins(){
		// register javascript 
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

    public function MacroContentHammer__register__styles(){
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

}
function macrocontenthammer()
{
	global $macrocontenthammer;
	
	if( !isset($macrocontenthammer) )
	{
		$macrocontenthammer = new MacroContentHammer__kickstarter();
	}
	
	return $macrocontenthammer;
}


// initialize
macrocontenthammer();


endif; // class_exists check