'use strict';

$(document).ready(function(){
  $.widget('lindneo.plinkComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      console.log(this.options.component.data);
      //return;

      var componentplinkid='plink'+this.options.component.id;
      

      var plink_data = this.options.component.data.plink_data;
      var page_link = this.options.component.data.page_link;
      var marker = this.options.component.data.marker;
      var selected_tab = this.options.component.data.selected_tab;
      console.log(plink_data);
      
      if(selected_tab == "name"){
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; width:100%; height:100%; "></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html(plink_data);
      }
      else if(selected_tab == "icon"){
        var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; "></div>');
        popupmessage.appendTo(this.element);
        popupmessage.html('<img src="'+this.options.component.data.marker+'" style="width:100%; height:100%;"/>');
      }
      else if(selected_tab == "area"){
        console.log(this.options.component.data.height);
        console.log(this.options.component.data.self.css);
        var width = this.options.component.data.self.css.width;
        var height = this.options.component.data.self.css.height; 
        if(this.options.component.data.height!=0){
          var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; border: solid yellow; width:'+width+'; height:'+height+';"></div>');
        }
        else{
          var popupmessage=$('<div  id="message_'+componentplinkid+'"  style="overflow:hidden; border: solid yellow; min-width:'+'100%; min-height:'+'100%;"></div>');
        }
        popupmessage.appendTo(this.element);
      }
       
      this._super({resizableParams:{handles:"e, s, se"}});
      
    },
    _on : function (event, ui) {
      console.log(this.options.component.id);
      
    },
    field: function(key, value){
      
      this._super();


      // set
      this.options.component[key] = value
    }
    
  });
});


