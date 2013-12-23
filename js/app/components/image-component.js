'use strict';

$(document).ready(function(){
  $.widget('lindneo.imageComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
      

    
      if( this.options.component.data.img ) {
        this.element.attr('src', this.options.component.data.img.src);  
      }
      
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
            // access image size here 
            console.log(this.width);
            var image_width = this.width;
            var image_height = this.height;
        
        
        imageBinary = evt.target.result;        
        
        component = $.parseJSON(window.lindneo.tlingit.componentToJson(that.options.component));
        console.log(component);
        component.data.img.src = imageBinary;
        component.data.self.css.width = 
        window.lindneo.tlingit.componentHasCreated(component);
        window.lindneo.nisga.deleteComponent(that.options.component);
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
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



var createImageComponent = function ( event, ui ) {

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Görsel Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
      <div>\
        <input type='text' name='width' id='width' placeholder='Genişlik' value=''>\
        <input type='text' name='height' id='height' placeholder='Yükseklik' value=''>\
      </div> \
    </div>").appendTo('body').draggable();

    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

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
      var image_width = '200px';
      var image_height = '150px';
      if($('#width').val() != '')
        image_width = $('#width').val()+'px';
      if($('#height').val() != '')
        image_height = $('#height').val();
      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};

      reader.onload = function (evt) {
          
        var image = new Image();
        image.src = evt.target.result;

        image.onload = function() {
            // access image size here 
            
            image_width = this.width + 'px';
            image_height = this.height + 'px';

        
console.log(image_width);
        imageBinary = evt.target.result;        
        
        $("#image-add-dummy-close-button").trigger('click');

        component = {
          'type' : 'image',
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
              } , 
              'src': imageBinary
            },
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
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