<?php


// ******************************************************
//
// Génération des éditeurs par ajax
//
// ******************************************************


class MacroContentHammer__editors
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
    public $images__id;
    public $elementsRemove;
    public $postID;

	public function getNewContent(){

		// on récupère la liste des contenus et on génére un nouveau MCH post

		log_it('metabox ' . $this->n__metabox);
		if( $this->n__metabox != 0 )$this->update = true;

		$this->metabox__id = $this->metabox__id * ( $this->n__metabox + 1 );

		$structureArray = explode(',', urldecode($this->structure) );

		?>
		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container mch-container">
			
	        <div id="mch__container--template--<?=$this->metabox__id?>" class="meta-box-sortables">
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

						if( trim($element) === 'editeur' ){

							$this->getNewEditor();

						}

						if( trim($element) === 'image' ){

							$this->getNewImage();

						}

					}

		$this->closeMetabox();

	}

	public function openMetabox( $n__metabox ){
		$first = '';
		if( $n__metabox === 0 )$first = ' mch-first';
		$this->metabox__id = 1000 * ( $n__metabox + 1 );
		// log_it($this->metabox__id);
		// log_it($n__metabox);
		?>


		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container mch-container<?=$first?>">
			
	        <div id="mch__container--template--<?=$this->metabox__id?>" class="meta-box-sortables">
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
		            	<div class="mch__remove__element" data-elements="<?=$this->elementsRemove?>">
		            		<ul>
		            			<li class="remover"><a href="#" class="submitdelete deletion"><?=_e('Remove')?></a></li>
		            			<li class="confirm">
		            				<?=_e('Are you sur?')?>
		            				<a href="#" class="delete"><?=_e('Yes')?></a>
		            				<a href="#" class="cancel"><?=_e('No')?></a>
		            			</li>
		            		</ul>
		            	</div>
		            	<div class="clear"></div>
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
				<input type="hidden" name="mch__image__id[]" class="mch__image__id" value="<?=$this->images__id?>" />

	    	<?php
	    	// pour une mise à jour du champ
	    	if( $this->update === true ){
	    		?>
	    		<input type="hidden" name="mch__ID[]" value="<?=$this->ID?>" />
	    		<?php
	    	}else{
	    		?>
	    		<input type="hidden" name="mch__ID[]" />
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
    	$showRemover = '';
    	$hideUploader = '';
    	$this->openElement();

    	if( !empty( $this->content ) && is_numeric( $this->content ) ){
    		$showRemover = ' show';
    		$hideUploader = ' hide';
    		echo wp_get_attachment_image( $this->content, 'medium' );
    	}

    	?>
		<input data-upload_image="<?=_e('Meta content Image')?>" data-upload_image_button="<?=_e('Select Image')?>" id="<?=$this->name?>" class="upload_image_button button<?=$hideUploader?>" type="button" value="Upload Image" />
		<div>
			<a href="#" class="mch__imageRemover<?=$showRemover?>"><?php _e( 'Remove Image', 'macrocontenthammer' ) ?></a>
		</div>
		<?php
		$this->closeElement();
 
    }


}