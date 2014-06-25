'use strict';

$(document).ready(function() {
    $.widget('lindneo.videoComponent', $.lindneo.component, {
        options: {
        },
        _create: function() {

            var that = this;

            
            this.videoTag=$('<video width="100%" height="100%" id="v_'+this.options.component.id+'" poster="'+this.options.component.data.poster+'" ></video>');

            if(this.options.component.data.video_type == 'popup'){
              
              if(typeof this.options.marker ==="undefined" ) {
                this.options.marker = "http://" + window.location.hostname + "/css/video_play_trans.png";
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
            this.videoTag.css({"width":"100%", "height":"100%"});
            console.log(this.videoTag.css({"width":"100%", "height":"100%"}));
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

  var marker = window.base_path+'/css/popupmarker.png';
  var video_marker=window.base_path+'/css/video_play_trans.png';
  var video_width_height = '';
  var contentType;
  var videoType;
  var videoURL = "http://lindneo.com/5.mp4";
  var token = '';
  var poster = '';
  var selectd_tab;
  var selected_marker;

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
    video_url = oldcomponent.data.source.attr.src;
    videoURL = oldcomponent.data.source.attr.src;
    console.log(videoURL);
    video_type = oldcomponent.data.video_type;
    auto_type = oldcomponent.data.auto_type;
    control_type = oldcomponent.data.control_type;
    selected_marker = oldcomponent.data.marker;
  };

  var video_url = "http://lindneo.com/5.mp4";
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

  top = top + "px";
  left = left + "px";

  var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Video"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){

      if(selectd_tab == "link"){

        if(typeof oldcomponent == 'undefined'){
          
          var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
          var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
          
        }
        else{
          top = oldcomponent.data.self.css.top;
          left = oldcomponent.data.self.css.left;
          window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        };
        
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
              'marker' : selected_marker,
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
        if(typeof oldcomponent !== 'undefined'){
          window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        };
        window.lindneo.tlingit.componentHasCreated( component );
      }
      else{

        $('<div>').componentBuilder({

        top:top,
        left:left,
        title: j__("Video Poster"),
        btnTitle : j__("Ekle"), 
        beforeClose : function () {
          /* Warn about not saved work */
          /* Dont allow if not confirmed */
          return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
        },
        onBtnClick: function(){

          if(typeof oldcomponent == 'undefined'){
            
            var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
            var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
            
          }
          else{
            top = oldcomponent.data.self.css.top;
            left = oldcomponent.data.self.css.left;
            window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
          };
          
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
                'marker' : selected_marker,
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

            if(typeof oldcomponent !== 'undefined'){
              window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
            };
            window.lindneo.tlingit.componentHasCreated( component );

        },
        onComplete:function (ui){

          $(ui).parent().parent().css({"height":"550px"});

          
          var VideoSnapper = {
          
            
            captureAsCanvas: function(video, options, handle) {
            
                // Create canvas and call handle function
                var callback = function() {
                    // Create canvas
                    var canvas = $('<canvas />').attr({
                        width: options.width,
                        height: options.height
                    })[0];
                    // Get context and draw screen on it
                    console.log($(video)[0]);
                    console.log(canvas);

                    canvas.getContext("2d").drawImage($(video)[0], 0, 0, options.width, options.height);
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
          /*
          console.log(videoType);
          console.log(videoURL);
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

           $('#capture').click(function() {
              var canvases = $('canvas');
              VideoSnapper.captureAsCanvas(video, { width: $("#current_page").width(), height: $("#current_page").height(), time: 0 }, function(canvas) {
                console.log(canvas);
                $('#screen').html("");
                $('#screen').append(canvas); 
                $('#screen canvas').addClass("caputure_image");
                $('.caputure_image').width(160);
                $('.caputure_image').height(68);
                var image = new Image();
                image.src = canvas.toDataURL();
                poster = image.src;
                //console.log(image.src);
                //console.log(canvas);
       
                if (canvases.length == 4) 
                  canvases.eq(0).remove();     
              })
            });
          */

          var mainDiv = $('<div>')
            .appendTo(ui);

            var captureVideo = $('<video>')
              .attr("width","320")
              .attr("height","240")
              .attr("controls","controls")
              .attr("preload","none")
              .attr("onloadedmetadata","$(this).trigger('video_really_ready')")
              .appendTo(mainDiv);

              var captureSource = $('<source>')
                .attr("src",videoURL)
                .appendTo(captureVideo);
            $("<br>").appendTo(mainDiv);

            var captureIput = $('<input type="button">')
              .val("Capture")
              .click(function() {
                var canvases = $('canvas');
                VideoSnapper.captureAsCanvas(captureVideo, { width: $("#current_page").width(), height: $("#current_page").height(), time: 0 }, function(canvas) {
                  console.log(canvas);
                  screen.html("");
                  screen.append(canvas); 
                  $(screen).find("canvas").addClass("caputure_image");
                  $('.caputure_image').width(160);
                  $('.caputure_image').height(68);
                  var image = new Image();
                  image.src = canvas.toDataURL();
                  poster = image.src;
                  //console.log(image.src);
                  //console.log(canvas);
         
                  if (canvases.length == 4) 
                    canvases.eq(0).remove();     
                })
              })
              .appendTo(mainDiv);

            var captureSpan = $('<span>')
              .text(j__("Video'yu başlatarak istediğiniz anda görüntüyü yakalayabilirsiniz"))
              .appendTo(mainDiv);

            $("<br>").appendTo(mainDiv);

            var screen = $('<div>')
              .appendTo(mainDiv);

          }
        }).appendTo('body');
      }
    },
    onComplete:function (ui){

      $(ui).parent().parent().css({"height":"550px"});

      var mainDiv = $('<div>')
        .appendTo(ui);

        var videoTypeDiv = $('<div>')
          .addClass("typei")
          .css({"padding": "4px", "display": "inline-block"})
          .appendTo(mainDiv);

        var popupDiv = $('<div>')
          .appendTo(mainDiv);

          var videoTypeRadioDiv = $('<div>')
            .addClass("btn-group")
            .attr("data-toggle","buttons")
            .appendTo(videoTypeDiv);

            var videoTypeLinkLabel = $('<label>')
              .addClass("btn btn-primary " + link_check_active)
              .appendTo(videoTypeRadioDiv);

              var videoTypeLinkInput = $('<input type="radio">')
                .attr("name","video_type")
                .val("link")
                .change(function () {
                  video_type = $(this)[0].value;
                })
                .appendTo(videoTypeLinkLabel);

              var videoTypeLinkText = $('<span>')
                .text(j__("Sayfada"))
                .appendTo(videoTypeLinkLabel);

            var videoTypePopupLabel = $('<label>')
              .addClass("btn btn-primary " + popup_check_active)
              .appendTo(videoTypeRadioDiv);

              var videoTypePopupInput = $('<input type="radio">')
                .attr("name","video_type")
                .val("popup")
                .change(function () {
                  video_type = $(this)[0].value;

                  var videoPopupDiv = $('<span>')
                    .appendTo(popupDiv); 

                      var pIconRadioFirst = $('<input type="radio">')
                        .attr("name","plink_video_type")
                        .appendTo(videoPopupDiv);

                      var pIconButtonFirst = $('<button>')
                        .css({"background":"url('"+marker+"') ","-moz-background-size": "cover", "-webkit-background-size": "cover", "-o-background-size": "cover", "background-size": "cover", "width":"70px", "height":"70px"})
                        .appendTo(videoPopupDiv);

                      var pIconRadioSecond = $('<input type="radio">')
                        .attr("name","plink_video_type")
                        .appendTo(videoPopupDiv);
                      var pIconButtonSecond = $('<button>')
                        .css({"background":"url('"+video_marker+"') ","-moz-background-size": "cover", "-webkit-background-size": "cover", "-o-background-size": "cover", "background-size": "cover", "width":"70px", "height":"70px"})
                        .appendTo(videoPopupDiv);

                      pIconButtonFirst.click(function(){pIconRadioFirst.prop("checked", true); selected_marker = marker; console.log(marker);});
                      pIconButtonSecond.click(function(){pIconRadioSecond.prop("checked", true); selected_marker = video_marker; console.log(marker);});

                      var pIconNewLink = $('<a>')
                        .addClass("icon-upload dark-blue size-40")
                        .click(function(){
                          pIconFile.click();
                        })
                        .css("padding-left","15px")
                        .appendTo(videoPopupDiv);

                      var pIconNewImage = $ ('<div>')
                        .appendTo(videoPopupDiv);

                      var pIconFile = $('<input type="file">')
                        .css("visibility","hidden")
                        .change(function(){

                          var file = this.files[0];
                          var name = file.name;
                          var size = file.size;
                          var type = file.type;
                          
                          var reader = new FileReader();
                          reader.readAsDataURL(file);
                          //console.log(reader);
                          reader.onload = function(evt) {
                            var FileBinary = evt.target.result;
                            var contentTypeImage = FileBinary.substr(5, FileBinary.indexOf('/')-5);
                              
                            //console.log(contentType);
                            if(contentTypeImage == 'image'){
                              
                              pIconNewImage.html('');
                              var newIconImage = $("<img style='width:70px; height:70px;' src='"+FileBinary+"' />");
                              selected_marker=FileBinary;
                              pIconNewImage.append(newIconImage);
                              return;
                              
                            }
                          };

                        })
                      .appendTo(videoPopupDiv);
                })
                .appendTo(videoTypePopupLabel);

              var imageTypePopupText = $('<span>')
                .text(j__("Açılır Pencerede"))
                .appendTo(videoTypePopupLabel);

        var tabDiv = $ ('<div>')
            .addClass("tabbable")
            .appendTo(mainDiv);

            var tabUl = $ ('<ul>')
              .addClass("nav nav-tabs")
              .appendTo (tabDiv);

              var tabVideoDragLi = $('<li>')
                .addClass("active")
                .appendTo(tabUl);
                
                var tabVideoDragA = $ ('<a>')
                  .attr('href','#'+idPre+'drag')
                  .attr('data-toggle','tab')
                  .text(j__("Video Sürükle"))
                  .click(function(){
                    selectd_tab = "drag";
                    console.log(selectd_tab);
                  })
                  .appendTo(tabVideoDragLi);

              
              var tabVideoUploadLi = $('<li>')
                .appendTo(tabUl);

                var tabVideoUploadA = $ ('<a>')
                  .attr('href','#'+idPre+'upload')
                  .attr('data-toggle','tab')
                  .text(j__("Video Yükle"))
                  .click(function(){
                    selectd_tab = "upload";
                    console.log(selectd_tab);
                  })
                  .appendTo(tabVideoUploadLi);

              var tabVideoLinkLi = $('<li>')
                .appendTo(tabUl);

                var tabVideoLinkA = $ ('<a>')
                  .attr('href','#'+idPre+'link')
                  .attr('data-toggle','tab')
                  .text(j__("Video Bağlantı"))
                  .click(function(){
                    selectd_tab = "link";
                    console.log(selectd_tab);
                  })
                  .appendTo(tabVideoLinkLi);

              $('<br>').appendTo(tabDiv);

            var videoDiv = $ ('<div>')
                .addClass("tab-content")
                .appendTo(tabDiv);

                var videoDragDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .addClass("active in")
                  .attr('id',idPre+'drag')
                  .appendTo(videoDiv);

                  $('<br>').appendTo(videoDragDiv);

                  var videoDragContent = $ ('<div>')
                    .addClass("add-image-drag-area")
                    .on('dragenter', function (e) 
                    {
                        e.stopPropagation();
                        e.preventDefault();
                    })
                    .on('dragexit', function (e) 
                    {
                        e.stopPropagation();
                        e.preventDefault();
                    })
                    .on('dragover', function (e) 
                    {
                         e.stopPropagation();
                         e.preventDefault();
                    })
                    .on('drop', function (e) 
                    {
                      e.stopPropagation();
                      e.preventDefault();

                      var token = '';
                      var poster = '';
                      var reader = new FileReader();
                      var component = {};
                      videoURL = '';
                      reader.onload = function(evt) {
                        
                        var videoBinary = evt.target.result;
                        contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
                        videoType = contentType.substr(contentType.indexOf('/')+1);
                      
                        var response = '';
                        var token = '';

                        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
                        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';


                        window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
                          response=window.lindneo.tlingit.responseFromJson(response);
                        
                          window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {

                            videoURL = response.result.URL;
                            console.log(videoURL);
                            if(!videoURL)
                              $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();

                          });

                        });

                      };
                      reader.readAsDataURL( e.originalEvent.dataTransfer.files[0] );
                    })
                    .appendTo(videoDragDiv);


                var videoUploadDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .attr('id',idPre+'upload')
                  .appendTo(videoDiv);

                  var videoUploadDiv = $ ('<input type="file">')
                    .attr("name","image_file")
                    .change(function(){

                      //console.log(that);
                      var that = this;
                      var file = that.files[0];
                      var name = file.name;
                      var size = file.size;
                      var type = file.type;
                      var token = '';
                      var reader = new FileReader();
                      //console.log(reader);
                      var component = {};
                      videoURL = '';
                      reader.readAsDataURL(file);
                      //console.log(reader);
                      reader.onload = function(_file) {
                        var videoBinary = _file.target.result;
                        contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
                        videoType = contentType.substr(contentType.indexOf('/')+1);
                      
                        var response = '';
                        var token = '';

                        console.log(contentType);
                        window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
                          response=window.lindneo.tlingit.responseFromJson(response);
                        
                          window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {
                            
                            videoURL = response.result.URL;
                            console.log(videoURL);
                            if(!videoURL)
                              $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();
                            });

                        });
                      }
                    })
                    .appendTo(videoUploadDiv);

                var videoLinkDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .attr('id',idPre+'link')
                  .appendTo(videoDiv);

                  var videoLinkDiv = $ ('<input type="url">')
                    .addClass("input-textbox")
                    .attr("placeholder",j__("URL Adresini Giriniz"))
                    .val(video_url)
                    .change(function(){
                      var poster = "";
                      var req = new XMLHttpRequest();
                      videoURL = $(this).val();
                      console.log(videoURL);
                      req.open('HEAD', videoURL, false);
                      req.send(null);
                      var headers = req.getAllResponseHeaders().toLowerCase();
                      contentType = req.getResponseHeader('content-type');
                      var contenttypes = contentType.split('/');
                      console.log(videoURL);
                      if(!videoURL)
                        $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();
                    })
                    .appendTo(videoLinkDiv);


        if(typeof oldcomponent !== 'undefined'){
          if(oldcomponent.data.video_type == "popup")
            videoTypePopupInput.change();
        }

        var typeDiv = $ ('<div>')
            .addClass("type")
            .css({"padding": "4px", "display": "inline-block"})
            .appendTo(mainDiv);

            var typeAutoDiv = $ ('<div>')
              .addClass("btn-group")
              .attr("data-toggle","buttons")
              .text(j__("Otomatik Başlama"))
              .appendTo(typeDiv);

              $("<br>").appendTo(typeAutoDiv);

              var typeAutoLabelY = $ ('<label>')
                .addClass("btn btn-primary " + auto_y_check_active)
                .appendTo(typeAutoDiv);

                var typeAutoInputY = $ ('<input type="radio">')
                  .attr("name","auto_type")
                  .attr("checked",auto_y_check)
                  .val("Y")
                  .change(function(){
                    auto_type = $(this).val();
                  })
                  .appendTo(typeAutoLabelY);

                var typeAutoSpanY = $ ('<span>')
                  .text(j__("Evet"))
                  .appendTo(typeAutoLabelY);

              var typeAutoLabelN = $ ('<label>')
                .addClass("btn btn-primary " + auto_n_check_active)
                .appendTo(typeAutoDiv);

                var typeAutoInputN = $ ('<input type="radio">')
                  .attr("name","auto_type")
                  .attr("checked",auto_n_check)
                  .val("N")
                  .change(function(){
                    auto_type = $(this).val();
                  })
                  .appendTo(typeAutoLabelN);

                var typeAutoSpanY = $ ('<span>')
                  .text(j__("Hayır"))
                  .appendTo(typeAutoLabelN);

              var typeControlDiv = $ ('<div>')
                .addClass("btn-group")
                .css("margin-left", "100px")
                .attr("data-toggle","buttons")
                .text(j__("Kontrol Panel Görünümü"))
                .appendTo(typeDiv);

                $("<br>").appendTo(typeControlDiv);

                var typeControlLabelY = $ ('<label>')
                  .addClass("btn btn-primary " + control_y_check_active)
                  .appendTo(typeControlDiv);

                  var typeControlInputY = $ ('<input type="radio">')
                    .attr("name","control_type")
                    .attr("checked",control_y_check)
                    .val("Y")
                    .change(function(){
                      control_type = $(this).val();
                    })
                    .appendTo(typeControlLabelY);

                  var typeControlSpanY = $ ('<span>')
                    .text(j__("Evet"))
                    .appendTo(typeControlLabelY);

                var typeControlLabelN = $ ('<label>')
                  .addClass("btn btn-primary " + control_n_check_active)
                  .appendTo(typeControlDiv);

                  var typeControlInputN = $ ('<input type="radio">')
                    .attr("name","control_type")
                    .attr("checked",control_n_check)
                    .val("N")
                    .change(function(){
                      control_type = $(this).val();
                    })
                    .appendTo(typeControlLabelN);

                  var typeControlSpanY = $ ('<span>')
                    .text(j__("Hayır"))
                    .appendTo(typeControlLabelN);

    }

  }).appendTo('body');
      
};
