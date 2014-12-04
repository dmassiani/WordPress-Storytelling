<?php

// total__mch__content

// ===================================================================
// fonction qui retourne le nombre de post mch__content
// ===================================================================

function MacroContentHammer__getTotalMchPost(){

	// getNewContent( $editor__name, $tmpl__name );
    $db = new MacroContentHammer__database();
    // $editeur->getNewEditor( $editor__name );
    echo $db->total__mch__content();

}


// ===================================================================
// fonction qui retourne l'editeur wordpress !
// ===================================================================

function MacroContentHammer__getNewMacro(){

	$tmpl__name = $_POST['tmpl'];
	$structure = $_POST['structure'];
	$n__element = $_POST['n__element'];

    $editeur = new MacroContentHammer__getEditor();
    // $editeur->getNewEditor( $editor__name );
    $editeur->getNewContent( $tmpl__name, $structure, $n__element );

}
