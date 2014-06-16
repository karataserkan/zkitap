'use strict';

$(document).ready(function(){
  $.widget('lindneo.wrapComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;
      var html_data = html_tag_replace(this.options.component.data.html_inner);
      console.log(html_data);
      
      var wrap_cutoff = this.options.component.data.cutoff;
      //html_data = html_data + '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc justo massa, mattis in imperdiet in, pellentesque sit amet elit. Fusce vitae pulvinar nisi. Ut sed justo nec est congue cursus vestibulum eu dolor. Donec at mauris felis, sit amet ultrices odio. Aliquam erat volutpat. Nullam faucibus metus eu elit luctus sed malesuada risus molestie. Mauris nulla quam, tristique at lobortis at, fringilla quis nibh. Ut sapien mauris, imperdiet eget tincidunt semper, consectetur a augue. Donec vitae nibh augue, ut rhoncus elit. Nullam volutpat lorem sed odio lacinia non aliquet erat consequat. In ac libero turpis. In commodo nisl id diam dapibus varius. Sed lobortis ultricies ligula, quis auctor arcu imperdiet eget. Donec vel ipsum dui. In justo purus, molestie sit amet mattis sed, cursus non orci. Nullam ac massa vel tortor scelerisque blandit quis a sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc justo massa, mattis in imperdiet in, pellentesque sit amet elit. Fusce vitae pulvinar nisi. Ut sed justo nec est congue cursus vestibulum eu dolor. Donec at mauris felis, sit amet ultrices odio. Aliquam erat volutpat. Nullam faucibus metus eu elit luctus sed malesuada risus molestie. Mauris nulla quam, tristique at lobortis at, fringilla quis nibh. Ut sapien mauris, imperdiet eget tincidunt semper, consectetur a augue. Donec vitae nibh augue, ut rhoncus elit. Nullam volutpat lorem sed odio lacinia non aliquet erat consequat. In ac libero turpis. In commodo nisl id diam dapibus varius. Sed lobortis ultricies ligula, quis auctor arcu imperdiet eget. Donec vel ipsum dui. In justo purus, molestie sit amet mattis sed, cursus non orci. Nullam ac massa vel tortor scelerisque blandit quis a sapien.</p>'
      console.log(html_data);
      html_data = html_data.replace('font-family: Arial, Helvetica, sans;', 'font-family: Helvetica;');
      html_data = html_data.replace('font-size: 11px;', 'font-size: 16px;');
console.log(html_data);
      var componentpopupid='popup'+this.options.component.id;

      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componentpopupid+'" style="display:block; font-family: Helvetica; font-size: 16px;" >'+html_data+'</div>');
        popupmessage.appendTo(this.element);
       //$($("#message_"+componentpopupid).find("img")).css("float",this.options.component.data.wrap_align);
      
      }

      //$($("#message_popupxbJ8GPriRdlVmYCy1zxTCzJXikXS7iIswGEJyrT8ck4Z").find("img")).css("float","left")

      
      
      $('.wrapReady.withSourceImage').slickWrap({
                    sourceImage: true,cutoff: wrap_cutoff, resolution: 1
                });
      this._super();       


    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});

var html_tag_replace = function (str){
   //var content = str.replace('&lt;','<')
   //                 .replace('&gt;','>')
   //                 .replace('<div>','')
   //                 .replace('</div>','');
   while( str.indexOf('&lt;') > -1)
      {
        str = str.replace('&lt;', '<');
      }

    while( str.indexOf('&gt;') > -1)
      {
        str = str.replace('&gt;', '>');
      }

    while( str.indexOf('&amp;') > -1)
      {
        str = str.replace('&amp;', '&');
      }

    while( str.indexOf('<div>') > -1)
      {
        str = str.replace('<div>', '');
      }

    while( str.indexOf('</div>') > -1)
      {
        str = str.replace('</div>', '');
      }

    while( str.indexOf('<span>') > -1)
      {
        str = str.replace('<span>', '');
      }

while( str.indexOf('<span style="line-height: 1.428571429;">') > -1)
      {
        str = str.replace('<span style="line-height: 1.428571429;">', '');
      }
    while( str.indexOf('</span>') > -1)
      {
        str = str.replace('</span>', '');
      }
      
      
   //console.log(str);  <span style="line-height: 1.428571429;">
   return str;
};
var width='';
var height='';
var wrap_align='';

