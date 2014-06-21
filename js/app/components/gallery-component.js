'use strict';

$(document).ready(function(){
  $.widget('lindneo.galeryComponent', $.lindneo.component, {
    
    options: {
      slideDur : 2000,
      fadeDur : 800 ,
      slideSelector : 'li', // selector for target elements
    }, 
    
    _create: function(){
        
      var that = this;
      //var image_width = "";
      //if( that.options.component.type=='galery')
      //console.log(that.options.component.data);
      if( that.options.component.data.ul.imgs ) {
        var counter=0;
        var ul=$('<ul></ul>');
        ul.css(that.options.component.data.ul.css);
        this.element.parent().find('.some-gallery').css(that.options.component.data['some_gallery'].css);
        
    
        //console.log(that);

        that.imageDOMs=[];  
        $.each (that.options.component.data.ul.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            //var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
            //var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            if( that.options.component.data.galery_type=='inner'){
              var image= $('<img class="galery_component_image" style="display: block; margin: auto auto; height:100%; padding:0; position:absolute; top:0; right:0; bottom:0; left:0; " src="'+value.src+ '" />'); 
              var container=$('<li class="galery_component_li" style="background-color:black; float:left; position: relative; clear:both; width: 100%; height: 100%; '+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
              image.galleryContainer=container;
              that.imageDOMs.push(image);
              }
            else{
              var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
              var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            }
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
      this._super({resizableParams:{handles:"e, s, se", minWidth:100, minHeight:100,resize:function(event,ui){
                                                        
                                                        window.lindneo.toolbox.makeMultiSelectionBox();
                                                        if( that.options.component.data.galery_type=='inner')
                                                            that.also_resize_inner_images(event,ui,that);

                                                      }
    }});
    },

    also_resize_inner_images: function(event,ui,that){
                                                      $.each(that.imageDOMs,function(index,element){
                                                            var containerWidth = element.galleryContainer.width();
                                                            var containerHeight = element.galleryContainer.height();
                                                            var imageWidth = element.width();
                                                            var imageHeight = element.height();

                                                            var containerAspect = containerWidth/containerHeight;
                                                            var imageAspect = imageWidth/imageHeight;

                                                            if(containerAspect<imageAspect){
                                                              element.css({'width':containerWidth +"px" , "height" : "auto" });
                                                            } else {
                                                              element.css({'height':containerHeight +"px" , "width" : "auto" });
                                                            }
                                                            //console.log(containerWidth);
                                                        });
    },

    field: function(key, value){
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});
 
var image_width ;
var image_height;

var createGaleryComponent = function (event,ui, oldcomponent){

  var galery_type = "";
  var images = "";
  var imagesDiv;

    

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

  var control_y_check ="";
  var control_y_check_active ="";
  var control_n_check ="";
  var control_n_check_active ="";
  if(galery_type == 'inner') { control_y_check = "checked='checked'"; control_y_check_active = 'active';}
  else { control_n_check = "checked='checked'"; control_n_check_active = 'active'; }
  
  //console.log(min_top);
  //console.log(max_top);
  if(left < min_left)
    left = min_left;
  else if(left+310 > max_left)
    left = max_left - 310;

  if(top < min_top)
    top = min_top;
  else if(top+500 > max_top)
    top = max_top - 500;

  top = top + "px";
  left = left + "px";

  if(typeof oldcomponent == "undefined"){
    galery_type = "inner";
    image_width = "200px";
    image_height = "200px";
    
  }
  else{
    galery_type = oldcomponent.data.galery_type;
    image_width = oldcomponent.data.self.css.width;
    image_height = oldcomponent.data.self.css.height;
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    //console.log(top);
  }

  var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Galeri"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){
      /*if (!plink_data) {
          alert (j__("Lütfen başlığı giriniz"));
          return false;
        }
      else 
      if (!page_link) {
          alert (j__("Lütfen bir sayfa linki seçiniz"));
          return false;
        }
        */
        //console.log(top);
      var imgs=[];
      imagesDiv.find("img").each(function( index ) {
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

        //console.log( index + ": " + $( this ).text() );
      });

      var component = {
        'type' : 'galery',
        'data': {
          'some_gallery':{
            'css': {
              'width': '100%',
              'height': '100%',
              'min-height':'100px',
              'min-width':'100px',
            }
          },
          'galery_type': galery_type,
          'ul':{
            'css': {
              'overflow':'hidden',
              'margin': '0',
              'padding': '0',
              'position': 'relative',
              'min-height':'100px',
              'min-width':'100px',
              'width': '100%',
              'height': '100%'
            },
          'imgs':imgs
          },
          'lock':'',
          'self': {
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,
              'background-color': 'transparent',
              'width': image_width,
              'height': image_height,
              'z-index': 'first',
              'opacity':'1'

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

              var galeryDiv = $ ('<div>')
                .addClass("tab-content")
                .appendTo(tabDiv);

                var galeryDragDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .addClass("active in")
                  .attr('id',idPre+'drag')
                  .appendTo(galeryDiv);

                  $('<br>').appendTo(galeryDragDiv);

                  var galeryDragContent = $ ('<div>')
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
                      
                        //console.log(image_width);
                        //console.log(control_val);
                        imageBinary = evt.target.result;
                        var newimageLI = $ ('<div>')
                          .css({"height":"60px", "width":"60px", "margin":"10px", "border": "1px dashed #ccc", "float":"left"})
                          .appendTo(imagesDiv);

                          var newimageA = $ ('<a>')
                          .addClass("btn btn-info size-10 icon-delete galey-image-delete")
                          .css({"margin-left": "42px", "position":"absolute"})
                          .click(function(){
                              $(this).parent().remove();
                          })
                          .appendTo(newimageLI);

                          var newimageIMG = $ ('<img>')
                          .css("height","100%")
                          .attr("src",imageBinary)
                          .appendTo(newimageLI);
                            
                          imagesDiv.sortable({
                            placeholder: "ui-state-highlight"
                          });
                          imagesDiv.disableSelection();
                     

                        }; 
                      };
                      //console.log(e.originalEvent.dataTransfer.files[0]);
                      reader.readAsDataURL( e.originalEvent.dataTransfer.files[0] );

                    })
                    .appendTo(galeryDragDiv);

                var galeryUploadDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .attr('id',idPre+'upload')
                  .appendTo(galeryDiv);

                  $('<br>').appendTo(galeryUploadDiv);

                  var galeryuploadContent = $ ('<span>')
                    .addClass("btn btn-success fileinput-button")
                    .css({"position": "relative", "overflow": "hidden"})
                    .appendTo(galeryUploadDiv);

                    var galeryuploadContentI = $ ('<i>')
                      .addClass("fa fa-plus")
                      .appendTo(galeryuploadContent);

                    var galeryuploadContentSpan = $ ('<span>')
                      .text(j__("Resim Ekle"))
                      .appendTo(galeryuploadContent);

                    var galeryuploadContentInput = $ ('<input type="file" multiple>')
                      .attr("name","files[]")
                      .css({"position": "absolute", "top": "0", "right": "0", "min-width": "100%", "min-height": "100%", "font-size": "999px", "text-align": "right", "filter": "alpha(opacity=0)", "opacity": "0", "outline": "none", "background": "white", "cursor": "inherit", "display": "block"})
                      .change(function(event){

                        var image_type = $('input[name=image_type]:checked').val();

                        var files = event.target.files;
                        //console.log(files);

                        for(var i = 0; i< files.length; i++)
                        {
                            var file = files[i];
                            
                            //Only pics
                            if(!file.type.match('image'))
                              continue;
                            
                            var picReader = new FileReader();
                            
                            picReader.addEventListener("load",function(event){
                                
                                var picFile = event.target;
                                
                                //var div = document.createElement("div");
                                
                                //div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                                        //"title='" + picFile.name + "'/>";
                                
                                //output.insertBefore(div,null);            
                                imageBinary = picFile.result;

                              var newimageLI = $ ('<div>')
                                .css({"height":"60px", "width":"60px", "margin":"10px", "border": "1px dashed #ccc", "float":"left"})
                                .appendTo(imagesDiv);

                                var newimageA = $ ('<a>')
                                .addClass("btn btn-info size-10 icon-delete galey-image-delete")
                                .css({"margin-left": "42px", "position":"absolute"})
                                .click(function(){
                                    $(this).parent().remove();
                                })
                                .appendTo(newimageLI);

                                var newimageIMG = $ ('<img>')
                                .css("height","100%")
                                .attr("src",imageBinary)
                                .appendTo(newimageLI);
                            
                              imagesDiv.sortable({
                                placeholder: "ui-state-highlight"
                              });
                              imagesDiv.disableSelection();
                            
                            });
                            
                             //Read the image
                            picReader.readAsDataURL(file);
                        }   
                      })
                      .appendTo(galeryuploadContent);

                    $('<br><br>').appendTo(galeryUploadDiv);

            imagesDiv = $ ('<ul>')
            .css("width","100%")
            .appendTo(mainDiv)
            .sortable({
              placeholder: "ui-state-highlight"
            })
            .disableSelection();

          var typeDiv = $ ('<div>')
            .addClass("type1")
            .css({"padding": "4px", "display": "inline-block", "width": "100%"})
            .appendTo(mainDiv);

            var typeDivContent = $ ('<div>')
              .addClass("btn-group")
              .attr("data-toggle","buttons")
              .text(j__("Galeri Tipi"))
              .appendTo(typeDiv);
            $('<br>').appendTo(typeDivContent);

              var typeDivInner = $ ('<label>')
                .addClass("btn btn-primary "+control_y_check_active)
                .appendTo(typeDivContent);

                var typeDivInnerInput = $ ('<input type="radio">')
                  .attr("name","galery_type")
                  .attr("value","inner")
                  .change(function () {
                    galery_type = $(this)[0].value;
                  })
                  .appendTo(typeDivInner);

                var typeDivInnerName = $('<span>')
                  .text(j__("İçe Yaslı"))
                  .appendTo(typeDivInner);

              var typeDivOuter = $ ('<label>')
                .addClass("btn btn-primary "+control_n_check_active)
                .appendTo(typeDivContent);

                var typeDivOuterInput = $ ('<input type="radio">')
                  .attr("name","galery_type")
                  .attr("value","outer")
                  .change(function () {
                    galery_type = $(this)[0].value;
                  })
                  .appendTo(typeDivOuter);
                  
                var typeDivOuterName = $('<span>')
                  .text(j__("dışa Yaslı"))
                  .appendTo(typeDivOuter);

      var control_val = 0;
    
      var el = galeryDragContent;
      var imageBinary = '';

      if(typeof oldcomponent != "undefined"){
      
        $.each(oldcomponent.data.ul.imgs, function(i,val){
          //console.log(val.src);
          var newimageLI = $ ('<div>')
            .css({"height":"60px", "width":"60px", "margin":"10px", "border": "1px dashed #ccc", "float":"left"})
            .appendTo(imagesDiv);

            var newimageA = $ ('<a>')
            .addClass("btn btn-info size-10 icon-delete galey-image-delete")
            .css({"margin-left": "42px", "position":"absolute"})
            .click(function(){
                $(this).parent().remove();
            })
            .appendTo(newimageLI);

            var newimageIMG = $ ('<img>')
            .css("height","100%")
            .attr("src",val.src)
            .appendTo(newimageLI);
          
        });

        imagesDiv.sortable({
          placeholder: "ui-state-highlight"
        });
        imagesDiv.disableSelection();
      }



    }

  }).appendTo('body');

};
