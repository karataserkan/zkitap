'use strict';

window.lindneo = window.lindneo || {};

window.lindneo.toolbox = (function(window, $, undefined){

  var load = function () {
    // creates toolbox

  };

  var refresh = function ( component ) {

    if( component ) {
      // show only toolbox-items usable for selected component type
      switch( component.type() ) {
        case 'text':
          break;
        default:
          // show all toolbox items
      }
    } else {
      // show all toolbox items
    }
  };

  return {
    load: load,
    refresh: refresh
  };

})();