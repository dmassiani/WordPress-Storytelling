<?php
class MacroContentHammer__getEditor
{

    public function __construct()
    {
    	$content = '';
		ob_start();
        wp_editor( $content, 'mysecondeditor' );
		echo ob_get_clean();
    }

}