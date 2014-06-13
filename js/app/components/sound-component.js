'use strict';

$(document).ready(function(){
  $.widget('lindneo.soundComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;

      var auto_start = '';
      var repeat_type= '';
      //console.log(this.options.component.data);
      if(this.options.component.data.auto_type == 'Y') auto_start = 'autoplay';
      if(this.options.component.data.control_type == 'N') control = '';
      if(this.options.component.data.repeat_type == 'Y') repeat_type='loop';
      //console.log(repeat_type);
      if(this.options.component.data.source.attr.src ) {
        var source=$('<source src="'+this.options.component.data.source.attr.src+'" /> ');
        var audio=$('<audio controls="controls" '+auto_start+' '+repeat_type+'></audio>');
        var audioName = "";
        if(this.options.component.data.audio.name) audioName = this.options.component.data.audio.name;
        var audio_name=$('<span class="audio-name" >'+audioName+'</span>');
 
        source.appendTo(audio);
        //console.log('deneme');
        audio_name.appendTo(this.element);
        audio.appendTo(this.element);
        audio.css(this.options.component.data.audio.css);

        // this.element.attr('src', this.options.component.data.img.src);  
      }
      

      this._super({resizableParams:{
        "handles":"e",
        "maxHeight":60,
        "minHeight":60,
      }});
      this.element.height(60);


    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



 var createSoundComponent = function (event,ui){
  var imageBinary = '';
  var auto_y_check = '';
  var auto_y_check_active = '';
  var auto_n_check = '';
  var auto_n_check_active = '';

  if(typeof oldcomponent == 'undefined'){
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    var auto_type = 'N';
  }
  else{
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    auto_type = oldcomponent.data.auto_type;
  };
 
  if(auto_type == 'Y') { auto_y_check = "checked='checked'"; auto_y_check_active = 'active';}
    else { auto_n_check = "checked='checked'"; auto_n_check_active = 'active'; }
  
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

  //console.log(top);

  if(left < min_left)
    left = min_left;
  else if(left+355 > max_left)
    left = max_left - 355;

  if(top < min_top)
    top = min_top;
  else if(top+580 > max_top)
    top = max_top - 580;

//console.log(top);

  top = top + "px";
  left = left + "px";
  $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; width:355px; top:" + top + "; left: " + left + ";'> \
    <div class='popup-header' style='width:100%;'> \
    <i class='icon-m-sound'></i> &nbsp;"+j__("Ses Ekle")+" \
    <i id='sound-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
    </div> \
      <div class='gallery-inner-holder' style='width:100%;'> \
        <div style='clear:both'></div> \
        <div class='tabbable'>\
            <ul class='nav nav-tabs' id='mySoundTab'>\
              <li><a href='#sound_drag' data-toggle='tab'>"+j__("Ses Dosyası Sürükle")+"</a></li>\
              <li><a href='#upload' data-toggle='tab'>"+j__("Ses Dosyası Yükle")+"</a></li>\
            </ul>\
          </div>\
          <div class='tab-content'>\
            <div class='tab-pane fade in active' id='sound_drag'><br>\
              <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
            </div>\
            <div class='tab-pane fade' id='upload'><br>\
              <input type='file' name='sound_file' id='sound_file' value='' ><br><br>\
            </div>\
          </div>\
          <div class='type' style='padding: 4px; display: inline-block;'>\
              <div class='btn-group' data-toggle='buttons'>"+j__("Otomatik Başlama")+"<br>\
                <label class='btn btn-primary " + auto_y_check_active + "'>\
                  <input type='radio' name='auto_type' id='repeat0' " + auto_y_check + " value='Y'> Evet\
                </label>\
                <label class='btn btn-primary " + auto_n_check_active + "'>\
                  <input type='radio' name='auto_type' id='repeat1' " + auto_n_check + " value='N'> Hayır\
                </label>\
              </div>\
              <div class='btn-group' data-toggle='buttons'>"+j__("Tekrar et")+"<br>\
                <label class='btn btn-primary " + auto_y_check_active + "'>\
                  <input type='radio' name='repeat_type' id='repeat0' " + auto_y_check + " value='Y'> Evet\
                </label>\
                <label class='btn btn-primary " + auto_n_check_active + "'>\
                  <input type='radio' name='repeat_type' id='repeat1' " + auto_n_check + " value='N'> Hayır\
                </label>\
              </div>\
          </div>\
      </div> \
       <input type='text' class='input-textbox' id='pop-sound-name' placeholder='Ses Adı'  /> \
      <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn btn-info' >"+j__("Ekle")+"</a>\
    </div>").appendTo('body').draggable();

    $('#sound-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });
    $('#mySoundTab a:first').tab('show');

    $('#pop-image-OK').click(function (){

      var auto_type = $('input[name=auto_type]:checked').val();
      var repeat_type = $('input[name=repeat_type]:checked').val();

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
              'auto_type' : auto_type,
              'repeat_type': repeat_type,
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
              'lock':'',
              'self': {
                'css': {
                  'position':'absolute',
                  'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                  'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                  'width': '250px',
                  'height': '60px',
                  'background-color': 'transparent',
                  'overflow': 'visible',
                  'z-index': 'first',
                  'opacity':'1'
                }
              }
            
          }
        };
        //console.log(component);
        //return;

        window.lindneo.tlingit.componentHasCreated( component );
        $("#sound-add-dummy-close-button").trigger('click');


    });

    
   $('#sound_file').change(function(){
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
      
      imageBinary = _file.target.result;
      console.log(imageBinary);

    };

  });

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
         console.log(imageBinary);      
        
        
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };
