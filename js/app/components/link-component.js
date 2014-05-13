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

/*
      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

*/ 

    this.element.css({'width':'100%','height':'100%'});
      

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
 
var createLinkComponent = function ( event, ui, oldcomponent ) {

    if(typeof oldcomponent == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var link_value = 'http://linden-tech.com';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      link_value = oldcomponent.data.self.attr.href;
    };
    console.log(top);
    console.log(left);
    var top=(event.pageY-25)+"px";
    var left=(event.pageX-150)+"px";
      $("<div class='popup ui-draggable' id='pop-image-link' style='display: block; top:" + top + "; left: " + left + ";'> \
          <div class='popup-header'> \
          <i class='icon-m-link'></i> &nbsp;Bağlantı Ekle \
          <i id='link-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
          </div> \
         \
        <!-- popup content--> \
          <div class='gallery-inner-holder'> \
            <form id='video-url'> \
            <input id='link-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value=" + link_value + "> \
            <a href='#' id='pop-image-OK' class='btn btn-info' id='add-image' >Ekle</a> \
            </form> \
          </div>     \
           \
        <!-- popup content--> \
        </div>").appendTo('body').draggable();

      $('#link-add-dummy-close-button').click(function(){

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
      if(typeof oldcomponent == 'undefined'){
        console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
        var link_value = 'http://linden-tech.com';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        link_value = oldcomponent.data.self.attr.href;
        //window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        oldcomponent.data.self.attr.href = targetURL;
      };
       var  component = {
          'type' : 'link',
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
              } 
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
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
        if(typeof oldcomponent == 'undefined')
          window.lindneo.tlingit.componentHasCreated( component );
        else
          window.lindneo.tlingit.componentHasUpdated( oldcomponent );
        $("#link-add-dummy-close-button").trigger('click');

    });



  };