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
define ( 'MCH_VERSION', '1.0' );
define ( 'MCH_OPTION',  'simple-taxonomy' );
define ( 'MCH_FOLDER',  'micro-templates' );

define ( 'MCH_URL', plugins_url('', __FILE__) );
define ( 'MCH_DIR', dirname(__FILE__) );


add_action( 'plugins_loaded', 'initMacroContentHammer' );
function initMacroContentHammer() {
	global $MCHammer;
	// Load translations
	load_plugin_textdomain ( 'macro-content-hammer', false, basename(rtrim(dirname(__FILE__), '/')) . '/core/languages' );
}



class MacroContentHammer__kickstarter
{

	// =============================================
	// templates is for register all templates available
	// =============================================

	public $templates = [];
	
    public $mch__ajax;
    public $mch__metabox;
    public $mch__database;
    public $mch__post;
    public $mch__edit;


	// ==================================================
	// include all php needed
	// ==================================================

    public function __construct()
    {


        include_once MCH_DIR . '/core/inc/mch__database.php';
        include_once MCH_DIR . '/core/inc/mch__metabox.php';
        include_once MCH_DIR . '/core/inc/mch__editors.php';
        include_once MCH_DIR . '/core/inc/mch__ajax.php';
        include_once MCH_DIR . '/core/inc/mch__post.php';
        include_once MCH_DIR . '/core/inc/mch__edit.php';

		add_action('init', array($this, 'init'), 1);
		
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

    // ============================================================
    // Load Templates
    // ============================================================

    public function MacroContentHammer__register__templates(){

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

				$this->templates[] = json_encode( $tJson );

			}

		}
		 
    	return $this->templates;

    }

    public function MacroContentHammer__get__template__structure( $name ){
    	$folder = get_template_directory() . '/' . MCH_FOLDER;
		$defaultHeader = array(
			'TemplateName' => 'Template Name', 
			'Structure' => 'Structure', 
			'Description' => 'Description'
		);
    	$default = get_file_data( $folder . '/' . $name  . '.php',  $defaultHeader );
    	return $default[ 'Structure' ];
    }


    // ============================================================
    // Init MCH
    // ============================================================

    public function init(){


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

    }

}


function MacroContentHammer__CanTouchThis()
{
	global $cantouchthis;
	
	if( !isset($cantouchthis) )
	{
		$cantouchthis = new MacroContentHammer__kickstarter();
	}
	
	return $cantouchthis;
}


// initialize
$cantouchthis = MacroContentHammer__CanTouchThis();     