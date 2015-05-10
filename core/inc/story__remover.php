<?php

// ******************************************************
//
// Remover des contenus
//
// ******************************************************

class Storytelling__remover
{


    public $elements;
    public $parent;
    public $meta__elements;

	public function Storytelling__remove__elements() {


		if( !empty( $this->elements ) ){

			$elements = explode( ',', trim(urldecode($this->elements)) );

			foreach ($elements as $key => $element) {
				wp_delete_post( $element );
			}

			$this->meta__elements;
			$this->Storytelling__update__parentMeta();

			echo 'done';

		}// fin d'empty

	}

	public function Storytelling__update__parentMeta(){

		$post__id = $this->parent;
		// on retrouve la meta pour le post
		$metas = get_post_meta( $post__id, '_story_content', true );
		$elements = explode( ',', trim(urldecode($this->elements)) );

		// pour chaque metabox
		foreach ($metas as $key_metabox => $metabox):

			$contents = $metabox['content'];
			$log__key = $key_metabox;

			// on retrouve la partie contenu :

			// pour chaque contenu :
			foreach ($contents as $key_content => $content):
				// si l'id est égale à un content('id)')
			
				foreach ($elements as $key_element => $id):

					if( (int) $id === (int) $content['ID'] ){
						$remover__key = $log__key;
					}

				endforeach;


			endforeach;
		endforeach;

		unset($metas[$remover__key]);
		$metas = array_values($metas);
		foreach ($metas as $key_metabox => $metabox):
			$metas[$key_metabox]['container'] = ( $key_metabox + 1 ) * 1000;
		endforeach;

		// pour chaque meta on reinitialise le code metabox

		// on update les metas
		update_post_meta( $post__id, '_story_content', $metas );

		echo 'done';
	}

}