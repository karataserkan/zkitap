'use strict';

$(document).ready(function(){

  $.widget('lindneo.component', {

    _create: function (){
      
      var that = this;

      this.element
      .attr('id', this.options.component.id)
      .attr('component-instance', 'true')
      .resizable({
        'stop': function( event, ui ){
          that._resize(event, ui);
        }
      })
      .selectable({
        'selected': function(){
          console.log('selected');
        }
      })
      .focus(function( event, ui ){

        $('[component-instance]').css({
          'border': 'none'
        });

        $(event.currentTarget).css({
          'border': '1px solid #ccc'
        });
        that._selected( event, ui );
      })
      .focusout(function(event){
          
      });



      this.element.parent()
      .attr('component-instance', 'true')
      .draggable({
        'stop': function(event, ui){
          that._resizeDraggable( event, ui );
        }
      })
      .mouseenter(function(event){
        // add delete button
        var deleteButton = $('<a id="delete-button-' + 
          that.options.component.id + 
          '" class="btn red white size-15 radius icon-delete page-chapter-delete delete-page" style="position: relative; top: -20px; left: 0px;"></a>');
        
        deleteButton.click(function(e){
          e.preventDefault();

          window.lindneo.nisga.deleteComponent( that.options.component );

        }).appendTo(event.currentTarget);

      })
      .mouseleave(function(event){
        // remove delete button
        var deleteButton = $('#delete-button-' + that.options.component.id);
        deleteButton.remove();

      });


      var _data = this.options.component.data;

      $.each( _data, function(p, data) {
        
        if( p === 'self' ){

          if( data.css ) that.element.parent().css(data.css);
          if( data.attr ) that.element.parent().attr(data.attr);

        } else {

          if( data.css ) that.element.css(data.css);
          if( data.attr )  that.element.attr(data.attr);
          if( data.val ) that.element.val( data.val );
        }

      });

    },

    type: function () {
      return this.options.component.type;
    },

    id: function() {
      return this.options.component.id;
    },

    _resize: function ( event, ui ) {

      this.options.component.data.self.css.width = ui.size.width + "px";
      this.options.component.data.self.css.height = ui.size.height + "px";

      this._trigger('update', null, this.options.component );
      
    },

    _resizeDraggable: function( event, ui ){
      var element = $(ui).find('textarea');

      this.options.component.data.self.css.left = ui.position.left + "px";
      this.options.component.data.self.css.top = ui.position.top + "px";

      this._trigger('update', null, this.options.component );
    },

    _change: function ( ui ){

      this._trigger('update', null, this.options.component );

    },

    _selected: function( event, ui ) {
      this._trigger('selected', null, this );
    },

    unselect: function (){
      this.element.css({
        'border': 'none'
      });
    }

  });
});