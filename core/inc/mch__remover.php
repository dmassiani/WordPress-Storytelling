<?php

// ******************************************************
//
// Remover des contenus
//
// ******************************************************

class MacroContentHammer__remover
{


    public $elements;
    public $parent;
    public $meta__elements;

	public function Macrocontenthammer__remove__elements() {


		if( !empty( $this->elements ) ){

			$elements = explode( ',', trim(urldecode($this->elements)) );
			// log_it($elements);

			foreach ($elements as $key => $element) {
				wp_delete_post( $element );
			}

			// !! il va falloir refaire le meta du post !!
			$this->meta__elements;
			$this->Macrocontenthammer__update__parentMeta();

			echo 'done';

		}// fin d'empty

	}

	public function Macrocontenthammer__update__parentMeta(){

		$post__id = $this->parent;
		// on retrouve la meta pour le post
		$metas = get_post_meta( $post__id, '_mch_content', true );
		$elements = explode( ',', trim(urldecode($this->elements)) );

		// log_it($metas);

		// pour chaque metabox
		foreach ($metas as $key_metabox => $metabox):

			$contents = $metabox['content'];
			$log__key = $key_metabox;

			// on retrouve la partie contenu :
			// log_it($contents);

			// pour chaque contenu :
			foreach ($contents as $key_content => $content):
				// si l'id est égale à un content('id)')

				// log_it( $content );

			
				foreach ($elements as $key_element => $id):

					if( (int) $id === (int) $content['ID'] ){
						// log_it('we have a winner , found ' . $id . ' = ' . $content['ID'] . ' : key remover = '. $log__key);
						$remover__key = $log__key;
					}

				endforeach;


			endforeach;
		endforeach;

		// log_it($remover__key);
		unset($metas[$remover__key]);
		// on update les metas
		update_post_meta( $post__id, '_mch_content', $metas );

		// log_it($metas);

		echo 'done';
	}

}