'use strict';

// dataservice module
window.lindneo.dataservice = (function( $ ) {

  var percentage = 0;
  var that =this;
  var progressBars=[];
  var progressBarsCounter=0;

  var get_random_color = function () {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
  };

  var hexToRgb  = function(hex) {
    console.log(hex);
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
  };

  var graph_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var graph_value = {};
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
    };

      var letters= ["A","B","C","D","E","F","G","H","I","J","K"];

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        Görsel Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div class='gallery-inner-holder'> \
         \
          <label class='dropdown-label' id='graph_leading'> \
                  Grafik Çeşidi:  \
                    <select id='Graph Type' class='radius'> \
                      <option value='pie-chart'> Pasta</option> \
                      <option value='bar-chart' >Çubuk</option> \
                    </select>  \
          </label> \
          <select id='verisayisi' class='radius'> \
                      <option value='1' >1</option> \
                      <option value='2' selected='selected' >2</option> \
                      <option value='3' >3</option> \
                      <option value='4' >4</option> \
                      <option value='5' >5</option> \
                      <option value='6' >6</option> \
                      <option value='7' >7</option> \
                      <option value='8' >8</option> \
                      <option value='9' >9</option> \
                    </select>  \
            <div id='bar-chart-properties' class='chart_prop bar-chart' style='display:none;'> \
              <div class='bar-chart-slice-holder slice-holder'> \
                Arkaplan Rengi:  \
                <input type='color'  id='chart-bar-background' class='color-picker-box radius color' value='"+this.get_random_color()+"' placeholder='e.g. #bbbbbb'> \<br> \
                Çubuk Rengi:  \
                 <input type='color' id='chart-bar-stroke' class='color-picker-box radius color' value='"+this.get_random_color()+"' placeholder='e.g. #bbbbbb'> \<br> \
              </div> \
          </div> \
          <div id='pie-chart-properties' class='chart_prop pie-chart'> \
          </div> \
               \
          <a href='#' class='btn bck-light-green white radius' id='pop-image-OK' style='padding: 5px 30px;'>Ekle</a> \
          </div> \
          </div> \
        </div>").appendTo('body').draggable();

      $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });

      $('#verisayisi').change(function(){
    var str = "";
    $( "#verisayisi option:selected" ).each(function() {
      str += $( this ).val() + " ";
    });
    var newlenght=parseInt(str);
    var current= $( '.chart_prop').first().children('.data-row').length;

    console.log(newlenght );
    console.log(current );

    if ( current  > newlenght ) {
      console.log ((current  - newlenght) + 'Silinecek');

      $('.chart_prop').each (function () {
        $(this).children('.data-row').each(function (index) {
          if(index > newlenght -1 ){
            $(this).remove();     
          }
        });
      });

    } else 
    if ( current  < newlenght ) {
     
      console.log ((newlenght - current) +  ' tane Eklenecek ');
      for (var i= current ;i <  newlenght; i++){
      
          var newPieRow= $("<div class='pie-chart-slice-holder slice-holder data-row'> \
                      "+(i+1)+". Dilim <br> \
                      %<input type='text' class='chart-textbox radius grey-9 percent' value='"+Math.floor((Math.random()*100)+1)+"'><br> \
                      Etiket<input type='text' class='chart-textbox-wide radius grey-9 label' value='"+letters[i]+"'> \
                      <input type='color' class='color-picker-box radius color' value='"+ get_random_color()+"' placeholder='e.g. #bbbbbb'> \
              </div> \
              ");
         var newBarRow= $("<div class='bar-chart-slice-holder slice-holder data-row'> \
             "+(i+1)+". sütun adı: \
            <input type='text' class='chart-textbox-wide radius grey-9 label ' value='"+letters[i]+"'><br> \
             "+(i+1)+". sütun değeri:  \
            <input type='text' class='chart-textbox-wide radius grey-9 value ' value='"+Math.floor((Math.random()*100)+1)+"'><br> \
          </div> \
                ");
          newBarRow.appendTo( $('#bar-chart-properties') );
          newPieRow.appendTo( $('#pie-chart-properties') );
      
          }
        }
      });  

      $('#verisayisi').change();

      $('#graph_leading').change(function(){
        var str = "";
        $( "#graph_leading option:selected" ).each(function() {
          str += $( this ).val() + " ";
        });
        $('.chart_prop').hide();
        $('.chart_prop.' + str ).show();
      });

      console.log(component);
      createGraphComponent( event, ui, component );

    };

  var quiz_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var question = "Soru kökünü buraya yazınız.";
      var answers = [];
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
      question = component.data.question;
      answers = component.data.options;
    };

      $("<div class='popup ui-draggable' id='pop-quiz-popup' style='display: block; top:" + top  + "; left: " + left  + ";'> \
      <div class='popup-header'> \
        Quiz Ekle \
        <div class='popup-close' id='create-quiz-close-button'>x</div> \
      </div> \
      <!-- popup content --> \
      <div class='gallery-inner-holder'> \
        <label class='dropdown-label' id='leading'> \
          Şık Sayısı: \
          <select id='leading-option-count' class='radius'> \
            <option value='2'>2</option> \
            <option selected value='3'>3</option> \
            <option value='4'>4</option> \
            <option value='5'>5</option> \
          </select> \
        </label> \
        <br /> \
        <label class='dropdown-label' id='leading'> \
          Doğru Cevap: \
          <select id='leading-answer-selection' class='radius'> \
          </select> \
        </label> \
        <br /><br /> \
        <div class='quiz-inner'> \
          Soru kökü: \
          <form id='video-url'> \
            <textarea class='popup-text-area' id='question'>" + question + "</textarea><br> \
            <!--burası çoğalıp azalacak--> \
            <div id='selection-options-container'> \
            </div> \
          </form> \
        </div> \
        <a href='#' class='btn bck-light-green white radius' id='add-quiz' style='padding: 5px 30px;'>Ekle</a> \
      </div> \
      <!-- popup content--> \
    </div>").appendTo('body').draggable();
  
    // initialize options
    var n = $('#leading-option-count').val();
    $('#selection-options-container').empty();
    $('#leading-answer-selection').empty();  
    var appendedText = "";    
    var appendAnswerText = "";
    for(var i = 0; i < parseInt(n); i++ ){
      var answer = answers[i];
      if(typeof answer == 'undefined') answer = '';
      appendedText +=  (i + 1) + ". seçenek <textarea class='popup-choices-area' id='selection-option-index-" + i + "'>" + answer + "</textarea> <br>";

      appendAnswerText += (i === 0) ? "<option selected value='" + ( i + 1 ) + "'>"+ ( i + 1 ) +"</option>" : "<option value='" + ( i + 1 ) + "'>"+ ( i + 1 ) +"</option>";  
    }
    $('#selection-options-container').append(appendedText);
    $('#leading-answer-selection').append(appendAnswerText);      

    // attach close event to close button
    $('#create-quiz-close-button').click(function(){
      $('#pop-quiz-popup').remove();  
      if ( $('#pop-quiz-popup').length ){
        $('#pop-quiz-popup').remove();  
      }
    });
      console.log(component);
      createQuizComponent( event, ui, component );

    };

  var image_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
    };

      $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        Görsel Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
          </div> \
          <div>\
            <input type='text' name='width' id='width' placeholder='Genişlik' value=''>\
            <input type='text' name='height' id='height' placeholder='Yükseklik' value=''>\
          </div> \
        </div>").appendTo('body').draggable();

        $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });
      console.log(component);
      createImageComponent( event, ui, component );

    };

  var link_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var link_value = 'http://linden-tech.com';
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
      link_value = component.data.self.attr.href;
    };
    console.log(top);
    console.log(left);
      $("<div class='popup ui-draggable' id='pop-image-link' style='display: block; top:" + top + "; left: " + left + ";'> \
          <div class='popup-header'> \
          Link Ekle \
          <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
          </div> \
         \
        <!-- popup content--> \
          <div class='gallery-inner-holder'> \
            <form id='video-url'> \
            <input id='link-url-text' class='input-textbox' type='url' placeholder='URL Adresini Giriniz'   value=" + link_value + "> \
            <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' id='add-image' style='padding: 5px 30px;'>Ekle</a> \
            </form> \
          </div>     \
           \
        <!-- popup content--> \
        </div>").appendTo('body').draggable();

      $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-link').remove();  

        if ( $('#pop-image-link').length ){
          $('#pop-image-link').remove();  
        }

      });

      console.log(component);
      createLinkComponent( event, ui, component );

    };

  var popup_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var popup_value = 'http://linden-tech.com';
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
      popup_value = component.data.html_inner;
    };
    console.log(top);
    console.log(left);
      $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        Görsel Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
          <textarea  id='popup-explanation' class='popup-text-area'>" + popup_value + ". \
          </textarea> <br> \
          <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' style='padding: 5px 30px;'>Ekle</a> \
        </div> \
        </div>").appendTo('body').draggable();

      $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });


      console.log(component);
      createPopupComponent( event, ui, component );

    };

  var video_popup = function(event, ui, component){
    console.log(component);
    
    if(typeof component == 'undefined'){
      console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var video_url = "http://lindneo.com/5.mp4";
    }
    else{
      top = component.data.self.css.top;
      left = component.data.self.css.left;
      video_url = component.data.source.attr.src;
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

      console.log(component);
      createVideoComponent( event, ui, component );

    };
  var newComponentDropPage = function(e, reader, file){
    var that =this;
    var component = {};
    reader.onload = function (evt) { 
        var FileBinary = evt.target.result;
        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
        //console.log(contentType);
        if(contentType == 'image'){
          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
          var image_width = size.w;
          var image_height = size.h;
        
          //console.log(image_width);

          component = {
            'type' : 'image',
            'data': {
              'img':{
                'css' : {
                  'width':'100%',
                  'height':'100%',
                  'margin': '0',
                  'padding': '0px',
                  'border': 'none 0px',
                  'outline': 'none',
                  'background-color': 'transparent'
                } , 
                'src': FileBinary
              },
              'lock':'',
              'self': {
                'css': {
                  'position':'absolute',
                  'top': (e.offsetY ) + 'px',
                  'left':  ( e.offsetX ) + 'px',
                  'width': image_width,
                  'height': image_height,
                  'background-color': 'transparent',
                  'overflow': 'visible',
                  'z-index': '990'
                }
              }
            }
          };

          window.lindneo.tlingit.componentHasCreated( component );
        }
        else if(contentType == 'video'){
          var contentType = FileBinary.substr(0, FileBinary.indexOf(';'));
          var videoType = contentType.substr(contentType.indexOf('/')+1);
          //console.log(videoType);
          var response = '';
          var videoURL = '';
          var token = '';


          that.send( 'getFileUrl', {'type': videoType}, function(response) {
            response=window.lindneo.tlingit.responseFromJson(response);
          
            that.send( 'UploadFile', {'token': response.result.token, 'file' : FileBinary} , function(data) {
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


                 window.lindneo.tlingit.componentHasCreated(component);
              });

          });




          
        }
      }
      reader.readAsDataURL(file);
      return false;
  };

  var newProgressBar= function(){
    var newProgressBarContainer=$("<li style='float:right; ' class='has-sub'></li>");
    var newProgressBarElement=$("<div style='width:100px;'></div>");
    $('#headermenu > ul').append(newProgressBarContainer);
    newProgressBarContainer.append(newProgressBarElement);
    newProgressBarElement.progressbar({
      value: 0
    });

    var returnVal={
      'bar':newProgressBarElement,
      'container': newProgressBarContainer
    };

    
    return returnVal;

  };
  var removeProgressBar= function(progressbar){
    progressbar.remove();
  }

  var send = function( action, data, successCallback, failCallback ){
    var that =this;
    var progressbar = this.newProgressBar();
    var requestRoute='EditorActions' +'/' + action;


    
    //console.log(action);

    $.ajax({

       'xhr': function(){
         var xhr = new window.XMLHttpRequest();
         //xhr.upload.onprogress = function(evt){console.log('pprogress')};
         
         //console.log(xhr.upload);

         //Upload progress
         xhr.upload.addEventListener("progress", function(evt){
          //console.log('Upload');
          //console.log(evt);
         if (evt.lengthComputable) {
           var percentage = evt.loaded / evt.total;
           progressbar.bar.progressbar('value', percentage*100);
           //Do something with upload progress

           //console.log(percentage);
           }
         }, false);
       
         //Download progress
         xhr.addEventListener("progress", function(evt){       
           if (evt.lengthComputable) {
             var percentage = evt.loaded / evt.total;
             progressbar.bar.progressbar('value', percentage*100);
           }
         }, false);
         return xhr;
       },
      'headers': {
        'X-PINGOTHER': 'pingpong',
        'contentType': 'plain/text; charset=UTF-8'
      },
      
      'type': 'POST',
      'url': window.lindneo.url+requestRoute,
      'data': data,
      
      beforeSend: function(){
        // Handle the beforeSend event
        //console.log('yükleniyor');
        //$('#save_status').text('Yükleniyor...');
        $('#save_status').addClass('icon-arrows-cw animate-spin size-30 light-blue');
      },
      'success': function(data) {

         that.removeProgressBar(progressbar.container);
         return successCallback(data); 
      },
      //'error': failCallback,
      error: function () {
        //console.log('ERROR');
        //$('#save_status').text('HATA VAR...');
        that.removeProgressBar(progressbar.container);
        $('#save_status').addClass('icon-warning light-red');
        $('#save_status').removeClass('arrows-cw animate-spin size-30 light-blue ');
        },
      complete: function(){

        // Handle the complete event
        //console.log('bitti');
        //$('#save_status').text('Kaydedildi...');
        that.removeProgressBar(progressbar.container);
        $('#save_status').addClass('icon-tick light-green');
        $('#save_status').removeClass('icon-arrows-cw animate-spin size-30 light-blue');
      }
    });
  };

  return {
    removeProgressBar: removeProgressBar,
    newProgressBar: newProgressBar,
    newComponentDropPage: newComponentDropPage,
    image_popup: image_popup,
    link_popup: link_popup,
    video_popup: video_popup,
    popup_popup: popup_popup,
    graph_popup: graph_popup,
    quiz_popup: quiz_popup,
    get_random_color: get_random_color,
    hexToRgb: hexToRgb,
    send: send
  };


})(jQuery);
