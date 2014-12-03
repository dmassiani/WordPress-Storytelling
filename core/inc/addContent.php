<?php
class MacroContentHammer__addButton
{
    public function __construct()
    {
        add_action( 'edit_page_form', array($this, 'init') );
    }

    public function init()
    {
    	// $content = '';
        // wp_editor( $content, 'mysecondeditor' );

    	// add a button
    	$this->addButton();

    }

    public function addButton(){
 
    	printf( '<div class="macro-content-hammer" id="mch__init"> <a href="#" class="button button-primary button-large">%s</a> </div>', esc_html__( 'Add Macro Content', 'plugin_domain' ) );
 
    }

}