'use strict';

$(document).ready(function(){
  $.widget('lindneo.plinkComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      console.log(this.options.component.data);
      //return;

      var componentplinkid='plink'+this.options.component.id;
      

      var plink_data = this.options.component.data.plink_data;
      var page_link = this.options.component.data.page_link;
      var marker = this.options.component.data.marker;
      var selected_tab = this.options.component.data.selected_tab;
      console.log(plink_data);
      
      if(selected_tab == "#plink_name"){
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; width:100%; height:100%; "></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html(plink_data);
      }
      else if(selected_tab == "#plink_icon"){
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; "></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html('<img src="'+this.options.component.data.marker+'" style="width:100%; height:100%;"/>');
      }
      else if(selected_tab == "#plink_area"){
        console.log("GELIYO");
        console.log(this.options.component.data.height);
        console.log(this.options.component.data.self.css);
        var width = this.options.component.data.self.css.width;
        var height = this.options.component.data.self.css.height; 
        if(this.options.component.data.height!=0){
          var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; border: solid yellow; width:'+width+'; height:'+height+';"></div>');
        }
        else{
          var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; border: solid yellow; min-width:'+'100%; min-height:'+'100%;"></div>');
        }
        popupmessage.appendTo(this.element);
      }
       
      this._super({resizableParams:{handles:"e, s, se"}});
      
    },
    _on : function (event, ui) {
      console.log(this.options.component.id);
      
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
  var marker = window.base_path+'/css/popupmarker.svg';
  var video_marker=window.base_path+'/css/image_play_trans.svg';
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
console.log("dede ");
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
    var window_width = $( window ).width();
    var window_height = $( window ).height();

    if(max_top > window_height) max_top = window_height;
    if(max_left > window_width) max_top = window_width;
    
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
  
  

  var html_popup = $("<div class='popup ui-draggable' id='pop-plink-popup' style='display: block; top:" + top + "; left: " + left + "; width:550px;'> \
      </div>");
  html_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
  var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;"+j__("Sayfa Bağlantısı Ekle")+" </div> ");
  var close_button = $("<i id='plink-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
  
  var galery_inner = $("<div class='gallery-inner-holder' style='width: " + width + "; height: " + height + ";'> \
      <div style='clear:both'></div> \
    </div> ");
  var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' >\
                          <div class='tabbable'>\
                            <ul class='nav nav-tabs' id='plink_tab'>\
                              <li><a href='#plink_name' data-toggle='tab'>"+j__("Sayfa Bağlantısı Adı")+"</a></li>\
                              <li><a href='#plink_icon' data-toggle='tab'>"+j__("Sayfa Bağlantısı İkonu")+"</a></li>\
                              <li><a href='#plink_area' data-toggle='tab'>"+j__("Sayfa Bağlantısı Alanı")+"</a></li>\
                            </ul>\
                          </div>\
                          <div class='tab-content'>\
                            <div class='tab-pane fade in active' id='plink_name'><br>\
                              <div  id='popup-explanation' contenteditable='true' class='drag-cancel'><textarea row='2' cols='30' id='baslik' name='baslik' placeholder='"+j__("Başlığı buraya giriniz")+"...'></textarea></div> \
                            </div>\
                            <div class='tab-pane fade' id='plink_icon'><br>\
                              <span id='plink_image'>\
                                <input type='radio' id='plink_image0' name='plink_image_type' value='plink_image0'><button id='button0' style='background:url(\""+marker+"\") no-repeat center center;-moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button>\
                                <input type='radio' id='plink_image1' name='plink_image_type' value='plink_image1'><button id='button1' style='background:url(\""+video_marker+"\") no-repeat center center; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button>\
                                <a href='#' onclick='document.getElementById(\"plink_image_file\").click(); return false;' class='icon-upload dark-blue size-40' style='padding-left:15px;'></a>\
                                <input type='file' name='plink_image_file' id='plink_image_file' value='' style='visibility: hidden;' >\
                                <div id='new_image'></div>\
                                <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
                              </span>\
                            </div>\
                            <div class='tab-pane fade in active' id='plink_area'><br>\
                              <div  id='area' contenteditable='true' class='drag-cancel'>"+j__("Sayfa Bağlantısı Alanı Ekle butonuna basıldıktan sonra sayfaya eklenecek ve alanın büyüklüğünü sayfa üzerinden yapabileceksiniz")+"...</div> \
                            </div>\
                          </div>\
                        </div> <br>");
  var add_button = $("<br><a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> ");
  poup_header.appendTo(html_popup);
  close_button.appendTo(poup_header);
  galery_inner.appendTo(html_popup);
  popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
  var chapter= $('<div class="panel-group" id="accordion1" style="height: 300px; overflow: auto;"></div>');
  chapter.appendTo(galery_inner);
  $('#plink_tab a:first').tab('show');
  $( "button" ).button();
  $('#button0').click(function(){$("#plink_image0").prop("checked", true); console.log(marker);});
  $('#button1').click(function(){$("#plink_image1").prop("checked", true); marker = video_marker; console.log(marker);});
  var deger = 1;
  console.log(book_data);
  $.each( book_data, function( key, value ) {
    console.log(value.title);
    var title = value.title;
    if(!value.title) title = deger + ". "+j__("Bölüm");
    
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
        $('<input type="radio" name="page_select" value="'+value_page+'">'+page_count+'. '+j__("Sayfa")+'<br>').appendTo('.panel-body_'+value.chapter_id);
      page_count++;
    });
    
  });
  add_button.appendTo(galery_inner);

  close_button.click(function(){
      html_popup.remove();  

      if ( html_popup.length ){
        html_popup.remove();  
      }

    });

  $('#plink_image_file').change(function(){

    var file = this.files[0];
    var name = file.name;
    var size = file.size;
    var type = file.type;
    
    var reader = new FileReader();
    var component = {};
    reader.readAsDataURL(file);
    //console.log(reader);
    reader.onload = function(evt) {
      FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        
        //console.log(contentType);
        if(contentType == 'image'){
          var imageBinary = FileBinary;
          $('#new_image').html('');
          var newImage = $("<img style='width:70px; height:70px;' src='"+imageBinary+"' />");
          marker=imageBinary;
          $('#new_image').append(newImage);
          return;
          
        }
    };

});


  
  add_button.click(function (){  
      
      var width = html_popup.width();
      var height = html_popup.height(); 
      var selected_tab = $('#plink_tab').find('.active').children().attr('href');
      
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
            'width': '0',
            'height': '0',
            'marker': marker,
            'selected_tab': selected_tab,
            'overflow': 'visible',
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'overflow': 'visible',
                'opacity': '1',
                'z-index': 'first',
                'width':width,
                'height':height,
                'opacity':'1'
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
          $('#new_image').html('');
          var newImage = $("<img style='width:70px; height:70px;' src='"+imageBinary+"' />");
          marker=imageBinary;
          $('#new_image').append(newImage);
          return;
          
        }

        
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);
    
  });
  

};