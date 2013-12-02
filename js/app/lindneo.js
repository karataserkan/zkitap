// namespace lindneo
// all global variables and the things other than module should be defined here.
window.lindneo = (function(window){

  var url = '/index.php';
  var currentPageId ;
  var currentComponent = {};

  return {
    url: url,
    currentPageId: currentPageId,
    currentComponent: currentComponent
  };

})( window );