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

	public function getNewContent( $tmpl__name, $structure, $n__element, $n__metabox ){

		// on récupère la liste des contenus et on génére un nouveau MCH post

		$this->metabox__id = $this->metabox__id * ( $n__metabox + 1 );

		// $db = new MacroContentHammer__database();
		// $nPost = $db->total__mch__content();


		$structureArray = explode(',', urldecode($structure) );

		?>
		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container mch-container">
			
	        <div id="mch__container--template--<?=$this->metabox__id?>" class="meta-box-sortables ui-sortable">
	            <div id="mch__rapper--macro" class="postbox mch closed">
	                <div class="handlediv mch" title="Cliquer pour inverser."><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	Macro Template : <?=$tmpl__name?>
	                    </span>
	                </h3>
	                <div class="inside">

					<?php

					wp_nonce_field( 'mch__editor', 'macrocontenthammer__nonce' );

					foreach ($structureArray as $key => $element) {

						$this->element__id = $this->metabox__id + ( $key + 1 );
						$new__editor = "mch__editor__" . $this->element__id;	
						

						if( trim($element) === 'content' ){

							$this->getNewEditor( $new__editor, $tmpl__name, '' );

						}

						if( trim($element) === 'image' ){

							$this->getNewImage( $new__editor, $tmpl__name, '' );

						}

					}

					?>

	                </div>
	            </div>
	        </div>
        </div>
		<?php

	}

	public function openMetabox( $tmpl__name, $n__metabox ){
		$first = '';
		if( $n__metabox === 1000 )$first = ' mch-first';
		$this->metabox__id = $this->metabox__id * ( $n__metabox + 1 );
		?>


		<div id="postbox-container-<?=$this->metabox__id?>" class="postbox-container mch-container<?=$first?>">
			
	        <div id="mch__container--template--<?=$this->metabox__id?>" class="meta-box-sortables ui-sortable">
	            <div id="mch__rapper--macro" class="postbox mch closed">
	                <div class="handlediv" title="Cliquer pour inverser."><br></div>
	                <h3 class="hndle">
	                    <span>
	                    	Macro Template : <?=$tmpl__name?>
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

    public function getNewEditor( $name, $tmpl__name, $content )
    {


    		?>

    		<div class="mch__editeur--container mch__element">
				<input type="hidden" name="mch__post__[]" value="<?=$name?>">
				<input type="hidden" name="mch__template__[]" value="<?=$tmpl__name?>">
				<input type="hidden" name="mch__type__[]" value="content">
	    		<input type="hidden" name="metabox__id[]" value="<?=$this->metabox__id?>">

    		<?php
    		// print_r($name);
				ob_start();
        		wp_editor( $content, $name );
                echo ob_get_clean();

            ?>

            </div>

            <?php
 
    }

    public function getNewImage( $name, $tmpl__name, $content ){

    	?>
    		<div class="mch__image--container mch__element">
    			<input type="hidden" name="mch__post__[]" value="<?=$name?>">
    			<input type="hidden" name="mch__template__[]" value="<?=$tmpl__name?>">
    			<input type="hidden" name="mch__type__[]" value="image">
    			<input type="hidden" name="metabox__id[]" value="<?=$this->metabox__id?>">

		    	<input id="<?=$name?>" class="upload_image_button button" type="button" value="Upload Image" />
    		</div>
    	<?php

    }


}