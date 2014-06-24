'use strict';

$(document).ready(function(){
  $.widget('lindneo.popupComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      

      var componentpopupid='popup'+this.options.component.id;


      if( this.options.marker ) {
        var newimage=$('<img id="img_'+componentpopupid+'" src="' + this.options.marker +  '" />');
        newimage.appendTo(this.element);
      }
      

      //console.log(this.options.component.data.html_inner);
      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componentpopupid+'" style="display:none" >'+this.options.component.data.html_inner+'</div>');
        popupmessage.appendTo(this.element);
      }

      this._super({resizableParams:{handles:"e, s, se"}});
/*
      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

*/ 
      

    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});



var createPopupComponent = function ( event, ui, oldcomponent ) {  

  var popup_value;
  
  if(typeof oldcomponent == 'undefined'){
    console.log('dene');
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    popup_value = '';
    var width = 'auto';
    var height = 'auto';
  }
  else{
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    popup_value = oldcomponent.data.html_inner;
    var width = oldcomponent.data.width ;
    var height = oldcomponent.data.height;
  };
  
  var min_left = $("#current_page").offset().left;
  var min_top = $("#current_page").offset().top;
  var max_left = $("#current_page").width() + min_left;
  var max_top = $("#current_page").height() + min_top;
  var window_width = $( window ).width();
  var window_height = $( window ).height();

  if(max_top > window_height) max_top = window_height;
  if(max_left > window_width) max_top = window_width;
  
  var top=(event.pageY - 25);
  var left=(event.pageX-150);

  console.log(top);

  if(left < min_left)
    left = min_left;
  else if(left+200 > max_left)
    left = max_left - 200;

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
    title: j__("Açılır Pencere"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){

      if (popup_value == "") {
          alert (j__("Lütfen bir URL adresi giriniz"));
          return false;
      }

      if(typeof oldcomponent != 'undefined'){
        
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
      }  

      var  component = {
        'type' : 'popup',
        'data': {
          'img':{
            'css' : {
              'width': '100%',
              'height': '100%',
              'margin': '0',
              'padding': '0px',
              'border': 'none 0px',
              'outline': 'none',
              'background-color': 'transparent'
            } 
          },
          'html_inner':  popup_value,
          'width': width,
          'height': height,
          'lock':'',
          'self': {
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,
              'width':'128px',
              'height':'128px',
              'background-color': 'transparent',
              'overflow': 'visible',
              'z-index': 'first',
              'opacity':'1'
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
        .css({"width":"100%","height":"100%"})
        .appendTo(ui);

        var wrapperDiv = $('<div>')
          .addClass("popup_wrapper drag-cancel")
          .css({"width":"100%","height":"100%","border": "1px #ccc solid"})
          .appendTo(mainDiv);

          var detail = $('<textarea>')
            .addClass("drag-cancel")
            .css({"resize":"none","width":"100%", "height":"100%"})
            .val(popup_value)
            .change(function(){
              popup_value = $(this).val();
            })
            .appendTo(wrapperDiv); 

    }

  }).appendTo('body');

};