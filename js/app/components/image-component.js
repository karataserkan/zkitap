'use strict';

$(document).ready(function(){
  $.widget('lindneo.imageComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
      
console.log(this.options.component);
      var componentimageid='image'+this.options.component.id;
        if(this.options.component.data.img.image_type == 'popup'){
          if( this.options.marker ) {
            //var newimage=$('<img id="img_'+componentimageid+'" src="' + this.options.marker +  '"/>');
            //console.log(this.options);
            //newimage.appendTo(this.element);
            this.element.attr('src', this.options.marker);
          }
          this.options.component.data.html_inner = '<img src="' + this.options.component.data.img.src + '" ></img> ';
          var popupmessage=$('<div  id="message_'+componentimageid+'" style="display:none" >'+this.options.component.data.html_inner+'</div>');
          popupmessage.appendTo(this.element.parent());
        }
      else{
        if( this.options.component.data.img ) {
          //var source = $('<img src="' + this.options.component.data.img.src + '" ></img> ');

          //source.appendTo(this.element);
          this.element.attr('src', this.options.component.data.img.src);  
        }
      }
      //console.log(this.options.component);
      
      var el=this.element.get(0);
      var imageBinary;


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

      reader.onload = function (evt) {

        var image = new Image();
        image.src = evt.target.result;

        image.onload = function() {

          //console.log(this.width);
          var image_width = this.width;
          var image_height = this.height;
          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
          //console.log(size);
          image_width = size.w;
          image_height = size.h;

          imageBinary = evt.target.result;        
          
          component = $.parseJSON(window.lindneo.tlingit.componentToJson(that.options.component));
          //console.log(component.data.lock);
          if(component.data.lock == ''){ 
           
            component.data.img.src = imageBinary;
            component.data.self.css.width = image_width;
            component.data.self.css.height = image_height;

            
            window.lindneo.tlingit.componentHasCreated(component);
            window.lindneo.tlingit.componentHasDeleted(that.options.component, that.options.component.id);
            
          };
        };
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

      this._super();
    },
    getSettable : function (propertyName){
     return this.options.component.data.img;
    },

    field: function(key, value){
      console.log(key);
      console.log(value);
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



var createImageComponent = function ( event, ui ,oldcomponent) {

  var marker = window.base_path+'/css/popupmarker.svg';
  var video_marker=window.base_path+'/css/image_play_trans.svg';
  var image_width_height = '';
  var image_type_image = function(){
      var image_type = $('input[name=image_type]:checked').val();
        if(image_type == 'popup'){
          $("<span id='type_image'>\
                <input type='radio' id='image_type0' name='image_popup_type' value='image_type0'><button id='button0' style='background:url(\""+marker+"\") no-repeat center center;-moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button>\
                <input type='radio' id='image_type1' name='image_popup_type' value='image_type1'><button id='button1' style='background:url(\""+video_marker+"\") no-repeat center center; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button>\
                <a href='#' onclick='document.getElementById(\"image_popup_file\").click(); return false;' class='icon-upload dark-blue size-40' style='padding-left:15px;'></a>\
                <input type='file' name='image_popup_file' id='image_popup_file' value='' style='visibility: hidden;' >\
                <div id='new_image'></div>\
              </span>").appendTo('.typei');
          $( "button" ).button();
          $('#button0').click(function(){$("#image_type0").prop("checked", true); console.log(marker);});
          $('#button1').click(function(){$("#image_type1").prop("checked", true); marker = video_marker; console.log(marker);});
        }
        else{ 
          $('#type_image').remove();
        }
    };

  if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var image_type = 'link';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      image_type = oldcomponent.data.img.image_type;
      marker = oldcomponent.data.marker;
    };
    var link_check = '';
    var link_check_active = '';
    var popup_check = '';
    var popup_check_active = '';

    if(image_type == 'link') { link_check = "checked='checked'"; link_check_active = 'active';}
    else { popup_check = "checked='checked'"; popup_check_active = 'active'; }

    //console.log(link_check);
    //console.log(popup_check);
    var min_left = $("#current_page").offset().left;
    var min_top = $("#current_page").offset().top;
    var max_left = $("#current_page").width() + min_left;
    var max_top = $("#current_page").height() + min_top;

    top=(event.pageY-25);
    left=(event.pageX-150);

    if(left < min_left)
      left = min_left;
    else if(left+310 > max_left)
      left = max_left - 310;

    if(top < min_top)
      top = min_top;
    else if(top+600 > max_top)
      top = max_top - 600;

    top = top + "px";
    left = left + "px";

      var img_cmp="<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        <i class='icon-m-image'></i> &nbsp;Görsel Ekle \
        <i id='images-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='typei' style='padding: 4px; display: inline-block;'>\
                <div class='btn-group' data-toggle='buttons'>\
                  <label class='btn btn-primary " + link_check_active + "'>\
                    <input type='radio' name='image_type' id='repeat0' " + link_check + " value='link'> Sayfada\
                  </label>\
                  <label class='btn btn-primary " + popup_check_active + "'>\
                    <input type='radio' name='image_type' id='repeat1' " + popup_check + " value='popup'> Açılır Pencerede\
                  </label>\
                </div><br><br>\
            </div>\
            <div class='tabbable'>\
              <ul class='nav nav-tabs' id='myTab'>\
                <li><a href='#image_drag' data-toggle='tab'>Resim Sürükle</a></li>\
                <li><a href='#image_upload' data-toggle='tab'>Resim Yükle</a></li>\
              </ul>\
            </div>\
            <div class='tab-content'>\
              <div class='tab-pane fade in active' id='image_drag'><br>\
                <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
              </div>\
              <div class='tab-pane fade' id='image_upload'><br>\
                <input type='file' name='image_file' id='image_file' value='' ><br><br>\
              </div>\
            </div>\
            <input type='text' name='width' id='width' placeholder='Genişlik' value=''>\
            <input type='text' name='height' id='height' placeholder='Yükseklik' value=''>\
          </div> \
        </div>";
        $(img_cmp).appendTo('body').draggable();
        if(image_type == 'popup') image_type_image();

        $('#images-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });
        $( "#repeat" ).buttonset();
        $('#myTab a:first').tab('show');

  var imagePopupBinary = '';
    $(document ).on('change','#image_popup_file' , function(){
    
      var that = this;
      var file = that.files[0];
      var name = file.name;
      var size = file.size;
      var type = file.type;
      var token = '';
      //console.log('dene');
      var reader = new FileReader();
      //console.log(reader);
      var component = {};
      reader.readAsDataURL(file);
      //console.log(reader);
      reader.onload = function(_file) {
        imagePopupBinary = _file.target.result;
        console.log(imageBinary);
        $('#new_image').html('');
        $("<input type='radio' id='image_type2' name='image_popup_type' value='image_type2' checked='checked'><button id='button2' style='background:url(" + imagePopupBinary +") no-repeat center center; no-repeat center center; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button><br><br>").appendTo('#new_image');
        $( "button" ).button();
        marker = imagePopupBinary;
        //console.log(marker);
      }
      //console.log(marker);
    });

    $("input[name=image_type]:radio").change(function () {
        image_type_image();
      });
  
  $('#image_file').change(function(){
    if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );

    };
    var image_type = $('input[name=image_type]:checked').val();
    //console.log(image_type);
    //console.log(marker);
    var image_width = '200px';
    var image_height = '150px';
    var file = this.files[0];
    var name = file.name;
    var size = file.size;
    var type = file.type;
    
    var reader = new FileReader();
    var component = {};
    reader.readAsDataURL(file);
    //console.log(reader);
    reader.onload = function(_file) {
      //console.log(_file);
      var image = new Image();
        image.src = _file.target.result;

        image.onload = function() {
            // access image size here 
            
            image_width = this.width;
            image_height = this.height;
            if($('#width').val() != '')
              image_width = $('#width').val();
            if($('#height').val() != '')
              image_height = $('#height').val();
            var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
            image_width = size.w;
            image_height = size.h;

        
        
        imageBinary = _file.target.result;      
        //console.log(top);
        //$("#images-add-dummy-close-button").trigger('click');
        if(image_type == 'popup') {image_width_height = '80px';image_height='80px';image_width='80px';}
        else image_width_height = '100%';

        component = {
          'type' : 'image',
          'data': {
            'img':{
              'css' : {
                'width':image_width_height,
                'height':image_width_height,
                'margin': '0',
                'padding': '0px',
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } , 
              'image_type' : image_type,
              'marker' : marker,
              'src': imageBinary
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': image_width,
                'height': image_height,
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '990'
              }
            }
          }
        };
        $('#images-add-dummy-close-button').click();
        window.lindneo.tlingit.componentHasCreated( component );
      };
    };

});

    var el = document.getElementById("dummy-dropzone");
    var imageBinary = '';

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

    if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
      console.log(oldcomponent);
    };

    var image_type = $('input[name=image_type]:checked').val();
    var image_width = '200px';
    var image_height = '150px';

      //console.log(ui);
      
      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};

      reader.onload = function (evt) {

        var image = new Image();
        image.src = evt.target.result;

        image.onload = function() {
            // access image size here 
            
            image_width = this.width;
            image_height = this.height;
            if($('#width').val() != '')
              image_width = $('#width').val();
            if($('#height').val() != '')
              image_height = $('#height').val();
            var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
            image_width = size.w;
            image_height = size.h;

        
        //console.log(image_width);
        imageBinary = evt.target.result;      
        
        $("#images-add-dummy-close-button").trigger('click');
        
        if(image_type == 'popup') image_width_height = '80%';
        else image_width_height = '100%';

        component = {
          'type' : 'image',
          'data': {
            'img':{
              'css' : {
                'width':image_width_height,
                'height':image_width_height,
                'margin': '0',
                'padding': '0px',
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } , 
              'image_type' : image_type,
              'marker' : marker,
              'src': imageBinary
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': image_width,
                'height': image_height,
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '990'
              }
            }
          }
        };

        window.lindneo.tlingit.componentHasCreated( component );
      };
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };
