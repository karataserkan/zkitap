'use strict';

$(document).ready(function() {
    $.widget('lindneo.videoComponent', $.lindneo.component, {
        options: {
        },
        _create: function() {

            var that = this;


            if (this.options.component.data.source.attr.src) {
                var source = $('<source src="' + this.options.component.data.source.attr.src + '" /> ');
                var video = $('<video controls="controls"></video>');

                source.appendTo(video);
                video.appendTo(this.element);
                video.css(this.options.component.data.video.css);

                // this.element.attr('src', this.options.component.data.img.src);  
            }


            this._super();
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

    if(typeof oldcomponent == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var video_url = "http://lindneo.com/5.mp4";
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      video_url = oldcomponent.data.source.attr.src;
    };
    console.log(top);
    console.log(left);
      $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        Video Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
            <input type='file' name='video_file' id='video_file' value='' ><br><br>\
            <input id='video-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value=" + video_url + "> \
            <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>Ekle</a> \
          </div> \
        </div>").appendTo('body');

      $('#image-add-dummy-close-button').click(function() {

          $('#pop-image-popup').remove();

          if ($('#pop-image-popup').length) {
              $('#pop-image-popup').remove();
          }

      });
      
    var change = false;
    var that = '';
    $('#video_file').change(function(){
          change = true;
          that = this;
        });


    $('#pop-image-OK').click(function() {

        if(typeof oldcomponent == 'undefined'){
          
          var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
          var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
          
        }
        else{
          top = oldcomponent.data.self.css.top;
          left = oldcomponent.data.self.css.left;
          window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        };
        

        if(change){
          console.log(that);
          var file = that.files[0];
          var name = file.name;
          var size = file.size;
          var type = file.type;
          var token = '';
          console.log('dene');
          var reader = new FileReader();
          console.log(reader);
          var component = {};
          var videoURL = '';
          reader.readAsDataURL(file);
          console.log(reader);
          reader.onload = function(_file) {
            var videoBinary = _file.target.result;
            var contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
            var videoType = contentType.substr(contentType.indexOf('/')+1);
          
            var response = '';
            var videoURL = '';
            var token = '';

            console.log(videoBinary);
            window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
              response=window.lindneo.tlingit.responseFromJson(response);
            
              window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {
                videoURL = response.result.URL;
                console.log(videoURL);
                    var component = {
                        'type': 'video',
                        'data': {
                            'video': {
                                'attr': {
                                    'controls': 'controls'
                                },
                                'css': {
                                    'width': '100%',
                                    'height': '100%',
                                },
                                'contentType': contentType
                            },
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
                                    'overflow': 'visible'
                                }
                            }

                        }
                    };

                    console.log(oldcomponent);
                    window.lindneo.tlingit.componentHasCreated( component );
                  
                });

            });


          $("#image-add-dummy-close-button").trigger('click');

        };

      }
      else{


        var req = new XMLHttpRequest();
        var videoURL = $('#video-url-text').val();

        req.open('HEAD', videoURL, false);
        req.send(null);
        var headers = req.getAllResponseHeaders().toLowerCase();
        var contentType = req.getResponseHeader('content-type');
        var contenttypes = contentType.split('/');
        console.log(contentType);
        /*if (contenttypes[0] != 'video') {
            alert('Lütfen bir video dosyası URL adresi giriniz');
            return;
        }*/
        /*
         $.ajax({
         type: "POST",
         url: 'http://ugur.dev.lindneo.com/index.php?r=EditorActions/UploadFile&url=fileiQH34JPdOLbbOyhW5vfLzpwrtbWlfr',
         data: {file:'data:video/mp4;base64,AAAAGGZ0eXBtcDQyAAAAAW1wNDJhdmMxAAJwqW1vb3YAAABsbXZoZAAAAADFzieXxc4nmQAACcQACJVEAAEAAAEAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUAANpZdHJhawAAAFx0a2hkAAAAAcXOJ5LFzieZAAAAAQAAAAAACJVEAAAAAAAAAAAAAAAAAQAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAJGVkdHMAAAAcZWxzdAAAAAAAAAABAAiVRAAAAAAAAQAAAADZ0W1kaWEAAAAgbWRoZAAAAADFzieXxc4nlwAArEQAl2gAFccAAAAAADpoZGxyAAAAAAAAAABzb3VuAAAAAAAAAAAAAAAAQXBwbGUgU291bmQgTWVkaWEgSGFuZGxlcgAAANlvbWluZgAAABBzbWhkAAAAAAAAAAAAAAAkZGluZgAAABxkcmVmAAAAAAAAAAEAAAAMdXJsIAAAAAEAANkzc3RibAAAAGdzdHNkAAAAAAAAAAEAAABXbXA0YQAAAAAAAAABAAAAAAAAAAAAAgAQAAAAAKxEAAAAAAAzZXNkcwAAAAADgICAIgAAAASAgIAUQBUAGAAAAfQAAAH0AAWAgIACEhAGgICAAQIAAAAYc3R0cwAAAAAAAAABAAAl2gAABAAA'},
         success: function(data){console.log(data);},
         });
         
         */

        console.log(contentType);
        var component = {
            'type': 'video',
            'data': {
                'video': {
                    'attr': {
                        'controls': 'controls'
                    },
                    'css': {
                        'width': '100%',
                        'height': '100%',
                    },
                    'contentType': contentType
                },
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
                        'overflow': 'visible'
                    }
                }

            }
        };


        window.lindneo.tlingit.componentHasCreated(component);
        $("#image-add-dummy-close-button").trigger('click');

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

        var reader = new FileReader();
        var component = {};
        var videoURL = '';
        reader.onload = function(evt) {
            /*
            console.log('niden ama');
            var videoBinary = evt.target.result;
            var contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
            var videoType = contentType.substr(contentType.indexOf('/')+1);
           
           
            window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
            response=window.lindneo.tlingit.responseFromJson(response);
          
                window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {
                  var component = {
                            'type': 'video',
                            'data': {
                                'video': {
                                    'attr': {
                                        'controls': 'controls'
                                    },
                                    'css': {
                                        'width': '100%',
                                        'height': '100%',
                                    },
                                    'contentType': contentType
                                },
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
                                        'top': top ,
                                        'left': left ,
                                        'width': 'auto',
                                        'height': '60px',
                                        'background-color': 'transparent',
                                        'overflow': 'visible'
                                    }
                                }

                            }
                        };


                 window.lindneo.tlingit.componentHasCreated(component);
              });

          });
*/
          //window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
          var videoBinary = evt.target.result;
          var contentType = videoBinary.substr(0, videoBinary.indexOf(';'));
          var videoType = contentType.substr(contentType.indexOf('/')+1);
        
          var response = '';
          var videoURL = '';
          var token = '';


          window.lindneo.dataservice.send( 'getFileUrl', {'type': videoType}, function(response) {
            response=window.lindneo.tlingit.responseFromJson(response);
          
            window.lindneo.dataservice.send( 'UploadFile',{'token': response.result.token, 'file' : videoBinary} , function(data) {
              videoURL = response.result.URL;
                  var component = {
                      'type': 'video',
                      'data': {
                          'video': {
                              'attr': {
                                  'controls': 'controls'
                              },
                              'css': {
                                  'width': '100%',
                                  'height': '100%',
                              },
                              'contentType': contentType
                          },
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
                                  'top': (e.offsetY ) + 'px',
                                  'left':  ( e.offsetX ) + 'px',
                                  'width': 'auto',
                                  'height': '60px',
                                  'background-color': 'transparent',
                                  'overflow': 'visible'
                              }
                          }

                      }
                  };


                 if(typeof oldcomponent == 'undefined')
                  window.lindneo.tlingit.componentHasCreated( component );
                else{
                  oldcomponent.data.video.contentType = contentType;
                  oldcomponent.data.source.attr.src = videoURL;
                  window.lindneo.tlingit.componentHasUpdated( oldcomponent );
                }
              });

          });


        $("#image-add-dummy-close-button").trigger('click');

        };
        reader.readAsDataURL(e.dataTransfer.files[0]);

    }, false);

};