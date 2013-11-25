'use strict';

$(document).ready(function(){
  $.widget('lindneo.soundComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;

    
      if(this.options.component.data.source.attr.src ) {
        var source=$('<source src="'+this.options.component.data.source.attr.src+'" /> ');
        var audio=$('<audio controls="controls"></audio>');
        var audio_name=$('<span class="audio-name" >'+this.options.component.data.audio.name+'</span>');
 
        source.appendTo(audio);

        audio.appendTo(this.element);
        audio.appendTo(this.element);


        // this.element.attr('src', this.options.component.data.img.src);  
      }
      

      this._super();
    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



 var createSoundComponent = function (event,ui){

  $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Ses Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
         <input type='text' class='input-textbox' id='pop-sound-name' placeholder='Ses Adı'  /> \
      <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn white btn radius ' >Tamam</a>\
    </div>").appendTo('body');

    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });


    $('#pop-image-OK').click(function (){

      

      var component = {
          'type' : 'sound',
          'data': {
              'audio':{
                'attr': {
                  'controls':'controls'
                },
                'css': {
                  'width' : '100%',
                  'height': '30px',
                },
                'name': $('#pop-sound-name').val()
              },
              'source': {
                'attr': {
                  'src':imageBinary
                }
              },
              '.audio-name': {
                'css': {
                  'width':'100%'
                }
              },
              'self': {
                'css': {
                  'position':'absolute',
                  'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                  'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                  'width': 'auto',
                  'height': '60px',
                  'background-color': 'transparent',
                  'overflow': 'visible'
                }
              }
            
          }
        };
        

        window.lindneo.tlingit.componentHasCreated( component );
        $("#image-add-dummy-close-button").trigger('click');


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
        
        
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };