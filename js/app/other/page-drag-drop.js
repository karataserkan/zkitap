$( document ).ready(function () {

	function first_time(){

    $( ".component" ).draggable({
     // helper: "clone",
      revert: "valid"
    });

		$('#current_page').droppable({
      drop: function (event, ui) {
			  //create a component object from dom object
			  //pass it to tlingit        


        if( $(event.toElement).attr('component-instance') ){
          return;
        }

        var component = { 
          'type' : $(event.toElement).attr('ctype'),
          'data': {
            'textarea':{
              'css' : {
                'width':'100%',
                'height':'100%',
                'margin': '0',
                'padding': '0px',
                'border': 'none 0px',
                'outline': 'none'
              } ,
              'attr': {
                'asd': 'coadsad'
              },
              'val': 'some text'
            },
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '100px',
                'height': '20px'
              }
            }
          }
        };

		    window.lindneo.tlingit.componentHasCreated(component);
	 	  }
    });

	 	$('#zoom-pane').slider({
	    value:100,
	    min: 25,
	    max: 500,
	    step: 25,
	    slide: function( event, ui ) {
	      $('#author_pane').css({'zoom': (ui.value / 100) });
	    }
	  });
	}

  first_time();

});