var createPlinkComponent = function ( event, ui, oldcomponent ) {  

  var width = 'auto';
  var height = 'auto';
  var wrap_align='left';
  var plink_data="";
  var page_link="";
  var self_width = "550px";
  var self_height = "600px";
  var top;
  var left;
  var FileBinary = "";
  var marker = window.base_path+'/css/popupmarker.svg';
  var video_marker=window.base_path+'/css/image_play_trans.png';
  var selected_tab = "name";

  if(typeof oldcomponent == 'undefined'){
    //console.log('dene');
    top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
  }
  else{
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    plink_data = oldcomponent.data.html_inner;
    width = oldcomponent.data.width ;
    height = oldcomponent.data.height;
  }; 

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
  else if(left+310 > max_left)
    left = max_left - 310;

  if(top < min_top)
    top = min_top;
  else if(top+650 > max_top)
    top = max_top - 650;

    top = top + "px";
    left = left + "px";
 

  var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Sayfa Bağlantısı"),
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
      else */
      if (!page_link) {
          alert (j__("Lütfen bir sayfa linki seçiniz"));
          return false;
        }

      var width = "200px";
      var height = "150px"; 
      //var plink_data = $("textarea#baslik").val();
      //var page_link = $('input[name=page_select]:checked').val();

      var  component = {
          'type' : 'plink',
          'data': {
            'plink_data': plink_data ,
            'plink_image': FileBinary,
            'page_link': page_link ,
            'width': '0',
            'height': '0',
            'marker': marker,
            'selected_tab': selected_tab,
            'overflow': 'visible',
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'overflow': 'visible',
                'opacity': '1',
                'z-index': 'first',
                'width':width,
                'height':height
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
        var book_data='';
        

        var mainDiv = $('<div>')
            .appendTo(ui);

          var tabDiv = $ ('<div>')
            .addClass("tabbable")
            .appendTo(mainDiv);

            var tabUl = $ ('<ul>')
              .addClass("nav nav-tabs")
              .appendTo (tabDiv);

              var tabPageLinkNameLi = $('<li>')
                .addClass("active")
                .appendTo(tabUl);
                
                var tabPageLinkNameA = $ ('<a>')
                  .attr('href','#'+idPre+'name')
                  .attr('data-toggle','tab')
                  .text(j__("Sayfa Bağlantısı Adı"))
                  .click(function() {
                    selected_tab = $(this)[0].hash.substr(14);
                  })
                  .appendTo(tabPageLinkNameLi);

              
              var tabPageLinkIconLi = $('<li>')
                .appendTo(tabUl);

                var tabPageLınkIconA = $ ('<a>')
                  .attr('href','#'+idPre+'icon')
                  .attr('data-toggle','tab')
                  .text(j__("Sayfa Bağlantısı İkonu"))
                  .click(function() {
                    selected_tab = $(this)[0].hash.substr(14);
                  })
                  .appendTo(tabPageLinkIconLi);

              var tabPageLinkAreaLi = $('<li>')
                .appendTo(tabUl);

                var tabPageLınkAreaA = $ ('<a>')
                  .attr('href','#'+idPre+'area')
                  .attr('data-toggle','tab')
                  .text(j__("Sayfa Bağlantısı Alanı"))
                  .click(function() {
                    selected_tab = $(this)[0].hash.substr(14);
                  })
                  .appendTo(tabPageLinkAreaLi);

            $('<br>').appendTo(tabDiv);

            var pLinkDiv = $ ('<div>')
              .addClass("tab-content")
              .appendTo(tabDiv);


            var pageNameDiv = $ ('<div>')
              .addClass("tab-pane fade")
              .addClass("active in")
              .attr('id',idPre+'name')
              .appendTo(pLinkDiv);

              var pNameContent = $ ('<div>')
                .appendTo(pageNameDiv);

                var pNameTextArea = $ ('<textarea >')
                  .attr("row","2")
                  .attr("cols","30")
                  .attr('placeholder',j__("Başlığı buraya giriniz"))
                  .change(function() {
                    plink_data = $(this)[0].value;
                  })
                  .appendTo(pNameContent);

                $('<br>').appendTo(pageNameDiv);

            var pageIconDiv = $ ('<div>')
              .addClass("tab-pane fade")
              .attr('id',idPre+'icon')
              .appendTo(pLinkDiv);

              var pIconContent = $('<span>')
                .appendTo(pageIconDiv);

                var pIconRadioFirst = $('<input type="radio">')
                  .attr("name","plink_image_type")
                  .appendTo(pIconContent);
                var pIconButtonFirst = $('<button>')
                  .css({"background":"url('"+marker+"') no-repeat center center","-moz-background-size": "cover", "-webkit-background-size": "cover", "-o-background-size": "cover", "background-size": "cover", "width":"70px", "height":"70px"})
                  .appendTo(pIconContent);

                var pIconRadioSecond = $('<input type="radio">')
                  .attr("name","plink_image_type")
                  .appendTo(pIconContent);
                var pIconButtonSecond = $('<button>')
                  .css({"background":"url('"+video_marker+"') no-repeat center center","-moz-background-size": "cover", "-webkit-background-size": "cover", "-o-background-size": "cover", "background-size": "cover", "width":"70px", "height":"70px"})
                  .appendTo(pIconContent);

                pIconButtonFirst.click(function(){pIconRadioFirst.prop("checked", true); console.log(marker);});
                pIconButtonSecond.click(function(){pIconRadioSecond.prop("checked", true); marker = video_marker; console.log(marker);});

                var pIconNewLink = $('<a>')
                  .addClass("icon-upload dark-blue size-40")
                  .click(function(){
                    pIconFile.click();
                  })
                  .css("padding-left","15px")
                  .appendTo(pIconContent);

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
                      FileBinary = evt.target.result;
                        var contentType = FileBinary.substr(5, FileBinary.indexOf('/')-5);
                        
                        //console.log(contentType);
                        if(contentType == 'image'){
                          var imageBinary = FileBinary;
                          pIconNewImage.html('');
                          var newImage = $("<img style='width:70px; height:70px;' src='"+imageBinary+"' />");
                          marker=imageBinary;
                          pIconNewImage.append(newImage);
                          return;
                          
                        }
                      };

                    })
                  .appendTo(pIconContent);

                var pIconNewImage = $ ('<div>')
                  .appendTo(pIconContent);

                var pIconDragImage = $ ('<div>')
                  .addClass("add-image-drag-area")
                  .appendTo(pIconContent);

                $('<br>').appendTo(pageIconDiv);


            var pageAreaDiv = $ ('<div>')
              .addClass("tab-pane fade")
              .attr('id',idPre+'area')
              .appendTo(pLinkDiv);

              var pNameContent = $ ('<div>')
                .text(j__("Sayfa Bağlantısı Alanı Ekle butonuna basıldıktan sonra sayfaya eklenecek ve alanın büyüklüğünü sayfa üzerinden yapabileceksiniz"))
                .appendTo(pageAreaDiv);

              $('<br>').appendTo(pageAreaDiv);

            tabDiv.tab();

        var plinkWindowElement = ui ;

        var page_count = 1;
        
        $.ajax({
          url: "/book/getBookPages/"+lindneo.currentBookId,
        }).done(function(result) {
          book_data = JSON.parse(result);

          var pageDiv = $ ('<div>')
                .appendTo(pLinkDiv);

          $.each( book_data, function( key, value ) {
            console.log(value.title);
            var title = value.title;
            if(!value.title) title = deger + ". "+j__("Bölüm");

            var pageChapterTitle = $ ('<h3>')
                .text(title)
                .appendTo(pageDiv);

            var pageChapterContent = $ ('<p>')
                .appendTo(pageDiv);

            $.each( value.pages, function( key_page, value_page ) {
              //<input type="radio" name="page_select" value="'+value_page+'">'+page_count+'. '+j__("Sayfa")+'<br>
              

                var pageChapterPage = $ ('<input type="radio">')
                  .attr("name","page_select")
                  .attr("value",value_page)
                  .change(function(){
                    page_link = $(this)[0].value;
                  })
                  .appendTo(pageChapterContent);
                var pageChapterPageName = $('<span>')
                  .text(page_count+'. '+j__("Sayfa"))
                  .appendTo(pageChapterContent);

                $('<br>').appendTo(pageChapterContent);

              page_count++;
            });

          });

          pageDiv.accordion();

        });
    }
  }).appendTo('body');

};
