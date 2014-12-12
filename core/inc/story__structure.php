<?php

// ******************************************************
//
// Remover des contenus
//
// ******************************************************

class Storytelling__structure extends Storytelling__kickstarter
{

	public function __construct(){


	}

    // ============================================================
    // Load Templates
    // ============================================================

    public function Storytelling__register__templates(){

		// use file data to get name and template
		$folder = get_template_directory() . '/' . STORY_FOLDER;
		$listFiles = scandir( $folder );

		$defaultHeader = array(
			'TemplateName' => 'Template Name', 
			'Description' => 'Description'
		);

		foreach ($listFiles as &$value) {
			$file_parts = pathinfo( $value );


			if( $file_parts['extension'] === "php" ){

				$utility = new Storytelling__utility();
				$default = get_file_data( $folder . '/' . $value,  $defaultHeader );
				$jsons 	 = $utility->get_file_data( $folder . '/' . $value,  $defaultHeader );

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

    public function Storytelling__realTemplates(){

    	$templates = $this->Storytelling__register__templates();
        
        $elements = [];

        foreach ($templates as $template):
        	// pour chaque macro template

            $template = json_decode($template);

        	$name = sanitize_title( $template->name );
        	$elements[ $name ] = (array) $template->elements;


        endforeach;

        return $elements;
        // Parent::mch__templates = $elements;

    }

    public function Storytelling__get__template__structure( $name ){
    	$folder = get_template_directory() . '/' . STORY_FOLDER;
		$defaultHeader = array(
			'TemplateName' => 'Template Name',  
			'Description' => 'Description'
		);
    	$default = get_file_data( $folder . '/' . $name  . '.php',  $defaultHeader );
    	return $default[ 'Structure' ];
    }

}