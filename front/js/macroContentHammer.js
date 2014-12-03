(function($){

	$(document).on('click', '#mch__init', function( e ){
		
		e.preventDefault();

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

		    	},100);


		    });

		return false;

	});

})(jQuery);