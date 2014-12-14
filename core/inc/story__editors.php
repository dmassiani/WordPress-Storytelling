<?php


// ******************************************************
//
// Génération des éditeurs par ajax
//
// ******************************************************


class Storytelling__editors
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
    public $container__id;
    public $content;
    public $type;
    public $slug;
    public $file;
    public $update = false;
    public $images__id;
    public $elementsRemove;
    public $postID;

	public function getNewBox(){

		// on doit pouvoir générer une metabox à partir du nom du fichier

		// on récupère la liste des contenus et on génére un nouveau story post

		// log_it('metabox ' . $this->n__metabox);
		if( $this->n__metabox != 0 )$this->update = true;

		$this->metabox__id = $this->metabox__id * ( $this->n__metabox + 1 );

		// ici on doit récupérer la structure et les slugs !

		// CURRENT TODO : créer un récupérateur de structure et un récupérateur de slug à partir du nom du fichier
		$story__structure = new Storytelling__Structure();


		$structureArray = $story__structure->Storytelling__getFileStructure( $this->file );
		$slugsArray = $story__structure->Storytelling__getFileSlugs( $this->file );
		$this->template = $story__structure->Storytelling__getFileTemplate( $this->file );

		// $structureArray = explode(',', urldecode($this->structure) );
		// $slugsArray = explode(',', urldecode($this->slugs) );

		?>
		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container story-container">
			
	        <div id="story__container--template--<?=$this->metabox__id?>" class="meta-box-sortables">
	            <div id="story__rapper--macro" class="postbox story closed">
	                <div class="handlediv story" title="<?php _e('Clic for invert') ?>"><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	<?php _e('Story Telling') ?> : <?=$this->template?>
	                    </span>
	                </h3>
	                <div class="inside">

					<?php
					
					wp_nonce_field( 'story__editor', 'storytelling__nonce' );

					foreach ($structureArray as $key => $element) {

						$this->element__id = $this->metabox__id + ( $key + 1 );
						$new__editor = "story__editor__" . $this->element__id;	
						$this->container__id = $new__editor;
						$this->slug = $slugsArray[ $key ];

						if( trim($element) === 'editor' ){
							// 

							$this->getNewEditor();

						}

						if( trim($element) === 'image' ){

							$this->getNewImage();

						}

					}

		$this->closeMetabox();

	}

	public function getNewContent(){

		// on doit pouvoir générer une metabox à partir du nom du fichier

		// on récupère la liste des contenus et on génére un nouveau story post

		// log_it('metabox ' . $this->n__metabox);
		if( $this->n__metabox != 0 )$this->update = true;

		$this->metabox__id = $this->metabox__id * ( $this->n__metabox + 1 );

		$structureArray = explode(',', urldecode($this->structure) );
		$slugsArray = explode(',', urldecode($this->slugs) );

		?>
		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container story-container">
			
	        <div id="story__container--template--<?=$this->metabox__id?>" class="meta-box-sortables">
	            <div id="story__rapper--macro" class="postbox story closed">
	                <div class="handlediv story" title="<?php _e('Clic for invert') ?>"><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	<?php _e('Story Telling') ?> : <?=$this->template?>
	                    </span>
	                </h3>
	                <div class="inside">

					<?php
					
					wp_nonce_field( 'story__editor', 'macrocontenthammer__nonce' );

					foreach ($structureArray as $key => $element) {

						$this->element__id = $this->metabox__id + ( $key + 1 );
						$new__editor = "story__editor__" . $this->element__id;	
						$this->container__id = $new__editor;
						$this->slug = $slugsArray[ $key ];

						if( trim($element) === 'editor' ){
							// 

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
		if( $n__metabox === 0 )$first = ' story-first';
		$this->metabox__id = 1000 * ( $n__metabox + 1 );

		?>


		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container story-container<?=$first?>">
			
	        <div id="story__container--template--<?=$this->metabox__id?>" class="meta-box-sortables">
	            <div id="story__rapper--macro" class="postbox story closed">
	                <div class="handlediv" title="<?php _e('Clic for invert') ?>"><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	<?php _e('Story Telling') ?> : <?=$this->template?>
	                    </span>
	                </h3>
	                <div class="inside">
					<?php
					wp_nonce_field( 'story__editor', 'storytelling__nonce' );
	}



	public function closeMetabox(){
		?>
		            	<div class="story__remove__element" data-elements="<?=$this->elementsRemove?>">
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
    		<div class="story__element story__element__<?=$this->type?>">

				<input type="hidden" name="story__post__[]" value="<?=$this->container__id?>">
				<input type="hidden" name="story__template__[]" value="<?=$this->template?>">
				<input type="hidden" name="story__file__[]" value="<?=$this->file?>">
				<input type="hidden" name="story__type__[]" value="<?=$this->type?>">
				<input type="hidden" name="story__slug__[]" value="<?=$this->slug?>">
	    		<input type="hidden" name="metabox__id[]" value="<?=$this->metabox__id?>">
				<input type="hidden" name="story__image__id[]" class="story__image__id" value="<?=$this->images__id?>" />

	    	<?php
	    	// pour une mise à jour du champ
	    	if( $this->update === true ){
	    		?>
	    		<input type="hidden" name="story__ID[]" value="<?=$this->ID?>" />
	    		<?php
	    	}else{
	    		?>
	    		<input type="hidden" name="story__ID[]" />
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
    	$this->type = 'editor';
    	$this->openElement();

		ob_start();
		wp_editor( $this->content, $this->container__id );
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
		<input data-upload_image="<?=_e('Meta content Image')?>" data-upload_image_button="<?=_e('Select Image')?>" id="<?=$this->container__id?>" class="upload_image_button button<?=$hideUploader?>" type="button" value="Upload Image" />
		<div>
			<a href="#" class="story__imageRemover<?=$showRemover?>"><?php _e( 'Remove Image', 'macrocontenthammer' ) ?></a>
		</div>
		<?php
		$this->closeElement();
 
    }


}