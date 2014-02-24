'use strict';

$(document).ready(function(){
  $.widget('lindneo.htmlComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      

      var componenthtmlid='html'+this.options.component.id;
      

      var html_data = html_tag_replace(this.options.component.data.html_inner);
      console.log(html_data);
      while( html_data.indexOf('&lt;') > -1)
      {
        html_data = html_data.replace('&lt;', '<');
      }

    while( html_data.indexOf('&gt;') > -1)
      {
        html_data = html_data.replace('&gt;', '>');
      }

    while( html_data.indexOf('&amp;') > -1)
      {
        html_data = html_data.replace('&amp;', '&');
      }

    while( html_data.indexOf('<div>') > -1)
      {
        html_data = html_data.replace('<div>', '');
      }

    while( html_data.indexOf('</div>') > -1)
      {
        html_data = html_data.replace('</div>', '');
      }
      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componenthtmlid+'"  ></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html(html_data);
      }
       
      var sel = window.getSelection();
      $( "#"+this.options.component.id ).selectable({
        selecting: function( event, ui ) {
          console.log('xcxcxcxcxc');
        }
      });
      if(sel.type == 'Range'){
        //console.log(sel);  
      }

      this.element.autogrow({element:this});
      
      
      this._super(); 
/*
      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

*/ 
      

    },
    _on : function () {
      console.log(this.element);
       /* selectable =function(){
          stop: function() {
            var s = window.getSelection();
               console.log(s);
          }
        }*/
    },
    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});

var html_tag_replace = function (str){
   //var content = str.replace('&lt;','<')
   //                 .replace('&gt;','>')
   //                 .replace('<div>','')
   //                 .replace('</div>','');
   while( str.indexOf('&lt;') > -1)
      {
        str = str.replace('&lt;', '<');
      }

    while( str.indexOf('&gt;') > -1)
      {
        str = str.replace('&gt;', '>');
      }

    while( str.indexOf('&amp;') > -1)
      {
        str = str.replace('&amp;', '&');
      }

    while( str.indexOf('<div>') > -1)
      {
        str = str.replace('<div>', '');
      }

    while( str.indexOf('</div>') > -1)
      {
        str = str.replace('</div>', '');
      }
      
      
   console.log(str);
   return str;
};



var createHtmlComponent = function ( event, ui, oldcomponent ) {  
//console.log(oldcomponent);  
  if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
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
    //console.log(width);
    //console.log(height);
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
    
    var html_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      </div>");
    html_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
    var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;Html Ekle </div> ");
    var close_button = $("<i id='html-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
    
    var galery_inner = $("<div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
      </div> ");
    var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
    var popup_detail = $("<div  id='popup-explanation' contenteditable='true' class='drag-cancel'>" + popup_value + "</div>");
    var add_button = $("<a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>Ekle</a> ");
    poup_header.appendTo(html_popup);
    close_button.appendTo(poup_header);
    galery_inner.appendTo(html_popup);
    popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
    
    popup_detail.appendTo(popup_wrapper);
    add_button.appendTo(galery_inner);
    popup_detail.resizable({alsoResize: galery_inner});
    close_button.click(function(){

      html_popup.remove();  

      if ( html_popup.length ){
        html_popup.remove();  
      }

    });

    
    
    
    add_button.click(function (){  
      
      var width = html_popup.width();
      var height = html_popup.height(); 
      //console.log(width);
      //console.log(height);      
      if(typeof oldcomponent == 'undefined'){
        //console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        oldcomponent.data.html_inner = $("#popup-explanation").html();

      };
      //console.log($("#popup-explanation").text());
      //return;
      var html_data = html_tag_replace($("#popup-explanation").html());
       var  component = {
          'type' : 'html',
          'data': {
            'html_inner': html_data ,
            'width': width,
            'height': height,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width':'400px',
                'height':'100px',
                'overflow': 'visible',
                'opacity': '1',
                'z-index': '1000'
              }
            }
          }
        };
       
        window.lindneo.tlingit.componentHasCreated( component );
        
        close_button.trigger('click');

    });
    

  };