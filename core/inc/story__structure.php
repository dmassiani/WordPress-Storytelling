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

		$this->themeFolder = get_template_directory() . '/' . STORY_FOLDER;
		$this->pluginFolder = STORY_DEFAULT_TEMPLATE;

		if( file_exists( $this->themeFolder ) ){
			$this->files = scandir( $this->themeFolder );
		}else{
			$this->files = [];
		}
		$this->utility = new Storytelling__utility();
		$this->currentFolder = $this->themeFolder;
		
	}

	// ----------------------------------------------------------------
	// Cette fonction est utilisé pour connaitre la structure d'un dossier (fichier et dossier enfant)
	// ----------------------------------------------------------------

	public function dir__to__array($dir) { 
   
	   $result = array(); 

	   $cdir = scandir($dir); 
	   foreach ($cdir as $key => $value) 
	   { 
	      if (!in_array($value,array(".",".."))) 
	      { 
	         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
	         { 
	            $result[$value] = $this->dir__to__array($dir . DIRECTORY_SEPARATOR . $value); 
	         } 
	         else 
	         { 
	            $result[] = $value; 
	         } 
	      } 
	   } 
	   
	   return $result; 
	} 


	// ---------------------------------------------------------------
	// Cette fonction scanne un dossier en particulier et retourne les json des contents
	// ---------------------------------------------------------------

	public function Storytelling__scan__folder($content, $folder){

		$filesFounded = [];

		foreach ($content as $value) {

			$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $value );

			// log_it($file_parts);

			if( isset($file_parts['extension']) && $file_parts['extension'] === "php" ){

				$default = get_file_data( $this->currentFolder .'/'. $folder .'/'. $value,  $this->fileHeader );
				$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $value );

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


				$filesFounded[] = json_encode( $tJson );

			}

		}
		 
    	return $filesFounded;

	}


    // ============================================================
    // Load PLUGIN Templates
    // ============================================================

	public function Storytelling__register__Plugin__folder(){

		// log_it($this->pluginFolder);

		// on prend on dossier et on le transforme en tableau de contenance dossier -> fichier
    	$pluginFolder = $this->dir__to__array($this->pluginFolder);

    	// log_it('-----------------------------------------');
    	// log_it('je créé un tableau des fichiers et dossiers');
    	// log_it($test);
    	// log_it('-----------------------------------------');
    	// $this->files = scandir( $this->folder );

		foreach ($pluginFolder as $key => $value) {

			if( gettype($value) === "array" ){
				// log_it("J'ai trouvé un dossier contenant des fichiers");
				// // j'ai trouvé un dossier contenant des fichiers
				// log_it('nommé '.$key);
				// log_it('contenant');
				// log_it($value);
				// // je le scanne donc

				// si dans le dossier scanner des dossiers enfant on retrouve les fichiers
				// et on les transforme en json contenant les informations du fichier
				// json utilisable ensuite pour générer les metabox de content
				$this->currentFolder = $this->pluginFolder;
				$pluginFolder[$key] = $this->Storytelling__scan__folder( $value, $key );

			}

		}

		// log_it($pluginFolder);

		return $pluginFolder;	
	}

    // ============================================================
    // Load THEMES Templates
    // ============================================================

	public function Storytelling__register__Theme__folder(){

		// log_it($this->currentFolder);

		// log_it($this->themeFolder);
		// on prend on dossier et on le transforme en tableau de contenance dossier -> fichier
    	$themesFolder = $this->dir__to__array($this->themeFolder);

    	// log_it('-----------------------------------------');
    	// log_it('je créé un tableau des fichiers et dossiers');
    	// log_it($test);
    	// log_it('-----------------------------------------');
    	// $this->files = scandir( $this->folder );

		foreach ($themesFolder as $key => $value) {

			if( gettype($value) === "array" ){
				// log_it("J'ai trouvé un dossier contenant des fichiers");
				// // j'ai trouvé un dossier contenant des fichiers
				// log_it('nommé '.$key);
				// log_it('contenant');
				// log_it($value);
				// // je le scanne donc

				// si dans le dossier scanner des dossiers enfant on retrouve les fichiers
				// et on les transforme en json contenant les informations du fichier
				// json utilisable ensuite pour générer les metabox de content

				$this->currentFolder = $this->themeFolder;
				$themesFolder[$key] = $this->Storytelling__scan__folder( $value, $key );

			}

		}

		// log_it($themesFolder);

		return $themesFolder;	
	}

    public function Storytelling__register__templates(){

		
		// on prend on dossier et on le transforme en tableau de contenance dossier -> fichier
    	$themesFolder = $this->dir__to__array($this->themeFolder);



    	// log_it('-----------------------------------------');
    	// log_it('je créé un tableau des fichiers et dossiers');
    	// log_it($test);
    	// log_it('-----------------------------------------');
    	// $this->files = scandir( $this->folder );

		foreach ($themesFolder as $key => $value) {

			if( gettype($value) === "array" ){
				// log_it("J'ai trouvé un dossier contenant des fichiers");
				// // j'ai trouvé un dossier contenant des fichiers
				// log_it('nommé '.$key);
				// log_it('contenant');
				// log_it($value);
				// // je le scanne donc

				// si dans le dossier scanner des dossiers enfant on retrouve les fichiers
				// et on les transforme en json contenant les informations du fichier
				// json utilisable ensuite pour générer les metabox de content

				$themesFolder[$key] = $this->Storytelling__scan__folder( $value, $key );

			}

		}

		// log_it($themesFolder);

		return $themesFolder;

    }

    public function Storytelling__realTemplates(){

    	$templates = $this->Storytelling__register__templates();
        
    	// log_it($templates);

        $elements = [];


        foreach ($templates as $key => $value) {

            if( gettype($value) === "array" ){

            }

        }

        foreach ($templates as $template):
        	// pour chaque macro template

            $template = json_decode($template);

        	$name = sanitize_title( $template->name );
        	$elements[ $name ] = (array) $template->elements;


        endforeach;

        // log_it($elements);

        return $elements;

    }

    public function Storytelling__get__template__structure( $name ){

		foreach ($this->files as $value) {
			$file_parts = pathinfo( $value );
			// log_it('ici story structure');
			// log_it('je regarde le fichier ' . $value );


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

		return $elements;
    }

    public function Storytelling__get__fileStructure( $type, $folder, $file ){


    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );


   			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $file );

				$element = [];

				foreach( $jsons as $key => $json ):

						$element[] = json_decode($json);

				endforeach;


			}	

		return $element;
    }

    public function Storytelling__getFileStructure( $type, $folder, $file ){

    	// type = theme ou plugin : désigne si le template est situé dans le theme ou le plugin
    	// folder = dossier dans lequel est le template. Ex : plugin / folder / file ou theme / folder / file
    	// file est le nom du fichier/template

    	// return array of structure

    	// log_it($type);
    	// log_it($folder);
    	// log_it($file);

    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );


   			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $file );

				$element = [];
    			$structure = [];

				foreach( $jsons as $key => $json ):

						$element = json_decode($json);
						$structure[] = $element->type;

				endforeach;


			}	

		return $structure;

    }

    public function Storytelling__getFileSlugs( $type, $folder, $file ){

    	// return array of slugs

    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );



   			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $file );

				$element = [];
    			$structure = [];

				foreach( $jsons as $key => $json ):

						$element = json_decode($json);
						$structure[] = $element->slug;

				endforeach;


			}	

		return $structure;
    }

    public function Storytelling__getFileNames( $type, $folder, $file ){

    	// return array of slugs

    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );



   			if( $file_parts['extension'] === "php" ){

				$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $file );

				$element = [];
    			$structure = [];

				foreach( $jsons as $key => $json ):

						$element = json_decode($json);
						$structure[] = $element->name;

				endforeach;


			}	

		return $structure;
    }

    public function Storytelling__getFileTemplate( $type, $folder, $file ){

    	// return array of slugs

    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );


		if( $file_parts['extension'] === "php" ){

			$default = get_file_data(  $this->currentFolder .'/'. $folder .'/'. $file,  $this->fileHeader );
			return $default[ 'Name' ];

		}	

    }

    public function Storytelling__getNameFileSlug( $type, $folder, $file, $slug ){

    	// return array of slugs

    	// log_it( $slug );

    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );


			if( $file_parts['extension'] === "php" ){

			$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $file );


			foreach( $jsons as $key => $json ):

					$element = json_decode($json);
					if( $element->slug === $slug ){
						return $element->name;
					}

			endforeach;


		}	

    }

  //   public function Storytelling__slugExist( $file, $slug ){

  //   	$file_parts = pathinfo( $file );

  //   	$exist = false;


		// 	if( $file_parts['extension'] === "php" ){

		// 	$jsons 	 = $this->utility->get_file_data( $this->folder . '/' . $file );


		// 	foreach( $jsons as $key => $json ):

		// 			$element = json_decode($json);
		// 			if( $element->slug === $slug ){
		// 				$exist = true;
		// 			}

		// 	endforeach;


		// }

		// return $exist;

  //   }

    public function Storytelling__slugType( $type, $folder, $file, $slug ){


    	if( $type === 'theme' ){
    		$this->currentFolder = $this->themeFolder;
    	}else{
    		$this->currentFolder = $this->pluginFolder;
    	}

    	$file_parts = pathinfo( $this->currentFolder .'/'. $folder .'/'. $file );

    	$exist = false;


			if( $file_parts['extension'] === "php" ){

			$jsons 	 = $this->utility->get_file_data( $this->currentFolder .'/'. $folder .'/'. $file );


			foreach( $jsons as $key => $json ):

					$element = json_decode($json);
					if( $element->slug === $slug ){
						return $element->type;
					}

			endforeach;


		}

		return false;

    }

}