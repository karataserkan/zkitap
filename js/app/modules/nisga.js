// Nisga'a Tribe jQuery UI elements for Client Side
// Triggers Framework events and client events
'use strict';

// lindneo namespace
window.lindneo = window.lindneo || {};

// nisga module
window.lindneo.nisga = (function(window, $, undefined){

  var page_div_selector = '#current_page';

  var createComponent = function( component ){
    componentBuilder( component );   
  };

  var componentBuilder = function( component ){
     
    switch( component.type ) {
      case 'text':
        textComponentBuilder( component );
        break;
      case 'image':
        imageComponentBuilder( component );
        break;
      default:
         // what can I do sometimes
    }
    
  }; 

  var destroyComponent = function ( component ) {
    $('[id="'+component.id+'"]').parent().remove();
  };

  var deleteComponent = function ( component ) {
    
    window.lindneo.tlingit.componentHasDeleted( component );

  };

  var textComponentBuilder = function( component ) {

    var element = $('<textarea></textarea>');

    element
    .appendTo( page_div_selector )
    .textComponent({
      'component': component,
      'update': function ( event, component ) {
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  }



  var destroyChapter=function(chapter){
    $(".chapter[chapter_id='"+chapter.id+"']").remove();
  }

  var imageComponentBuilder = function ( component ) {
    console.log('image compnnent builder not implemented yet');
  };

  return {
    createComponent: createComponent,
    deleteComponent: deleteComponent,
    destroyChapter: destroyChapter
  };

})( window, jQuery );

