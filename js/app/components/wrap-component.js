'use strict';

$(document).ready(function(){
  $.widget('lindneo.wrapComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;
      var html_data = html_tag_replace(this.options.component.data.html_inner);
      var image_data = "<img class='wrapReady withSourceImage "+this.options.component.data.wrap_align+"' style='float:"+this.options.component.data.wrap_align+"; padding: 10px; border: 1px solid red; margin: 0 10px;' src='"+this.options.component.data.image_data+"' >";
      html_data = image_data +html_data;
      console.log(html_data);
      
      var wrap_cutoff = this.options.component.data.cutoff;
      //html_data = html_data + '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc justo massa, mattis in imperdiet in, pellentesque sit amet elit. Fusce vitae pulvinar nisi. Ut sed justo nec est congue cursus vestibulum eu dolor. Donec at mauris felis, sit amet ultrices odio. Aliquam erat volutpat. Nullam faucibus metus eu elit luctus sed malesuada risus molestie. Mauris nulla quam, tristique at lobortis at, fringilla quis nibh. Ut sapien mauris, imperdiet eget tincidunt semper, consectetur a augue. Donec vitae nibh augue, ut rhoncus elit. Nullam volutpat lorem sed odio lacinia non aliquet erat consequat. In ac libero turpis. In commodo nisl id diam dapibus varius. Sed lobortis ultricies ligula, quis auctor arcu imperdiet eget. Donec vel ipsum dui. In justo purus, molestie sit amet mattis sed, cursus non orci. Nullam ac massa vel tortor scelerisque blandit quis a sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc justo massa, mattis in imperdiet in, pellentesque sit amet elit. Fusce vitae pulvinar nisi. Ut sed justo nec est congue cursus vestibulum eu dolor. Donec at mauris felis, sit amet ultrices odio. Aliquam erat volutpat. Nullam faucibus metus eu elit luctus sed malesuada risus molestie. Mauris nulla quam, tristique at lobortis at, fringilla quis nibh. Ut sapien mauris, imperdiet eget tincidunt semper, consectetur a augue. Donec vitae nibh augue, ut rhoncus elit. Nullam volutpat lorem sed odio lacinia non aliquet erat consequat. In ac libero turpis. In commodo nisl id diam dapibus varius. Sed lobortis ultricies ligula, quis auctor arcu imperdiet eget. Donec vel ipsum dui. In justo purus, molestie sit amet mattis sed, cursus non orci. Nullam ac massa vel tortor scelerisque blandit quis a sapien.</p>'
      //console.log(html_data);
      html_data = html_data.replace('font-family: Arial, Helvetica, sans;', 'font-family: Helvetica;');
      html_data = html_data.replace('font-size: 11px;', 'font-size: 16px;');
      //console.log(html_data);

      var componentpopupid='popup'+this.options.component.id;

      if(this.options.component.data.html_inner){
        var popupmessage=$('<div  id="message_'+componentpopupid+'" style="display:block; font-family: Helvetica; font-size: 16px;" >'+html_data+'</div>');
        popupmessage.appendTo(this.element);
       //$($("#message_"+componentpopupid).find("img")).css("float",this.options.component.data.wrap_align);
      
      }

      //$($("#message_popupxbJ8GPriRdlVmYCy1zxTCzJXikXS7iIswGEJyrT8ck4Z").find("img")).css("float","left")

      
      
      $('.wrapReady.withSourceImage').slickWrap({
                    sourceImage: true,cutoff: wrap_cutoff, resolution: 1
                });
      this._super();  
      if(this.options.component.data.wrap_align == "right"){     
        var position = $("#message_"+componentpopupid).css("background-position");
        var px_pos = position.indexOf("px");
        var value = parseInt(position.substr(0,px_pos));
        position = position.replace(value, value -250);
        $("#message_"+componentpopupid).css("background-position", position);
      }
    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });
});

var html_tag_replace = function (str){
   //var content = str.replace('&lt;','<')
   //                 .replace('&gt;','>')
   //                 .replace('<div>','')
   //                 .replace('</div>','');
   while( str.indexOf('&lt;') > -1)
      {
        str = str.replace('&lt;', '<');
      }

    while( str.indexOf('&gt;') > -1)
      {
        str = str.replace('&gt;', '>');
      }

    while( str.indexOf('&amp;') > -1)
      {
        str = str.replace('&amp;', '&');
      }

    while( str.indexOf('<div>') > -1)
      {
        str = str.replace('<div>', '');
      }

    while( str.indexOf('</div>') > -1)
      {
        str = str.replace('</div>', '');
      }

    while( str.indexOf('<span>') > -1)
      {
        str = str.replace('<span>', '');
      }

while( str.indexOf('<span style="line-height: 1.428571429;">') > -1)
      {
        str = str.replace('<span style="line-height: 1.428571429;">', '');
      }
    while( str.indexOf('</span>') > -1)
      {
        str = str.replace('</span>', '');
      }
      
      
   //console.log(str);  <span style="line-height: 1.428571429;">
   return str;
};


