'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var percentage = 0;
  var that =this;
  var progressBars=[];
  var progressBarsCounter=0;
  var GrandTotals=new Object();

  var graph_popup = function(event, ui, component){
      createGraphComponent( event, ui, component );
    };

  var quiz_popup = function(event, ui, component){
      createQuizComponent( event, ui, component );
    };

  var image_popup = function(event, ui, component){
      createImageComponent( event, ui, component );
    };

  var link_popup = function(event, ui, component){
      createLinkComponent( event, ui, component );
    };

  var popup_popup = function(event, ui, component){
      createPopupComponent( event, ui, component );
    };

  var html_popup = function(event, ui, component){
      createHtmlComponent( event, ui, component );
    };

  var video_popup = function(event, ui, component){
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
  var progressContinue = function(){
     $('#save_status').addClass('icon-arrows-cw animate-spin size-30 light-blue');
  }
  var ProgressOfTop = function () {
    var that =this;
    var Ftotal=0;
    var Floaded=0;
    //console.log(window.lindneo.dataservice.GrandTotals);
    if (typeof window.lindneo.dataservice.GrandTotals == "undefined") return;
    $.each(window.lindneo.dataservice.GrandTotals, function  (index,reqstat) {
      if (reqstat.total != reqstat.loaded ){
        Ftotal += reqstat.total;
        Floaded += reqstat.loaded;
      };



    });
    
   // console.log(Floaded / Ftotal);
    if (Ftotal==0){
      NProgress.done();
    } else {
    NProgress.set(Floaded / Ftotal);
    }

  }
  var send = function( action, data, successCallback, failCallback ){
    var that = this;
    var requestRoute='EditorActions' +'/' + action;
    
    var timestamp = new Date().getTime().toString();
    NProgress.configure({
       ease: 'ease',
       speed: 50,
       showSpinner: false, 
       trickleRate: 0.02, 
       trickleSpeed: 10  
    });
    
    
    $.ajax({

       'xhr': function(){
         var xhr = new window.XMLHttpRequest();
         
         
         //Upload progress
         xhr.upload.addEventListener("progress", function(evt){
           progressContinue();
           if (evt.lengthComputable) {
              var totalz={
                total:evt.total,
                loaded:evt.loaded
              };

             window.lindneo.dataservice.GrandTotals[timestamp]=totalz;
             that.ProgressOfTop();         

             }
         }, false);
       
         //Download progress
        
        xhr.addEventListener("progress", function(evt){      
          progressContinue();
           if (evt.lengthComputable) {
              var totalz={
                total:evt.total,
                loaded:evt.loaded
              };

             window.lindneo.dataservice.GrandTotals[timestamp]=totalz;
             that.ProgressOfTop();         
             
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
        progressContinue();
      },
      'success': function(data) {
        that.ProgressOfTop();
         //that.removeProgressBar(progressbar.container);
         return successCallback(data); 
      },
      //'error': failCallback,
      error: function () {
        that.ProgressOfTop();
        //console.log('ERROR');
        //$('#save_status').text('HATA VAR...');
        //that.removeProgressBar(progressbar.container);
        $('#save_status').addClass('icon-warning light-red');
        $('#save_status').removeClass('arrows-cw animate-spin size-30 light-blue ');
        },
      complete: function(){
        that.ProgressOfTop();
        // Handle the complete event
        //console.log('bitti');
        //$('#save_status').text('Kaydedildi...');
        //that.removeProgressBar(progressbar.container);
        $('#save_status').addClass('icon-tick light-green');
        $('#save_status').removeClass('icon-arrows-cw animate-spin size-30 light-blue');
      }
    });
  };

  return {
    ProgressOfTop: ProgressOfTop,
    GrandTotals: GrandTotals,
    progressContinue: progressContinue,
    removeProgressBar: removeProgressBar,
    newProgressBar: newProgressBar,
    newComponentDropPage: newComponentDropPage,
    image_popup: image_popup,
    link_popup: link_popup,
    video_popup: video_popup,
    popup_popup: popup_popup,
    graph_popup: graph_popup,
    quiz_popup: quiz_popup,
    send: send
  };


})(jQuery);
