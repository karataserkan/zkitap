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

  var destroyComponent = function ( componentId ) {
    $('[id="'+componentId+'"]').remove();
  };

  var deleteComponent = function ( component ) {

    window.lindneo.tlingit.componentHasDeleted( component.id );

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

  };



  var destroyChapter=function(chapter){
    $(".chapter[chapter_id='"+chapter+"']").remove();
  }; 


  var imageComponentBuilder = function ( component ) {
    
    var element = $('<img></img>');

    element
    .appendTo( page_div_selector )
    .imageComponent({
      'component': component,
      'update': function ( event, component ) {
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };

  var setBgColorOfSelectedComponent = function ( componentId ,activeUser){
    $('[id="' + componentId + '"]').parent().css({
      'border': '1px solid #ccc',
      'border-color': activeUser.color
    });
    
    $('[color="' +activeUser.color+ '"]').parent().children('.activeUser').remove();
    $('[color="' +activeUser.color+ '"]').css( {'border': 'none'});


    $('[id="' + componentId + '"]').parent().children('.activeUser').remove();
    var activeUserDOM=$('<span class="activeUser" style="position: absolute; top: -20px; right: -20px;color:'+activeUser.color+'; " color="'+activeUser.color+'">'+activeUser.name+'</span>');
    console.log(activeUserDOM);   

    $('[id="' + componentId + '"]').parent().append(activeUserDOM); 

    

  };

  return {
    createComponent: createComponent,
    deleteComponent: deleteComponent,
    destroyChapter: destroyChapter,
    destroyComponent: destroyComponent,
    setBgColorOfSelectedComponent: setBgColorOfSelectedComponent
  };

})( window, jQuery );

