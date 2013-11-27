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
            'outline': 'none'
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
            'width': '100px',
            'height': '20px'
          }
        }
      }
    };

    window.lindneo.tlingit.componentHasCreated(component);
  };