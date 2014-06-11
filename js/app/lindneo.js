// namespace lindneo
// all global variables and the things other than module should be defined here.
window.lindneo = (function(window){

  var url = '/';
  var controls = {
    
  };
  var dontAllowToLoagPage = $('<div class = "dontAllowToLoagPage" style="width: 140px; height: 50px; background-color: #E54E45;top:20px;position: absolute;text-align: center;padding-top: 5px;margin-left:-10px;color: #830700;font-weight: bold;border-radius: 3px;border: 2px solid#A30900;">' + j__('İşlem tamamlanırken lütfen bekleyiniz..') + '</div>'  );
  var pageCanvasHoverIn = function(e){
    //console.log(e);
    dontAllowToLoagPage.appendTo( $(e.currentTarget) )
    ;}
  var pageCanvasHoverOut = function(e){
  //console.log(e);
  dontAllowToLoagPage.remove()
  ;
  //dontAllowToLoagPage.appendTo( $(e.).parent() )
  ;}
  var pageLoaded = function(value){

    if (typeof (value)!="undefined")
      if (value === true || value === false )
        window.lindneo.controls.pageLoaded = value;

    if (value===true){
      $('.dontAllowToLoagPage').remove();

      $("canvas.preview").parent().unbind("mouseenter",pageCanvasHoverIn);
      $("canvas.preview").parent().unbind("mouseleave",pageCanvasHoverOut);
      //window.lindneo.controls.dontAllowToLoagPage;
    }
    else {
      $("canvas.preview").parent().bind("mouseenter",pageCanvasHoverIn);
      $("canvas.preview").parent().bind("mouseleave",pageCanvasHoverOut);
    }


    return window.lindneo.controls.pageLoaded;

  }
  /*controls.watch ( "pageLoaded" function (id, oldval, newval) {
    if(newval){
      $('.dontClickForReload').remove();
    } else {

    }

    return newval;
  });*/
  var currentPageId ;
  var currentComponent = {};
  var online_users = [];
  var selection_text = "";
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

  function empty(mixed_var) {
    //  discuss at: http://phpjs.org/functions/empty/
    // original by: Philippe Baumann
    //    input by: Onno Marsman
    //    input by: LH
    //    input by: Stoyan Kyosev (http://www.svest.org/)
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Onno Marsman
    // improved by: Francesco
    // improved by: Marc Jansen
    // improved by: Rafal Kukawski
    //   example 1: empty(null);
    //   returns 1: true
    //   example 2: empty(undefined);
    //   returns 2: true
    //   example 3: empty([]);
    //   returns 3: true
    //   example 4: empty({});
    //   returns 4: true
    //   example 5: empty({'aFunc' : function () { alert('humpty'); } });
    //   returns 5: false

    var undef, key, i, len;
    var emptyValues = [undef, null, false, 0, '', '0'];

    for (i = 0, len = emptyValues.length; i < len; i++) {
      if (mixed_var === emptyValues[i]) {
        return true;
      }
    }

    if (typeof mixed_var === 'object') {
      for (key in mixed_var) {
        // TODO: should we check for own properties only?
        //if (mixed_var.hasOwnProperty(key)) {
        return false;
        //}
      }
      return true;
    }

    return false;
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
    selection_text: selection_text,
    currentPageId: currentPageId,
    currentComponent: currentComponent,
    online_users: online_users,
    pageLoaded: pageLoaded,
    controls: controls,
    empty: empty
  }; 

})( window );
