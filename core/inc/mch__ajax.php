<?php

// ******************************************************
//
// Register ajax
//
// ******************************************************

class MacroContentHammer__ajax
{


    // best tricks ever : die()


    public function __construct(){

        add_action("wp_ajax_MacroContentHammer__getNewMacro", array( $this, "MacroContentHammer__getNewMacro") );
        add_action("wp_ajax_nopriv_MacroContentHammer__getNewMacro", array( $this, "MacroContentHammer__getNewMacro") );

        add_action("wp_ajax_MacroContentHammer__deleteElements", array( $this, "MacroContentHammer__deleteElements") );
        add_action("wp_ajax_nopriv_MacroContentHammer__deleteElements", array( $this, "MacroContentHammer__deleteElements") );

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

        $editeur = new MacroContentHammer__editors();

        $editeur->template = $_POST['tmpl'];
        $editeur->structure = $_POST['structure'];
        $editeur->slugs = $_POST['slugs'];
        $editeur->n__metabox = $_POST['n__metabox'];

        $editeur->getNewContent();

        die();

    }

    // ===================================================================
    // delete all element of metabox
    // ===================================================================

    public function MacroContentHammer__deleteElements(){

        $remover = new MacroContentHammer__remover();

        $remover->elements = $_POST['elements'];
        $remover->parent = $_POST['parent'];

        $remover->Macrocontenthammer__remove__elements();

        die();

    }


}
