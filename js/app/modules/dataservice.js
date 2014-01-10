'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var percentage = 0;
  var that =this;
  var progressBars=[];
  var progressBarsCounter=0;

  var image_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
    };

      $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        Görsel Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
          </div> \
          <div>\
            <input type='text' name='width' id='width' placeholder='Genişlik' value=''>\
            <input type='text' name='height' id='height' placeholder='Yükseklik' value=''>\
          </div> \
        </div>").appendTo('body').draggable();

        $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });
      console.log(component);
      createImageComponent( event, ui, component );

    };

  var link_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var link_value = 'http://linden-tech.com';
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
      link_value = component.data.self.attr.href;
    };
    console.log(top);
    console.log(left);
      $("<div class='popup ui-draggable' id='pop-image-link' style='display: block; top:" + top + "; left: " + left + ";'> \
          <div class='popup-header'> \
          Link Ekle \
          <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
          </div> \
         \
        <!-- popup content--> \
          <div class='gallery-inner-holder'> \
            <form id='video-url'> \
            <input id='link-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value=" + link_value + "> \
            <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>Ekle</a> \
            </form> \
          </div>     \
           \
        <!-- popup content--> \
        </div>").appendTo('body').draggable();

      $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-link').remove();  

        if ( $('#pop-image-link').length ){
          $('#pop-image-link').remove();  
        }

      });

      console.log(component);
      createLinkComponent( event, ui, component );

    };

  var video_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var video_url = "http://lindneo.com/5.mp4";
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
      video_url = component.data.source.attr.src;
    };
    console.log(top);
    console.log(left);
      $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        Video Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
            <input id='video-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value=" + video_url + "> \
            <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>Ekle</a> \
          </div> \
        </div>").appendTo('body');

      $('#image-add-dummy-close-button').click(function() {

          $('#pop-image-popup').remove();

          if ($('#pop-image-popup').length) {
              $('#pop-image-popup').remove();
          }

      });

      console.log(component);
      createVideoComponent( event, ui, component );

    };
  var newComponentDropPage = function(e, reader, file){
    var that =this;
    var component = {};
    reader.onload = function (evt) { 
        var FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        //console.log(contentType);
        if(contentType == 'image'){
          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
          var image_width = size.w;
          var image_height = size.h;
        
          //console.log(image_width);

          component = {
            'type' : 'image',
            'data': {
              'img':{
                'css' : {
                  'width':'100%',
                  'height':'100%',
                  'margin': '0',
                  'padding': '0px',
                  'border': 'none 0px',
                  'outline': 'none',
                  'background-color': 'transparent'
                } , 
                'src': FileBinary
              },
              'lock':'',
              'self': {
                'css': {
                  'position':'absolute',
                  'top': (e.offsetY ) + 'px',
                  'left':  ( e.offsetX ) + 'px',
                  'width': image_width,
                  'height': image_height,
                  'background-color': 'transparent',
                  'overflow': 'visible',
                  'z-index': '990'
                }
              }
            }
          };

          window.lindneo.tlingit.componentHasCreated( component );
        }
        else if(contentType == 'video'){
          var contentType = FileBinary.substr(0, FileBinary.indexOf(';'));
          var videoType = contentType.substr(contentType.indexOf('/')+1);
          //console.log(videoType);
          var response = '';
          var videoURL = '';
          var token = '';


          that.send( 'getFileUrl', {'type': videoType}, function(response) {
            response=window.lindneo.tlingit.responseFromJson(response);
          
            that.send( 'UploadFile', {'token': response.result.token, 'file' : FileBinary} , function(data) {
                  var component = {
                      'type': 'video',
                      'data': {
                          'video': {
                              'attr': {
                                  'controls': 'controls'
                              },
                              'css': {
                                  'width': '100%',
                                  'height': '100%',
                              },
                              'contentType': contentType
                          },
                          'source': {
                              'attr': {
                                  'src': response.result.URL
                              }
                          },
                          '.audio-name': {
                              'css': {
                                  'width': '100%'
                              }
                          },
                          'self': {
                              'css': {
                                  'position': 'absolute',
                                  'top': (e.offsetY ) + 'px',
                                  'left':  ( e.offsetX ) + 'px',
                                  'width': 'auto',
                                  'height': '60px',
                                  'background-color': 'transparent',
                                  'overflow': 'visible'
                              }
                          }

                      }
                  };


                 window.lindneo.tlingit.componentHasCreated(component);
              });

          });




          
        }
      }
      reader.readAsDataURL(file);
      return false;
  };

  var newProgressBar= function(){
    var newProgressBarContainer=$("<li style='float:right; ' class='has-sub'></li>");
    var newProgressBarElement=$("<div style='width:100px;'></div>");
    $('#headermenu > ul').append(newProgressBarContainer);
    newProgressBarContainer.append(newProgressBarElement);
    newProgressBarElement.progressbar({
      value: 0
    });

    var returnVal={
      'bar':newProgressBarElement,
      'container': newProgressBarContainer
    };

    
    return returnVal;

  };
  var removeProgressBar= function(progressbar){
    progressbar.remove();
  }

  var send = function( action, data, successCallback, failCallback ){
    var that =this;
    var progressbar = this.newProgressBar();
    var requestRoute='EditorActions' +'/' + action;


    
    //console.log(action);

    $.ajax({

       'xhr': function(){
         var xhr = new window.XMLHttpRequest();
         //xhr.upload.onprogress = function(evt){console.log('pprogress')};
         
         //console.log(xhr.upload);

         //Upload progress
         xhr.upload.addEventListener("progress", function(evt){
          //console.log('Upload');
          //console.log(evt);
         if (evt.lengthComputable) {
           var percentage = evt.loaded / evt.total;
           progressbar.bar.progressbar('value', percentage*100);
           //Do something with upload progress

           //console.log(percentage);
           }
         }, false);
       
         //Download progress
         xhr.addEventListener("progress", function(evt){       
           if (evt.lengthComputable) {
             var percentage = evt.loaded / evt.total;
             progressbar.bar.progressbar('value', percentage*100);
           }
         }, false);
         return xhr;
       },
      'headers': {
        'X-PINGOTHER': 'pingpong',
        'contentType': 'plain/text; charset=UTF-8'
      },
      
      'type': 'POST',
      'url': window.lindneo.url+requestRoute,
      'data': data,
      
      beforeSend: function(){
        // Handle the beforeSend event
        //console.log('yükleniyor');
        //$('#save_status').text('Yükleniyor...');
        $('#save_status').addClass('icon-arrows-cw animate-spin size-30 light-blue');
      },
      'success': function(data) {

         that.removeProgressBar(progressbar.container);
         return successCallback(data); 
      },
      //'error': failCallback,
      error: function () {
        //console.log('ERROR');
        //$('#save_status').text('HATA VAR...');
        that.removeProgressBar(progressbar.container);
        $('#save_status').addClass('icon-warning light-red');
        $('#save_status').removeClass('arrows-cw animate-spin size-30 light-blue ');
        },
      complete: function(){

        // Handle the complete event
        //console.log('bitti');
        //$('#save_status').text('Kaydedildi...');
        that.removeProgressBar(progressbar.container);
        $('#save_status').addClass('icon-tick light-green');
        $('#save_status').removeClass('icon-arrows-cw animate-spin size-30 light-blue');
      }
    });
  };

  return {
    removeProgressBar: removeProgressBar,
    newProgressBar: newProgressBar,
    newComponentDropPage: newComponentDropPage,
    image_popup: image_popup,
    link_popup: link_popup,
    video_popup: video_popup,
    //opup_popup: popup_popup,
    send: send
  };


})(jQuery);
