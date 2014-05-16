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
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden;"></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html(plink_data);
      }
      if(this.options.component.data.plink_image){
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden;"></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html('<img src="'+this.options.component.data.plink_image+'"/>');
      }
       
      this._super({resizableParams:{handles:"e, s, se"}});
      
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
  url: "/book/getBookPages/"+lindneo.currentBookId,
}).done(function(result) {
  console.log(result);
  book_data = JSON.parse(result);
  console.log(book_data.length);
  
  var min_left = $("#current_page").offset().left;
    var min_top = $("#current_page").offset().top;
    var max_left = $("#current_page").width() + min_left;
    var max_top = $("#current_page").height() + min_top;
    
    var top=(event.pageY - 25);
    var left=(event.pageX-150);

    console.log(top);

    if(left < min_left)
      left = min_left;
    else if(left+310 > max_left)
      left = max_left - 310;

    if(top < min_top)
      top = min_top;
    else if(top+650 > max_top)
      top = max_top - 650;

console.log(top);

    top = top + "px";
    left = left + "px";

  var html_popup = $("<div class='popup ui-draggable' id='pop-plink-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      </div>");
  html_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
  var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;Sayfa Bağlantısı Ekle </div> ");
  var close_button = $("<i id='plink-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
  
  var galery_inner = $("<div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
      <div style='clear:both'></div> \
      <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
       <div id='new_image'></div>\
    </div> ");
  var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
  var popup_detail = $("<div  id='popup-explanation' contenteditable='true' class='drag-cancel'><textarea row='2' cols='30' id='baslik' name='baslik' placeholder='Başlığı buraya giriniz...'></textarea></div>");
  var add_button = $("<br><a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>Ekle</a> ");
  poup_header.appendTo(html_popup);
  close_button.appendTo(poup_header);
  galery_inner.appendTo(html_popup);
  popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
  var chapter= $('<div class="panel-group" id="accordion1"></div>');
  chapter.appendTo(galery_inner);
  var deger = 1;
  console.log(book_data);
  $.each( book_data, function( key, value ) {
    console.log(value.title);
    var title = value.title;
    if(!value.title) title = deger + ". Bölüm";
    
    var chapter_title = $('<div class="panel panel-default">\
    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse'+value.chapter_id+'"><div class="panel-heading">\
      <h4 class="panel-title">\
        '+title+'\
      </h4>\
    </div></a>\
    <div id="collapse'+value.chapter_id+'" class="panel-collapse collapse">\
      <div class="panel-body_'+value.chapter_id+'">\
      </div>\
    </div>\
  </div>');
    chapter_title.appendTo(chapter);
    $.each( value.pages, function( key_page, value_page ) {
      console.log(value_page);
      if(value_page)
        $('<input type="radio" name="page_select" value="'+value_page.page_id+'">'+page_count+'. Sayfa<br>').appendTo('.panel-body_'+value.chapter_id);
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
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
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
            'plink_image': FileBinary,
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
var el = document.getElementById("dummy-dropzone");
    var FileBinary = '';
    console.log(el);

    el.addEventListener("dragenter", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("dragexit", function(e){
      e.stopPropagation();
      e.preventDefault();
    },false);

    el.addEventListener("dragover", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("drop", function(e){

      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};
      var imageBinary = '';
      var videoContentType = '';
      var videoURL = '';
      console.log(reader);
      reader.onload = function (evt) {

        FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        
        //console.log(contentType);
        if(contentType == 'image'){
          var imageBinary = FileBinary;
          var newImage = $("<img style='width:80%' src='"+imageBinary+"' />");

          $('#new_image').append(newImage);
          return;
          
        }

        
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);
    
  });
  

};