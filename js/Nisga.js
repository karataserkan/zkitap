// Nisga'a Tribe jQuery UI elements for Client Side
// Triggers Framework events and client events
'use strict';

window.lindneo = window.lindneo || {};
window.lindneo.nisga = (function(window, $, undefined){

  var page_div_selecter='#current_page';

  var componentBuilder = function(component){
     
    
    var inner_html="";
    var container='<div class="component_container" id="'+component.id+'" ctype="'+component.type+'" ></div>';

    inner_html='<div style="" id="type_specific">    <input type="text" id="value"/>     </div>  ';
    if (component.type=='text'){
      inner_html = inner_html+ '<textarea >'+ component.data.value + '</textarea>';


    }


    


    console.log(component);



    
    return $(container).append(inner_html).css(component.data.css);






  }

  var createComponent = function(component){

    //get component and work on it on U


    // can create jquery widget extendiston
    // builder class construct from component variable 
    // it may be text class or image etc. 
    //console.log(component);
    $(page_div_selecter).append(componentBuilder(component));

    $('.component_container textarea').change(function(){

          $(this).parent().find('#type_specific input').val($(this).val());
          $(this).parent().find('#type_specific input').change();
        });

    $('.component_container #type_specific input').change(function(){
      var component=$(this).parent().parent().attr('ctype');

      console.log(component);
    });    

  };

  return {
    createComponent: createComponent
  };

})( window, jQuery );

$( document ).ready(function () {

	function first_time(){

    $( ".component" ).draggable({
     // helper: "clone",
      revert: "valid"
    });

		$('#current_page').droppable({
      drop: function (event, ui) {
			  //create a component object from dom object
			  //pass it to Tlingit
        console.log($(event.toElement));



        var component = { 
          'type' : $(event.toElement).attr('ctype'),
          'data': {
            'css' : {
              'position':'absolute',
              'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
              'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
              'width':'100px',
              'height':'200px'
            } ,
            'value' : ''
          }
        };

        

       /* console.log(ui);
        console.log(component );
        console.log(event);
        */

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
