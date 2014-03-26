'use strict';

$(document).ready(function(){
  $.widget('lindneo.latexComponent', $.lindneo.component, {
    
    options: {
     

    },

    _create: function(){

      var that = this;

      

      var componenthtmlid='latex'+this.options.component.id;
      

      // = '<p>\\[\\pi r^3\\]</p>';
      //console.log(this.options.component.data.html_inner);
      var latex_data = html_tag_replace(this.options.component.data.html_inner);

      //console.log(html_tag_replace(this.options.component.data.html_inner));
      if(this.options.component.data.html_inner){
        var pop_message=$('<div class="box" id="'+this.options.component.id+'_box"></div>');
        //var popupmessage=$('<div></div>');
        pop_message.appendTo(this.element);
        //popupmessage.appendTo(pop_message);
        //pop_message.html(latex_data);
        //console.log(latex_data);
        //UpdateMath(pop_message);
        latex_to_html(latex_data, this.options.component.id);
      }
       

      
      this._super(); 
/*
      this.element.resizable("option",'maxHeight', 128 );
      this.element.resizable("option",'minHeight', 128 );
      this.element.resizable("option",'maxWidth', 128 );
      this.element.resizable("option",'minWidth', 128 );

*/ 
      

    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value
    }
    
  });

  
});

var latex_to_html = function(tex, component_id){
  component_id = component_id;
  tex = "$" + tex + "$";
  //tex.replace('\\','\\\\');
  var componentSelector = '#'+component_id;
  //console.log(tex);
  //$(componentSelector).find('.box').attr('id', component_id + "_box");

  $("#"+component_id + "_box").html(tex);
  //console.log($("#"+component_id + "_box"));

  MathJax.Hub.queue.Push(["Typeset", MathJax.Hub, component_id + "_box"]);

}



var html_tag_replace = function (str){
   //var content = str.replace('&lt;','<')
   //                 .replace('&gt;','>')
   //                 .replace('<div>','')
   //                 .replace('</div>','');
   //console.log(str);
   while( str.indexOf('<pre style="color: rgb(0, 0, 0); line-height: normal; text-align: start;">') > -1)
      {
        str = str.replace('<pre style="color: rgb(0, 0, 0); line-height: normal; text-align: start;">', '');
      }

    while( str.indexOf('</pre>') > -1)
      {
        str = str.replace('</pre>', '>');
      }
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

      
   //console.log(str);
   return str;
};


var QUEUE = MathJax.Hub.queue;  // shorthand for the queue
var box = document.getElementById("box");

var HIDEBOX = function () {box.style.visibility = "hidden"}
var SHOWBOX = function () {box.style.visibility = "visible"}

  var UpdateMath = function (TeX) {
    //console.log(TeX);
    //console.log($('#MathOutput'));
    
    QUEUE.Push(function(){
      box = document.getElementById("box");
    });
    

    document.getElementById("MathOutput").innerHTML = "$"+TeX+"$";

    //reprocess the MathOutput Element
    QUEUE.Push(HIDEBOX, ["Typeset",MathJax.Hub,"MathOutput"], SHOWBOX);
    

    /*
    document.getElementById("MathOutput").innerHTML = "\\displaystyle{"+TeX+"}";

    //reprocess the MathOutput Element
    MathJax.Hub.Queue(["Text",MathJax.Hub,"MathOutput"]);
    */
  }

  var LatexOutput = function (TeX, component_id) {
    QUEUE.Push(HIDEBOX,["Text",math,"\\displaystyle{"+TeX+"}"],SHOWBOX);
    $( ".box" ).css( "visibility", "visible" );
    //console.log(math);
  }


var createLatexComponent = function ( event, ui, oldcomponent ) {  
//console.log(oldcomponent);  
  if(typeof oldcomponent == 'undefined'){
      //console.log('dene');
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var popup_value = '';
      var width = 'auto';
      var height = 'auto';
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      popup_value = oldcomponent.data.html_inner;
      var width = oldcomponent.data.width ;
      var height = oldcomponent.data.height;
    };
    //console.log(width);
    //console.log(height);
   /* $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      <div class='popup-header'> \
      Görsel/Video Ekle \
      <i id='popup-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
      </div> \
        <div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
        <div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' > \
          <div  id='MathInput' style='width:100%;height:100%; ' contenteditable='true' class='drag-cancel'>" + popup_value + ". \
         </div>  \
        </div> <br>\
        <a href='#' id='pop-image-OK' class='btn bck-light-green white radius' style='padding: 5px 30px;'>Ekle</a> \
      </div> \
      </div>").appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();*/
    
    var html_popup = $("<div class='popup ui-draggable' id='pop-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
      </div>");
    html_popup.appendTo('body').draggable({cancel:'.drag-cancel'}).resizable();
    var poup_header = $("<div class='popup-header'><i class='icon-m-link'></i> &nbsp;Latex Ekle </div> ");
    var close_button = $("<i id='html-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> ");
    
    var galery_inner = $("<div class='gallery-inner-holder' style='width: " + width + "px; height: " + height + "px;'> \
        <div style='clear:both'></div> \
      </div> ");
    var popup_wrapper = $("<div class ='popup_wrapper drag-cancel' style='border: 1px #ccc solid; ' ></div> <br>");
    var popup_detail = $('<input class="MathInput" contenteditable="true" class="drag-cancel" value="'+popup_value+'">');
    var latex_preview = $('<div class="box" id="box" style="visibility:hidden">\
                            <div id="MathOutput" class="output"></div>\
                          </div>');
    var add_button = $("<a href='#' id='pop-image-OK' class='btn btn-info' style='padding: 5px 30px;'>Ekle</a> ");
    poup_header.appendTo(html_popup);
    close_button.appendTo(poup_header);
    galery_inner.appendTo(html_popup);
    popup_wrapper.appendTo(galery_inner).resizable({alsoResize: galery_inner});
    
    popup_detail.appendTo(popup_wrapper);
    latex_preview.appendTo(popup_wrapper);
    add_button.appendTo(galery_inner);
    popup_detail.resizable({alsoResize: galery_inner});
    close_button.click(function(){

      html_popup.remove();  

      if ( html_popup.length ){
        html_popup.remove();  
      }

    });

    $('.MathInput').change(function(){
      //console.log(this.value);
      UpdateMath(this.value);
    });

    if (MathJax.Hub.Browser.isMSIE) {
      MathInput.onkeypress = function () {
        if (window.event && window.event.keyCode === 13) {this.blur(); this.focus()}
      }
    }
    
    
    add_button.click(function (){  
      
      var width = html_popup.width();
      var height = html_popup.height(); 
      //console.log(width);
      //console.log(height);      
      if(typeof oldcomponent == 'undefined'){
        //console.log('dene');
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
        oldcomponent.data.html_inner = $(".MathInput").html();

      };
      //console.log($(".MathInput").val());
      //return;
       var  component = {
          'type' : 'latex',
          'data': {
            'html_inner':  $(".MathInput").val(),
            'width': width,
            'height': height,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'overflow': 'visible',
                'opacity': '1',
                'z-index': '1000'
              }
            }
          }
        };
       
        //console.log(component);
        window.lindneo.tlingit.componentHasCreated( component );
        
        close_button.trigger('click');

    });
    

  };