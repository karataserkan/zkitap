// namespace lindneo
// all global variables and the things other than module should be defined here.
window.lindneo = (function(window){

  var url = '/index.php';
  var currentPageId ;
  var currentComponent = {};
  var  randomString = function (length, chars) {
    length = typeof length !== 'undefined' ? length : 21;
    chars = typeof chars !== 'undefined' ? chars : '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
   }

  return {
    randomString:randomString,
    url: url,
    currentPageId: currentPageId,
    currentComponent: currentComponent
  }; 

})( window );