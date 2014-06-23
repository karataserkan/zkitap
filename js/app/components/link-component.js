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

  var radioTextInputText;

  if(typeof oldcomponent == 'undefined'){
    console.log('dene');
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    var link_value = 'http://';
    var targetURL;
    var link_area = "N";
    
    var link_text = "";
  }
  else{
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    link_value = oldcomponent.data.self.attr.href;
    link_area = oldcomponent.data.link_area;
    link_text = oldcomponent.data.link_text;
    targetURL = oldcomponent.data.self.attr.href;
  };
  console.log(targetURL);
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

  if(link_area == 'Y') { control_y_check = "checked"; control_y_check_active = 'active';}
  else if(link_area == 'N'){ control_n_check = "checked"; control_n_check_active = 'active'; }
  else if(link_area == 'Z'){ control_z_check = "checked"; control_z_check_active = 'active'; }

    
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

  top = top + "px";
  left = left + "px";

  var idPre = $.now();

  $('<div>').componentBuilder({
    top:top,
    left:left,
    title: j__("Bağlantı"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){
      console.log(targetURL);

      if (targetURL == "") {
          alert (j__("Lütfen bir URL adresi giriniz"));
          return false;
      }

      if (!IsURL (targetURL) ){
        alert (j__("Lütfen gecerli bir URL adresi giriniz."));
        return false;

      }

      if(typeof oldcomponent != 'undefined'){
        
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
      }
      
      if(link_area == "Z"){
        link_text = radioTextInputText.val();
      }

      console.log(link_area);

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
      if(typeof oldcomponent !== 'undefined'){
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
      };
      window.lindneo.tlingit.componentHasCreated( component );
    },
    onComplete:function (ui){
      var mainDiv = $('<div>')
        .appendTo(ui);

        var form = $('<form>')
          .appendTo(mainDiv);

          var linkURL = $('<input type="url">')
            .addClass("input-textbox")
            .attr("placeholder",j__("URL Adresini Giriniz"))
            .val(link_value)
            .change(function(){
              targetURL = $(this).val();
            })
            .appendTo(form);

          var typeDiv = $('<div>')
            .addClass("type1")
            .css({"padding": "4px", "display": "inline-block"})
            .text(j__("Bağlantı alanı yayınlandığında gözükmeyecektir. Üstüne getirdiğiniz diğer araçlar ile kullanınız."))
            .appendTo(form);

           $("<br>").appendTo(typeDiv);

            var radioDiv = $('<div>')
              .addClass("btn-group")
              .attr("data-toggle","buttons")
              .appendTo(typeDiv);

              var radioIconLabel = $('<label>')
                .addClass("btn btn-primary " + control_n_check_active)
                .appendTo(radioDiv);

                var radioIconInput = $('<input type="radio">')
                  .attr("name","link_area")
                  .attr("checked",control_n_check)
                  .val("N")
                  .change(function(){
                    linkTextDiv.html("");
                    link_area = $(this).val()
                  })
                  .appendTo(radioIconLabel);

                var radioIconInput = $('<span>')
                  .text(j__("Bağlantı Simgesi"))
                  .appendTo(radioIconLabel);

              var radioAreaLabel = $('<label>')
                .addClass("btn btn-primary " + control_y_check_active)
                .appendTo(radioDiv);

                var radioAreaInput = $('<input type="radio">')
                  .attr("name","link_area")
                  .attr("checked",control_y_check)
                  .val("Y")
                  .change(function(){
                    linkTextDiv.html("");
                    //console.log($(this).val());
                    link_area = $(this).val();
                  })
                  .appendTo(radioAreaLabel);

                var radioAreaInput = $('<span>')
                  .text(j__("Bağlantı Alanı"))
                  .appendTo(radioAreaLabel);

              var radioTextLabel = $('<label>')
                .addClass("btn btn-primary " + control_z_check_active)
                .appendTo(radioDiv);

                var radioTextInput = $('<input type="radio">')
                  .attr("name","link_area")
                  .attr("checked",control_z_check)
                  .val("Z")
                  .change(function(){
                    radioTextInputText = $('<input type="text">')
                      .attr("name","text_link")
                      .attr("placeholder",j__("Bağlantı vereceğinizi yazıyı giriniz."))
                      .css("width","250px")
                      .val(link_text)
                      .appendTo(linkTextDiv);
                    link_area = $(this).val();
                    console.log("zzzzzzzzzzzzzz");
                  })
                  .appendTo(radioTextLabel);

                var radioTextInput = $('<span>')
                  .text(j__("Bağlantı Yazı Alanı"))
                  .appendTo(radioTextLabel);

          var linkTextDiv = $('<div>')
            .appendTo(form);

          radioTextInput.change(function(){
                    radioTextInputText = $('<input type="text">')
                      .attr("name","text_link")
                      .attr("placeholder",j__("Bağlantı vereceğinizi yazıyı giriniz."))
                      .css("width","250px")
                      .val(link_text)
                      .appendTo(linkTextDiv);
                    //link_area = $(this).val();
                    console.log("zzzzzzzzzzzzzz");
                  });

        if(typeof oldcomponent !== 'undefined'){
          console.log(oldcomponent.data.link_area)
          if(oldcomponent.data.link_area == "N") radioIconInput.change();
          else if(oldcomponent.data.link_area == "Y") radioAreaInput.change(); 
          else if(oldcomponent.data.link_area == "Z") {radioTextInput.change();  console.log("asdasdasd");}
        };

    }


  }).appendTo('body');


};