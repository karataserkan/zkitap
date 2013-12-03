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



var createVideoComponent = function(event, ui) {

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top - $(event.target).offset().top) + "px; left: " + (ui.offset.left - $(event.target).offset().left) + "px;'> \
    <div class='popup-header'> \
    Video Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
        <input id='video-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value='http://lindneo.com/5.mp4'> \
        <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>Ekle</a> \
      </div> \
    </div>").appendTo('body');

    $('#image-add-dummy-close-button').click(function() {

        $('#pop-image-popup').remove();

        if ($('#pop-image-popup').length) {
            $('#pop-image-popup').remove();
        }

    });


    $('#pop-image-OK').click(function() {

        var req = new XMLHttpRequest();
        var videoURL = $('#video-url-text').val();

        req.open('HEAD', videoURL, false);
        req.send(null);
        var headers = req.getAllResponseHeaders().toLowerCase();
        var contentType = req.getResponseHeader('content-type');
        var contenttypes = contentType.split('/');
        console.log(contenttypes);
        if (contenttypes[0] != 'video') {
            alert('Lütfen bir video dosyası URL adresi giriniz');
            return;
        }
        /*
         $.ajax({
         type: "POST",
         url: 'http://ugur.dev.lindneo.com/index.php?r=EditorActions/UploadFile&url=fileiQH34JPdOLbbOyhW5vfLzpwrtbWlfr',
         data: {file:'data:video/mp4;base64,AAAAGGZ0eXBtcDQyAAAAAW1wNDJhdmMxAAJwqW1vb3YAAABsbXZoZAAAAADFzieXxc4nmQAACcQACJVEAAEAAAEAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUAANpZdHJhawAAAFx0a2hkAAAAAcXOJ5LFzieZAAAAAQAAAAAACJVEAAAAAAAAAAAAAAAAAQAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAJGVkdHMAAAAcZWxzdAAAAAAAAAABAAiVRAAAAAAAAQAAAADZ0W1kaWEAAAAgbWRoZAAAAADFzieXxc4nlwAArEQAl2gAFccAAAAAADpoZGxyAAAAAAAAAABzb3VuAAAAAAAAAAAAAAAAQXBwbGUgU291bmQgTWVkaWEgSGFuZGxlcgAAANlvbWluZgAAABBzbWhkAAAAAAAAAAAAAAAkZGluZgAAABxkcmVmAAAAAAAAAAEAAAAMdXJsIAAAAAEAANkzc3RibAAAAGdzdHNkAAAAAAAAAAEAAABXbXA0YQAAAAAAAAABAAAAAAAAAAAAAgAQAAAAAKxEAAAAAAAzZXNkcwAAAAADgICAIgAAAASAgIAUQBUAGAAAAfQAAAH0AAWAgIACEhAGgICAAQIAAAAYc3R0cwAAAAAAAAABAAAl2gAABAAA'},
         success: function(data){console.log(data);},
         });
         
         */


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
                        'top': (ui.offset.top - $(event.target).offset().top) + 'px',
                        'left': (ui.offset.left - $(event.target).offset().left) + 'px',
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
        var token='';
        
        var reader = new FileReader();
        var component = {};

        //console.log("ok");
        var videoURL ='';
        var fileURL = "http://bekir.dev.lindneo.com/index.php?r=EditorActions/getFileUrl";
        $.get( fileURL, { type: "mp4"} )
            .done(function( data ) {
             videoURL = window.lindneo.tlingit.responseFromJson( data ).result.URL;
             
             $.ajax({
                type: "POST",
                url: 'http://ugur.dev.lindneo.com/index.php?r=EditorActions/UploadFile&url=' + window.lindneo.tlingit.responseFromJson( data ).result.token,
                data: {file:reader},
                success: function(data){console.log(data);},
                });
            
        });
       /* $.getJSON(fileURL, {
            type: "mp4"
        }).done(function(data) {
            $.each(data.items, function(i, item) {
                videoURL=item.token;
                var videoToken=item.URL
            });
        });
        console.log(videoURL);
        var req = new XMLHttpRequest();
        var videoURL = $('#video-url-text').val();

        req.open('HEAD', videoURL, false);
        req.send(null);
        var headers = req.getAllResponseHeaders().toLowerCase();
        var contentType = req.getResponseHeader('content-type');
        var contenttypes = contentType.split('/');
        console.log(contenttypes);
        if (contenttypes[0] != 'video') {
            alert('Lütfen bir video dosyası URL adresi giriniz');
            return;
        }
        /*
         

         */


       /* var component = {
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
                        'top': (ui.offset.top - $(event.target).offset().top) + 'px',
                        'left': (ui.offset.left - $(event.target).offset().left) + 'px',
                        'width': 'auto',
                        'height': '60px',
                        'background-color': 'transparent',
                        'overflow': 'visible'
                    }
                }

            }
        };


        window.lindneo.tlingit.componentHasCreated(component);
        $("#image-add-dummy-close-button").trigger('click');*/
    });

};