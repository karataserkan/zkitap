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

        imageBinary = evt.target.result;        
        
        component = $.parseJSON(window.lindneo.tlingit.componentToJson(that.options.component));
        console.log(component);
        component.data.img.src = imageBinary;

        window.lindneo.tlingit.componentHasCreated(component);
        window.lindneo.nisga.deleteComponent(that.options.component)
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
    </div>").appendTo('body');

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
      
      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};

      reader.onload = function (evt) {

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
                'width': '100px',
                'height': '20px',
                'background-color': 'transparent',
                'overflow': 'visible',
                'z-index': '990'
              }
            }
          }
        };

        window.lindneo.tlingit.componentHasCreated( component );
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };