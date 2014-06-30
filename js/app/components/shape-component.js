'use strict';

$(document).ready(function(){
  $.widget('lindneo.shapeComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this; 
      this._super();
      this.redraw();
    },
    redraw: function(){ 
            this.options.canvas = this.element[0];
      this.options.context = this.options.canvas.getContext("2d");
        switch(this.options.component.data.shapeType){

          case 'square':

            this.options.context.beginPath();
            this.options.context.rect(0, 0, this.options.canvas.width, this.options.canvas.height);
            this.options.context.fillStyle   = this.options.component.data.fillStyle;
            this.options.context.strokeStyle = this.options.component.data.strokeStyle;

            this.options.context.fill();

           
            break;

          case 'line':

            this.options.context.beginPath();
            this.options.context.fillStyle   = this.options.component.data.fillStyle;
            this.options.context.strokeStyle = this.options.component.data.strokeStyle;
            this.options.context.lineWidth   = 4;
            this.options.context.fillRect(this.options.canvas.width /4 *1,  0, this.options.canvas.width /4 *3, this.options.canvas.height);
            this.element.width(15);
            this.element.parent().width(15);
            this.element.resizable("option",'maxWidth', 15 );
            this.element.resizable("option",'minWidth', 15 );
           
            break;
          
          case 'circle':
            var centerX = parseInt( this.options.canvas.width / 2 );
            var centerY = parseInt( this.options.canvas.height / 2 );
            var radius = centerX;


            this.options.context.beginPath();
            this.options.context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
            this.options.context.fillStyle   = this.options.component.data.fillStyle;
            this.options.context.strokeStyle = this.options.component.data.strokeStyle;

            this.options.context.fill();

            console.log(centerX);
            break;

          case 'triangle':
            var centerX = parseInt( this.options.canvas.width / 2 );

            var radius = centerX;
            // Set the style properties.
            this.options.context.fillStyle   = this.options.component.data.fillStyle;
            this.options.context.strokeStyle = this.options.component.data.strokeStyle;


            this.options.context.beginPath();
            // Start from the top-left point.
            this.options.context.moveTo(centerX, 0); // give the (x,y) coordinates
            this.options.context.lineTo(0, this.options.canvas.height);
            this.options.context.lineTo(this.options.canvas.width, this.options.canvas.height);
            this.options.context.lineTo(centerX, 0);

            // Done! Now fill the shape, and draw the stroke.
            // Note: your shape will not be visible until you call any of the two methods.
            this.options.context.fill();
            this.options.context.closePath();

            break;
          
          default:
            
            break;

      }
    },
    setFromData: function(){ 
      this._super();
      this.redraw();

    },
    setPropertyofObject : function (propertyName,propertyValue){
      //console.log(propertyName);
      //console.log(propertyValue);
      switch (propertyName){
            case 'fillStyle':           
            case 'strokeStyle':         
               

                this.options.component.data[propertyName]=propertyValue;
                
                var return_val;
                return this.getProperty(propertyName) ;
              
              break;
            
            default:
              this._super(propertyName, propertyValue);
              break;
          }
    },

    getProperty : function (propertyName){
      switch (propertyName){
            case 'fillStyle':           
            case 'strokeStyle':         
            

                switch (propertyName){
                  case 'fillStyle':
                  case 'strokeStyle':         
                    var default_val='#000';
                    break;
                  }

                var return_val=this.options.component.data[propertyName];
                console.log(propertyName);

                return ( return_val ? return_val : default_val );
              
              break;
            
              default:
              
              this._super(propertyName);
              break;
          }
    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});

  
var createShapeComponent = function ( event, ui ) {

  var type;

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

  if(left < min_left)
    left = min_left;
  else if(left+210 > max_left)
    left = max_left - 210;

  if(top < min_top)
    top = min_top;
  else if(top+230 > max_top)
    top = max_top - 230;

  top = top + "px";
  left = left + "px";
    
  var idPre = $.now();

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Şekil"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){
      console.log(type);
      if(typeof oldcomponent != 'undefined'){
        
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
      }  

      var component = {
        'type' : 'shape',
        'data': {
          'canvas':{
            'css' : {
              'width':'100%',
              'height':'100%',
              'margin': '0',
              'padding': '0px',
              'border': 'none 0px',
              'outline': 'none',
              'background-color': 'transparent'
            } , 
            'attr':{
              'width': '1000',
              'height': '1000',
            }
          },
          'fillStyle': 'black',
          'strokeStyle': 'black',
          'shapeType': type ,
          'lock':'',
          'self': {
            'css': {
              'position':'absolute',
              'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
              'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
              'width': '100px',
              'height': '100px',
              'background-color': 'transparent',
              'overflow': 'visible',
              'opacity': '1',
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
      console.log();
      $(ui).parent().parent().css({"width":"250px","height":"170px"});
      $($(ui).parent().parent()).find(".popup-footer").css("display","none");
      var mainDiv = $('<div>')
        .css({"width":"100%","height":"100%"})
        .appendTo(ui);

        var typeDiv = $('<div>')
          .addClass("popup-even")
          .appendTo(mainDiv);

          var circleI = $('<i>')
            .addClass("icon-s-circle shape-select size-20 dark-blue")
            .attr("rel","circle")
            .click(function(){
              type = "circle";
              $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();
            })
            .appendTo(typeDiv);

          var triangleI = $('<i>')
            .addClass("icon-s-triangle shape-select  size-20 dark-blue")
            .attr("rel","triangle")
            .click(function(){
              type = "triangle";
              $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();
            })
            .appendTo(typeDiv);

          var squareI = $('<i>')
            .addClass("icon-s-square  shape-select  size-20 dark-blue")
            .attr("rel","square")
            .click(function(){
              type = "square";
              $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();
            })
            .appendTo(typeDiv);

          var lineI = $('<i>')
            .addClass("icon-s-line shape-select  size-20 dark-blue")
            .attr("rel","line")
            .click(function(){
              type = "line";
              $($($(ui).parent().parent()).find(".popup-footer")).find("a").click();
            })
            .appendTo(typeDiv);

    }


  }).appendTo('body');

};