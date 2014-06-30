'use strict';

$(document).ready(function(){
  $.widget('lindneo.imageComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
      
      console.log(this.options.component);
      var componentimageid='image'+this.options.component.id;
        if(this.options.component.data.img.image_type == 'popup'){
          console.log(this.options.marker);
          if( this.options.marker ) {
            //var newimage=$('<img id="img_'+componentimageid+'" src="' + this.options.marker +  '"/>');
            //console.log(this.options);
            //newimage.appendTo(this.element);

            this.element.attr('src', this.options.marker);
          }
          
          //this.options.component.data.html_inner = '<img src="' + this.options.component.data.img.src + '" ></img> ';
          //var popupmessage=$('<div  id="message_'+componentimageid+'" style="display:none" >'+this.options.component.data.html_inner+'</div>');
          //popupmessage.appendTo(this.element.parent());
        }
      else{
        if( this.options.component.data.img ) {
          //var source = $('<img src="' + this.options.component.data.img.src + '" ></img> ');

          //source.appendTo(this.element);
          this.element.attr('src', this.options.component.data.img.src);  
        }
      }
      //console.log(this.options.component);
      
      var el=this.element.get(0);
      var imageBinary;


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

        var image = new Image();
        image.src = evt.target.result;

        image.onload = function() {

          //console.log(this.width);
          var image_width = this.width;
          var image_height = this.height;
          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
          //console.log(size);
          image_width = size.w;
          image_height = size.h;

          imageBinary = evt.target.result;        
          
          component = $.parseJSON(window.lindneo.tlingit.componentToJson(that.options.component));
          //console.log(component.data.lock);
          if(component.data.lock == ''){ 
           
            component.data.img.src = imageBinary;
            component.data.self.css.width = image_width;
            component.data.self.css.height = image_height;

            
            window.lindneo.tlingit.componentHasCreated(component);
            window.lindneo.tlingit.componentHasDeleted(that.options.component, that.options.component.id);
            
          };
        };
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

      this._super();
    },
    getSettable : function (propertyName){
     return this.options.component.data.img;
    },

    field: function(key, value){
      console.log(key);
      console.log(value);
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



var createImageComponent = function ( event, ui ,oldcomponent) {

  var marker = window.base_path+'/css/popupmarker.png';
  var video_marker=window.base_path+'/css/image_play_trans.png';
  var image_width_height = '';
  var imageBinary;
  var image_width;
  var image_height;

  if(typeof oldcomponent == 'undefined'){
    //console.log('dene');
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    var image_type = 'link';
  }
  else{
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    image_type = oldcomponent.data.img.image_type;
  };
  var link_check = '';
  var link_check_active = '';
  var popup_check = '';
  var popup_check_active = '';

  if(image_type == 'link') { link_check = "checked='checked'"; link_check_active = 'active';}
  else { popup_check = "checked='checked'"; popup_check_active = 'active'; }

  var min_left = $("#current_page").offset().left;
  var min_top = $("#current_page").offset().top;
  var max_left = $("#current_page").width() + min_left;
  var max_top = $("#current_page").height() + min_top;
  var window_width = $( window ).width();
  var window_height = $( window ).height();

  if(max_top > window_height) max_top = window_height;
  if(max_left > window_width) max_top = window_width;

  top=(event.pageY-25);
  left=(event.pageX-150);

  if(left < min_left)
    left = min_left;
  else if(left+310 > max_left)
    left = max_left - 310;

  if(top < min_top)
    top = min_top;
  else if(top+600 > max_top)
    top = max_top - 600;

  top = top + "px";
  left = left + "px";

  var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Resim"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){

      console.log(marker);

      if(typeof oldcomponent == 'undefined'){
        //console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
        
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;

      };
      
      image_width_height = '100%';
      var component = {
          'type' : 'image',
          'data': {
            'img':{
              'css' : {
                'width':image_width_height,
                'height':image_width_height,
                'margin': '0',
                'padding': '0px',
                'border': 'none 0px',
                'outline': 'none',
                'opacity': '1',
                'background-color': 'transparent'
              } , 
              'image_type' : image_type,
              'marker' : marker,
              'src': imageBinary
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': image_width,
                'height': image_height,
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
      var mainDiv = $('<div>')
        .appendTo(ui);

        var imageTypeDiv = $('<div>')
          .addClass("typei")
          .css({"padding": "4px", "display": "inline-block"})
          .appendTo(mainDiv);

        var popupDiv = $('<div>')
          .appendTo(mainDiv);

          var imageTypeRadioDiv = $('<div>')
            .addClass("btn-group")
            .attr("data-toggle","buttons")
            .appendTo(imageTypeDiv);

            var imageTypeLinkLabel = $('<label>')
              .addClass("btn btn-primary " + link_check_active)
              .appendTo(imageTypeRadioDiv);

              var imageTypeLinkInput = $('<input type="radio">')
                .attr("name","image_type")
                .val("link")
                .change(function () {
                  image_type = $(this)[0].value;
                })
                .appendTo(imageTypeLinkLabel);

              var imageTypeLinkText = $('<span>')
                .text(j__("Sayfada"))
                .appendTo(imageTypeLinkLabel);

            var imageTypePopupLabel = $('<label>')
              .addClass("btn btn-primary " + popup_check_active)
              .appendTo(imageTypeRadioDiv);

              var imageTypePopupInput = $('<input type="radio">')
                .attr("name","image_type")
                .val("popup")
                .change(function () {
                  image_type = $(this)[0].value;

                  var imagePopupDiv = $('<span>')
                    .appendTo(popupDiv);

                      var pIconRadioFirst = $('<input type="radio">')
                        .attr("name","plink_image_type")
                        .appendTo(imagePopupDiv);
                      var pIconButtonFirst = $('<button>')
                        .css({"background":"url('"+marker+"') no-repeat center center","-moz-background-size": "cover", "-webkit-background-size": "cover", "-o-background-size": "cover", "background-size": "cover", "width":"70px", "height":"70px"})
                        .appendTo(imagePopupDiv);

                      var pIconRadioSecond = $('<input type="radio">')
                        .attr("name","plink_image_type")
                        .appendTo(imagePopupDiv);
                      var pIconButtonSecond = $('<button>')
                        .css({"background":"url('"+video_marker+"') no-repeat center center","-moz-background-size": "cover", "-webkit-background-size": "cover", "-o-background-size": "cover", "background-size": "cover", "width":"70px", "height":"70px"})
                        .appendTo(imagePopupDiv);

                      pIconButtonFirst.click(function(){pIconRadioFirst.prop("checked", true); console.log(marker);});
                      pIconButtonSecond.click(function(){pIconRadioSecond.prop("checked", true); marker = video_marker; console.log(marker);});

                      var pIconNewLink = $('<a>')
                        .addClass("icon-upload dark-blue size-40")
                        .click(function(){
                          pIconFile.click();
                        })
                        .css("padding-left","15px")
                        .appendTo(imagePopupDiv);

                      var pIconNewImage = $ ('<div>')
                        .appendTo(imagePopupDiv);

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
                            var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
                              
                            //console.log(contentType);
                            if(contentType == 'image'){
                              
                              pIconNewImage.html('');
                              var newIconImage = $("<img style='width:70px; height:70px;' src='"+FileBinary+"' />");
                              marker=FileBinary;
                              pIconNewImage.append(newIconImage);
                              return;
                              
                            }
                          };  

                        })
                      .appendTo(imagePopupDiv);
                })
                .appendTo(imageTypePopupLabel);

              var imageTypePopupText = $('<span>')
                .text(j__("Açılır Pencerede"))
                .appendTo(imageTypePopupLabel);

        var tabDiv = $ ('<div>')
            .addClass("tabbable")
            .appendTo(mainDiv);

            var tabUl = $ ('<ul>')
              .addClass("nav nav-tabs")
              .appendTo (tabDiv);

              var tabGaleryDragLi = $('<li>')
                .addClass("active")
                .appendTo(tabUl);
                
                var tabGaleryDragA = $ ('<a>')
                  .attr('href','#'+idPre+'drag')
                  .attr('data-toggle','tab')
                  .text(j__("Resim Sürükle"))
                  .appendTo(tabGaleryDragLi);

              
              var tabGaleryUploadLi = $('<li>')
                .appendTo(tabUl);

                var tabGaleryUploadA = $ ('<a>')
                  .attr('href','#'+idPre+'upload')
                  .attr('data-toggle','tab')
                  .text(j__("Resim Yükle"))
                  .appendTo(tabGaleryUploadLi);

              $('<br>').appendTo(tabDiv);

            var imageDiv = $ ('<div>')
                .addClass("tab-content")
                .appendTo(tabDiv);

                var imageDragDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .addClass("active in")
                  .attr('id',idPre+'drag')
                  .appendTo(imageDiv);

                  $('<br>').appendTo(imageDragDiv);

                  var imageDragContent = $ ('<div>')
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

                      var reader = new FileReader();
                      var component = {};
                      
                      reader.onload = function (evt) {

                        var image = new Image();
                        image.src = evt.target.result;

                        image.onload = function() {
                         
                          
                          image_width = this.width;
                          image_height = this.height;
                          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
                          image_width = size.w;
                          image_height = size.h;
                        
                        
                          imageBinary = evt.target.result;

                          newImageDiv.html("");
                          $("<img src='"+imageBinary+"' style='width:60px; height:60px;'>").appendTo(newImageDiv);
                     

                        }; 
                      };
                      //console.log(e.originalEvent.dataTransfer.files[0]);
                      reader.readAsDataURL( e.originalEvent.dataTransfer.files[0] );

                    })
                    .appendTo(imageDragDiv);


                var imageUploadDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .attr('id',idPre+'upload')
                  .appendTo(imageDiv);

                  var imageUploadDiv = $ ('<input type="file">')
                    .attr("name","image_file")
                    .change(function(){
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
                        var image = new Image();
                          image.src = _file.target.result;

                          image.onload = function() {
                          // access image size here 
                          
                          image_width = this.width;
                          image_height = this.height;
                          if($('#width').val() != '')
                            image_width = $('#width').val();
                          if($('#height').val() != '')
                            image_height = $('#height').val();
                          var size = window.lindneo.findBestSize({'w':image_width,'h':image_height});
                          image_width = size.w;
                          image_height = size.h;

                          
                          
                          imageBinary = _file.target.result;  
                          newImageDiv.html("");
                          $("<img src='"+imageBinary+"' style='width:60px; height:60px;'>").appendTo(newImageDiv);
                        }
                      }
                    })
                    .appendTo(imageUploadDiv);


        var newImageDiv = $('<div>')
          .addClass("newimage")
          .appendTo(mainDiv); 

        if(typeof oldcomponent !== 'undefined'){
          $("<img src='"+oldcomponent.data.img.src+"' style='width:60px; height:60px;'>").appendTo(newImageDiv);
          if(oldcomponent.data.img.image_type == "popup")
            imageTypePopupInput.change();
        }
                    
    }

  }).appendTo('body');

};
