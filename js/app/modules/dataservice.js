'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var send = function( action, data, successCallback, failCallback ){

    data.r = 'EditorActions' +'/' + action;

    $.ajax({
      'type': 'GET',
      'url': window.lindneo.url,
      'data': data,
      'success': successCallback,
      'error': failCallback
    });
  };

  return {
    send: send
  };

})(jQuery);