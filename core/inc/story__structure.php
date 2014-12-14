<?php

// ******************************************************
//
// Remover des contenus
//
// ******************************************************

class Storytelling__structure extends Storytelling__kickstarter
{

	public $folder;
	public $files;
	public $fileHeader = array(
		'Name' => 'Template Name', 
		'Description' => 'Description'
	);

	// class access
	public $utility;

	public function __construct(){

		$this->folder = get_template_directory() . '/' . STORY_FOLDER;
		$this->files = scandir( $this->folder );
		$this->utility = new Storytelling__utility();
		// log_it($this->files);

	}

    // ============================================================
    // Load Templates
    // ============================================================

    public function Storytelling__register__templates(){

		// use file data to get name and template

		$defaultHeader = array(
			'TemplateName' => 'Template Name', 
			'Description' => 'Description'
		);

		foreach ($this->files as &$value) {
			$file_parts = pathinfo( $value );

			// log_it($file_parts);

			if( $file_parts['extension'] === "php" ){

				$default = get_file_data( $this->folder . '/' . $value,  $this->fileHeader );
				$jsons 	 = $this->utility->get_file_data( $this->folder . '/' . $value );

				$elements = [];
				foreach( $jsons as $key => $json ):

						$elements[] = json_decode($json);

				endforeach;


				$tJson = array(					
					'name'			=> 		$default[ 'Name' ], 
					'description'	=> 		$default[ 'Description' ],
					'file' 			=>		$file_parts['basename'],
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

    }

    public function Storytelling__get__template__structure( $name ){

		foreach ($this->files as &$value) {
			$file_parts = pathinfo( $value );


			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->folder . '/' . $value );

				$elements = [];
				foreach( $jsons as $key => $json ):

						$elements[] = json_decode($json);

				endforeach;

				// $elements

				// log_it( $elements );

			}

		}
    }

    public function Storytelling__getFileStructure( $file ){

    	// return array of structure

    	$file_parts = pathinfo( $file );


   			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->folder . '/' . $file );

				$element = [];
    			$structure = [];

				foreach( $jsons as $key => $json ):

						$element = json_decode($json);
						$structure[] = $element->type;

				endforeach;


			}	

		return $structure;

    }

    public function Storytelling__getFileSlugs( $file ){

    	// return array of slugs

    	$file_parts = pathinfo( $file );


   			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->folder . '/' . $file );

				$element = [];
    			$structure = [];

				foreach( $jsons as $key => $json ):

						$element = json_decode($json);
						$structure[] = $element->slug;

				endforeach;


			}	

		return $structure;
    }

    public function Storytelling__getFileTemplate( $file ){

    	// return array of slugs

    	$file_parts = pathinfo( $file );

		if( $file_parts['extension'] === "php" ){

			$default = get_file_data( $this->folder . '/' . $file,  $this->fileHeader );
			return $default[ 'Name' ];

		}	

    }

}