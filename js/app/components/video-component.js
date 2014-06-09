'use strict';

$(document).ready(function() {
    $.widget('lindneo.videoComponent', $.lindneo.component, {
        options: {
        },
        _create: function() {

            var that = this;

            
            this.videoTag=$('<video poster="'+this.options.component.data.poster+'" style="width:100%; height:100%;"></video>');

            if(this.options.component.data.video_type == 'popup'){
              
              if(typeof this.options.marker ==="undefined" ) {
                this.options.marker = "http://" + window.location.hostname + "/css/video_play_trans.svg";
              }

              var componentvideoid='popup'+this.options.component.id;
              var newimage=$('<img id="img_'+componentvideoid+'" src="' + this.options.marker +  '" style="width:100%; height:100%;"/>');
              this.element.append(newimage);


            }

            console.log(this.options.component);
                  
              if(this.options.component.data.control_type == 'N') 
                this.videoTag.attr("control","true");

              if(this.options.component.data.auto_type == 'Y')
                this.videoTag.attr("autoplay","");

              var source = $('<source/> ');
              source.attr("src", this.options.component.data.source.attr.src );

              source.appendTo(this.videoTag);


            if(this.options.component.data.video_type == 'popup'){
              var popupmessage=$('<div  id="message_'+componentvideoid+'" style="display:none" ></div>');
              popupmessage.append(this.videoTag);
              popupmessage.appendTo(this.element);
            } else {
              this.element.append(this.videoTag);
            }

            this._super({resizableParams:{handles:"e, s, se"}});
        },
        field: function(key, value) {

            this._super();

            // set
            this.options.component[key] = value;

        }

    });
});



var top = 0;
var left = 0;

