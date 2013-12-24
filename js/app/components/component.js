'use strict';

$(document).ready(function(){

  $.widget('lindneo.component', {

    _create: function () {

      var that = this;
      var MIN_DISTANCE = 10; // minimum distance to "snap" to a guide
      var guides = []; // no guides available ... 
      var innerOffsetX, innerOffsetY; // we'll use those during drag ... 
      
      this.element
      .attr('id', this.options.component.id)
      .attr('component-instance', 'true')
      .click(function (e) {
        that._selected(e,null);
      })
      .resizable({
        'stop': function( event, ui ){
          that._resize(event, ui);
        }
      })
      .selectable({
        'selected': function(event, ui){
          that._selected(event, ui);
        }
      })
      .focus(function( event, ui ){




        //that._selected( event, ui );
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
        //console.log();
          $( "#guide-v, #guide-h" ).hide(); 
          that._resizeDraggable( event, ui );
        },

        drag: function( event, ui ){
          if( $('#general-options').val().indexOf("rehber")===-1 ) return ;

          // iterate all guides, remember the closest h and v guides
          var guideV, guideH, distV = MIN_DISTANCE+1, distH = MIN_DISTANCE+1, offsetV, offsetH; 
          var chosenGuides = { top: { dist: MIN_DISTANCE+1 }, left: { dist: MIN_DISTANCE+1 } }; 
          var $t = $(this); 
          var pos = { top: event.originalEvent.pageY , left: event.originalEvent.pageX - innerOffsetX }; 
        
          

          var w = $t.outerWidth() - 1; 
          var h = $t.outerHeight() - 1; 
      //    var sispos= $('#current_page').offset();
        
          

          var elemGuides = computeGuidesForElement( null, pos, w, h ); 
          
          $.each( guides, function( i, guide ){
              $.each( elemGuides, function( i , elemGuide ){
                
                  if( guide.type == elemGuide.type ){
                      var prop = guide.type == "h"? "top":"left"; 
                      var d = Math.abs( elemGuide[prop] - guide[prop] ); 

                      if( d < chosenGuides[prop].dist ){
                          chosenGuides[prop].dist = d; 
                          chosenGuides[prop].offset = elemGuide[prop] - pos[prop]; 
                          chosenGuides[prop].guide = guide; 
                      }
                  }
              } ); 
          } );

          if( chosenGuides.top.dist <= MIN_DISTANCE ){
              $( "#guide-h" ).css( "top", chosenGuides.top.guide.top- $('#current_page').offset().top ).show(); 
              ui.position.top = chosenGuides.top.guide.top - chosenGuides.top.offset - $('#current_page').offset().top;
          }
          else{
              $( "#guide-h" ).hide(); 
              //ui.position.top = pos.top; 
          }
          
          if( chosenGuides.left.dist <= MIN_DISTANCE ){
              $( "#guide-v" ).css( "left", chosenGuides.left.guide.left- $('#current_page').offset().left ).show(); 
              ui.position.left = chosenGuides.left.guide.left - chosenGuides.left.offset- $('#current_page').offset().left; 
          }
          else{
              $( "#guide-v" ).hide(); 
              //ui.position.left = pos.left; 
          }

        },

        start: function( event, ui ) {
          var that = this;
          guides = $.map( $( "#current_page .ui-draggable" ).not( this ), computeGuidesForElement );
          //console.log(guides);
          
          innerOffsetX = event.originalEvent.offsetX;
          innerOffsetY = event.originalEvent.offsetY;
        }

      }) 


      .mouseenter(function(event){
        // add delete button
         var deleteButton = $('<a id="delete-button-' + that.options.component.id + '" class="icon-delete white"style="position: absolute; top: -20px; right: 5px;"></a>');
         var commentButton = $('<a id="comment-button-' + that.options.component.id + '" class="icon-down-arrow comment-box-arrow size-10 icon-up-down" style="position: absolute; top: -20px; right: 30px;"></a>');
      
         deleteButton.click(function(e){
         e.preventDefault();
        
          //window.lindneo.nisga.ComponentDelete( that.options.component );
          window.lindneo.nisga.deleteComponent( that.options.component );

        }).appendTo(event.currentTarget);
        
        commentButton.click(function(e){
          //$('#'+that.options.component.id).append('<div class="comment_window"></div>');
          if ($.type(that.options.component.data.comments) == "undefined") that.options.component.data.comments=[]
          
          var isCommentBoxCreated=$('#commentBox_'+that.options.component.id).doesExist();
          
          if (isCommentBoxCreated===false){
            
            that.createCommentBox();
           
          }else{
              
              $("#commentBox_"+that.options.component.id).toggle();
              $("comment_card_"+that.options.component.id).toggleClass("opacity-level");
              $(this).toggleClass("icon-up-down");

          }

        }).appendTo(event.currentTarget);
             
      

      })
      .mouseleave(function(event){

        // remove delete button
        var deleteButton = $('#delete-button-' + that.options.component.id);
        var commentButton = $('#comment-button-' + that.options.component.id);
        deleteButton.remove();
        commentButton.remove();

      })
      .append('<div class="dragging_holder"></div>' )
      .on('unselect', function(){
        that.unselect();
      });

      this.setFromData();
      this.listCommentsFromData();

    },

    createCommentBox : function () {

      var that = this;

      that.comment_box = $('<div id="commentBox_'+that.options.component.id+'" \
            class="comment_card" style="z-index:99999999999; top:0px; right:-293px; position:absolute">\
      </div>');


      that.comment_list =  $('<div class="comment_cards_list"> </div>');

      that.newCommentBox = $('<div></div>');

      that.newCommentBox_textarea = $('<input type="text" class="commentBoxTextarea" placeholder="Yorum giriniz..." id="commentBoxTextarea'+that.options.component.id+'" />');
      that.newCommentBox_button = $('<button id="commentBoxTextareaSend'+that.options.component.id+'" class="commentBoxTextareaSend">Gönder</button></div>');

      that.newCommentBox_button.click(function(){
                var commentBoxTextareaValue = that.newCommentBox_textarea.val();
                var comment_id = window.lindneo.randomString();

                var comment = {
                  "text" : commentBoxTextareaValue,
                  "user" : window.lindneo.user,
                  "comment_id" : comment_id
                };
                
                that.CommentNewLine(comment);
                that.newCommentBox_textarea.val("");
                

                that.options.component.data.comments.push(comment);
                that._trigger('update', null, that.options.component );

        }); 

      function commentTextareaEventHandler(evt) {
        if (evt.keyCode == 13 ) {
          that.newCommentBox_button.click();
        }
      }
      that.newCommentBox_textarea.keydown(commentTextareaEventHandler).keypress(commentTextareaEventHandler);

      that.newCommentBox.append(that.newCommentBox_textarea).append(that.newCommentBox_button);

      that.comment_box.append(that.comment_list).append(that.newCommentBox);
      
      that.comment_box.appendTo(that.element.parent());

    },

    listCommentsFromData : function () {
      var that = this;
      if ($.type(that.options.component.data.comments) == "undefined") 
        return;

      if ( that.options.component.data.comments.length == 0 ) 
        return;

      this.createCommentBox();


      $.each ( that.options.component.data.comments, function (key,comment){
        that.CommentNewLine(comment);

      });


    },

    CommentNewLine : function ( comment  ){
    
      var that = this;
      var line = comment.text;
      var activeUser = comment.user;
      var component_id = that.options.component.id;

      if(line!=""){
        var lineHtml = $('<div class="comment_card_user_name yellow_msg_box" id="yellow_msg_box_' + component_id + '">\
                            '+activeUser.name+': '+line+' \
                 </div>');

        var deleteThisCommentLink = $( '<a><i class="icon-delete comment-box-delete size-15" id="comment-box-delete_' + component_id + '"></i></a>');
        
        if ( JSON.stringify(comment.user) === JSON.stringify(window.lindneo.user) )  deleteThisCommentLink.appendTo(lineHtml);

        deleteThisCommentLink.click(function(){
          $.each (that.options.component.data.comments , function (i,val){
            console.log(comment);
            console.log(val.comment_id);
            if (val.comment_id == comment.comment_id){
              that.options.component.data.comments.splice(i,1);
              lineHtml.remove();
              that._trigger('update', null, that.options.component );
              return;
            }
          });     
        });

        that.comment_list.append(lineHtml);
        $('#commentBox_'+component_id).animate({ scrollTop: $('#commentBox_'+component_id)[0].scrollHeight}, 10);
       
      }
    },

    setFromData : function () {
      var that=this;
      var _data = this.options.component.data;

      $.each( _data, function(p, data) {
        
        if( p === 'self' ){ 

          if( data.css ) that.element.parent().css(data.css);
          if( data.attr ) that.element.parent().attr(data.attr);

        } else {
          
          if( data.css ) that.element.parent().find(p).css(data.css);
          if( data.attr )  that.element.parent().find(p).attr(data.attr);
          if( data.val ) that.element.parent().find(p).val( data.val );

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
      this._selected(event, ui)
      
    },

    _resizeDraggable: function( event, ui ){
      var element = $(ui).find('textarea');

      this.options.component.data.self.css.left = ui.position.left + "px";
      this.options.component.data.self.css.top = ui.position.top + "px";
    
      
      this._trigger('update', null, this.options.component );
      this._selected(event, ui);
    },

    _change: function ( ui ){

      this._trigger('update', null, this.options.component );
      this._selected(null, ui);

    },

    _selected: function( event, ui ) {
      //console.log('selected');

      
      if (event)
      if(  event.ctrlKey || event.metaKey )
        console.log('control is pressed');
      else
        $('.selected').trigger('unselect');


      this.element.removeClass('unselected');
      this.element.addClass('selected');
      window.lindneo.toolbox.addComponentToSelection(this);
      this.element.css({
          'border': '1px solid #ccc'
      });
      console.log(this);
      this._trigger('selected', null, this );
      window.lindneo.tsimshian.emitSelectedComponent( this );
      

    },

    selected: function ( event, ui) {
     
     that._selected(event, ui);

    },

    unselect: function (){
      this.element.removeClass('selected');
      this.element.addClass('unselected');
      this.element.css({
        'border': 'none'
      });
      window.lindneo.toolbox.removeComponentFromSelection(this);
    },
    _getSettable : function (propertyName){
     return this.options.component.data.self;
    },
    getSettable : function (propertyName){
     return this._getSettable(propertyName);
    },

    _getProperty : function (propertyName){
      return this.getSettable().css[propertyName];
    }, 
    getProperty : function (propertyName){
      return this._getProperty(propertyName);
    },
    setPropertyofObject : function (propertyName,propertyValue){
      console.log('****');
      return this._setPropertyofObject(propertyName,propertyValue) ;
    },
    _setPropertyofObject : function (propertyName,propertyValue){
      console.log('****');
      switch(propertyName){
        case 'zindex':

            switch (propertyValue){
              case 'top':
                this.setProperty ('z-index',  window.lindneo.toolbox.findHighestZIndexToSet('[component-instance="true"]',this.options.component.id ));
              break;
              case 'higher':
                this.setProperty ('z-index',window.lindneo.toolbox.findHigherZIndexToSet('[component-instance="true"]',this.options.component.id ) );
              break;
              case 'lower':
                this.setProperty ('z-index', window.lindneo.toolbox.findlowerZIndexToSet('[component-instance="true"]',this.options.component.id ) );
              break;
              case 'bottom':
                this.setProperty ('z-index', window.lindneo.toolbox.findlowestZIndexToSet('[component-instance="true"]',this.options.component.id ) );
              break;

            }

          break;
        case 'z-index':
          //console.log('z-index girdi'+ propertyValue);
          this.options.component.data.self.css[propertyName]=propertyValue;
        break;
        default:
          
          this.getSettable().css[propertyName]=propertyValue;
          return this.getProperty(propertyName) ;
          break;
      }
    },
    setProperty : function (propertyName,propertyValue){
      console.log('****');
        this._setProperty(propertyName,propertyValue);
    },
    _setProperty : function (propertyName,propertyValue){
        this.setPropertyofObject(propertyName,propertyValue);
        this.setFromData();
        this._trigger('update', null, this.options.component );
        
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



function computeGuidesForElement( elem, pos, w, h ){
    if( elem != null ){
        var $t = $(elem); 
        pos = $t.offset();

        w = $t.outerWidth() - 1; 
        h = $t.outerHeight() - 1; 

    }


    
    return [
        { type: "h", left: pos.left , top: pos.top }, 
        { type: "h", left: pos.left, top: pos.top + h }, 
        { type: "v", left: pos.left, top: pos.top }, 
        { type: "v", left: pos.left + w, top: pos.top },
        // you can add _any_ other guides here as well (e.g. a guide 10 pixels to the left of an element)
        { type: "h", left: pos.left, top: pos.top + h/2 },
        { type: "v", left: pos.left + w/2, top: pos.top } 




    ]; 
}

jQuery.fn.doesExist = function(){
        return jQuery(this).length > 0;
 };
