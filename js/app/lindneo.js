// namespace lindneo
// all global variables and the things other than module should be defined here.
window.lindneo = (function(window){

  var url = '/';
  var currentPageId ;
  var currentComponent = {};
  var  randomString = function (length, chars) {
    length = typeof length !== 'undefined' ? length : 21;
    chars = typeof chars !== 'undefined' ? chars : '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
   };
   var  findBestSize = function (currentSize, containerlement) {
    var scale = 1;
    var newSize =  {
      "w":100,
      "h":100
    }; 

    containerlement = typeof containerlement !== 'undefined' ? containerlement : '#current_page';
    if ( $(containerlement).size() == 0 ) return newSize;
    var containerSize = {
      "w":$(containerlement).width() * 0.8 ,
      "h":$(containerlement).height() * 0.8
    }
    if (  typeof currentSize == 'undefined' ) return newSize;

    if(currentSize.w > currentSize.h) { // Image is wider than it's high
      //console.log("landscape");
      if (currentSize.w > containerSize.w){
        scale = containerSize.w / currentSize.w;
      }
    }
    else { // Image is higher than it's wide
      if (currentSize.h > containerSize.h){
        scale = containerSize.h / currentSize.h;
      }
    }
    newSize = {
      "w":currentSize.w * scale,
      "h":currentSize.h * scale       
    }
    return newSize;
   }
  
  function toInt32(bytes) {
    return (bytes[0] << 24) | (bytes[1] << 16) | (bytes[2] << 8) | bytes[3];
  };


  function getDimensions(data) {
    return {
      width: toInt32(data.slice(16, 20)),
      height: toInt32(data.slice(20, 24))
    };
  };

  var base64Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

  function base64Decode(data) {
    var result = [];
    var current = 0;

    for(var i = 0, c; c = data.charAt(i); i++) {
      if(c === '=') {
        if(i !== data.length - 1 && (i !== data.length - 2 || data.charAt(i + 1) !== '=')) {
          throw new SyntaxError('Unexpected padding character.');
        }

        break;
      }

      var index = base64Characters.indexOf(c);

      if(index === -1) {
        throw new SyntaxError('Invalid Base64 character.');
      }

      current = (current << 6) | index;

      if(i % 4 === 3) {
        result.push(current >> 16, (current & 0xff00) >> 8, current & 0xff);
        current = 0;
      }
    }

    if(i % 4 === 1) {
      throw new SyntaxError('Invalid length for a Base64 string.');
    }

    if(i % 4 === 2) {
      result.push(current >> 4);
    } else if(i % 4 === 3) {
      current <<= 6;
      result.push(current >> 16, (current & 0xff00) >> 8);
    }

    return result;
  }

  window.getImageDimensions = function(dataUri) {
    return getDimensions(base64Decode(dataUri.substring( dataUri.indexOf(',')+1)));
  };

  return {
    findBestSize:findBestSize,
    randomString:randomString,
    url: url,
    currentPageId: currentPageId,
    currentComponent: currentComponent
  }; 

})( window );
