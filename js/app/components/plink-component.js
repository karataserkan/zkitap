'use strict';

$(document).ready(function(){
  $.widget('lindneo.plinkComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      

      var componentplinkid='plink'+this.options.component.id;
      

      var plink_data = this.options.component.data.plink_data;
      var page_link = this.options.component.data.page_link;
      console.log(plink_data);
      
      if(this.options.component.data.plink_data){
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  ></div>');
        popupmessage.appendTo(this.element);
        $('<a href="'+page_link+'.html">'+plink_data+'</a>').appendTo(popupmessage);
      }
       
      this._super(); 
      
    },
    _on : function () {
      console.log(this.element);

    },
    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});


var createPlinkComponent = function ( event, ui, oldcomponent ) {  
  var book_data='';
  if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var popup_value = '';
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
var page_count = 1;
$.ajax({
  url: "getBookPages/"+lindneo.currentBookId,
}).done(function(result) {
  book_data = JSON.parse(result);
  console.log(book_data.length);

  var html_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      </div>");
  html_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
  var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;Html Ekle </div> ");
  var close_button = $("<i id='html-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
  
  var galery_inner = $("<div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
      <div style='clear:both'></div> \
    </div> ");
  var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
  var popup_detail = $("<div  id='popup-explanation' contenteditable='true' class='drag-cancel'><textarea row='2' cols='30' id='baslik' name='baslik' placeholder='Başlığı buraya giriniz...'></textarea></div>");
  var add_button = $("<br><a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>Ekle</a> ");
  poup_header.appendTo(html_popup);
  close_button.appendTo(poup_header);
  galery_inner.appendTo(html_popup);
  popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
  var chapter= $('<div class="panel-group" id="accordion"></div>');
  chapter.appendTo(galery_inner);
  
  $.each( book_data, function( key, value ) {
    console.log(value.title);
    var chapter_title = $('<div class="panel panel-default">\
    <a data-toggle="collapse" data-parent="#accordion" href="#collapse'+value.title+'"><div class="panel-heading">\
      <h4 class="panel-title">\
        '+value.title+'\
      </h4>\
    </div></a>\
    <div id="collapse'+value.title+'" class="panel-collapse collapse">\
      <div class="panel-body_'+value.title+'">\
      </div>\
    </div>\
  </div>');
    chapter_title.appendTo(chapter);
    $.each( value.pages, function( key_page, value_page ) {
      console.log(value_page);
      $('<input type="radio" name="page_select" value="'+value_page.page_id+'">'+page_count+'. Sayfa<br>').appendTo('.panel-body_'+value.title);
      page_count++;
    });
    
  });
  popup_detail.appendTo(popup_wrapper);
  add_button.appendTo(galery_inner);
  popup_detail.resizable({alsoResize: galery_inner});
  close_button.click(function(){

    html_popup.remove();  

    if ( html_popup.length ){
      html_popup.remove();  
    }

  });

  
  add_button.click(function (){  
      
      var width = html_popup.width();
      var height = html_popup.height(); 
      //console.log(width);
      //console.log(height);      
      if(typeof oldcomponent == 'undefined'){
        //console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        oldcomponent.data.html_inner = $("#popup-explanation").html();

      };
      /*console.log($("textarea#baslik").val());
      console.log($('input[name=page_select]:checked').val());
      return;*/
      var plink_data = $("textarea#baslik").val();
      var page_link = $('input[name=page_select]:checked').val();
       var  component = {
          'type' : 'plink',
          'data': {
            'plink_data': plink_data ,
            'page_link': page_link ,
            'width': width,
            'height': height,
            'overflow': 'visible',
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'overflow': 'visible',
                'opacity': '1',
                'z-index': '1000'
              }
            }
          }
        };
       
        window.lindneo.tlingit.componentHasCreated( component );
        
        close_button.trigger('click');

    });
    
  });
  };