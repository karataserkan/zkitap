'use strict';

$(document).ready(function(){
  $.widget('lindneo.htmlComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;
      
      

      var componenthtmlid='html'+this.options.component.id;
      
	try{
    		var html_data = window.decodeURI(this.options.component.data.html_inner);
	  }
	catch(err)
	{
		var html_data = this.options.component.data.html_inner;
	}
      //console.log(this.options.component);
    

      if(this.options.component.data.html_inner){



        var popupmessage=$('<div  id="message_'+componenthtmlid+'" style="overflow:hidden; width:100%; height:100%;" ><iframe id="if'+componenthtmlid+'" src="'+window.base_path+"/uploads/files/"+this.options.component.id+'.html" style="width:100%; height:100%; border:none;" /></iframe></div>');
        popupmessage.appendTo(this.element);

        $(window).on('blur',function(e) {    
            if($(this).data('mouseIn') != 'yes')return;
            $('#if'+componenthtmlid).filter(function(){
                return $(this).data('mouseIn') == 'yes';
            }).trigger('iframeclick');    
        });

        $(window).mouseenter(function(){
            $(this).data('mouseIn', 'yes');
        }).mouseleave(function(){
            $(this).data('mouseIn', 'no');
        });

        $('#if'+componenthtmlid).mouseenter(function(){
            $(this).data('mouseIn', 'yes');
            $(window).data('mouseIn', 'yes');
        }).mouseleave(function(){
            $(this).data('mouseIn', null);
        });

        $('#if'+componenthtmlid).on('iframeclick', function(){
            //console.log(this);
            $(this).parent().parent().parent().addClass("selected");
            $(this).parent().parent().addClass("selected");
            window.lindneo.toolbox.addComponentToSelection(that);
        });

        //popupmessage.html(html_data);
        //this.element.html(html_data);
        //var iframe = document.getElementById('if'+componenthtmlid),
        //iframedoc = iframe.contentDocument || iframe.contentWindow.document;

        //iframedoc.open();
        //iframedoc.write(html_data);
        //iframedoc.close();
      }
       

     this._super({resizableParams:{handles:"e, s, se"}});

    },
    _on : function () {
      //console.log(this.element);
       /* selectable =function(){
          stop: function() {
            var s = window.getSelection();
               console.log(s);
          }
        }*/
    },
    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});


var createHtmlComponent = function ( event, ui, oldcomponent ) {  

  var htmlContent;

  if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var width = 'auto';
      var height = 'auto';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      var width = oldcomponent.data.width ;
      var height = oldcomponent.data.height;
    };

    var page_off=$('#current_page').offset();
    top=page_off.top;
    left=page_off.left;
    width=$('#current_page').width();
    height=$('#current_page').height();

    var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("HTML"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){
      /*if (!plink_data) {
          alert (j__("Lütfen başlığı giriniz"));
          return false;
        }
      else */
        console.log(htmlContent);
      if (!htmlContent) {
          alert (j__("Lütfen bir html kodu giriniz"));
          return false;
        }
      var width = "300px";
      var height = "300px";

      var html_data = window.encodeURI(htmlContent.val());
      //console.log(html_data);
      var  component = {
        'type' : 'html',
        'data': {
          'html_inner': html_data ,
          'overflow': 'visible',
          'lock':'',
          'self': {
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,
              'overflow': 'visible',
              'opacity': '1',
              'width': width,
              'height': height,
              'z-index': 'first'
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
      console.log($(ui).parent().parent());
      $(ui).parent().parent().css({"width":$('#current_page').width(),"height":$('#current_page').height()});
      var mainDiv = $('<div>')
        .appendTo(ui);

        var galleryInnerDiv = $('<div>')
          .addClass("gallery-inner-holder")
          .appendTo(mainDiv);

          var wrapperDiv = $('<div>')
            .addClass("popup_wrapper drag-cancel")
            .css({"border": "1px #ccc solid" })
            .appendTo(galleryInnerDiv);

            htmlContent = $('<textarea>')
              .addClass("my-code-area")
              .css({"width": (width-50)+"px", "height": (height-120)+"px", "overflow":"auto", "text-align": "left" })
              .appendTo(wrapperDiv);

        
        if(typeof oldcomponent !== 'undefined'){
          console.log(window.decodeURI(oldcomponent.data.html_inner));
          console.log(htmlContent)
          htmlContent.val(window.decodeURI(oldcomponent.data.html_inner));
        }
        htmlContent.ace({ theme: "twilight", lang: "html" });
    }

  }).appendTo('body');
};
