<?php
class MacroContentHammer__getEditor
{

    public function __construct()
    {
    	$content = '';
		ob_start();
		$settings = array( 'tinymce' => true );
        wp_editor( $content, 'mysecondeditor', $settings );
		echo ob_get_clean();
    }

}