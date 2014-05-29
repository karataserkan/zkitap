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
      

      console.log(this.options.component.data.html_inner);
      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componentpopupid+'" style="display:none" >'+this.options.component.data.html_inner+'</div>');
        popupmessage.appendTo(this.element);
      }

      this._super({resizableParams:{handles:"e, s, se"}});
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
console.log(oldcomponent);  
  if(typeof oldcomponent == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var popup_value = '';
      var width = 'auto';
      var height = 'auto';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      popup_value = oldcomponent.data.html_inner;
      var width = oldcomponent.data.width ;
      var height = oldcomponent.data.height;
    };
    console.log(width);
    console.log(height);
   /* $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      <div class='popup-header'> \
      Görsel/Video Ekle \
      <i id='popup-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
      </div> \
        <div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
        <div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' > \
          <div  id='popup-explanation' style='width:100%;height:100%; ' contenteditable='true' class='drag-cancel'>" + popup_value + ". \
         </div>  \
        </div> <br>\
        <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' style='padding: 5px 30px;'>Ekle</a> \
      </div> \
      </div>").appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();*/

    
    var min_left = $("#current_page").offset().left;
    var min_top = $("#current_page").offset().top;
    var max_left = $("#current_page").width() + min_left;
    var max_top = $("#current_page").height() + min_top;
    var window_width = $( window ).width();
    var window_height = $( window ).height();

    if(max_top > window_height) max_top = window_height;
    if(max_left > window_width) max_top = window_width;
    
    var top=(event.pageY - 25);
    var left=(event.pageX-150);

    console.log(top);

    if(left < min_left)
      left = min_left;
    else if(left+200 > max_left)
      left = max_left - 200;

    if(top < min_top)
      top = min_top;
    else if(top+300 > max_top)
      top = max_top - 300;

console.log(top);

    top = top + "px";
    left = left + "px";

    var pop_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      </div>");
    pop_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
    var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;"+j__("Açılır Pencere Ekle")+" </div> ");
    var close_button = $("<i id='popup-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
    var drag_file = $("<div class='add-image-drag-area' id='dummy-dropzone' > </div> ");
    var galery_inner = $("<div class='gallery-inner-holder' style='width: 100%; height: 100%;'> \
        <div style='clear:both'></div> \
      </div> ");
    var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
    var popup_detail = $("<textarea  id='popup-explanation' class='drag-cancel' style='width:100%; height:100%;'>" + popup_value + "</textarea>");
    var add_button = $("<a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> ");
    poup_header.appendTo(pop_popup);
    close_button.appendTo(poup_header);
    galery_inner.appendTo(pop_popup);
    popup_wrapper.appendTo(galery_inner);//.resizable({alsoResize: galery_inner});
    //drag_file.prependTo(popup_wrapper);
    popup_detail.appendTo(popup_wrapper);
    add_button.appendTo(galery_inner);
    popup_detail.resizable({alsoResize: popup_wrapper});
    close_button.click(function(){

      pop_popup.remove();  

      if ( pop_popup.length ){
        pop_popup.remove();  
      }

    });

    
    
    
    add_button.click(function (){  
      
      var width = pop_popup.width();
      var height = pop_popup.height(); 
      console.log(width);
      console.log(height);      
      if(typeof oldcomponent == 'undefined'){
        console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        oldcomponent.data.html_inner = $("#popup-explanation").html();

      };
      console.log($("#popup-explanation").val());
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
            'width': width,
            'height': height,
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
                'z-index': 'first'
              }
            }
          }
        };
       // if(typeof oldcomponent == 'undefined')
          window.lindneo.tlingit.componentHasCreated( component );
       /* else 
          window.lindneo.tlingit.componentHasUpdated( oldcomponent );
          */
        close_button.trigger('click');

    });

  };