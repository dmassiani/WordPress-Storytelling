<?php

// ******************************************************
//
// Remover des contenus
//
// ******************************************************

class MacroContentHammer__structure
{

    // ============================================================
    // Load Templates
    // ============================================================

    public function MacroContentHammer__register__templates(){

		// use file data to get name and template
		$folder = get_template_directory() . '/' . MCH_FOLDER;
		$listFiles = scandir( $folder );

		$defaultHeader = array(
			'TemplateName' => 'Template Name', 
			'Structure' => 'Structure', 
			'Description' => 'Description'
		);

		foreach ($listFiles as &$value) {
			$file_parts = pathinfo( $value );


			if( $file_parts['extension'] === "php" ){

				$utility = new MacroContentHammer__utility();
				$default = get_file_data( $folder . '/' . $value,  $defaultHeader );
				$jsons 	 = $utility->get_file_data( $folder . '/' . $value,  $defaultHeader );

				// log_it( $jsons[0]->element );
				// var_dump($jsons);

				$elements = [];
				foreach( $jsons as $key => $json ):

						$elements[] = json_decode($json);

				endforeach;


				$tJson = array(					
					'name'			=> 		$default[ 'TemplateName' ], 
					'description'	=> 		$default[ 'Description' ],
					'elements' 		=> 		$elements
				);


				$this->templates[] = json_encode( $tJson );

			}

		}
		 
    	return $this->templates;

    }

    public function MacroContentHammer__get__template__structure( $name ){
    	$folder = get_template_directory() . '/' . MCH_FOLDER;
		$defaultHeader = array(
			'TemplateName' => 'Template Name', 
			'Structure' => 'Structure', 
			'Description' => 'Description'
		);
    	$default = get_file_data( $folder . '/' . $name  . '.php',  $defaultHeader );
    	return $default[ 'Structure' ];
    }

}