'use strict';

$(document).ready(function(){
  $.widget('lindneo.linkComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      

      var componentlinkid='link'+this.options.component.id;


      if( this.options.marker ) {
        var newimage=$('<img id="img_'+componentlinkid+'" src="' + this.options.marker +  '" />');
        newimage.appendTo(this.element);
      }
      





      
      
      this._super(); 

      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

 
      

    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});


var IsURL = function (url) {

    var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
     var re=new RegExp(strRegex);
     return re.test(url);
 }

var createLinkComponent = function ( event, ui ) {

    $("<div class='popup ui-draggable' id='pop-image-link' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
      <div class='popup-header'> \
      Görsel Ekle \
      <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
      </div> \
   \
  <!-- popup content--> \
    <div class='gallery-inner-holder'> \
      <form id='video-url'> \
      <input id='link-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value='http://linden-tech.com'> \
      <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>Ekle</a> \
      </form> \
    </div>     \
     \
  <!-- popup content--> \
  </div>").appendTo('body').draggable();

    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-link').remove();  

      if ( $('#pop-image-link').length ){
        $('#pop-image-link').remove();  
      }

    });


    $('#pop-image-OK').click(function (){   
    var targetURL = $("#link-url-text").val();

      if (!IsURL (targetURL) ){
        alert ("Lütfen gecerli bir URL adresi giriniz.");
        return;

      }
       var  component = {
          'type' : 'link',
          'data': {
            
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '128px',
                'height': '128px',
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '99997'
              },
              'attr':{
                'href': targetURL
              }
            }
          }
        };
        
        window.lindneo.tlingit.componentHasCreated( component );
        $("#image-add-dummy-close-button").trigger('click');

    });



  };