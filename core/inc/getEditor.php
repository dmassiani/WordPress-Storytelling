<?php
class MacroContentHammer__getEditor
{
    public function __construct()
    {
    	$content = '';
        echo wp_editor( $content, 'mysecondeditor' );
    }

}