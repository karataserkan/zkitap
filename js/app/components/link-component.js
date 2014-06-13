'use strict';

$(document).ready(function(){
  $.widget('lindneo.linkComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      console.log(this.options.component.data);      

      var componentlinkid='link'+this.options.component.id;

      if(this.options.component.data.link_area == "N"){
        if( this.options.marker ) {
          var newimage=$('<img id="img_'+componentlinkid+'" src="' + this.options.marker +  '" />');
          newimage.appendTo(this.element);
        }
      }
      else if(this.options.component.data.link_area == "Y"){
        var blanklink=$('<div  id="message_'+componentlinkid+'"  style="overflow:hidden; border: solid yellow; width:100%; height:100%;"></div>');
        blanklink.appendTo(this.element);
      }
      else{
        var blanklink=$('<div  id="message_'+componentlinkid+'"  style="overflow:hidden; width:100%; height:100%;">'+this.options.component.data.link_text+'</div>');
        blanklink.appendTo(this.element);
      }
      




document.execCommand
      
      
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
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)"
        + "(.*){0,}$";
     var re=new RegExp(strRegex);
     return re.test(url);
 }
 
var createLinkComponent = function ( event, ui, oldcomponent ) {

    if(typeof oldcomponent == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var link_value = 'http://';
      var control_type = "N";
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      link_value = oldcomponent.data.self.attr.href;
    };
    console.log(top);
    console.log(left);
    
    var min_left = $("#current_page").offset().left;
    var min_top = $("#current_page").offset().top;
    var max_left = $("#current_page").width() + min_left;
    var max_top = $("#current_page").height() + min_top;
    var window_width = $( window ).width();
    var window_height = $( window ).height();

    if(max_top > window_height) max_top = window_height;
    if(max_left > window_width) max_top = window_width;

    var control_y_check = '';
    var control_y_check_active = '';
    var control_n_check = '';
    var control_n_check_active = '';
    var control_z_check = '';
    var control_z_check_active = '';

    if(control_type == 'Y') { control_y_check = "checked='checked'"; control_y_check_active = 'active';}
    else if(control_type == 'N'){ control_n_check = "checked='checked'"; control_n_check_active = 'active'; }
    else if(control_type == 'Z'){ control_z_check = "checked='checked'"; control_z_check_active = 'active'; }
 
      
    var top=(event.pageY - 25);
    var left=(event.pageX-150);

    console.log(top);

    if(left < min_left)
      left = min_left;
    else if(left+310 > max_left)
      left = max_left - 310;

    if(top < min_top)
      top = min_top;
    else if(top+300 > max_top)
      top = max_top - 300;

console.log(top);

    top = top + "px";
    left = left + "px";

      $("<div class='popup ui-draggable' id='pop-image-link' style='display: block; top:" + top + "; left: " + left + ";'> \
          <div class='popup-header'> \
          <i class='icon-m-link'></i> &nbsp;"+j__("Bağlantı Ekle")+" \
          <i id='link-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
          </div> \
         \
        <!-- popup content--> \
          <div class='gallery-inner-holder' style='width:500px;'> \
            <form id='video-url'> \
            <input id='link-url-text' class='input-textbox' type='url' placeholder='"+j__("URL Adresini Giriniz")+"'   value=" + link_value + "> \
            <div class='type1' style='padding: 4px; display: inline-block;'>"+j__("Bağlantı alanı yayınlandığında gözükmeyecektir. Üstüne getirdiğiniz diğer araçlar ile kullanınız.")+"\
                  <div class='btn-group' data-toggle='buttons'><br>\
                    <label class='btn btn-primary " + control_n_check_active + "'>\
                      <input type='radio' name='link_area' id='repeat1' " + control_n_check + " value='N'> "+j__("Bağlantı Simgesi")+"\
                    </label>\
                    <label class='btn btn-primary " + control_y_check_active + "'>\
                      <input type='radio' name='link_area' id='repeat0' " + control_y_check + " value='Y'> "+j__("Bağlantı Alanı")+"\
                    </label>\
                    <label class='btn btn-primary " + control_z_check_active + "'>\
                      <input type='radio' name='link_area' id='repeat2' " + control_z_check + " value='Z'> "+j__("Bağlantı Yazı Alanı")+"\
                    </label>\
                  </div>\
              </div><br><br>\
              <div id='link_text'></div>\
            <a href='#' id='pop-image-OK' class='btn btn-info' id='add-image' >"+j__("Ekle")+"</a> \
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
      $('input:radio[name="link_area"]').change(function(e){
        if($('input:radio[name="link_area"]:checked').attr("value") == "Z"){
          $('<input type="text" name="text_link" id="text_link" placeholder="'+j__("Bağlantı vereceğinizi yazıyı giriniz.")+'" style="width:250px;"><br><br>').appendTo("#link_text");
        }
        else{
          $("#link_text").html("");
        }
      });

    $('#pop-image-OK').click(function (){   
    var targetURL = $("#link-url-text").val();
    var link_area = $('input:radio[name="link_area"]:checked').attr("value");
    var link_text = "";

      if (!IsURL (targetURL) ){
        alert (j__("Lütfen gecerli bir URL adresi giriniz."));
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
      if(link_area == "Z"){
        link_text = $("#text_link").val();
      }

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
            'link_area': link_area,
            'link_text': link_text,
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': '128px',
                'height': '128px',
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': 'first',
                'opacity':'1'
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