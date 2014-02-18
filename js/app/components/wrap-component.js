'use strict';

$(document).ready(function(){
  $.widget('lindneo.wrapComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;
      var html_data = html_tag_replace(this.options.component.data.html_inner);
      html_data = html_data + '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc justo massa, mattis in imperdiet in, pellentesque sit amet elit. Fusce vitae pulvinar nisi. Ut sed justo nec est congue cursus vestibulum eu dolor. Donec at mauris felis, sit amet ultrices odio. Aliquam erat volutpat. Nullam faucibus metus eu elit luctus sed malesuada risus molestie. Mauris nulla quam, tristique at lobortis at, fringilla quis nibh. Ut sapien mauris, imperdiet eget tincidunt semper, consectetur a augue. Donec vitae nibh augue, ut rhoncus elit. Nullam volutpat lorem sed odio lacinia non aliquet erat consequat. In ac libero turpis. In commodo nisl id diam dapibus varius. Sed lobortis ultricies ligula, quis auctor arcu imperdiet eget. Donec vel ipsum dui. In justo purus, molestie sit amet mattis sed, cursus non orci. Nullam ac massa vel tortor scelerisque blandit quis a sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc justo massa, mattis in imperdiet in, pellentesque sit amet elit. Fusce vitae pulvinar nisi. Ut sed justo nec est congue cursus vestibulum eu dolor. Donec at mauris felis, sit amet ultrices odio. Aliquam erat volutpat. Nullam faucibus metus eu elit luctus sed malesuada risus molestie. Mauris nulla quam, tristique at lobortis at, fringilla quis nibh. Ut sapien mauris, imperdiet eget tincidunt semper, consectetur a augue. Donec vitae nibh augue, ut rhoncus elit. Nullam volutpat lorem sed odio lacinia non aliquet erat consequat. In ac libero turpis. In commodo nisl id diam dapibus varius. Sed lobortis ultricies ligula, quis auctor arcu imperdiet eget. Donec vel ipsum dui. In justo purus, molestie sit amet mattis sed, cursus non orci. Nullam ac massa vel tortor scelerisque blandit quis a sapien.</p>'
      console.log(this.options.component);

      var componentpopupid='popup'+this.options.component.id;

      /*
      if( this.options.marker ) {
        var newimage=$('<img id="img_'+componentpopupid+'" src="' + this.options.marker +  '" />');
        newimage.appendTo(this.element);
      }
      
*/


      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componentpopupid+'" style="display:block" >'+html_data+'</div>');
        popupmessage.appendTo(this.element);
      }


      
      $('.wrapReady.withSourceImage').slickWrap({
                    sourceImage: true,cutoff:180
                });
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

    while( str.indexOf('<span>') > -1)
      {
        str = str.replace('<span>', '');
      }

while( str.indexOf('<span style="line-height: 1.428571429;">') > -1)
      {
        str = str.replace('<span style="line-height: 1.428571429;">', '');
      }
    while( str.indexOf('</span>') > -1)
      {
        str = str.replace('</span>', '');
      }
      
      
   //console.log(str);  <span style="line-height: 1.428571429;">
   return str;
};

var createWrapComponent = function ( event, ui, oldcomponent ) {  
console.log(oldcomponent);  
  if(typeof oldcomponent == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var popup_value = 'http://linden-tech.com';
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
    
    var pop_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      </div>");
    pop_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
    var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;Pop-up Ekle </div> ");
    var close_button = $("<i id='popup-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
    var drag_file = $("<div class='add-image-drag-area' id='dummy-dropzone'> </div> ");
    var galery_inner = $("<div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
      </div> ");
    var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
    var popup_detail = $("<div  id='popup-explanation' contenteditable='true' class='drag-cancel'>" + popup_value + "</div>");
    var add_button = $("<a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>Ekle</a> ");
    poup_header.appendTo(pop_popup);
    close_button.appendTo(poup_header);
    galery_inner.appendTo(pop_popup);
    popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
    drag_file.prependTo(popup_wrapper);
    popup_detail.appendTo(popup_wrapper);
    add_button.appendTo(galery_inner);
    popup_detail.resizable({alsoResize: galery_inner});
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
        var self_width = 'auto';
        var self_height = 'auto';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        oldcomponent.data.html_inner = $("#popup-explanation").html();
        var self_width = oldcomponent.data.width ;
        var self_height = oldcomponent.data.height;

      };
      
       var  component = {
          'type' : 'wrap',
          'data': {
            'html_inner':  $("#popup-explanation").html(),
            'width': width,
            'height': height,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': self_width,
                'height': self_height,
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '99998'
              }
            }
          }
        };
        
        window.lindneo.tlingit.componentHasCreated( component );
        
        close_button.trigger('click');

    });
    
    var el = document.getElementById("dummy-dropzone");
    var FileBinary = '';

    el.addEventListener("dragenter", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("dragexit", function(e){
      e.stopPropagation();
      e.preventDefault();
    },false);

    el.addEventListener("dragover", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("drop", function(e){

      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};
      var imageBinary = '';
      var videoContentType = '';
      var videoURL = '';
      console.log(reader);
      reader.onload = function (evt) {

        FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        
        //console.log(contentType);
        if(contentType == 'image'){
          var imageBinary = FileBinary;
          var newImage = $("<img class='wrapReady withSourceImage right' style='float:right;padding:30px;' src='"+imageBinary+"' >");

          $('#popup-explanation').append(newImage);
          return;
          
        }
        else if(contentType == 'video'){
         
          var contentType = FileBinary.substr(0, FileBinary.indexOf(';'));
          var videoType = contentType.substr(contentType.indexOf('/')+1);
          console.log(videoType);
          var response = '';
          var token = '';
          videoContentType = videoType;
          console.log(videoContentType);
          window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
            response=window.lindneo.tlingit.responseFromJson(response);
          
            window.lindneo.dataservice.send( 'UploadFile', {'token': response.result.token, 'file' : FileBinary} , function(data) {
              console.log('denemeee');
              videoURL = response.result.URL;
              var newVideo = $("<video controls='controls' style='width:80%'><source src='"+videoURL+"'></video>");

              $('#popup-explanation').append(newVideo);
              return;
              
                
            });

          });

        }

        
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };