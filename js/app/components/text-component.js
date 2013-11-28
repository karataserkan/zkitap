'use strict';

// text component
// jquery ui widget extension
$(document).ready(function(){

  (function(window, $, undefined){

    $.widget( "lindneo.textComponent", $.lindneo.component, {

      options: {

      },

      _create: function() {

        if( this.options.component.data.textarea.val === '' ){
          this.options.component.data.textarea.val = 'My name is text component';
        }

        var that = this;
        
        this.element.change(function ( ui ){
          that._change( ui );
        })

        this._super();
          
      },

      getSettable : function (){
        return this.options.component.data.textarea;
      },


      setPropertyofObject : function (propertyName,propertyValue){

        switch (propertyName){


            case 'font-size':           
            case 'text-align':           
            case 'font-family':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration':   

                this.getSettable().css[propertyName]=propertyValue;
                console.log(this.getSettable());
                var return_val;
                return this.getProperty(propertyName) ;
              
              break;
            
            default:
              return null;
              break;
          }
      },

      getProperty : function (propertyName){

          switch (propertyName){
            case 'font-size':           
            case 'font-type':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration': 
            case 'text-align':         
            

                switch (propertyName){
                  case 'text-align':
                    var default_val='left';
                    break;
                  case 'font-weight':
                    var default_val='normal';
                    break;
                  case 'font-style':
                    var default_val='normal';
                    break;
                  case 'text-decoration':
                    var default_val='none';
                    break;
                  case 'font-size':
                    var default_val='14px';
                    break;
                  case 'font-type':
                    var default_val='Arial';
                    break;
                  case 'color':
                    var default_val='#000';
                    break;
                }

                var return_val=this.getSettable().css[propertyName];

                return ( return_val ? return_val : default_val );
              
              break;
            
            default:
              return null;
              break;
          }

      },

      _change: function ( ui ) {

        this.options.component.data.textarea.val = $(ui.target).val();

        this._super();
      }

    });
         
  }) (window, jQuery);
  
});




  var createTextComponent = function ( event, ui ) {

    var component = {
      'type' : 'text',
      'data': {
        'textarea':{
          'css' : {
            'width':'100%',
            'height':'100%',
            'margin': '0',
            'padding': '0px',
            'border': 'none 0px',
            'outline': 'none',
            'color' : '#000',
            'font-size' : '14px',
            'font-family' : 'Arial',
            'font-weight' : 'normal',
            'font-style' : 'normal',
            'text-decoration' : 'none',
            'background-color' : 'transparent'  
          } , 
          'attr': {
            'asd': 'coadsad'
          },
          'val': 'some text'
        },
        'self': {
          'css': {
            'overflow':'visible',
            'position':'absolute',
            'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
            'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
            'width': '150px',
            'height': '100px',
            'opacity': '1'

          }
        }
      }
    };

    window.lindneo.tlingit.componentHasCreated(component);
  };