var createWrapComponent = function ( event, ui, oldcomponent ) {  
  var width = 'auto';
  var height = 'auto';
  var wrap_align='left';
  var image_data;
  var multipleGroupName = "radioG"+$.now();
  var popup_value = '';
  var tolerance = 100;
  var html_inner = "";
  var self_width = "400px";
  var self_height = "300px";
  var top;
  var left;

  if(typeof oldcomponent == 'undefined'){
      top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    }
    else
    {
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      html_inner = oldcomponent.data.html_inner;
      image_data = oldcomponent.data.image_data;
      tolerance = oldcomponent.data.cutoff;
      self_width = oldcomponent.data.self.css.width ;
      self_height = oldcomponent.data.self.css.height;
      wrap_align = oldcomponent.data.wrap_align;
    };


    $('<div>').componentBuilder({
      top:top,
      left:left,
      title: j__("Metinle Çevrele"),
      btnTitle : j__("Ekle"), 
      beforeClose : function () {
        /* Warn about not saved work */
        /* Dont allow if not confirmed */
        return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
      },
      onBtnClick: function(){
        if (!image_data) {
          alert (j__("Lütfen bir resim ekleyiniz"));
          return false;
        }
        else if (html_inner == "") {
          alert (j__("Lütfen metin giriniz"));
          return false;
        }

        var  component = {
          'type' : 'wrap',
          'data': {
            'html_inner':  html_inner,
            'image_data':image_data,
            'cutoff':  tolerance,
            'wrap_align':  wrap_align,
            'width': self_width,
            'height': self_height,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'width': self_width,
                'height': self_height,
                'background-color': 'transparent',
                'overflow': 'visible',
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
        var compeleteForm = $("<form>")
          .attr("role","form")
          .appendTo(ui);

        var alingmentDiv = $('<div>')
          .addClass("form-group")
          .append( $("<label >").text( j__("Resim Pozisyonunu")+":").addClass("col-sm-4"))
          .appendTo(compeleteForm);

          var alignmetBtnGrp = $('<div>')
            .addClass("btn-group")
            .addClass("col-sm-8")
            .appendTo(alingmentDiv);
            
            var alignLeftLbl = $("<label>")
              .addClass("btn btn-primary")
              .text(j__("Sol"))
              .appendTo(alignmetBtnGrp);
              
              var alignLeftInput = $("<input type='radio'>")
                .val('left')
                .attr('name',multipleGroupName)
                .prependTo(alignLeftLbl);

            var alignRightLbl = $("<label>")
              .addClass("btn btn-primary")
              .text(j__("Sağ"))
              .appendTo(alignmetBtnGrp);
              
              var alignRightInput = $("<input type='radio'>")
                .val('right')
                .attr('name',multipleGroupName)
                .prependTo(alignRightLbl);

         

        var tolaranceDiv = $('<div>')
          .appendTo(compeleteForm);


          var toleranceLbl = $("<label>")
            .addClass("col-sm-4")
            .append(j__("Tolerans değeri")+":")
            .appendTo(tolaranceDiv);

          var toleranceValue = $('<span>')
            .addClass("col-sm-2")
            .addClass("integer")
            .addClass("bold")
            .text(tolerance);
            

          var toleranceSlider = $('<div>')
            .addClass("col-sm-6")
            .slider({
              value: tolerance,
              min: 0,
              max: 200,
              step: 10,
              slide: function( event, ui ) {
                tolerance = ui.value;
                toleranceValue.text( tolerance );
              }
            }).appendTo(tolaranceDiv);

          toleranceValue.appendTo(tolaranceDiv);

          var mainDiv = $("<div>")
            .addClass('col-sm-12')
            .appendTo(compeleteForm);

            var imageArea  = $("<div>")
              .addClass('col-sm-4')
              .appendTo(mainDiv);

              

              var removeImgBtn = $("<div>")
                .addClass("fa fa-trash-o")
                .click(function(){
                  image.hide();
                  $(this).hide();
                  drag_file.show();
                })
                .hide()
                .appendTo(imageArea);


              var image = $("<img>")
                .width("100%")
                .appendTo(imageArea)
                .hide();

              var drag_file = $("<div>")
                .addClass('add-image-drag-area')
                .appendTo(imageArea)
                ;

            var textArea  = $("<div>")
              .addClass('col-sm-8')
              .appendTo(mainDiv);

              var textdiv  = $("<div>")
                .attr("contenteditable",true)
                .attr("placeholder",j__("Metini buraya giriniz"))
                .css({'height':'300px'})
                .html(html_inner)
                .appendTo(textArea);

        textdiv.on('blur keyup paste input', function() {
          html_inner = $(this).html();
        });

        $(document).on('click','input[name="' + multipleGroupName + '"]', function(){
          wrap_align = $('input[name="' + multipleGroupName + '"]:checked').val();
          if (wrap_align=="left")
            imageArea.after(textArea);
          else
            imageArea.before(textArea);
        });

        var loadImage = function(image_data){
          image.attr("src",image_data);
          removeImgBtn.show();
          image.show();
          drag_file.hide();
        };

          var el = drag_file[0];
          var FileBinary = '';
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
            reader.onload = function (evt) {
              FileBinary = evt.target.result;
              var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
              if(contentType == 'image'){
                var imageBinary = FileBinary;
                image_data = imageBinary;
                loadImage(image_data);
                return;         
              } 
            };
            reader.readAsDataURL( e.dataTransfer.files[0] );
          }, false);

        /* Set values from empty or old component */
        if(image_data) loadImage(image_data);
        if(tolerance) toleranceSlider.slider( "option", "value",tolerance);
        if(html_inner) textdiv.html(html_inner);



      }
    }).appendTo('body');

  };
