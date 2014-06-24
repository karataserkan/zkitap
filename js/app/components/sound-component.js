'use strict';

$(document).ready(function(){
  $.widget('lindneo.soundComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;

      var auto_start = '';
      var repeat_type= '';
      //console.log(this.options.component.data);
      if(this.options.component.data.auto_type == 'Y') auto_start = 'autoplay';
      if(this.options.component.data.control_type == 'N') control = '';
      if(this.options.component.data.repeat_type == 'Y') repeat_type='loop';
      //console.log(repeat_type);
      if(this.options.component.data.source.attr.src ) {
        var source=$('<source src="'+this.options.component.data.source.attr.src+'" /> ');
        var audio=$('<audio controls="controls" '+auto_start+' '+repeat_type+'></audio>');
        var audioName = "";
        if(this.options.component.data.audio.name) audioName = this.options.component.data.audio.name;
        var audio_name=$('<span class="audio-name" >'+audioName+'</span>');
 
        source.appendTo(audio);
        //console.log('deneme');
        audio_name.appendTo(this.element);
        audio.appendTo(this.element);
        audio.css(this.options.component.data.audio.css);

        // this.element.attr('src', this.options.component.data.img.src);  
      }
      

      this._super({resizableParams:{
        "handles":"e",
        /*"maxHeight":60,*/
        "minHeight":60,
      }});
      //this.element.height(60);


    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



var createSoundComponent = function (event,ui){
  var imageBinary = '';
  var auto_y_check = '';
  var auto_y_check_active = '';
  var auto_n_check = '';
  var auto_n_check_active = '';
  var repeat_y_check = '';
  var repeat_y_check_active = '';
  var repeat_n_check = '';
  var repeat_n_check_active = '';
  var auto_type;
  var repeat_type;
  var sound_name;

  if(typeof oldcomponent == 'undefined'){
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    auto_type = 'N';
    repeat_type = 'N';
    sound_name = "";
  }
  else{
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
    auto_type = oldcomponent.data.auto_type;
    repeat_type = oldcomponent.data.repeat_type;
    sound_name = oldcomponent.data.audio.name;
  };
 
  if(auto_type == 'Y') { auto_y_check = "checked'"; auto_n_check = ''; auto_y_check_active = 'active'; auto_n_check_active =""; }
    else { auto_n_check = "checked"; auto_y_check = ''; auto_n_check_active = 'active'; auto_y_check_active = ""; }

  if(repeat_type == 'Y') { repeat_y_check = "checked'"; repeat_n_check = ''; repeat_y_check_active = 'active'; repeat_n_check_active =""; }
    else { repeat_n_check = "checked"; repeat_y_check = ''; repeat_n_check_active = 'active'; repeat_y_check_active = ""; }
  
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
  else if(left+355 > max_left)
    left = max_left - 355;

  if(top < min_top)
    top = min_top;
  else if(top+580 > max_top)
    top = max_top - 580;

//console.log(top);

  top = top + "px";
  left = left + "px";

  var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Ses"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){

      if(typeof oldcomponent != 'undefined'){
        
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
      }  

      console.log(auto_type);
      console.log(repeat_type);

      var component = {
        'type' : 'sound',
        'data': {
            'audio':{
              'attr': {
                'controls':'controls'
              },
              'css': {
                'width' : '100%'/*,
                'height': '30px',*/
              },
              'name': sound_name
            },
            'auto_type' : auto_type,
            'repeat_type': repeat_type,
            'source': {
              'attr': {
                'src':imageBinary
              }
            },
            '.audio-name': {
              'css': {
                'width':'100%'
              }
            },
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '250px',
                /*'height': '60px',*/
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

      $(ui).parent().parent().css({"height":"550px"});

      var mainDiv = $('<div>')
        .appendTo(ui);

        var tabDiv = $ ('<div>')
            .addClass("tabbable")
            .appendTo(mainDiv);

            var tabUl = $ ('<ul>')
              .addClass("nav nav-tabs")
              .appendTo (tabDiv);

              var tabSoundDragLi = $('<li>')
                .addClass("active")
                .appendTo(tabUl);
                
                var tabSoundDragA = $ ('<a>')
                  .attr('href','#'+idPre+'drag')
                  .attr('data-toggle','tab')
                  .text(j__("Ses Dosyası Sürükle"))
                  .appendTo(tabSoundDragLi);

              
              var tabSoundUploadLi = $('<li>')
                .appendTo(tabUl);

                var tabSoundUploadA = $ ('<a>')
                  .attr('href','#'+idPre+'upload')
                  .attr('data-toggle','tab')
                  .text(j__("Ses Dosyası Yükle"))
                  .appendTo(tabSoundUploadLi);

              $('<br>').appendTo(tabDiv);

            var soundDiv = $ ('<div>')
                .addClass("tab-content")
                .appendTo(tabDiv);

                var imageDragDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .addClass("active in")
                  .attr('id',idPre+'drag')
                  .appendTo(soundDiv);

                  $('<br>').appendTo(imageDragDiv);

                  var soundDragContent = $ ('<div>')
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
                        imageBinary = evt.target.result;  
                        console.log(imageBinary);
                      };
                      //console.log(e.originalEvent.dataTransfer.files[0]);
                      reader.readAsDataURL( e.originalEvent.dataTransfer.files[0] );

                    })
                    .appendTo(imageDragDiv);


                var soundUploadDiv = $ ('<div>')
                  .addClass("tab-pane fade")
                  .attr('id',idPre+'upload')
                  .appendTo(soundDiv);

                  var soundUploadDiv = $ ('<input type="file">')
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
                        
                        imageBinary = _file.target.result;
                        console.log(imageBinary);

                      };
                    })
                    .appendTo(soundUploadDiv);

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

              var typeRepeatDiv = $ ('<div>')
                .addClass("btn-group")
                .css("margin-left", "100px")
                .attr("data-toggle","buttons")
                .text(j__("Tekrar Et"))
                .appendTo(typeDiv);

                $("<br>").appendTo(typeRepeatDiv);

                var typeRepeatLabelY = $ ('<label>')
                  .addClass("btn btn-primary " + repeat_y_check_active)
                  .appendTo(typeRepeatDiv);

                  var typeRepeatInputY = $ ('<input type="radio">')
                    .attr("name","repeat_type")
                    .attr("checked",repeat_y_check)
                    .val("Y")
                    .change(function(){
                      repeat_type = $(this).val();
                    })
                    .appendTo(typeRepeatLabelY);

                  var typeRepeatSpanY = $ ('<span>')
                    .text(j__("Evet"))
                    .appendTo(typeRepeatLabelY);

                var typeRepeatLabelN = $ ('<label>')
                  .addClass("btn btn-primary " + repeat_n_check_active)
                  .appendTo(typeRepeatDiv);

                  var typeRepeatInputN = $ ('<input type="radio">')
                    .attr("name","repeat_type")
                    .attr("checked",repeat_n_check)
                    .val("N")
                    .change(function(){
                      repeat_type = $(this).val();
                    })
                    .appendTo(typeRepeatLabelN);

                  var typeRepeatSpanY = $ ('<span>')
                    .text(j__("Hayır"))
                    .appendTo(typeRepeatLabelN); 

          $("<br>").appendTo(mainDiv);

          var soundText = $ ('<input type="text">')
            .addClass("input-textbox")
            .attr("placeholder","Ses Adı")
            .change(function(){
              sound_name = $(this).val();
            })
            .appendTo(mainDiv);




    }

  }).appendTo('body');
  
};
