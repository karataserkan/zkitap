'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var send = function( action, data, successCallback, failCallback ){

    data.r = 'EditorActions' +'/' + action;

    $.ajax({
      'type': 'GET',
      'url': window.lindneo.url,
      'data': data,
      beforeSend: function(){
        // Handle the beforeSend event
        console.log('yükleniyor');
        $('#save_status').text('Yükleniyor...');
        $('#save_status').addClass('saving');
      },
      'success': successCallback,
      //'error': failCallback,
      error: function () {
        console.log('ERROR');
        $('#save_status').text('HATA VAR...');
        $('#save_status').addClass('error');
        $('#save_status').removeClass('saving');
        },
      complete: function(){
        // Handle the complete event
        console.log('bitti');
        $('#save_status').text('Kaydedildi...');
        $('#save_status').addClass('complete');
        $('#save_status').removeClass('saving');
      }
    });
  };

  return {
    send: send
  };


})(jQuery);