<?php
class MacroContentHammer__editors extends MacroContentHammer__kickstarter
{

	public function getNewContent( $tmpl__name, $structure, $n__element ){

		// on récupère la liste des contenus et on génére un nouveau MCH post

		$nEditeur = $n__element+1;

		$db = new MacroContentHammer__database();
		$nPost = $db->total__mch__content();


		$structureArray = explode(',', urldecode($structure) );

		?>
		<div id="postbox-container-1<?=$nEditeur?>" class="postbox-container">
			
	        <div id="mch__container--template--<?=$nEditeur?>" class="meta-box-sortables ui-sortable">
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

					foreach ($structureArray as $element) {

						$idNewEditor = $nEditeur + $nPost;
						$new__editor = "mch__editor__" . $idNewEditor;	
						

						if( trim($element) === 'content' ){

							$this->getNewEditor( $new__editor, $tmpl__name, '' );

						}

						if( trim($element) === 'image' ){

							$this->getNewImage( $new__editor, $tmpl__name, '' );

						}

						$nEditeur++;

					}

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

    		<div class="mch__editeur--container">
			<input type="hidden" name="mch__post__[]" value="<?=$name?>">
			<input type="hidden" name="mch__template__[]" value="<?=$tmpl__name?>">

    		<?php

				ob_start();
        		wp_editor( $content, $name );
                echo ob_get_clean();

            ?>

            </div>

            <?php
 
    }

    public function getNewImage( $name, $tmpl__name, $content ){

    	?>
    		<div class="mch__image--container">
    			<input type="hidden" name="mch__post__[]" value="<?=$name?>">
    			<input type="hidden" name="mch__template__[]" value="<?=$tmpl__name?>">
		    	<input id="<?=$name?>" class="upload_image_button button" type="button" value="Upload Image" />
    		</div>
    	<?php

    }


}