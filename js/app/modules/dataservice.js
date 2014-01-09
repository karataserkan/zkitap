'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var percentage = 0;
  var that =this;
  var progressBars=[];
  var progressBarsCounter=0;

  var newComponentDropPage = function(e, reader, file){

    var that =this;
    var component = {};
    reader.onload = function (evt) { 
        var FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        console.log(contentType);
        if(contentType == 'image'){
          image_width = this.width;
          image_height = this.height;
          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
          console.log(this);
          image_width = size.w;
          image_height = size.h;
        
          console.log(image_width);

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
          console.log(videoType);
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

    console.log(returnVal);
    return returnVal;

  };
  var removeProgressBar= function(progressbar){
    progressbar.remove();
  }

  var send = function( action, data, successCallback, failCallback ){
    var that =this;
    var progressbar = this.newProgressBar();
    var requestRoute='EditorActions' +'/' + action;


    
    console.log(action);

    $.ajax({

       xhr: function(){
         var xhr = new window.XMLHttpRequest();
         xhr.upload.onprogress = function(evt){console.log('progress')};
         //Upload progress
         xhr.upload.addEventListener("progress", function(evt){
          console.log('Upload');
          console.log(evt);
         if (evt.lengthComputable) {
           var percentage = evt.loaded / evt.total;
           progressbar.bar.progressbar('value', percentage*100);
           //Do something with upload progress

           console.log(percentage);
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
    send: send
  };


})(jQuery);