var createVideoComponent = function( event, ui, oldcomponent ) {

  var marker = window.base_path+'/css/popupmarker.svg';
  var video_marker=window.base_path+'/css/video_play_trans.svg';
  var video_width_height = '';
  var video_type_video = function(){
      var video_type = $('input[name=video_type]:checked').val();
        if(video_type == 'popup'){
          $("<span id='type_video'>\
                <input type='radio' id='video_type0' name='video_image_type' value='video_type0'><button id='button0' style='background:url(\""+marker+"\") no-repeat center center;-moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button>\
                <input type='radio' id='video_type1' name='video_image_type' value='link'><button id='button1' style='background:url(\""+video_marker+"\") no-repeat center center; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button>\
                <a href='#' onclick='document.getElementById(\"video_image_file\").click(); return false;' class='icon-upload dark-blue size-40' style='padding-left:15px;'></a>\
                <input type='file' name='video_image_file' id='video_image_file' value='' style='visibility: hidden;' >\
                <div id='new_image'></div>\
              </span>").appendTo('.typev');
          $( "button" ).button();
          $('#button0').click(function(){$("#video_type0").prop("checked", true); console.log(marker);});
          $('#button1').click(function(){$("#video_type1").prop("checked", true); marker = video_marker; console.log(marker);});
        }
        else{ 
          $('#type_video').remove();
        }
    };
    var video_url = "http://lindneo.com/5.mp4";
    if(typeof oldcomponent == 'undefined'){
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
      var video_type = 'link';
      var auto_type = 'N';
      var control_type = 'Y';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      //video_url = oldcomponent.data.source.attr.src;
      video_type = oldcomponent.data.video_type;
      auto_type = oldcomponent.data.auto_type;
      control_type = oldcomponent.data.control_type;
      marker = oldcomponent.data.marker;
    };
    var link_check = '';
    var link_check_active = '';
    var popup_check = '';
    var popup_check_active = '';

    var auto_y_check = '';
    var auto_y_check_active = '';
    var auto_n_check = '';
    var auto_n_check_active = '';

    var control_y_check = '';
    var control_y_check_active = '';
    var control_n_check = '';
    var control_n_check_active = '';

    if(video_type == 'link') { link_check = "checked='checked'"; link_check_active = 'active';}
    else { popup_check = "checked='checked'"; popup_check_active = 'active'; }

    if(auto_type == 'Y') { auto_y_check = "checked='checked'"; auto_y_check_active = 'active';}
    else { auto_n_check = "checked='checked'"; auto_n_check_active = 'active'; }

    if(control_type == 'Y') { control_y_check = "checked='checked'"; control_y_check_active = 'active';}
    else { control_n_check = "checked='checked'"; control_n_check_active = 'active'; }
 
    //console.log(link_check);
    //console.log(popup_check);
    

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
    else if(left+510 > max_left)
      left = max_left - 510;

    if(top < min_top)
      top = min_top;
    else if(top+700 > max_top)
      top = max_top - 700;

//console.log(top);

    top = top + "px";
    left = left + "px";

      $("<div class='popup ui-draggable' id='pop-video-popup' style='display: block; top:" + top + "; left: " + left + "; '> \
        <div class='popup-header'> \
        <i class='icon-m-video'></i> &nbsp;"+j__("Video Ekle")+" \
        <i id='video-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
        </div> \
          <div class='gallery-inner-holder' style='width:500px;'> \
            <div style='clear:both'></div> \
            <div class='typev' style='padding: 4px; display: inline-block;'>\
                <div class='btn-group' data-toggle='buttons'>\
                  <label class='btn btn-primary " + link_check_active + "'>\
                    <input type='radio' name='video_type' id='repeat0' " + link_check + " value='link'> "+j__("Sayfada")+"\
                  </label>\
                  <label class='btn btn-primary " + popup_check_active + "'>\
                    <input type='radio' name='video_type' id='repeat1' " + popup_check + " value='popup'> "+j__("Açılır Pencerede")+"\
                  </label>\
                </div><br><br>\
            </div>\
            <div class='tabbable'>\
              <ul class='nav nav-tabs' id='myTab'>\
                <li><a href='#video_drag' data-toggle='tab'>"+j__("Video Sürükle")+"</a></li>\
                <li><a href='#video_upload' data-toggle='tab'>"+j__("Video Yükle")+"</a></li>\
                <li><a href='#video_link' data-toggle='tab'>"+j__("Video Bağlantı")+"</a></li>\
              </ul>\
            </div>\
            <div class='tab-content'>\
              <div class='tab-pane active' id='video_drag'>\
                <div class='divide-10'></div>\
                <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
              </div>\
              <div class='tab-pane ' id='video_upload'>\
                <div class='divide-10'></div>\
                <input type='file' name='video_file' id='video_file' value='' ><br><br>\
              </div>\
              <div class='tab-pane ' id='video_link'>\
                <div class='divide-10'></div>\
                <input id='video-url-text' class='input-textbox' type='url' placeholder='"+j__("URL Adresini Giriniz")+"'   value='" + video_url + "'> \
              </div>\
            </div>\
            <div class='gallery-inner-holder' style='width:500px;'> \
              <div style='clear:both'></div> \
              <div class='type1' style='padding: 4px; display: inline-block;'>\
                  <div class='btn-group' data-toggle='buttons'>"+j__("Otomatik Başlama")+"<br>\
                    <label class='btn btn-primary " + auto_y_check_active + "'>\
                      <input type='radio' name='auto_type' id='repeat0' " + auto_y_check + " value='Y'> "+j__("Evet")+"\
                    </label>\
                    <label class='btn btn-primary " + auto_n_check_active + "'>\
                      <input type='radio' name='auto_type' id='repeat1' " + auto_n_check + " value='N'> "+j__("Hayır")+"\
                    </label>\
                  </div>\
                </div>\
                <div class='type1' style='padding: 4px; display: inline-block;'>\
                  <div class='btn-group' data-toggle='buttons'>"+j__("Kontrol Panel Görünümü")+"<br>\
                    <label class='btn btn-primary " + control_y_check_active + "'>\
                      <input type='radio' name='control_type' id='repeat0' " + control_y_check + " value='Y'> "+j__("Evet")+"\
                    </label>\
                    <label class='btn btn-primary " + control_n_check_active + "'>\
                      <input type='radio' name='control_type' id='repeat1' " + control_n_check + " value='N'> "+j__("Hayır")+"\
                    </label>\
                  </div>\
              </div>\
            </div>\
            <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> \
          </div> \
        </div>").appendTo('body').draggable();
    if(video_type == 'popup') video_type_video();

      $('#video-add-dummy-close-button').click(function() {

          $('#pop-video-popup').remove();

          if ($('#pop-video-popup').length) {
              $('#pop-video-popup').remove();
          }

      });
     $('.btn').button();
     $('#myTab a:first').tab('show');
    
   //$('#dialog').dialog();
   /*\
            <div id='dialog' title='Video'>\
  <video controls='controls' style='width: 100%; height: 100%;''><source src='http://lindneo.com/5.mp4'></video><br><br>\
</div>\*/
    var changeimage = false;
    var change = false;
    var that = '';
    $('#video_file').change(function(){
          change = true;
          that = this;
        });
    var imageBinary = '';
    $(document ).on('change','#video_image_file' , function(){
          changeimage = true;
          that = this;
          var file = that.files[0];
          var name = file.name;
          var size = file.size;
          var type = file.type;
          var token = '';
          var reader = new FileReader();
          //console.log(reader);
          var component = {};
          var videoURL = '';
          reader.readAsDataURL(file);
          //console.log(reader);
          reader.onload = function(_file) {
            imageBinary = _file.target.result;
            //console.log(imageBinary);
            $('#new_image').html('');
            $("<input type='radio' id='video_type2' name='video_image_type' value='video_type2' checked='checked'><button id='button2' style='background:url(" + imageBinary +") no-repeat center center; no-repeat center center; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover; background-size: cover; width:70px; height:70px;'></button><br><br>").appendTo('#new_image');
            $( "button" ).button();
            marker = imageBinary;
            //console.log(marker);
          }
          //console.log(marker);
        });

    $("input[name=video_type]:radio").change(function () {
        video_type_video();
      });
    
    if(changeimage){
          //console.log(that);
          var file = that.files[0];
          var name = file.name;
          var size = file.size;
          var type = file.type;
        };

    $('#pop-image-OK').click(function() {
        var poster = "";
        var video_type = $('input[name=video_type]:checked').val();
        var auto_type = $('input[name=auto_type]:checked').val();
        var control_type = $('input[name=control_type]:checked').val();
        //console.log(auto_type);
        //console.log(control_type);
        
        if(typeof oldcomponent == 'undefined'){
          
          var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
          var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
          
        }
        else{
          top = oldcomponent.data.self.css.top;
          left = oldcomponent.data.self.css.left;
          window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        };
        

        if(change){
          //console.log(that);
          var file = that.files[0];
          var name = file.name;
          var size = file.size;
          var type = file.type;
          var token = '';
          var reader = new FileReader();
          //console.log(reader);
          var component = {};
          var videoURL = '';
          reader.readAsDataURL(file);
          //console.log(reader);
          reader.onload = function(_file) {
            var videoBinary = _file.target.result;
            var contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
            var videoType = contentType.substr(contentType.indexOf('/')+1);
          
            var response = '';
            var videoURL = '';
            var token = '';

            //console.log(videoBinary);
            window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
              response=window.lindneo.tlingit.responseFromJson(response);
            
              window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {
                videoURL = response.result.URL;
                
                $("#video-add-dummy-close-button").trigger('click');
                var VideoSnapper = {
    
                    /**
                     * Capture screen as canvas
                     * @param {HTMLElement} video element 
                     * @param {Object} options = width of screen, height of screen, time to seek
                     * @param {Function} handle function with canvas element in param
                     */
                    captureAsCanvas: function(video, options, handle) {
                    
                        // Create canvas and call handle function
                        var callback = function() {
                            // Create canvas
                            var canvas = $('<canvas />').attr({
                                width: options.width,
                                height: options.height
                            })[0];
                            // Get context and draw screen on it
                            
                            canvas.getContext('2d').drawImage(video, 0, 0, options.width, options.height);
                            // Seek video back if we have previous position 
                            if (prevPos) {
                                // Unbind seeked event - against loop
                                $(video).unbind('seeked');
                                // Seek video to previous position
                                video.currentTime = prevPos;
                            }
                            // Call handle function (because of event)
                            handle.call(this, canvas);    
                        }

                        // If we have time in options 
                        if (options.time && !isNaN(parseInt(options.time))) {
                            // Save previous (current) video position
                            var prevPos = video.currentTime;
                            // Seek to any other time
                            video.currentTime = options.time;
                            // Wait for seeked event
                            $(video).bind('seeked', callback);              
                            return;
                        }
                        
                        // Otherwise callback with video context - just for compatibility with calling in the seeked event
                        return callback.apply(video);
                    }
                };

           
                        
                   

                $("<div class='popup ui-draggable' id='pop-video-poster' style='display: block; top:" + top + "; left: " + left + "; '> \
                  <div class='popup-header'> \
                  <i class='icon-m-video'></i> &nbsp;"+j__("Poster Ekle")+" \
                  <i id='poster-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
                  </div> \
                    <div class='gallery-inner-holder' style='width:500px;'> \
                      <video id='video' width='320' height='240' controls preload='none' onloadedmetadata=\"$(this).trigger('video_really_ready')\">\
                        <source id='"+videoType+"' src='"+videoURL+"' type='video/"+videoType+"'>\
                      </video><br><br>\
                      <input type='button' id='capture' value='Capture' />    "+j__("Video'yu başlatarak istediğiniz anda görüntüyü yakalayabilirsiniz")+"<br><br>\
                      <div id='screen'></div><br>\
                      <a href='#' id='pop-poster-OK' class='btn bck-light-green white radius' id='add-poster' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> \
                    </div> \
                  </div>\
                  ").appendTo('body').draggable();
                  
                $('#poster-add-dummy-close-button').click(function() {

                    $('#pop-video-poster').remove();

                    if ($('#pop-video-poster').length) {
                        $('#pop-video-poster').remove();
                    }

                });
                
                 $('#capture').click(function() {
                            var canvases = $('canvas');
                            VideoSnapper.captureAsCanvas(video, { width: 160, height: 68, time: 0 }, function(canvas) {
                                $('#screen').html("");
                                $('#screen').append(canvas); 
                                var image = new Image();
                                image.src = canvas.toDataURL();
                                poster = image.src;
                                //console.log(image.src);
                                //console.log(canvas);
                       
                                if (canvases.length == 4) 
                                    canvases.eq(0).remove();     
                            })
                        }); 
                $('#pop-poster-OK').click(function() {         
                if(video_type == 'popup') video_width_height = '80%';
                else video_width_height = '100%';

                    var component = {
                        'type': 'video',
                        'data': {
                            'video': {
                                'css': {
                                    'width': video_width_height,
                                    'height': video_width_height,
                                },
                                'contentType': contentType
                            },
                            'poster': poster,
                            'video_type' : video_type,
                            'auto_type' : auto_type,
                            'control_type' : control_type,
                            'marker' : marker,
                            'source': {
                                'attr': {
                                    'src': videoURL
                                }
                            },
                            '.audio-name': {
                                'css': {
                                    'width': '100%'
                                }
                            },
                            'self': {
                                'css': {
                                    'position': 'absolute',
                                    'top': top,
                                    'left':  left,
                                    'width': 'auto',
                                    'height': '60px',
                                    'background-color': 'transparent',
                                    'overflow': 'visible',
                                    'z-index': 'first'
                                }
                            }

                        }
                    };

                    //console.log(component);
                    window.lindneo.tlingit.componentHasCreated( component );
                    $("#poster-add-dummy-close-button").trigger('click');
                  });
                });

            });


          

        };

      }
      else{
        if($($("#myTab").find(".active")).children().attr("href") == "#video_link"){
          var poster = "";
          var video_type = $('input[name=video_type]:checked').val();
          var req = new XMLHttpRequest();
          var videoURL = $('#video-url-text').val();

          req.open('HEAD', videoURL, false);
          req.send(null);
          var headers = req.getAllResponseHeaders().toLowerCase();
          var contentType = req.getResponseHeader('content-type');
          var contenttypes = contentType.split('/');
          console.log(contenttypes[1]);
          
          

                
/*
               $('#capture').click(function() {
                  var canvases = $('canvas');
                  VideoSnapper.captureAsCanvas(video, { width: 160, height: 68, time: 0 }, function(canvas) {
                    $('#screen').html("");
                    $('#screen').append(canvas); 
                    var image = new Image();
                    image.src = canvas.toDataURL();
                    poster = image.src;
                    //console.log(image.src);
                    //console.log(canvas);
                    console.log(poster);
                    return;
           
                    if (canvases.length == 4) 
                      canvases.eq(0).remove();     
                  })
              }); 
*/
              //$('#pop-image-OK').click(function() {
              if(video_type == 'popup') video_width_height = '80%';
              else video_width_height = '100%';
              //console.log(contentType);
                    console.log(poster);
                    poster="";
              var component = {
                'type': 'video',
                'data': {
                    'video': {
                        'css': {
                            'width': video_width_height,
                            'height': video_width_height,
                        },
                        'contentType': contentType
                    },
                    'poster': poster,
                    'video_type' : video_type,
                    'auto_type' : auto_type,
                    'control_type' : control_type,
                    'marker' : marker,
                    'source': {
                        'attr': {
                            'src': videoURL
                        }
                    },
                    '.audio-name': {
                        'css': {
                            'width': '100%'
                        }
                    },
                    'lock':'',
                    'self': {
                        'css': {
                            'position': 'absolute',
                            'top': top ,
                            'left': left ,
                            'width': 'auto',
                            'height': '60px',
                            'background-color': 'transparent',
                            'overflow': 'visible',
                            'z-index': 'first'
                        }
                    }

                }
            };

            //console.log(component);
            window.lindneo.tlingit.componentHasCreated(component);
            $("#video-add-dummy-close-button").trigger('click');
          //});
        }
      };
    });
    // http://bekir.dev.lindneo.com/index.php?r=EditorActions/getFileUrl&type=mp4
    //drag video file
    var el = document.getElementById("dummy-dropzone");
    var videoBinary = '';

    el.addEventListener("dragenter", function(e) {
        e.stopPropagation();
        e.preventDefault();
    }, false);

    el.addEventListener("dragexit", function(e) {
        e.stopPropagation();
        e.preventDefault();
    }, false);

    el.addEventListener("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
    }, false);

    el.addEventListener("drop", function(e) {

        e.stopPropagation();
        e.preventDefault();

        var token = '';
        var poster = '';
        var video_type = $('input[name=video_type]:checked').val();
        var reader = new FileReader();
        var component = {};
        var videoURL = '';
        reader.onload = function(evt) {
          
          var videoBinary = evt.target.result;
          var contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
          var videoType = contentType.substr(contentType.indexOf('/')+1);
        
          var response = '';
          var videoURL = '';
          var token = '';

          var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
          var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';


          window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
            response=window.lindneo.tlingit.responseFromJson(response);
          
            window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {
              videoURL = response.result.URL;
                if($($("#myTab").find(".active")).children().attr("href") == "#video_drag"){
                  console.log("12313123");
                  $("#video-add-dummy-close-button").trigger('click');
                  var VideoSnapper = {
      
                      /**
                       * Capture screen as canvas
                       * @param {HTMLElement} video element 
                       * @param {Object} options = width of screen, height of screen, time to seek
                       * @param {Function} handle function with canvas element in param
                       */
                      captureAsCanvas: function(video, options, handle) {
                      
                          // Create canvas and call handle function
                          var callback = function() {
                              // Create canvas
                              var canvas = $('<canvas />').attr({
                                  width: options.width,
                                  height: options.height
                              })[0];
                              // Get context and draw screen on it
                              
                              canvas.getContext('2d').drawImage(video, 0, 0, options.width, options.height);
                              // Seek video back if we have previous position 
                              if (prevPos) {
                                  // Unbind seeked event - against loop
                                  $(video).unbind('seeked');
                                  // Seek video to previous position
                                  video.currentTime = prevPos;
                              }
                              // Call handle function (because of event)
                              handle.call(this, canvas);    
                          }

                          // If we have time in options 
                          if (options.time && !isNaN(parseInt(options.time))) {
                              // Save previous (current) video position
                              var prevPos = video.currentTime;
                              // Seek to any other time
                              video.currentTime = options.time;
                              // Wait for seeked event
                              $(video).bind('seeked', callback);              
                              return;
                          }
                          
                          // Otherwise callback with video context - just for compatibility with calling in the seeked event
                          return callback.apply(video);
                      }
                  };

                $("<div class='popup ui-draggable' id='pop-video-poster' style='display: block; top:" + top + "; left: " + left + "; '> \
                  <div class='popup-header'> \
                  <i class='icon-m-video'></i> &nbsp;"+j__("Poster Ekle")+" \
                  <i id='poster-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
                  </div> \
                    <div class='gallery-inner-holder' style='width:500px;'> \
                      <video id='video' width='320' height='240' controls preload='none' onloadedmetadata=\"$(this).trigger('video_really_ready')\">\
                        <source id='"+videoType+"' src='"+videoURL+"' type='video/"+videoType+"'>\
                      </video><br><br>\
                      <input type='button' id='capture' value='Capture' />    "+j__("Video'yu başlatarak istediğiniz anda görüntüyü yakalayabilirsiniz")+"<br><br>\
                      <div id='screen'></div><br>\
                      <a href='#' id='pop-poster-OK' class='btn bck-light-green white radius' id='add-poster' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> \
                    </div> \
                  </div>\
                  ").appendTo('body').draggable();

                $('#poster-add-dummy-close-button').click(function() {

                    $('#pop-video-poster').remove();

                    if ($('#pop-video-poster').length) {
                        $('#pop-video-poster').remove();
                    }

                });

               $('#capture').click(function() {
                  var canvases = $('canvas');
                  VideoSnapper.captureAsCanvas(video, { width: 160, height: 68, time: 0 }, function(canvas) {
                    $('#screen').html("");
                    $('#screen').append(canvas); 
                    var image = new Image();
                    image.src = canvas.toDataURL();
                    poster = image.src;
                    //console.log(image.src);
                    //console.log(canvas);
           
                    if (canvases.length == 4) 
                      canvases.eq(0).remove();     
                  })
              }); 
              $('#pop-poster-OK').click(function() {
                    console.log("dede");

                    var component = {
                        'type': 'video',
                        'data': {
                            'video': {
                                'css': {
                                    'width': '100%',
                                    'height': '100%',
                                },
                                'contentType': contentType
                            },
                            'poster' : poster,
                            'video_type' : video_type,
                            'auto_type' : auto_type,
                            'control_type' : control_type,
                            'marker' : marker,
                            'source': {
                                'attr': {
                                    'src': response.result.URL
                                }
                            },
                            '.audio-name': {
                                'css': {
                                    'width': '100%'
                                }
                            },
                            'self': {
                                'css': {
                                    'position': 'absolute',
                                    'top': top,
                                    'left':  left,
                                    'width': 'auto',
                                    'height': '60px',
                                    'background-color': 'transparent',
                                    'overflow': 'visible',
                                    'z-index': 'first'
                                }
                            }

                        }
                    };


                    if(typeof oldcomponent == 'undefined'){
                      window.lindneo.tlingit.componentHasCreated( component );
                      
                      }
                    else{
                      oldcomponent.data.video.contentType = contentType;
                      oldcomponent.data.source.attr.src = videoURL;
                      window.lindneo.tlingit.componentHasUpdated( oldcomponent );
                    }
                    $("#poster-add-dummy-close-button").trigger('click');
                  });
                }
            });

          });


        //$("#video-add-dummy-close-button").trigger('click');

        };
        reader.readAsDataURL(e.dataTransfer.files[0]);

    }, false);

};
