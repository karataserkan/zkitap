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
      var componenttagid='tag'+this.options.component.id;
      if( that.options.component.data.tagDetails ) {
        console.log(that.options.component.data.tagDetails[0]);
        console.log(that.options.component.data.tags[0][0]);
        console.log(that.options.component.data.imageBinary);
        //return;
        var source = $('<div  id="message_'+componenttagid+'" style="width:560px;" ></div>');
        var source_image = $('<img src="' + this.options.component.data.imageBinary + '" style="width:560px; padding-left:5px; position:relative;" >');

        source.appendTo(this.element);
        source_image.appendTo(source);
        $.each( that.options.component.data.tags, function( key, value ) {
          console.log(that.options.component.data.tagDetails[key]);
          $('<a data-toggle="modal" data-target="#myModal'+key+'"><img src="/css/images/t01.png" style="position:absolute; margin-top:'+value[0]+';margin-left:'+value[1]+'"></a> ').appendTo(source);
          $('<div class="modal fade" id="myModal'+key+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:100px; z-index:9999;">\
              <div class="modal-dialog">\
                <div class="modal-content">\
                  <div class="modal-header">\
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                    <h4 class="modal-title" id="myModalLabel">'+j__("Modal title")+'</h4>\
                  </div>\
                  <div class="modal-body">\
                    '+that.options.component.data.tagDetails[key]+'\
                  </div>\
                  <div class="modal-footer">\
                    <button type="button" class="btn btn-default" data-dismiss="modal">'+j__("Close")+'</button>\
                    <button type="button" class="btn btn-primary">'+j__("Save changes")+'</button>\
                  </div>\
                </div>\
              </div>\
            </div>').appendTo('body');
        });
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

var createTagComponent = function (event,ui){

  var imageBinary = '';

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px; width800x;'> \
    <div class='popup-header'> \
    <i class='icon-m-galery'></i> &nbsp;"+j__("Galeri Ekle")+" \
    <i id='tag-close-button' class='icon-close size-10 popup-close-button' style='width: 800px; height:50px;'></i> \
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
     <a id='pop-image-OK' class='btn btn-info' >"+j__("Tamam")+"</a>\
    </div> ").appendTo('body').draggable();
    $('#tag-close-button').click(function(){

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
        var new_image_tag_detail = $('<textarea id="tag_detail_'+count+'"rows="3" style="width:500px; margin-left:150px; margin-top:5px;" placeholder="'+(count+1)+'. '+j__("Tag için açıklama giriniz")+'...."></textarea><br>');
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
          var tag_position = [$('#tag_'+i).css('margin-top'), $('#tag_'+i).css('margin-left')];
          tags.push(tag_position);
       }
      console.log(tags);
        
      var component = {
          'type' : 'tag',
          'data': {
            'tagDetails':tagDetails,
            'tags':tags,
            'imageBinary':imageBinary,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'background-color': 'transparent',
                'z-index': 'first'
              }
            }
          }
        };

         window.lindneo.tlingit.componentHasCreated( component );
         $("#tag-close-button").trigger('click');

    });

    var control_val = 0;
    var image_width = 0;
    var image_height = 0;
    var el = document.getElementById("dummy-dropzone");
    

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
