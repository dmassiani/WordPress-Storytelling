(function($){

	$rapper 	= 'mch__rapper',
	$selector 	= 'mch__selector';

	var n__element 		= 0;
	var n__post 		= 0;

	var n__metabox 		= 0;
	var n__element 		= 0;

	getMetaboxs();
	getElements();

	// ================================
	// get total post of mch
	// ================================

	function getTotalMCHPost(){
		// MacroContentHammer__getTotalMchPost
		var data = {
			'action': 'MacroContentHammer__getTotalMchPost'
		};

		// nombre total d'element enregistrer an base

	    $.post('/wp-admin/admin-ajax.php', data, function(response) {
	    	
	    	// on insere le form juste avant le contenu
	    	
			n__post = parseInt(response) + 1;


	    });
	    
	}

	function getMetaboxs(){
		// retourne le nombre d'elements disponibles dans la page
		n__metabox = $('.mch-container').length;
	}
	function getElements(){
		// retourne le nombre d'elements disponibles dans la page
		n__element = $('.mch__element').length;
	}

	// ================================
	// requete template
	// ================================


	function getTemplate( tmpl, structure ){

		// Construct editor name ID
		// on récupère le nombre total de post MCH + n__element

		// nombre de content et image nécessaire à la construction du contenu

		// console.log(n__element);

		structure.replace(/ /g,'');
		var structureArray = structure.split(',');
		var contentLength = structureArray.length;
    	var file_frame;

    	// var n__elements = parseInt(n__element + nElements)

    	// console.log(n__elements);

		var data = {
			'action': 'MacroContentHammer__getNewMacro',
			'tmpl' : tmpl,
			'structure': encodeURIComponent(structure),
			'n__element': n__element,
			'n__metabox': n__metabox
		};


		// alert(n__metabox);

	    $.post('/wp-admin/admin-ajax.php', data, function(response) {

	    	// on insere le form juste avant le contenu

	    	// $(response).append( '#postbox-container-1' );
	    	// console.log(response);
				// close all editor : open the new editor
			// $('.mch-container .postbox.mch').not('.closed').addClass('closed');

	    	$( '#post-body-content' ).append( response );

	    	window.setTimeout(function() {

				var idNewEditor = n__element + 1 + ( 1000 * n__metabox );

				if( n__element === 0 )$('.mch-container').first().addClass('mch-first');

	    		// pour chaque structure de type content, on init un tinymce
	    		for (index = 0; index < contentLength; ++index) {


	    			var new__editor = "mch__editor__" + parseInt( parseInt( ( n__metabox + 1 ) * 1000 ) + parseInt( index + 1 ) );
					// var new__editor = "mch__editor__" + idNewEditor;
					// console.log(n__metabox, index, new__editor);
	    		
	    			// alert(structureArray[ index ]);
	    			// alert($.trim(structureArray[ index ]));

	    			// seulement si l'index de la structure est un contenu de type content

	    			// console.log(structureArray);

					if( $.trim(structureArray[ index ]) === "content" ){

			    		// on modifie la config initiale WP en appliquant le nouvel id de l'éditeur
						tinyMCEPreInit.mceInit[ 'content' ].selector = '#' + new__editor;
						tinyMCEPreInit.qtInit[ 'content' ].id = new__editor;
						tinymce.init(tinyMCEPreInit.mceInit[ 'content' ]);
						quicktags( tinyMCEPreInit.qtInit[ 'content' ] );

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

					idNewEditor++;
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
		
		getElements();
		getMetaboxs();

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