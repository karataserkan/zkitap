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
/*
      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

*/ 
      

    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});



var createPopupComponent = function ( event, ui, oldcomponent ) {

    $('#pop-image-OK').click(function (){        
      if(typeof oldcomponent == 'undefined'){
        console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        //window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        oldcomponent.data.html_inner = $("#popup-explanation").val();

      };
       var  component = {
          'type' : 'popup',
          'data': {
            'img':{
              'css' : {
                'width': '100%',
                'height': '100%',
                'margin': '0',
                'padding': '0px',
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } 
            },
            'html_inner':  $("#popup-explanation").val(),
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width':'128px',
                'height':'128px',
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '99998'
              }
            }
          }
        };
        if(typeof oldcomponent == 'undefined')
          window.lindneo.tlingit.componentHasCreated( component );
        else 
          window.lindneo.tlingit.componentHasUpdated( oldcomponent );
        $("#image-add-dummy-close-button").trigger('click');

    });



  };