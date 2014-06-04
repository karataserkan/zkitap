'use strict';

$(document).ready(function(){
  $.widget('lindneo.htmlComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;
      
      

      var componenthtmlid='html'+this.options.component.id;
      
	try{
    		var html_data = window.decodeURI(this.options.component.data.html_inner);
	  }
	catch(err)
	{
		var html_data = this.options.component.data.html_inner;
	}
      console.log(this.options.component);
    

      if(this.options.component.data.html_inner){



        var popupmessage=$('<div  id="message_'+componenthtmlid+'" style="overflow:hidden; width:100%; height:100%;" ><iframe id="if'+componenthtmlid+'" src="'+window.base_path+"/uploads/files/"+this.options.component.id+'.html" style="width:100%; height:100%; border:none;" /></iframe></div>');
        popupmessage.appendTo(this.element);
        //popupmessage.html(html_data);
        //this.element.html(html_data);
        //var iframe = document.getElementById('if'+componenthtmlid),
        //iframedoc = iframe.contentDocument || iframe.contentWindow.document;

        //iframedoc.open();
        //iframedoc.write(html_data);
        //iframedoc.close();
      }
       

     this._super({resizableParams:{handles:"e, s, se"}});

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
      popup_value = window.decodeURI(oldcomponent.data.html_inner);
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
    var page_off=$('#current_page').offset();
    top=page_off.top;
    left=page_off.left;
    width=$('#current_page').width();
    height=$('#current_page').height();
    var html_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:"+top+"px; left: "+left+"px; width: "+width+"px; height:"+(height-10)+"px; z-index:99999;'> \
      </div>");
    html_popup.appendTo('body').draggable({cancel:'.drag-cancel'});
    var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;"+j__("Html Ekle")+" </div> ");
    var close_button = $("<i id='html-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
    
    var galery_inner = $("<div class='gallery-inner-holder' > \
        <div style='clear:both'></div> \
      </div> ");
    var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
    var popup_detail = $('<textarea class="my-code-area" style="width: '+(width-50)+'px; height:'+(height-120)+'px; overflow:auto; text-align: left;">'+popup_value+'</textarea>\
                            <script>\
                              $(".my-code-area").ace({ theme: "twilight", lang: "html" })\
                            </script>');
    var add_button = $("<a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px; margin-left: 480px;'>"+j__("Ekle")+"</a> ");
    poup_header.appendTo(html_popup);
    close_button.appendTo(poup_header);
    galery_inner.appendTo(html_popup);
    popup_wrapper.appendTo(galery_inner);
    
    popup_detail.appendTo(popup_wrapper);
    add_button.appendTo(galery_inner);
    popup_detail;
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
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        oldcomponent.data.html_inner = $(".my-code-area").val();

      };
      console.log($(".my-code-area").val());
      //return;
      var html_data = window.encodeURI($(".my-code-area").val());
      console.log(html_data);
       var  component = {
          'type' : 'html',
          'data': {
            'html_inner': html_data ,
            'width': width,
            'height': height,
            'overflow': 'visible',
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'overflow': 'visible',
                'opacity': '1',
                'z-index': 'first'
              }
            }
          }
        };
       
        window.lindneo.tlingit.componentHasCreated( component );
        
        close_button.trigger('click');

    });
    

  };
