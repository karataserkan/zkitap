'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var percentage = 0;
  var that =this;
  var progressBars=[];
  var progressBarsCounter=0;
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
  

    data.r = 'EditorActions' +'/' + action;

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
      'contentType': 'plain/text; charset=UTF-8',
      'type': 'GET',
      'url': window.lindneo.url,
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
    send: send
  };


})(jQuery);
