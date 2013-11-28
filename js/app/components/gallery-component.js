'use strict';

$(document).ready(function(){
  $.widget('lindneo.galeryComponent', $.lindneo.component, {
    
    options: {
      slideDur : 2000,
      fadeDur : 800 ,
      slideSelector : 'li', // selector for target elements
     
    }


    
    , 

    _create: function(){

     
     
      

      this._super();
      var that = this;

      //if( that.options.component.type=='galery')

      if( that.options.component.data.ul.imgs ) {
        var counter=0;
        var ul=$('<ul></ul>');
        console.log(that);  
        $.each (that.options.component.data.ul.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
            var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            image.appendTo(container);
           
            container.appendTo(ul);
              
            


           
            //$(that).html(image);   
          }       
        });
        ul.addClass('galery_component_ul');
        that.element.parent().addClass('galery_component_wrap');
        ul.appendTo(that.element);
       // that.element.find('li').hide();
        that.element.first().show();

        $('<div style="clear:both"></div>').appendTo(that.element);

      }
    },


    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});
 

var createGaleryComponent = function (event,ui){


    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Galeri Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
      <ul id='galery-popup-images' style='width: 250px;'> \
      </ul> \
     <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn white btn radius ' >Tamam</a>\
    </div> ").appendTo('body');
    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });

    $('#pop-image-OK').click(function (){

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

        
      var component = {
          'type' : 'galery',
          'data': {
            'ul':{
              'css': {
                'overflow':'hidden',
                'margin': '0',
                'padding': '0',
                'position': 'relative',
                'width': '100%',
                'height': '100%',
              },
            'imgs':imgs
            
         
            },
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '300px',
                'height': '200px',

                'background-color': 'transparent',
                

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
      e.stopPropagation ();
      e.preventDefault();
    }, false);

    el.addEventListener("drop", function(e){
      
      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};

      reader.onload = function (evt) {

        imageBinary = evt.target.result;        

        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><img style="height:100%;" src='+imageBinary+' /> \
          <a class="btn red white size-15 radius icon-delete galey-image-delete hidden-delete " style="margin-left: 38px;"></a> \
          </li>');
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();
     

       
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };
