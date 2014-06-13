'use strict';

$(document).ready(function(){
  $.widget('lindneo.galeryComponent', $.lindneo.component, {
    
    options: {
      slideDur : 2000,
      fadeDur : 800 ,
      slideSelector : 'li', // selector for target elements
    }, 
    
    _create: function(){
        
      var that = this;
      //var image_width = "";
      //if( that.options.component.type=='galery')
      //console.log(that.options.component.data);
      if( that.options.component.data.ul.imgs ) {
        var counter=0;
        var ul=$('<ul></ul>');
        ul.css(that.options.component.data.ul.css);
        this.element.parent().find('.some-gallery').css(that.options.component.data['some_gallery'].css);
        
    
        //console.log(that);

        that.imageDOMs=[];  
        $.each (that.options.component.data.ul.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            //var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
            //var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            if( that.options.component.data.galery_type=='inner'){
              var image= $('<img class="galery_component_image" style="display: block; margin: auto auto; height:auto; padding:0; position:absolute; top:0; right:0; bottom:0; left:0; " src="'+value.src+ '" />'); 
              var container=$('<li class="galery_component_li" style="background-color:black; float:left; position: relative; clear:both; width: 100%; height: 100%; '+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
              image.galleryContainer=container;
              that.imageDOMs.push(image);
              }
            else{
              var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
              var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            }
            image.appendTo(container);        
            container.appendTo(ul);
          }       
        });

        ul.addClass('galery_component_ul');
        that.element.parent().addClass('galery_component_wrap');
        ul.appendTo(that.element);
        that.element.first().show();

        $('<div style="clear:both"></div>').appendTo(that.element);

      }
      this._super({resizableParams:{handles:"e, s, se", minWidth:100, minHeight:100,resize:function(event,ui){
                                                        
                                                        window.lindneo.toolbox.makeMultiSelectionBox();
                                                        if( that.options.component.data.galery_type=='inner')
                                                            that.also_resize_inner_images(event,ui,that);

                                                      }
    }});
    },

    also_resize_inner_images: function(event,ui,that){
                                                      $.each(that.imageDOMs,function(index,element){
                                                            var containerWidth = element.galleryContainer.width();
                                                            var containerHeight = element.galleryContainer.height();
                                                            var imageWidth = element.width();
                                                            var imageHeight = element.height();

                                                            var containerAspect = containerWidth/containerHeight;
                                                            var imageAspect = imageWidth/imageHeight;

                                                            if(containerAspect<imageAspect){
                                                              element.css({'width':containerWidth +"px" , "height" : "auto" });
                                                            } else {
                                                              element.css({'height':containerHeight +"px" , "width" : "auto" });
                                                            }
                                                            //console.log(containerWidth);
                                                        });
    },

    field: function(key, value){
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});
 
var image_width ;
var image_height;

var createGaleryComponent = function (event,ui, oldcomponent){

  if(typeof oldcomponent == "undefined"){
    var galery_type = "inner";
  }
  else{
    var galery_type = oldcomponent.data.galery_type;
  }
    

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

    var control_y_check ="";
    var control_y_check_active ="";
    var control_n_check ="";
    var control_n_check_active ="";
    if(galery_type == 'inner') { control_y_check = "checked='checked'"; control_y_check_active = 'active';}
    else { control_n_check = "checked='checked'"; control_n_check_active = 'active'; }
    
    console.log(min_top);
    console.log(max_top);
    if(left < min_left)
      left = min_left;
    else if(left+310 > max_left)
      left = max_left - 310;

    if(top < min_top)
      top = min_top;
    else if(top+500 > max_top)
      top = max_top - 500;

console.log(top);

    top = top + "px";
    left = left + "px";

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      <div class='popup-header'> \
        <i class='icon-m-galery'></i> &nbsp;"+j__("Galeri Ekle")+" \
        <i id='galery-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i>\
      </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='tabbable'>\
          <ul class='nav nav-tabs' id='myTab'>\
            <li><a href='#galery_drag' data-toggle='tab'>"+j__("Resim Sürükle")+"</a></li>\
            <li><a href='#galery_upload' data-toggle='tab'>"+j__("Resim Yükle")+"</a></li>\
          </ul>\
        </div>\
        <div class='tab-content'>\
          <div class='tab-pane fade in active' id='galery_drag'><br>\
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
          </div>\
          <div class='tab-pane fade' id='galery_upload'><br>\
            <!--<input type='file' name='image_file' id='image_file' value='' >-->\
            <span class='btn btn-success fileinput-button'>\
              <i class='fa fa-plus'></i>\
              <span>"+j__("Resim Ekle")+"</span>\
              <input type='file' name='files[]' id='image_file' multiple>\
            </span><br><br>\
          </div>\
        </div>\
      </div> \
      <ul id='galery-popup-images' style='width: 250px;'> \
      </ul> \
     <div style='clear:both' > </div> \
     <div class='type1' style='padding: 4px; display: inline-block;'>\
        <div class='btn-group' data-toggle='buttons'>"+j__("Galeri Tipi")+"<br>\
          <label class='btn btn-primary " + control_y_check_active + "'>\
            <input type='radio' name='galery_type' id='repeat0' " + control_y_check + " value='inner'> "+j__("İçe Yaslı")+"\
          </label>\
          <label class='btn btn-primary " + control_n_check_active + "'>\
            <input type='radio' name='galery_type' id='repeat1' " + control_n_check + " value='outer'> "+j__("dışa Yaslı")+"\
          </label>\
        </div>\
    </div><br><br>\
     <a id='pop-image-OK' class='btn btn-info' >"+j__("Tamam")+"</a>\
    </div> ").appendTo('body').draggable();
    
    $("#galery-add-dummy-close-button").click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });

    $(".fileinput-button").css({"position": "relative", "overflow": "hidden"});
    $(".fileinput-button input[type=file]").css({"position": "absolute", "top": "0", "right": "0", "min-width": "100%", "min-height": "100%", "font-size": "999px", "text-align": "right", "filter": "alpha(opacity=0)", "opacity": "0", "outline": "none", "background": "white", "cursor": "inherit", "display": "block"});    
    if(typeof oldcomponent != "undefined"){
      
      $.each(oldcomponent.data.ul.imgs, function(i,val){
        //console.log(val.src);
        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><a class="btn btn-info size-10 icon-delete galey-image-delete  " style="margin-left: 42px; position:absolute;"></a>\
            <img style="height:100%; " src='+val.src+' /> \
          </li>');
      });
      var top = oldcomponent.data.self.css.top;
      var left = oldcomponent.data.self.css.left;
      //console.log(top);
      //console.log(oldcomponent.data.self.css.width);
      $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
      $('#galery-popup-images').disableSelection(); 
      
    }
    else{
      top = (ui.offset.top-$(event.target).offset().top )+ 'px';
      left = ( ui.offset.left-$(event.target).offset().left )+ 'px';
    }

    $('.galey-image-delete').click(function(){

      //console.log(this);
      $(this).parent().remove();

    });



    $('#pop-image-OK').click(function (){

      if(typeof oldcomponent != "undefined"){
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        //console.log(oldcomponent.data.self.css.width);
        image_width = oldcomponent.data.self.css.width;
        image_height = oldcomponent.data.self.css.height;
      }
      else{
        image_width = "200px";
        image_height = "200px";
      }
      var galery_type = $('input[name=galery_type]:checked').val();
      var imgs=[];
        $('#galery-popup-images img').each(function( index ) {
          var img={
              'css' : {

                'height':'100%',
                'margin': '0',
                
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } , 
              'src': $( this ).attr('src')
            }
            imgs.push(img);

          console.log( index + ": " + $( this ).text() );
        });

      //console.log(image_width);
      //return;
      var component = {
          'type' : 'galery',
          'data': {
            'some_gallery':{
              'css': {
                'width': '100%',
                'height': '100%',
                'min-height':'100px',
                'min-width':'100px',
              }
            },
            'galery_type': galery_type,
            'ul':{
              'css': {
                'overflow':'hidden',
                'margin': '0',
                'padding': '0',
                'position': 'relative',
                'min-height':'100px',
                'min-width':'100px',
                'width': '100%',
                'height': '100%'
                


              },
            'imgs':imgs
            
         
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'background-color': 'transparent',
                'width': image_width,
                'height': image_height,
                'z-index': 'first',
                'opacity':'1'

              }
            }
          }
        };

         window.lindneo.tlingit.componentHasCreated( component );
         $("#galery-add-dummy-close-button").trigger('click');

    });

    var control_val = 0;
    
    var el = document.getElementById("dummy-dropzone");
    var imageBinary = '';


  //$('#image_file').change(function(){
    var filesInput = document.getElementById("image_file");
        
    filesInput.addEventListener("change", function(event){

    var image_type = $('input[name=image_type]:checked').val();

    var files = event.target.files;
    console.log(files);

    for(var i = 0; i< files.length; i++)
    {
        var file = files[i];
        
        //Only pics
        if(!file.type.match('image'))
          continue;
        
        var picReader = new FileReader();
        
        picReader.addEventListener("load",function(event){
            
            var picFile = event.target;
            
            //var div = document.createElement("div");
            
            //div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                    //"title='" + picFile.name + "'/>";
            
            //output.insertBefore(div,null);            
            imageBinary = picFile.result;
       
        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><a class="btn btn-info size-10 icon-delete galey-image-delete  " style="margin-left: 42px; position:absolute;"></a>\
            <img style="height:100%; " src='+imageBinary+' /> \
          </li>');
        $('.galey-image-delete').click(function(){

          //console.log(this);
          $(this).parent().remove();

        });
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();
        
        });
        
         //Read the image
        picReader.readAsDataURL(file);
    }   
    //console.log(image_type);
    //console.log(marker);
    /*
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
          if(control_val == 0)
            {
              //console.log(this.width);
              image_width = this.width;
              image_height = this.height;
              var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
              image_width = size.w;
              image_height = size.h;
              control_val++;
            }
        
        //console.log(image_width);
        //console.log(control_val);
        imageBinary = image.src;
       
        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><a class="btn btn-info size-10 icon-delete galey-image-delete  " style="margin-left: 42px; position:absolute;"></a>\
            <img style="height:100%; " src='+imageBinary+' /> \
          </li>');
        $('.galey-image-delete').click(function(){

          //console.log(this);
          $(this).parent().remove();

        });
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();      
            
      };
    };
    */
});

    el.addEventListener("dragenter", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("dragexit", function(e){
      e.stopPropagation();
      e.preventDefault();
    },false);

    el.addEventListener("dragover", function(e){
      e.stopPropagation ();
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
           
            // access image size here 
            if(control_val == 0)
            {
              //console.log(this.width);
              image_width = this.width;
              image_height = this.height;
              var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
              image_width = size.w;
              image_height = size.h;
              control_val++;
            }
        
        //console.log(image_width);
        //console.log(control_val);
        imageBinary = evt.target.result;
        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><a class="btn btn-info size-10 icon-delete galey-image-delete  " style="margin-left: 42px; position:absolute;"></a>\
            <img style="height:100%; " src='+imageBinary+' /> \
          </li>');
        $('.galey-image-delete').click(function(){

          //console.log(this);
          $(this).parent().remove();

        });
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();
     

      }; 
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };
