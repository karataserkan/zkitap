// Nisga'a Tribe jQuery UI elements for Client Side
// Triggers Framework events and client events
'use strict';

// lindneo namespace
window.lindneo = window.lindneo || {};

// nisga module
window.lindneo.nisga = (function(window, $, undefined){

  var page_div_selector = '#current_page';

  var createComponent = function( component ){
    console.log(component);
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
      case 'galery':
        galeryComponentBuilder( component );

      break; 
      case 'sound':
        soundComponentBuilder( component );
      break; 

        break;
      case 'quiz':
        quizComponentBuilder( component );
        break;

      case 'video':
        videoComponentBuilder( component );
        break;

      case 'popup':
        popupComponentBuilder( component );
        break;

      case 'grafik':
        graphComponentBuilder( component );
        break;

      case 'shape':
        shapeComponentBuilder( component );
        break;

      case 'link':
        linkComponentBuilder( component );
        break;



      default:
         // what can I do sometimes
         break;
    }
    
  }; 

  var destroyComponent = function ( componentId ) {
    $('[id="'+componentId+'"]').parent().not('#current_page').remove();
    $('[id="'+componentId+'"]').remove();
  };

  var deleteComponent = function ( component ) {

    window.lindneo.tlingit.componentHasDeleted( component.id );

  };


  var shapeComponentBuilder = function( component ) {
    
    var element  = $('<canvas> </canvas>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .shapeComponent({
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

  var graphComponentBuilder = function( component ) {
    
    var element  = $('<canvas> </canvas>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .graphComponent({
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

  var linkComponentBuilder = function ( component ) {
    
    
    var element  = $('<a class="link-component"></a>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .popupComponent({
      'component': component,
      'marker': 'http://dev.lindneo.com/css/linkmarker.png'  ,
      'update': function ( event, component ) {
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };


  var popupComponentBuilder = function ( component ) {
    
    
    var element  = $('<div class="popup-controllers"> </div>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .popupComponent({
      'component': component,
      'marker': 'http://dev.lindneo.com/css/popupmarker.png'  ,
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

  var videoComponentBuilder = function ( component ) {
    
    var element  = $('<div class="video-controllers"> </div>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .videoComponent({
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





  var soundComponentBuilder = function ( component ) {
    var element  = $('<div class="sound-controllers"> </div>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .soundComponent({
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
  
  var galeryComponentBuilder = function ( component ) {
    

    var element  = $('<div class="some-gallery"> </div>');
    var elementWrap=$('<div ></div>');

    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .galeryComponent({
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

  var quizComponentBuilder = function ( component ) {

    var element  = $('<div></div>');
    var elementWrap=$('<div></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .quizComponent({
      'component': component,
      'update': function( event, component ){
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function ( event, element_ ){
        window.lindneo.currentComponentWidget = element_;
        window.lindneo.toolbox.refresh( element_ );
      }
    });
  };

  var setBgColorOfSelectedComponent = function ( componentId ,activeUser){
    $('[id="' + componentId + '"]').css({
      'border': '1px solid #ccc',
      'border-color': activeUser.color
    });
    console.log(activeUser.color);

    $('[color="' +activeUser.color+ '"]').parent().find('[component-instance="true"]').css( {'border': 'none'});
    $('[color="' +activeUser.color+ '"]').parent().children('.activeUser').remove();


    $('[id="' + componentId + '"]').parent().children('.activeUser').remove();
    var activeUserDOM=$('<span class="activeUser" style="position: absolute; top: -20px; right: -20px;color:'+activeUser.color+'; " color="'+activeUser.color+'">'+activeUser.name+'</span>');
 

    $('[id="' + componentId + '"]').parent().append(activeUserDOM); 

    

  };

  return {
    galeryComponentBuilder: galeryComponentBuilder,
    createComponent: createComponent,
    deleteComponent: deleteComponent,
    destroyChapter: destroyChapter,
    destroyComponent: destroyComponent,
    setBgColorOfSelectedComponent: setBgColorOfSelectedComponent
  };

})( window, jQuery );

