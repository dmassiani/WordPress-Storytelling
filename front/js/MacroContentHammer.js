(function($){

	$rapper 	= 'mch__rapper',
	$selector 	= 'mch__selector';

	var n__element 		= 0;
	var n__post 		= 0;
	getTotalMCHPost();

	// ================================
	// get total post of mch
	// ================================

	function getTotalMCHPost(){
		// MacroContentHammer__getTotalMchPost
		var data = {
			'action': 'MacroContentHammer__getTotalMchPost'
		};

	    $.post('/wp-admin/admin-ajax.php', data, function(response) {
	    	
	    	// on insere le form juste avant le contenu
	    	
			n__post = parseInt(response) + 1;


	    });
	    
	}

	// ================================
	// requete template
	// ================================

	function getMacroContent(){

		// mon sélecteur
		var myeditor = "mysecondeditor";

		var data = {
			'action': 'MacroContentHammer__getNewMacro'
		};

	    $.post('/wp-admin/admin-ajax.php', data, function(response) {
	    	
	    	// on insere le form juste avant le contenu
	    	$(response).insertBefore('#mch__init');

	    	// console.log(tinymce);

   			// window.onpageload = true;

	    	window.setTimeout(function() {

	    		// on modifie la config initiale WP en appliquant le nouvel id de l'éditeur
				tinyMCEPreInit.mceInit[ 'content' ].selector = '#' + myeditor;
				tinyMCEPreInit.qtInit[ 'content' ].id = myeditor;


				tinymce.init(tinyMCEPreInit.mceInit[ 'content' ]);

		
				quicktags( tinyMCEPreInit.qtInit[ 'content' ] );


				window.wpActiveEditor = myeditor;

				n__element++;

	    	},100);


	    });

	}

	function getTemplate( tmpl, structure ){

		// Construct editor name ID
		// on récupère le nombre total de post MCH + n__element

		// nombre de content et image nécessaire à la construction du contenu

		// console.log(n__element);

		structure.replace(/ /g,'');
		var structureArray = structure.split(',');
		var contentLength = structureArray.length;
    	var file_frame;

		var data = {
			'action': 'MacroContentHammer__getNewMacro',
			'tmpl' : tmpl,
			'structure': encodeURIComponent(structure),
			'n__element': n__element
		};

		// alert(encodeURIComponent(structure));

	    $.post('/wp-admin/admin-ajax.php', data, function(response) {

	    	// on insere le form juste avant le contenu
	    	$(response).insertBefore( '#mch__container' );

	    	window.setTimeout(function() {


	    		// pour chaque structure de type content, on init un tinymce
	    		for (index = 0; index < contentLength; ++index) {

					var idNewEditor = parseInt(n__element) + parseInt(n__post);
					var new__editor = "mch__editor__" + idNewEditor;
	    		
	    			// alert(structureArray[ index ]);
	    			// alert($.trim(structureArray[ index ]));

	    			// seulement si l'index de la structure est un contenu de type content
					if( $.trim(structureArray[ index ]) === "content" ){

			    		// on modifie la config initiale WP en appliquant le nouvel id de l'éditeur
						tinyMCEPreInit.mceInit[ 'content' ].selector = '#' + new__editor;
						tinyMCEPreInit.qtInit[ 'content' ].id = new__editor;
						tinymce.init(tinyMCEPreInit.mceInit[ 'content' ]);
						quicktags( tinyMCEPreInit.qtInit[ 'content' ] );

						// alert('init editeur ' + new__editor );

					}

					if( $.trim(structureArray[ index ]) === "image" ){
						$(document).on('click','#' + new__editor, function(e) {
					 
					        e.preventDefault();
					 

					        //If the uploader object has already been created, reopen the dialog
					        if ( file_frame ) {
						      file_frame.open();
						      return;
						    }
					 
						    // Create the media frame.
						    file_frame = wp.media.frames.file_frame = wp.media({
						      title: jQuery( this ).data( 'upload_image' ),
						      button: {
						        text: jQuery( this ).data( 'upload_image_button' ),
						      },
						      multiple: false  // Set to true to allow multiple files to be selected
						    });

						    // When an image is selected, run a callback.
						    file_frame.on( 'select', function() {
						      // We set multiple to false so only get one image from the uploader
						      attachment = file_frame.state().get('selection').first().toJSON();
						      // $('#upload_image').val(attachment.url);
						      console.log(attachment.sizes.medium.url);
						      // Do something with attachment.id and/or attachment.url here
						    });

						    // Finally, open the modal
						    file_frame.open();
					 
					    });
					}

					n__element++;
					// $('.meta-box-sortables').sortable();
					
				}


	    	},100);


	    });

	}
	
	// ================================
	// selector click
	// ================================

	$(document).on('click', '#mch__selector a', function( e ){
		
		e.preventDefault();

		var tmpl = $(this).data('name');
		var structure = $(this).data('structure');

		getTemplate( tmpl, structure, n__element );

		return false;

	});


	$(document).on('click', '.postbox .handlediv.mch', function(){

		var postbox = $(this).closest('.postbox');
		
		if( postbox.hasClass('closed') )
		{
			postbox.removeClass('closed');
		}
		else
		{
			postbox.addClass('closed');
		}
		
	});
    

})(jQuery);