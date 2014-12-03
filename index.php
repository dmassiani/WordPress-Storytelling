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
	load_plugin_textdomain ( 'macro-content-hammer', false, basename(rtrim(dirname(__FILE__), '/')) . '/core/languages' );
}

class MacroContentHammer__Plugin
{
    public function __construct()
    {

        include_once MCH_DIR . '/core/inc/addContent.php';
        include_once MCH_DIR . '/core/inc/getEditor.php';

		add_action('init', array($this, 'init'), 1);
    }

    public function MacroContentHammer__registerPlugins(){
		// register acf scripts
		$scripts = array();
		$scripts[] = array(
			'handle'	=> 'macroContentHammer',
			'src'		=> MCH_URL . '/front/js/macroContentHammer.js',
			'deps'		=> array('jquery')
		);
		
		
		foreach( $scripts as $script )
		{
			wp_enqueue_script( $script['handle'], $script['src'], $script['deps'] );
		}
    }

    public function MacroContentHammer__registerAjax(){

		add_action("wp_ajax_MacroContentHammer__getNewMacro", "MacroContentHammer__getNewMacro");
		add_action("wp_ajax_nopriv_MacroContentHammer__getNewMacro", "MacroContentHammer__getNewMacro");

    }

    public function MacroContentHammer__registerTemplates(){
 /*
 * @param string $file            Path to the file.
 * @param array  $default_headers List of headers, in the format array('HeaderKey' => 'Header Name').
 * @param string $context         Optional. If specified adds filter hook "extra_{$context}_headers".
 *                                Default empty.
 */
// function get_file_data( $file, $default_headers, $context = '' ) {

 		// use file data to get name and template
		 $folder = get_template_directory() . '/' . MCH_FOLDER;
		 
		 $defaultHeader = array('TemplateName' => 'Template Name');

		 $default = get_file_data( $folder . '/' . 'default.php',  $defaultHeader );
		 print_r($default);

    }

    public function init(){

    	// add register plugins
    	$this->MacroContentHammer__registerPlugins();
    	$this->MacroContentHammer__registerAjax();
    	$this->MacroContentHammer__registerTemplates();

    	// add content (button)
        new MacroContentHammer__addButton();

    }
}

function MacroContentHammer__getNewMacro(){
    new MacroContentHammer__getEditor();
}

function MacroContentHammer__CanTouchThis()
{
	global $canttouchthis;
	
	if( !isset($canttouchthis) )
	{
		$canttouchthis = new MacroContentHammer__Plugin();
	}
	
	return $canttouchthis;
}


// initialize
MacroContentHammer__CanTouchThis();


