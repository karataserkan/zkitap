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

          console.log(this.width);
          var image_width = this.width;
          var image_height = this.height;
          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
          console.log(size);
          image_width = size.w;
          image_height = size.h;

          imageBinary = evt.target.result;        
          
          component = $.parseJSON(window.lindneo.tlingit.componentToJson(that.options.component));
          console.log(component.data.lock);
          if(component.data.lock == ''){ 
           
            component.data.img.src = imageBinary;
            component.data.self.css.width = image_width;
            component.data.self.css.height = image_height;

            
            window.lindneo.tlingit.componentHasCreated(component);
            window.lindneo.tlingit.componentHasDeleted(that.options.component.id);
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
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



var createImageComponent = function ( event, ui ,oldcomponent) {

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

      console.log(ui);


    if(typeof oldcomponent == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
    };
      
      var image_width = '200px';
      var image_height = '150px';
      
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