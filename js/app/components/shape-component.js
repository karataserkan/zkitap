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

      switch (propertyName){
            case 'fillStyle':           
            case 'strokeStyle':         
               

                this.options.component.data[propertyName]=propertyValue;
                
                var return_val;
                return this.getProperty(propertyName) ;
              
              break;
            
            default:
              this._super(propertyName,propertyValue);
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

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
      <div class='popup-header'> \
Şekil Ekle \
<div id ='image-add-dummy-close-button' class='popup-close'>x</div> \
</div> \
<!--  popup content --> \
<br> \
  <div class='popup-even'> \
    <i rel='circle' id='shape-circle' class='icon-s-circle shape-select size-20 dark-blue'></i> \
    <i rel='triangle' id='shape-triangle' class='icon-s-triangle shape-select  size-20 dark-blue'></i> \
    <i rel='square' id='shape-square' class='icon-s-square  shape-select  size-20 dark-blue'></i> \
    <i rel='line' id='shape-line' class='icon-s-line shape-select  size-20 dark-blue'></i> \
  </div> \
<!--  popup content --> \
</div>").appendTo('body');

    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });

    $('.shape-select').click(function () {
       var type = $(this).attr('rel');
       $("#image-add-dummy-close-button").trigger('click');

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
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '100px',
                'height': '100px',
                'background-color': 'transparent',
                'overflow': 'visible',
                'opacity': '1'
                  }
              
              }
            
          }
        };

        window.lindneo.tlingit.componentHasCreated( component );
        

    });

  
        
      

  
        
       

   

  };