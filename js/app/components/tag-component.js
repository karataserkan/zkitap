'use strict';

$(document).ready(function(){
  $.widget('lindneo.tagComponent', $.lindneo.component, {
    
    options: {
      slideDur : 2000,
      fadeDur : 800 ,
      slideSelector : 'li', // selector for target elements
    }, 
    
    _create: function(){
        
      this._super();
      var that = this;
      var image_width = 0;
      //if( that.options.component.type=='galery')

      if( that.options.component.data.ul.imgs ) {
        var counter=0;
        var ul=$('<ul></ul>');
        ul.css(that.options.component.data.ul.css);
        this.element.parent().find('.some-gallery').css(that.options.component.data['some-gallery'].css);
        
    

        console.log(that);  
        $.each (that.options.component.data.ul.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
            var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
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
    },

    field: function(key, value){
      console.log(image_width);
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});
 
$.fn.getStyleObject = function(){
        var dom = this.get(0);
        var style;
        var returns = {};
        if(window.getComputedStyle){
            var camelize = function(a,b){
                return b.toUpperCase();
            };
            style = window.getComputedStyle(dom, null);
            for(var i = 0, l = style.length; i < l; i++){
                var prop = style[i];
                var camel = prop.replace(/\-([a-z])/g, camelize);
                var val = style.getPropertyValue(prop);
                returns[camel] = val;
            };
            return returns;
        };
        if(style = dom.currentStyle){
            for(var prop in style){
                returns[prop] = style[prop];
            };
            return returns;
        };
        return this.css();
    }
var createTagComponent = function (event,ui){

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px; width800x;'> \
    <div class='popup-header'> \
    <i class='icon-m-galery'></i> &nbsp;Galeri Ekle \
    <i id='galery-add-dummy-close-button' class='icon-close size-10 popup-close-button' style='width: 800px; height:50px;'></i> \
    </div> \
      <div class='gallery-inner-holder' style='width:800px;'> \
        <div style='clear:both'></div> \
        <div style='width:200px; margin-left:0px; float:left;'>\
          <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
          <div id='drag_image'></div>\
        </div>\
        <div id='galery-popup-images' style='margin-left:210px float:left;' >\
        </div> \
      </div> \
     <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn btn-info' >Tamam</a>\
    </div> ").appendTo('body').draggable();
    $('#galery-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });
    $('#drag_image').css('background-image',"url('/css/images/t01.png')");
    $('#drag_image').css('width',"100px");
    $('#drag_image').css('height',"100px");
    $( "#drag_image" ).draggable({
      appendTo: '#galery-popup-images', 
      helper:'clone'
    });
    var count=0;
    $('#galery-popup-images').droppable({
      drop: function (event, ui) {
        console.log(event);
        console.log(ui.position);
        var new_image_tag = $('<img id="tag_'+count+'" style="position:absolute;" src="/css/images/t01.png">');
        var new_image_tag_detail = $('<textarea id="tag_detail_'+count+'"rows="3" style="width:500px; margin-left:150px; margin-top:5px;" placeholder="'+(count+1)+'. Tag için açıklama giriniz...."></textarea><br>');
        new_image_tag.appendTo('#drop_area');
        var tag_margin_left = (ui.position.left-225)-555;
        var tag_margin_top = (ui.position.top-84);
        console.log(tag_margin_left);
        console.log(tag_margin_top);
        new_image_tag.css('margin-top',tag_margin_top+'px');
        new_image_tag.css('margin-left', tag_margin_left+'px');
        new_image_tag_detail.appendTo("#galery-popup-images");
        count++;
      }
    });

    $('#pop-image-OK').click(function (){

      var tagDetails = new Array();
      var tags = new Array();
      
      for ( var i = 0; i < count; i++ ) {
          tagDetails.push($('#tag_detail_'+i).val());
          tags.push($('#tag_0'));
       }
      console.log($('#tag_0').getStyleObject());
      return;
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
            'some-gallery':{
              'css': {
                'width': '100%',
                'height': '100%',
                'min-height':'100px',
                'min-width':'100px',
              }
            },
            'ul':{
              'css': {
                'overflow':'hidden',
                'margin': '0',
                'padding': '0',
                'position': 'relative',
                'min-height':'100px',
                'min-width':'100px',

                'width': image_width,
                'height': image_height,


              },
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
        $('#galery-popup-images').html('<div id="drop_area"><img style="width:560px; padding-left:5px; position:relative;" src='+imageBinary+' /></div>');
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();
     

      }; 
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };
