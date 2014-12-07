<?php

class MacroContentHammer__ajax extends MacroContentHammer__kickstarter
{


    // best tricks ever : die()


    public function __construct(){
        add_action("wp_ajax_MacroContentHammer__getNewMacro", array( $this, "MacroContentHammer__getNewMacro") );
        add_action("wp_ajax_nopriv_MacroContentHammer__getNewMacro", array( $this, "MacroContentHammer__getNewMacro") );
    }


    // ===================================================================
    // fonction qui retourne le nombre de post mch__content
    // ===================================================================

    public function MacroContentHammer__getTotalMchPost(){

    	// getNewContent( $editor__name, $tmpl__name );
        $db = new MacroContentHammer__database();
        // $editeur->getNewEditor( $editor__name );
        echo $db->total__mch__content();
        die();

    }


    // ===================================================================
    // fonction qui retourne l'editeur wordpress !
    // ===================================================================

    public function MacroContentHammer__getNewMacro(){

    	$tmpl__name = $_POST['tmpl'];
    	$structure = $_POST['structure'];
        $n__element = $_POST['n__element'];
    	$n__metabox = $_POST['n__metabox'];

        $editeur = new MacroContentHammer__editors();
        $editeur->getNewContent( $tmpl__name, $structure, $n__element, $n__metabox );
        die();

    }


}
