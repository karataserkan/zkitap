'use strict';

$(document).ready(function(){
  $.widget('lindneo.thumbComponent', $.lindneo.component, {
    
    options: {
      slideDur : 2000,
      //fadeDur : 800 ,
      slideSelector : 'li', // selector for target elements
    }, 
    
    _create: function(){
        
      this._super();
      var that = this;
      var image_width = 0;
      //if( that.options.component.type=='galery')
      console.log(that.options.component);
      //return;
      if( that.options.component.data.slides.imgs ) {
        var counter=0;
        var wrapper =  $('<div id="wrapper" style="width:'+that.options.component.data.somegallery.css.width+'; height:'+that.options.component.data.somegallery.css.height+'"></div>');
        var scroller =  $('<div id="scroller"></div>');
        var ul=$('<ul></ul>');
        //ul.css(that.options.component.data.ul.css);
        this.element.parent().find('.some-gallery').css(that.options.component.data['somegallery'].css);
        
    

        console.log(that);  
        $.each (that.options.component.data.slides.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            var image= $('<img class="galery_component_image" style="display: block; margin: auto;  src="'+value.src+ '" />'); 
            var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            image.appendTo(container);        
            container.appendTo(ul);
          }       
        });
        ul.appendTo(scroller);
        scroller.appendTo(wrapper);
        ul.addClass('galery_component_ul');
        that.element.parent().addClass('galery_component_wrap');
        wrapper.appendTo(that.element);
        that.element.first().show();

        $('<div style="clear:both"></div>').appendTo(that.element);

      }
    },

    field: function(key, value){
      console.log(image_width);
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});
 

var createThumbComponent = function (event,ui){

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    <i class='icon-m-galery'></i> &nbsp;Galeri Ekle \
    <i id='galery-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <input type='text' class='form-control' id='thumb_width' placeholder='Width' style='width:45%; float:left;'>\
        <input type='text' class='form-control' id='thumb_height' placeholder='Height' style='width:45%; float:right;'><br><br>\
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
      <ul id='galery-popup-images' style='width: 250px;'> \
      </ul> \
     <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn btn-info' >Tamam</a>\
    </div> ").appendTo('body').draggable();
    $('#galery-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });



    $('#pop-image-OK').click(function (){
      //console.log($('#thumb_width').val());
      //console.log($('#thumb_height').val());

      var imgs=[];
        $('#galery-popup-images img').each(function( index ) {
          var img={
              'css' : {

                'margin': '30%',
                
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } , 
              'src': $( this ).attr('src')
            }
            imgs.push(img);

          console.log( index + ": " + $( this ).text() );
        });

      

      var component = {
          'type' : 'thumb',
          'data': {
            'somegallery':{
              'css': {
                'width': $('#thumb_width').val(),
                'height': $('#thumb_height').val(),
                'min-height':$('#thumb_width').val(),
                'min-width':$('#thumb_height').val(),
              }
            },
            'slides':{
                'imgs':imgs       
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',

          

                'background-color': 'transparent',
                

              }
            }
          }
        };
        console.log(component);
        //return;
         window.lindneo.tlingit.componentHasCreated( component );
         $("#galery-add-dummy-close-button").trigger('click');

    });

    var control_val = 0;
    var image_width = 0;
    var image_height = 0;
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
        
        console.log(image_width);
        console.log(control_val);
        imageBinary = evt.target.result;
        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><img src='+imageBinary+' /> \
          <a class="btn btn-info size-15 icon-delete galey-image-delete hidden-delete " style="margin-left: 38px;"></a> \
          </li>');
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();
     

      }; 
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };
