'use strict';

$(document).ready(function(){
  $.widget('lindneo.sliderComponent', $.lindneo.component, {
    
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

      if( that.options.component.data.slides.imgs ) {
        var slider_align = that.options.component.data.slider_align;
        var counter=0;
        var container_bottom = $('<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 800px; height: 456px; background: #24262e; overflow: hidden;"></div>');
        var container_left = $('<div id="slider1_container" style="position: relative; padding: 0px; margin: 0 auto; top: 0px; left: 0px; width: 960px; height: 480px; background: #24262e;"></div>');
        var container_right = $('<div id="slider1_container" style="position: relative; padding: 0px; margin: 0 auto; top: 0px; left: 0px; width: 960px; height: 480px; background: #24262e;"></div>');
        
        var loading = $('<div u="loading" style="position: absolute; top: 0px; left: 0px;">\
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block; background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">\
            </div>\
            <div style="position: absolute; display: block; background: url(/css/images/loading.gif) no-repeat center center; top: 0px; left: 0px;width: 100%;height:100%;">\
            </div>\
        </div>');

        var slides_bottom = $('<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 356px; overflow: hidden;">');
        var slides_left = $('<div u="slides" style="cursor: move; position: absolute; left: 120px; top: 0px; width: 720px; height: 480px; overflow: hidden;">');
        var slides_right = $('<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 680px; height: 480px; overflow: hidden;">');
        //slides.css(that.options.component.data.slides.css);
        this.element.parent().find('.some-gallery').css(that.options.component.data['some-gallery'].css);
        var thumbnail_bottom_css = $('<style>\
                .jssort01 .w\
                {\
                    position: absolute;\
                    top: 0px;\
                    left: 0px;\
                    width: 100%;\
                    height: 100%;\
                }\
                .jssort01 .c\
                {\
                    position: absolute;\
                    top: 0px;\
                    left: 0px;\
                    width: 70px;\
                    height: 70px;\
                    border: #000 2px solid;\
                }\
                .jssort01 .p:hover .c, .jssort01 .pav:hover .c, .jssort01 .pav .c \
                {\
                  background: url(/css/images/t01.png) center center;\
                  border-width: 0px;\
                    top: 2px;\
                    left: 2px;\
                    width: 70px;\
                    height: 70px;\
                }\
                .jssort01 .p:hover .c, .jssort01 .pav:hover .c\
                {\
                    top: 0px;\
                    left: 0px;\
                    width: 72px;\
                    height: 72px;\
                    border: #fff 1px solid;\
                }\
            </style>');
        
        var thumbnail_left_css = $('<style>\
                  top: 2px;\
                  left: 2px;\
                  width: 97px;\
                  height: 64px;\
                .jssort02 .w\
                {\
                    position: absolute;\
                    top: 0px;\
                    left: 0px;\
                    width: 100%;\
                    height: 100%;\
                }\
                .jssort02 .c\
                {\
                    position: absolute;\
                    top: 0px;\
                    left: 0px;\
                    width: 97px;\
                    height: 64px;\
                    border: #000 2px solid;\
                }\
                .jssort02 .p:hover .c, .jssort02 .pav:hover .c, .jssort02 .pav .c \
                {\
                  background: url(/css/images/t01.png) center center;\
                  border-width: 0px;\
                  top: 2px;\
                  left: 2px;\
                  width: 97px;\
                  height: 64px;\
                }\
                .jssort02 .p:hover .c, .jssort02 .pav:hover .c\
                {\
                    top: 0px;\
                    left: 0px;\
                    width: 99px;\
                    height: 66px;\
                    border: #fff 1px solid;\
                }\
            </style>');

        var thumbnail_right_css = $('<style>\
                .jssort06 .f { clip: rect(8px 92px 59px 8px); }\
                .jssort06 .pav .f { clip: rect(2px 99px 66px 2px); }\
                .jssort06 .i\
                {\
                    position: absolute;\
                    background: #000;\
                    filter: alpha(opacity=30);\
                    opacity: .3;\
                    width: 101px;\
                    height: 68px;\
                    top: 0;\
                    left: 0;\
                    transition: background-color .6s;\
                    -moz-transition: background-color .6s;\
                    -webkit-transition: background-color .6s;\
                    -o-transition: background-color .6s;\
                }\
                .jssort06 .pav .i\
                {\
                    background: #fff;\
                    filter: alpha(opacity=100);\
                    opacity: 1;\
                }\
                .jssort06 .pdn .i { background: none; }\
                .jssort06 .p:hover .i, .jssort06 .pav:hover .i\
                {\
                    background: #fff;\
                    filter: alpha(opacity=30);\
                    opacity: .3;\
                }\
                .jssort06 .p:hover .i\
                {\
                  transition: none;\
                  -moz-transition: none;\
                  -webkit-transition: none;\
                  -o-transition: none;\
                }\
            </style>');
        
        var thumbnail_bottom = $('<div u="thumbnavigator" class="jssort01" style="position: absolute; width: 800px; height: 100px; left:0px; bottom: 0px;">\
            <div u="slides" style="cursor: move;">\
                <div u="prototype" class="p" style="position: absolute; width: 74px; height: 74px; top: 0; left: 0;">\
                    <div class=w><thumbnailtemplate style=" width: 100%; height: 100%; border: none;position:relative; top: 0; left: 0;"></thumbnailtemplate></div>\
                    <div class=c>\
                    </div>\
                </div>\
            </div>\
        </div>');

        var thumbnail_left = $('<div u="thumbnavigator" class="jssort02" style="position: absolute; width: 120px; height: 480px; left:0px; bottom: 0px;">\
            <div u="slides" style="cursor: move;">\
                <div u="prototype" class="p" style="position: absolute; width: 101px; height: 68px; top: 0; left: 0;">\
                    <div class=w><thumbnailtemplate style=" width: 100%; height: 100%; border: none;position:relative; top: 0; left: 0;"></thumbnailtemplate></div>\
                    <div class=c>\
                    </div>\
                </div>\
            </div>\
        </div>');

        var thumbnail_right = $('<div u="thumbnavigator" class="jssort06" style="position: absolute; width: 120px; height: 480px; right:160px; bottom: 0px;">\
            <div u="slides" style="cursor: move;">\
                <div u="prototype" class="p" style="position: absolute; width: 101px; height: 68px; top: 0; left: 0;">\
                    <div class="o" style="position:absolute;top:1px;left:1px;width:101px;height:68px;overflow:hidden;">\
                        <thumbnailtemplate class="b" style="width:101px;height:68px; border: none;position:relative; top: 0; left: 0;"></thumbnailtemplate>\
                        <div class="i"></div>\
                        <thumbnailtemplate class="f" style="width:101px;height:68px;border: none;position:absolute; top: 0; left: 0;"></thumbnailtemplate>\
                    </div>\
                </div>\
            </div>\
        </div>');

      var container = "";
      var slides = "";
      var thumbnail_css = "";
      var thumbnail = "";

      if(slider_align == 'bottom'){
        container = container_bottom;
        slides = slides_bottom;
        thumbnail_css = thumbnail_bottom_css;
        thumbnail = thumbnail_bottom;
      }
      else if(slider_align == 'left'){
        container = container_left;
        slides = slides_left;
        thumbnail_css = thumbnail_left_css;
        thumbnail = thumbnail_left;
      }
      else if(slider_align == 'right'){
        container = container_right;
        slides = slides_right;
        thumbnail_css = thumbnail_right_css;
        thumbnail = thumbnail_right;
      }
      console.log(slider_align);
      thumbnail_css.appendTo(thumbnail);

        console.log(that);  
        $.each (that.options.component.data.slides.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            var image = $('<div>\
                              <img u="image" src="'+value.src+ '" />\
                              <img u="thumb" style="width:72px; height:72px;" src="'+value.src+ '" />\
                          </div>');
            //var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
            //var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            //image.appendTo(container);  
                  
            image.appendTo(slides);
            
          }       
        });

        //ul.addClass('galery_component_ul');
        that.element.parent().addClass('galery_component_wrap');
        loading.appendTo(container);
        slides.appendTo(container);
        thumbnail.appendTo(container);
        container.appendTo(that.element);
        that.element.first().show();

        $('<div style="clear:both"></div>').appendTo(that.element);

        if(slider_align == 'bottom'){
          jssor_slider1_bottom('slider1_container');
        }
        else if(slider_align == 'left'){
          jssor_slider1_left('slider1_container');
        }
        else if(slider_align == 'right'){
          jssor_slider1_right('slider1_container');
        }

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
 
var jssor_slider1_bottom = function (containerId) {
    var jssor_slider1 = new $JssorSlider$(containerId, {
        $AutoPlay: false,                                   //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500

        $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
            $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
            $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            
            $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
            $SpacingX: 6,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
            $DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
            $ParkingPosition: 360                           //[Optional] The offset position to park thumbnail
        }
    });
};

var jssor_slider1_right = function (containerId) {
    var jssor_slider1 = new $JssorSlider$(containerId, {
        $AutoPlay: false,                                   //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500

        $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
            $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
            $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

            $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
            $SpacingX: 12,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
            $SpacingY: 10,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
            $DisplayPieces: 6,                             //[Optional] Number of pieces to display, default value is 1
            $ParkingPosition: 156,                          //[Optional] The offset position to park thumbnail
            $Orientation: 2                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
        }
    });
};

var jssor_slider1_left = function (containerId) {
    var jssor_slider1 = new $JssorSlider$(containerId, {
        $AutoPlay: false,                                   //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500

        $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
            $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
            $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

            $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
            $SpacingX: 12,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
            $SpacingY: 10,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
            $DisplayPieces: 6,                             //[Optional] Number of pieces to display, default value is 1
            $ParkingPosition: 156,                          //[Optional] The offset position to park thumbnail
            $Orientation: 2                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
        }
    });
};
 
