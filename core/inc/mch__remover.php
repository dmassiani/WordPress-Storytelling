<?php

// ******************************************************
//
// Remover des contenus
//
// ******************************************************

class MacroContentHammer__remover extends MacroContentHammer__kickstarter
{


    public $elements;

	public function Macrocontenthammer__remove__elements() {


		if( !empty( $this->elements ) ){

			$elements = explode( ',', trim(urldecode($this->elements)) );
			log_it($elements);

			foreach ($elements as $key => $element) {
				wp_delete_post( $element );
			}

			echo 'done';

		}// fin d'empty

	}

}