var createWrapComponent = function ( event, ui, oldcomponent ) {  
//console.log(oldcomponent); 
 
  if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var popup_value = 'http://linden-tech.com';
      var old_cutoff = '100';
      width = 'auto';
      height = 'auto';
      wrap_align = 'left';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      popup_value = oldcomponent.data.html_inner;
      old_cutoff = oldcomponent.data.cutoff;
      width = oldcomponent.data.width ;
      height = oldcomponent.data.height;
      wrap_align = oldcomponent.data.wrap_align;
    };

    var wrap_right = '';
    var wrap_right_active = '';
    var wrap_left = '';
    var wrap_left_active = '';

    if(wrap_align == 'right') { wrap_right = "checked='checked'"; wrap_right_active = 'active';}
    else { wrap_left = "checked='checked'"; wrap_left_active = 'active'; }
   /* $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      <div class='popup-header'> \
      Görsel/Video Ekle \
      <i id='popup-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
      </div> \
        <div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
        <div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' > \
          <div  id='popup-explanation' style='width:100%;height:100%; ' contenteditable='true' class='drag-cancel'>" + popup_value + ". \
         </div>  \
        </div> <br>\
        <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' style='padding: 5px 30px;'>Ekle</a> \
      </div> \
      </div>").appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();*/
    
    var pop_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:" + top + "; left: " + left + "; width:700px;'> \
      </div>");
    pop_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
    var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;"+j__("Metinle Çevrele Ekle")+" </div> ");
    var close_button = $("<i id='popup-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
    var drag_file = $("<div class='add-image-drag-area' id='dummy-dropzone'> </div> ");
    var galery_inner = $("<div class='gallery-inner-holder' style='width: 700px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
        <div class='type' style='padding: 4px; '>\
                <div class='btn-group'>\
                  <label class='btn btn-primary " + wrap_right_active + "'>\
                    <input type='radio' name='wrap_align' id='repeat0' " + wrap_right + " value='right'> "+j__("Sağ")+"\
                  </label>\
                  <label class='btn btn-primary " + wrap_left_active + "'>\
                    <input type='radio' name='wrap_align' id='repeat1' " + wrap_left + " value='left'> "+j__("Sol")+"\
                  </label>\
                </div><br><br>\
                <p>\
                  <label for='cutoff'>"+j__("Tolerans değerini belirleyin")+" (0 - 200) </label>\
                  <input type='text' name='cutoff' id='cutoff' value='"+old_cutoff+"' style='border:0; color:#f6931f; font-weight:bold;' onclick='this.select()' placeholder='"+j__("Çözünürlik Toleransı giriniz")+"....'><br><br>\
                </p>\
                <div id='slider'></div>\
            </div>\
      </div> ");
    var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
    var popup_detail = $("<div  id='popup-explanation' contenteditable='true' class='drag-cancel' style='min-height:300px;'>" + popup_value + "</div>");
    var add_button = $("<a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> ");
    poup_header.appendTo(pop_popup);
    close_button.appendTo(poup_header);
    galery_inner.appendTo(pop_popup);
    popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
    drag_file.prependTo(popup_wrapper);
    popup_detail.appendTo(popup_wrapper);
    add_button.appendTo(galery_inner);
    popup_detail.resizable({alsoResize: galery_inner});

    $("input[name=wrap_align]:radio").change(function () {
        wrap_align=$('input[name=wrap_align]:checked').val();
        console.log(wrap_align);
      });

    close_button.click(function(){

      pop_popup.remove();  

      if ( pop_popup.length ){
        pop_popup.remove();  
      }

    });

    $( "#slider" ).slider({
      value: old_cutoff,
      min: 0,
      max: 200,
      step: 10,
      slide: function( event, ui ) {
        $( "#cutoff" ).val( ui.value );
      }
    });
    $( "#cutoff" ).val( $( "#slider" ).slider( "value" ) );
    
    
    
    add_button.click(function (){  
      
      //var width = pop_popup.width();
      //var height = pop_popup.height(); 
      //console.log(width);
      //console.log(height);  
      wrap_align=$('input[name=wrap_align]:checked').val();
      //console.log(wrap_align);    
      var html_inner = $("#popup-explanation").html();
      if(typeof oldcomponent == 'undefined'){
        //console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
        var self_width = 'auto';
        var self_height = 'auto';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        //window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        //oldcomponent.data.html_inner = $("#popup-explanation").html();
        console.log(oldcomponent.data.wrap_align);
        html_inner.replace(oldcomponent.data.wrap_align,wrap_align);
        console.log(wrap_align);
        console.log(html_inner);
        var self_width = oldcomponent.data.self.css.width ;
        var self_height = oldcomponent.data.self.css.height;

      };
      
      console.log(self_width);
      console.log(self_height);
       var  component = {
          'type' : 'wrap',
          'data': {
            'html_inner':  html_inner,
            'cutoff':  $("#cutoff").val(),
            'wrap_align':  wrap_align,
            'width': self_width,
            'height': self_height,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': self_width,
                'height': self_height,
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': 'first'
              }
            }
          }
        };
        //console.log(component);
        window.lindneo.tlingit.componentHasCreated( component );
        
        close_button.trigger('click');

    });
    
    var el = document.getElementById("dummy-dropzone");
    var FileBinary = '';

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
      //console.log(reader);
      reader.onload = function (evt) {

        FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        
        //console.log(contentType);
        if(contentType == 'image'){
          var imageBinary = FileBinary;
          var newImage = $("<img class='wrapReady withSourceImage "+wrap_align+"' style='float:"+wrap_align+"; padding:30px;' src='"+imageBinary+"' >");

          $('#popup-explanation').append(newImage);
          return;
          
        }
        

        
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };