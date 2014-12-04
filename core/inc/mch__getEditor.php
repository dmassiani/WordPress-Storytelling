<?php
class MacroContentHammer__getEditor extends MacroContentHammer__Plugin
{

	public function getNewContent( $tmpl__name, $structure, $n__element ){

		// on récupère la liste des contenus et on génére un nouveau MCH post

		$nEditeur = $n__element+1;

		$db = new MacroContentHammer__database();
		$nPost = $db->total__mch__content();


		$structureArray = explode(',', urldecode($structure) );

		?>
        <div id="mch__container--template--<?=$nEditeur?>" class="meta-box-sortables ui-sortable">
            <div id="mch__rapper--macro" class="postbox mch">
                <div class="handlediv mch" title="Cliquer pour inverser."><br></div>
                <h3 class="hndle">
                    <span>
                    	Macro Template : <?=$tmpl__name?>
                    </span>
                </h3>
                <div class="inside">

				<?php

				wp_nonce_field( basename( __FILE__ ), 'mch_nonce' );

				foreach ($structureArray as $element) {

					$idNewEditor = $nEditeur + $nPost;
					$new__editor = "mch__editor__" . $idNewEditor;	
					

					if( trim($element) === 'content' ){

						$this->getNewEditor( $new__editor );

					}

					if( trim($element) === 'image' ){

						$this->getNewImage( $new__editor );

					}

					$nEditeur++;

				}

				?>

                </div>
            </div>
        </div>
		<?php

	}

    public function getNewEditor( $name )
    {

    	$content = '';

    		?>

    		<div class="mch__editeur--container">

    		<?php

				ob_start();
        		wp_editor( $content, $name );
                echo ob_get_clean();

            ?>

            </div>

            <?php
 
    }

    public function getNewImage( $name ){

    	?>
    		<div class="mch__image--container">
		    	<input id="<?=$name?>" class="upload_image_button button" type="button" value="Upload Image" />
    		</div>
    	<?php

    }


}