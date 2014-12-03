(function($){

	$(document).on('click', '#mch__init', function( e ){
		
		e.preventDefault();


			var data = {
				'action': 'MacroContentHammer__getNewMacro'
			};

		    $.post('/wp-admin/admin-ajax.php', data, function(response) {
		    	
		    	// on insere le form juste avant le contenu
		    	$(response).insertBefore('#mch__init');

				// // //init quicktags
	   //          quicktags({id : 'editorcontentid'});

				// //init tinymce
	   //          tinymce.init(tinyMCEPreInit.mceInit['editorcontentid']);

		   		window.setTimeout(function() {
		   			window.tinyMCE.dom.Event.domLoaded = true;
				    tinyMCE.init(tinyMCEPreInit.mceInit['mysecondeditor']);
				    try { quicktags( tinyMCEPreInit.qtInit['mysecondeditor'] ); } catch(e){}

				}, 1000);



		    });


	});

})(jQuery);