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

var createLinkComponent = function ( event, ui, oldcomponent ) {


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
        //window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        oldcomponent.data.self.attr.href = targetURL;
      };
       var  component = {
          'type' : 'link',
          'data': {
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
        $("#image-add-dummy-close-button").trigger('click');

    });



  };