var createSliderComponent = function (event,ui){
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

    console.log(top);

    if(left < min_left)
      left = min_left;
    else if(left+210 > max_left)
      left = max_left - 210;

    if(top < min_top)
      top = min_top;
    else if(top+230 > max_top)
      top = max_top - 230;
  
    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
    <div class='popup-header'> \
    <i class='icon-m-galery'></i> &nbsp;"+j__("Galeri Ekle")+" \
    <i id='galery-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='type' style='padding: 4px; display: inline-block;'>\
            <div class='btn-group' >\
              <label class='btn btn-primary active'>\
                <input type='radio' name='slider_align' checked='checked' id='repeat0' value='left'> "+j__("Sol")+"\
              </label>\
              <label class='btn btn-primary '>\
                <input type='radio' name='slider_align' id='repeat1' value='bottom'> "+j__("Orta")+"\
              </label>\
              <label class='btn btn-primary '>\
                <input type='radio' name='slider_align' id='repeat2' value='right'> "+j__("Sağ")+"\
              </label>\
            </div><br><br>\
        </div>\
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
      <ul id='galery-popup-images' style='width: 250px;'> \
      </ul> \
     <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn btn-info' >"+j__("Tamam")+"</a>\
    </div> ").appendTo('body').draggable();
    $('#galery-add-dummy-close-button').click(function(){

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

      var slider_align = $('input[name=slider_align]:checked').val();

      var component = {
          'type' : 'slider',
          'data': {
            'some-gallery':{
              'css': {
                'width': '100%',
                'height': '100%',
                'min-height':'100px',
                'min-width':'100px',
              }
            },
            'slider_align' : slider_align,
            'slides':{
              'css': {
                '.jssort01 .w': {
                    'position': 'absolute',
                    'top': '0px',
                    'left': '0px',
                    'width': '100%',
                    'height': '100%',
                },
                '.jssort01 .c': {
                    'position': 'absolute',
                    'top': '0px',
                    'left': '0px',
                    'width': '70px',
                    'height': '70px',
                    'border': '#000 2px solid',
                },
                '.jssort01 .p:hover .c, .jssort01 .pav:hover .c, .jssort01 .pav .c': {
                  'background': 'url(../img/t01.png) center center',
                  'border-width': '0px',
                   'top': '2px',
                  'left': '2px',
                  'width': '70px',
                  'height': '70px',
                },
                '.jssort01 .p:hover .c, .jssort01 .pav:hover .c': {
                    'top': '0px',
                    'left': '0px',
                    'width': '72px',
                    'height': '72px',
                    'border': '#fff 1px solid',
                },
              },
            'imgs':imgs
            
         
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'z-index': 'first',
                'background-color': 'transparent',
                'opacity':'1'
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
        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><img style="height:100%;" src='+imageBinary+' /> \
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
