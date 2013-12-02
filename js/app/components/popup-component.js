'use strict';

$(document).ready(function(){
  $.widget('lindneo.popupComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      

      var componentpopupid='popup'+this.options.component.id;


      if( this.options.marker ) {
        var newimage=$('<img id="img_'+componentpopupid+'" src="' + this.options.marker +  '" />');
        newimage.appendTo(this.element);
      }
      


      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componentpopupid+'" style="display:none" >'+this.options.component.data.html_inner+'</div>');
        popupmessage.appendTo(this.element);
      }



      
      
      this._super(); 

      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

 
      

    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



var createPopupComponent = function ( event, ui ) {

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Görsel Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
      <textarea  id='popup-explanation' class='popup-text-area'>Açılır kutunun içeriğini yazınız. \
      </textarea> <br> \
      <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' style='padding: 5px 30px;'>Ekle</a> \
    </div> \
    </div>").appendTo('body');

    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });


    $('#pop-image-OK').click(function (){        
        
       var  component = {
          'type' : 'popup',
          'data': {
            'html_inner':  $("#popup-explanation").val(),
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '128px',
                'height': '128px',
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '99998'
              }
            }
          }
        };
        
        window.lindneo.tlingit.componentHasCreated( component );
        $("#image-add-dummy-close-button").trigger('click');

    });



  };