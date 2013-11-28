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