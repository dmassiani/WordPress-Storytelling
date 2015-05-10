<?php

// ******************************************************
//
// Register ajax
//
// ******************************************************

class Storytelling__ajax
{


    public function __construct(){

        add_action("wp_ajax_Storytelling__getNewBox", array( $this, "Storytelling__getNewBox") );
        add_action("wp_ajax_nopriv_Storytelling__getNewBox", array( $this, "Storytelling__getNewBox") );

        add_action("wp_ajax_Storytelling__deleteElements", array( $this, "Storytelling__deleteElements") );
        add_action("wp_ajax_nopriv_Storytelling__deleteElements", array( $this, "Storytelling__deleteElements") );

    }


    // ===================================================================
    // fonction qui retourne le nombre de post mch__content
    // ===================================================================

    public function Storytelling__getTotalStoryPost(){

        $db = new Storytelling__database();
        echo $db->total__story__content();
        die();

    }


    // ===================================================================
    // fonction qui retourne l'editeur wordpress !
    // ===================================================================

    public function Storytelling__getNewBox(){

        $editeur = new Storytelling__editors();

        $editeur->folder_type = $_POST['type'];
        $editeur->folder = $_POST['folder'];
        $editeur->file = $_POST['file'];
        $editeur->ajax = true;
        $editeur->n__metabox = $_POST['n__metabox'];

        $editeur->getNewBox();

        die();

    }

    // ===================================================================
    // delete all element of metabox
    // ===================================================================

    public function Storytelling__deleteElements(){

        $remover = new Storytelling__remover();

        $remover->elements = $_POST['elements'];
        $remover->parent = $_POST['parent'];

        $remover->Storytelling__remove__elements();

        die();

    }


}
