<?php


// ******************************************************
//
// Génération des éditeurs par ajax
//
// ******************************************************


class MacroContentHammer__editors extends MacroContentHammer__kickstarter
{

	public $metabox__id = 1000;
	public $element__id = 1;

	// ID est uniquement défini lors d'une mise à jour du champ
	public $ID;

    public $template;
    public $structure;
    public $n__element;
    public $n__metabox;
    public $name;
    public $content;
    public $type;
    public $update = false;

	public function getNewContent(){

		// on récupère la liste des contenus et on génére un nouveau MCH post

		$this->metabox__id = $this->metabox__id * ( $this->n__metabox + 1 );

		$structureArray = explode(',', urldecode($this->structure) );

		?>
		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container mch-container">
			
	        <div id="mch__container--template--<?=$this->metabox__id?>" class="meta-box-sortables ui-sortable">
	            <div id="mch__rapper--macro" class="postbox mch closed">
	                <div class="handlediv mch" title="Cliquer pour inverser."><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	Macro Template : <?=$this->template?>
	                    </span>
	                </h3>
	                <div class="inside">

					<?php

					wp_nonce_field( 'mch__editor', 'macrocontenthammer__nonce' );

					foreach ($structureArray as $key => $element) {

						$this->element__id = $this->metabox__id + ( $key + 1 );
						$new__editor = "mch__editor__" . $this->element__id;	
						$this->name = $new__editor;

						if( trim($element) === 'content' ){

							$this->getNewEditor();

						}

						if( trim($element) === 'image' ){

							$this->getNewImage();

						}

					}

					?>

	                </div>
	            </div>
	        </div>
        </div>
		<?php

	}

	public function openMetabox( $n__metabox ){
		$first = '';
		if( $n__metabox === 0 )$first = ' mch-first';
		$this->metabox__id = $this->metabox__id * ( $n__metabox + 1 );
		?>


		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container mch-container<?=$first?>">
			
	        <div id="mch__container--template--<?=$this->metabox__id?>" class="meta-box-sortables ui-sortable">
	            <div id="mch__rapper--macro" class="postbox mch closed">
	                <div class="handlediv" title="Cliquer pour inverser."><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	Macro Template : <?=$this->template?>
	                    </span>
	                </h3>
	                <div class="inside">

					<?php

					wp_nonce_field( 'mch__editor', 'macrocontenthammer__nonce' );
	}

	public function closeMetabox(){
		?>
	                </div>
	            </div>
	        </div>
        </div>
        <?php
	}

	public function openElement(){
		?>
    		<div class="mch__element mch__element__<?=$this->type?>">
				<input type="hidden" name="mch__post__[]" value="<?=$this->name?>">
				<input type="hidden" name="mch__template__[]" value="<?=$this->template?>">
				<input type="hidden" name="mch__type__[]" value="<?=$this->type?>">
	    		<input type="hidden" name="metabox__id[]" value="<?=$this->metabox__id?>">

	    	<?php
	    	// pour une mise à jour du champ
	    	if( $this->update === true ){
	    		?>
	    		<input type="hidden" name="mch__ID[]" value="<?=$this->ID?>" />
	    		<?php
	    	}

	}
	public function closeElement(){
		?>
		</div>
		<?php
	}

    public function getNewEditor()
    {
    	$this->type = 'editeur';
    	$this->openElement();

		ob_start();
		wp_editor( $this->content, $this->name );
        echo ob_get_clean();

        $this->closeElement();
 
    }

    public function getNewImage(){

    	$this->type = 'image';
    	$this->openElement();
    	?>
		<input id="<?=$this->name?>" class="upload_image_button button" type="button" value="Upload Image" />
		<?php
		$this->closeElement();
 
    }


}