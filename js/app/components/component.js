'use strict';

$(document).ready(function(){

  $.widget('lindneo.component', {

    _create: function () {

      var that = this;

      this.element
      .attr('id', this.options.component.id)
      .attr('component-instance', 'true')
      .resizable({
        containment: "#current_page",
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
        containment: "#current_page",
        

        snap: '.ui-wrapper',
        snapMode: 'outer',
        'stop': function(event, ui){
        console.log();
         
          that._resizeDraggable( event, ui );
        }
      }) 


      .mouseenter(function(event){
        // add delete button
        var deleteButton = $('<a id="delete-button-' + that.options.component.id + '"class="btn red white size-15 radius icon-delete page-chapter-delete delete-page" style="position: absolute; top: -20px; right: -20px;"></a>');
        
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

      window.lindneo.tsimshian.emitSelectedComponent( this );
    },

    unselect: function (){
      this.element.css({
        'border': 'none'
      });
    },

    field: function(key, value) {
      
      if( value === undefined ) {
        return this.options.component[key];
      }

    }

  });
});



var overlaps = (function () {
    function getPositions( elem ) {
        var pos, width, height;
        pos = $( elem ).position();
        width = $( elem ).width();
        height = $( elem ).height();
        return [ [ pos.left, pos.left + width ], [ pos.top, pos.top + height ] ];
    }

    function comparePositions( p1, p2 ) {
        var r1, r2;
        r1 = p1[0] < p2[0] ? p1 : p2;
        r2 = p1[0] < p2[0] ? p2 : p1;
        return r1[1] > r2[0] || r1[0] === r2[0];
    }

    return function ( a, b ) {
        var pos1 = getPositions( a ),
            pos2 = getPositions( b );
        return comparePositions( pos1[0], pos2[0] ) && comparePositions( pos1[1], pos2[1] );
    };
})();

$(function () {
    var area = $( '#area' )[0],
        box = $( '#box0' )[0],
        html;
    
    html = $( area ).children().not( box ).map( function ( i ) {
        return '<p>Red box + Box ' + ( i + 1 ) + ' = ' + overlaps( box, this ) + '</p>';
    }).get().join( '' );

    $( 'body' ).append( html );
});