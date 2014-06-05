'use strict';

$(document).ready(function(){

  $.widget('lindneo.component', {

    options : {
       

    },

    extend: function (a, b,parentKey){

    for(var key in b)
        if(b.hasOwnProperty(key)){
          //console.log(parentKey );
          if (typeof b[key] === 'object') {
            parentKey = typeof parentKey ==="undefined" ? key: parentKey + "." + key
            a[key]=this.extend(a[key],b[key],parentKey);
          } else {
            a[key] = b[key];

          }
        }
    //console.log(a);
    return a;
    },

    _create: function (params) {

      var that = this;
      window.lindneo.tlingit.componentPreviosVersions[that.options.component.id]= JSON.parse(JSON.stringify(that.options.component));  ;
      that.overwriteParams = params;


      that.options.resizableParams = {
        //"maxHeight":null,
        //"minHeight":null,
        "handles":"n, e, w, s, nw, se, sw, ne",
          'start': function (event,ui){
            that._selected(event,ui);
           // console.log($(event.currentTarget).offset());
            //console.log(ui);
            //console.log($("#current_page").width());
            if(that.options.component.type == "plink"){
              $('#message_plink'+that.options.component.id).css('height','100%');
              $('#message_plink'+that.options.component.id).css('width','100%');
            }
            //$(ui.element.get(0)).resizable("option", "alsoResize",".selected");
            $(this).resizable("option", "alsoResize",".selected");
           //var max_width = $("#current_page").width() - $(event.currentTarget).offset().left + 284;
           //var max_height = $("#current_page").height() - $(event.currentTarget).offset().top + 124;
           console.log($(this));
           console.log($(this).parent());
          $(this).resizable({
            containment: "#current_page",
            //maxWidth: max_width,
            //maxHeight: max_height
          });
            //console.log($(this).parent().parent());
            //console.log($(this).css("left").replace("px",""));
            //ui.element.resizable("option", "alsoResize",".selected");
            //$(".selected").resizable();
            $(".selected").trigger("resize");
          },
          'stop': function( event, ui ){
            that._resize(event, ui);
          },
          'resize':function(event,ui){
            if( typeof this.resize_pass != "undefined" )
              this.resize_pass(event,ui);
            
            window.lindneo.toolbox.makeMultiSelectionBox();
          }
        };
      if(typeof params!='undefined'){

        //console.log(that.options);
        that.options = this.extend ( that.options,params  ) ;
        //console.log(that.options);
         //if(typeof params.resizableParams!='undefined') {
         //   that.options.resizableParams=that.extend(that.options.resizableParams,params.resizableParams);
         //}
      }
      var MIN_DISTANCE = 20; // minimum distance to "snap" to a guide
      var guides = []; // no guides available ... 
      var innerOffsetX, innerOffsetY; // we'll use those during drag ... 
      //console.log(this.element.parent());
      //this.element.parent().attr('id','c_'+this.options.component.id);
      //console.log(this.options.component.data.self.css);
      //this.options.component.data.self.css['z-index']=this.options.component.data.self.css.zindex;
      this.element
      .attr('id', this.options.component.id)
      .attr('component-instance', 'true')
      .click(function (e) {
        that._selected(e,null);
      })
    
      .resizable(that.options.resizableParams)

      .focus(function( event, ui ){
        //that._selected( event, ui );
      })
      .focusout(function(event){
 
      });


      this.element.parent()
          .append('  \
        <div class="top_holder"></div> \
        <div class="dragging_holder top"></div> \
        <div class="dragging_holder bottom "></div> \
        <div class="dragging_holder left "></div> \
        <div class="dragging_holder right"></div> \
        ' )
          .attr('id', 'c_'+this.options.component.id)
          .addClass('obstacle')
          .attr('component-instance', 'true')
          .draggable({
            containment: "#current_page",
            snap: '.guide.shown .ui-wrapper',
            handle: '.dragging_holder, img',
            snapTolerance:30,
            snapMode: 'both',
            'alsoDrag':'.ui-draggable.selected',
            'stop': function(event, ui){
            //console.log();

              $( "#guide-v, #guide-h" ).hide(); 
              that._resizeDraggable( event, ui );
              if ($('.selected').length > 1) {
                //console.log($('.selected'));
                //console.log($('.selected').not($(this)));
                $('.selected').not(this).trigger('alsoDragStopped');
              }
            },

            drag: function( event, ui ){
              
              window.lindneo.toolbox.makeMultiSelectionBox(); 
              if(event.shiftKey){
                $('#current_page').children().addClass('obstacle');
                //console.log($('#'+event.target.firstChild.id).parent());
                //$('#'+event.target.firstChild.id).parent().attr('id','c_'+event.target.firstChild.id);
                
                that.showOverlap(event,ui);
              }
              else $('#current_page').children().removeClass('obstacle');
              var zoom = $('#author_pane').css('zoom');
              var canvasHeight = $('#current_page').height() * zoom;
              var canvasWidth = $('#current_page').width() * zoom;

              // zoom fix
              ui.position.top = Math.round(ui.position.top / zoom);
              ui.position.left = Math.round(ui.position.left / zoom);
              
             /* // don't let draggable to get outside of the canvas
              if (ui.position.left < 0) 
                  ui.position.left = 0;
              if (ui.position.left + $(this).width() > canvasWidth)
                  ui.position.left = canvasWidth - $(this).width();  
              if (ui.position.top < 0)
                  ui.position.top = 0;
              if (ui.position.top + $(this).height() > canvasHeight)
                  ui.position.top = canvasHeight - $(this).height();  
    */





              if( $('#rehbercheck:checked').length==0 ) return ;
              if($('.guide').length==0){
                $('<div id="guide-h" class="guide" style="z-index:9999999999999999" ></div>').appendTo('#current_page');
                $('<div id="guide-v" class="guide" style="z-index:9999999999999999" ></div>').appendTo('#current_page');
              }
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
                  $( "#guide-h" ).css( "top", chosenGuides.top.guide.top- $('#current_page').offset().top ).addClass("shown").show(); 
                  //ui.position.top = chosenGuides.top.guide.top - chosenGuides.top.offset - $('#current_page').offset().top;
              }
              else{
                  $( "#guide-h" ).removeClass("shown").hide(); 
                  //ui.position.top = pos.top; 
              }
              
              if( chosenGuides.left.dist <= MIN_DISTANCE ){
                  $( "#guide-v" ).css( "left", chosenGuides.left.guide.left- $('#current_page').offset().left ).addClass("shown").show(); 
                 
                  //ui.position.left = chosenGuides.left.guide.left - chosenGuides.left.offset- $('#current_page').offset().left; 
              }
              else{
                  $( "#guide-v" ).removeClass("shown").hide(); 
                  //ui.position.left = pos.left; 
              }

            },

            start: function( event, ui ) {
             
              //this.selected(event,ui);
              that._selected(event,ui);
              guides = $.map( $( "#current_page .ui-draggable" ).not( this ), computeGuidesForElement );
              //console.log(guides);
              
              innerOffsetX = event.originalEvent.offsetX;
              innerOffsetY = event.originalEvent.offsetY;
            }

          }) 
          .dblclick(function(event, ui) {
            //console.log(event);
            //console.log(that.options.component.type);
            if(that.options.component.type == 'image')
              window.lindneo.dataservice.image_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'link')
              window.lindneo.dataservice.link_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'video')
              window.lindneo.dataservice.video_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'popup')
              window.lindneo.dataservice.popup_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'grafik')
              window.lindneo.dataservice.graph_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'quiz')
              window.lindneo.dataservice.quiz_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'html')
              window.lindneo.dataservice.html_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'wrap')
              window.lindneo.dataservice.wrap_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'latex')
              window.lindneo.dataservice.latex_popup(event, ui, that.options.component);
            else if(that.options.component.type == 'galery')
              window.lindneo.dataservice.galery_popup(event, ui, that.options.component);
          })
          
          .mouseenter(function(event){
            
             
             if(that.options.component.data.lock == '')
             var deleteButton = $('<a id="delete-button-' + that.options.component.id + '"class="icon-delete size-10" style="position: absolute; top: -20px; right: 5px;" ></a>');
             else
             var deleteButton=$('<a id="delete-button" class="icon-delete size-10" style="position: absolute; top: -20px; right: 5px;" hidden></a>');
             var commentButton = $('<a id="comment-button-' + that.options.component.id + '" class="icon-down-arrow comment-box-arrow size-10 icon-up-down" style="position: absolute; top: -20px; right: 30px;"></a>');
          
             deleteButton.click(function(e){
             e.preventDefault();
              that._deleting();
              //window.lindneo.nisga.ComponentDelete( that.options.component );
              window.lindneo.tlingit.componentHasDeleted( that.options.component );

            }).appendTo(event.currentTarget);
        
        commentButton
          .click(function(e){
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
      .on('unselect', function(event){
        that.unselect(event);
      })
      .on('select', function(event){
        //console.log(that.options.component.id);
        event.groupSelection=true;
        that._selected(event);
      })
      .on('group', function(event,group_id){
        that.group(event,group_id);
      })
      .on('ungroup', function(event){
        that.ungroup(event);
      })
      .on('alsoDragStopped', function(event){
          var ui={};
          ui.position={
            'left':parseInt($(this).css('left')),
            'top':parseInt($(this).css('top')),
          };
          that._resizeDraggable(event,ui);
      })
      .rotatable({
        
        angle: that.options.component.data.self.rotation,
        'stop': function( event, angle){

          that._rotate(event, angle);
          }
      });

      this.setFromData();
      this.listCommentsFromData();
      if (typeof this.options.component.data.group_id != "undefined"){
        that.group(null,this.options.component.data.group_id);
      }
    $(".ui-resizable-se.ui-icon.ui-icon-gripsmall-diagonal-se").removeClass("ui-icon").removeClass("ui-icon-gripsmall-diagonal-se");
    },

    createCommentBox : function () {

      var that = this;

      that.comment_box = $('<div id="commentBox_'+that.options.component.id+'" \
            class="comment_card" style="z-index:99999999999; top:0px; right:-293px; position:absolute">\
      </div>');


      that.comment_list =  $('<div class="comment_cards_list"> </div>');
      that.newCommentBox = $('<div></div>');

      that.newCommentBox_textarea = $('<input type="text" class="commentBoxTextarea" placeholder="'+j__("Yorum giriniz")+'..." id="commentBoxTextarea'+that.options.component.id+'" />');
      that.newCommentBox_button = $('<button id="commentBoxTextareaSend'+that.options.component.id+'" class="commentBoxTextareaSend">'+j__("Gönder")+'</button></div>');

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

    showOverlap : function (event,ui)
      {
        //console.log(event);
        //console.log(ui);
        //return;
        //console.log(event.target.firstChild.id);
        $("#collisions").children().remove();
        var collisions = $("#"+event.target.firstChild.id).parent().collision( ".obstacle", { relative: "collider", obstacleData: "odata", colliderData: "cdata", directionData: "ddata", as: "<div/>" } );
        for( var i=0; i<collisions.length; i++ )
        {
          var o = $(collisions[i]).data("odata");
          var c = $(collisions[i]).data("cdata");
          var d = $(collisions[i]).data("ddata");
          //console.log(o);
          var cwith = $(o).get(0).id;
          var cside = d;
          var snap  = $(c).clone(false,false).removeClass().addClass("wireframe");
          
          snap.get(0).id = null;
          snap.get(0).innerHTML = null;
          snap.children().remove();
          var olap  = $(collisions[i]).addClass("overlap").appendTo(snap);
          //console.log(olap);
          var tr    = $("<tr />");
          $("<td>"+cwith+"</td>").appendTo(tr);
          $("<td>"+cside+"</td>").appendTo(tr);
          snap.appendTo($("<td />")).appendTo(tr);
          tr.appendTo( $("#collisions") );
          //console.log(cside);
          //console.log($('#'+cwith).get(0).lastChild.offsetParent);
          //console.log($('#'+cwith));
          //console.log($('#current_page').parent().);
          //if(cwith == "Obstacle2"){
            if(cside == 'SW'){
              var position = $('#'+cwith).position();
              var left= position.left - 10;
              var top = position.top +10;
              if(left <= 0){
                left = $("#"+event.target.firstChild.id).parent().position().left + $("#"+event.target.firstChild.id).width();
              }
              var max_top = top + $('#'+cwith).height();
              if(max_top >= $('#current_page').height()){
                top = $("#"+event.target.firstChild.id).parent().position().top - $('#'+cwith).height();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(left);
            }
            else if(cside == 'S'){
              var position = $('#'+cwith).position();
              var left= position.left ;
              var top = position.top +10;
              var max_top = top + $('#'+cwith).height();
              if(max_top >= $('#current_page').height()){
                //console.log($('#'+cwith).height());
                //console.log($("#"+event.target.firstChild.id));
                top = $("#"+event.target.firstChild.id).parent().position().top - $('#'+cwith).height();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(top);
            }
            else   if(cside == 'SE'){
              var position = $('#'+cwith).position();
              var left= position.left +10;
              var top = position.top +10;
              var max_top = top + $('#'+cwith).height();
              if(max_top >= $('#current_page').height()){
                top = $("#"+event.target.firstChild.id).parent().position().top - $('#'+cwith).height();
              }
              var max_left = left + $('#'+cwith).width();
              if(max_left >= $('#current_page').width()){
                left = $("#"+event.target.firstChild.id).parent().position().left - $('#'+cwith).width();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(left);
            }
            else if(cside == 'W'){
              var position = $('#'+cwith).position();
              var left= position.left - 10;
              var top = position.top ;
              if(left <= 0){
                left = $("#"+event.target.firstChild.id).parent().position().left + $("#"+event.target.firstChild.id).width();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(left);
            }
            else if(cside == 'E'){
              var position = $('#'+cwith).position();
              var left= position.left +10;
              var top = position.top ;
              
              var max_left = left + $('#'+cwith).width();
              if(max_left >= $('#current_page').width()){
                //console.log($("#"+event.target.firstChild.id).parent().position().left);
                //console.log($('#'+cwith).width());
                left = $("#"+event.target.firstChild.id).parent().position().left - $('#'+cwith).width();
                //console.log(left);
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(left);
            }
            else if(cside == 'NW'){
              var position = $('#'+cwith).position();
              var left= position.left - 10;
              var top = position.top - 10;
              if(top <= 0){
                top = $("#"+event.target.firstChild.id).parent().position().top + $("#"+event.target.firstChild.id).height();
              }
              if(left <= 0){
                left = $("#"+event.target.firstChild.id).parent().position().left + $("#"+event.target.firstChild.id).width();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(left);
            }
            else if(cside == 'NE'){
              var position = $('#'+cwith).position();
              var left= position.left +10;
              var top = position.top - 10;
              var max_left = left + $('#'+cwith).width();
              if(max_left >= $('#current_page').width()){
                left = $("#"+event.target.firstChild.id).parent().position().left - $('#'+cwith).width();
              }
              if(top <= 0){
                top = $("#"+event.target.firstChild.id).parent().position().top + $("#"+event.target.firstChild.id).height();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(left);
            }
            else if(cside == 'N'){
              var position = $('#'+cwith).position();
              var left= position.left ;
              var top = position.top - 10;
              if(top <= 0){
                top = $("#"+event.target.firstChild.id).parent().position().top + $("#"+event.target.firstChild.id).height();
              }
              $('#'+cwith).css({'left':left+'px', 'top':top+'px'});
              //console.log(top);
            }
          //}
        }
      },

    group:function (event,group_id) {
      this.options.component.data.group_id=group_id;
      this.element.attr('group_id',group_id);
      if(event!=null)
        this._trigger('update', null, this.options.component );
    },

    ungroup:function(){
      delete this.options.component.data['group_id'];
      this.element.removeAttr('group_id');
      this._trigger('update', null, this.options.component );
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
            //console.log(comment);
            //console.log(val.comment_id);
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
      if($.type(this.options.component.data.lock) == "undefined") {  this.options.component.data.lock=''; }

      $.each( _data, function(p, data) {
        
        if( p === 'self' ){ 
          //console.log(data);
          if( data.css ) that.element.parent().css(data.css);
          if( data.attr ) that.element.parent().attr(data.attr);

        } else {
          if (typeof data != "undefined"){
                    if( data.css ) that.element.parent().find(p).css(data.css);
                    if( data.attr )  that.element.parent().find(p).attr(data.attr);
                    if( data.val ) that.element.parent().find(p).val( data.val );
                  }

        }

      });
      
      if(typeof this.options.component.data.lock.username != "undefined"){
        that.options.resizableParams['disabled']=true;
        /*
        $('#'+this.options.component.id).droppable({ disabled: true });
        //$('#'+this.options.component.id).selectable({ disabled: true });
        $('#'+this.options.component.id).sortable({ disabled: true });
        $('#'+this.options.component.id).resizable({ disabled: true });
        $('#'+this.options.component.id).attr('readonly','readonly');
        */
        $('#delete-button-'+this.options.component.id).hide();
      }
      else{      
        that.options.resizableParams['disabled']=false;
        /*
        $('#'+this.options.component.id).droppable({ disabled: false });
        //$('#'+this.options.component.id).selectable({ disabled: false });
        $('#'+this.options.component.id).sortable({ disabled: false });
        $('#'+this.options.component.id).resizable({ disabled: false });
        $('#'+this.options.component.id).removeAttr('readonly');
        */
      };
       // this.element.draggable(that.options.resizableParams);
      
      //console.log(this.options.component.data.lock);
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

    _rotate: function ( event, angle ) {
      //console.log(this.options.component);
      //this.options.component.data.self.css.width = ui.size.width + "px";
      //this.options.component.data.self.css.height = ui.size.height + "px";
      this.options.component.data.self.rotation = angle;
      //console.log(this.options.component.data.self.rotation);
      this.options.component.data.self.css['-webkit-transform'] = "rotate("+angle+"rad)" ;
      //$(self).css('-webkit-transform',"rotate("+angle+"rad)");
      //console.log(this.options.component.data.self.css['-webkit-transform']);
      this._trigger('update', null, this.options.component );
      //this._selected(event, ui)
      //console.log(this.options.component);
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
      //console.log(event);
      //console.log(event.originalEvent);
      
      //console.log(this.options.component.id);
    if(event)
      if (typeof event.originalEvent != "undefined")
        if (typeof event.originalEvent != "null")
          if (typeof event.originalEvent.originalEvent != "undefined")
            if (typeof event.originalEvent.originalEvent.type != "undefined")
              if ( event.originalEvent.originalEvent.type == "mouseup")
                if (!$(this).has($(event.toElement)).lenght)
                  var false_out_selection=true;
      if(event)
        if( event.groupSelection || false_out_selection  || event.ctrlKey || event.metaKey || $(event.toElement).hasClass('ui-resizable-handle') || $(event.toElement).hasClass('dragging_holder')  )
          window.lindneo.toolbox.makeMultiSelectionBox();
        else
          $('.selected').trigger('unselect');
        
      if (typeof this.options.component.data.group_id != "undefined" && !event.groupSelection){
       $("[group_id~='"+this.options.component.data.group_id+"']").trigger('select');
      }

      this.element.removeClass('unselected');
      this.element.addClass('selected');
      this.element.parent().addClass('selected');
      window.lindneo.toolbox.addComponentToSelection(this);

     
      this._trigger('selected', null, this );
      window.lindneo.tsimshian.emitSelectedComponent( this );
      
      return;
      
      if($.type(this.options.component.data.lock.username) != "undefined"){

       // $('#'+this.options.component.id).parent().draggable({ disabled: true });
        $('#'+this.options.component.id).droppable({ disabled: true });
       // $('#'+this.options.component.id).selectable({ disabled: true });
        $('#'+this.options.component.id).sortable({ disabled: true });
        //$('#'+this.options.component.id).resizable({ disabled: true });
        $('#'+this.options.component.id).attr('readonly','readonly');
        $('#delete-button-'+this.options.component.id).hide();
      }
      else{
        //$('#'+this.options.component.id).parent().draggable({ disabled: false });
        $('#'+this.options.component.id).droppable({ disabled: false });
        $('#'+this.options.component.id).selectable({ disabled: false });
        $('#'+this.options.component.id).sortable({ disabled: false });
        $('#'+this.options.component.id).resizable({ disabled: false });
        $('#'+this.options.component.id).removeAttr('readonly');
        
      };
      
      //console.log(this.options.component.data.lock);
    },

    selected: function ( event, ui) {
     
     that._selected(event, ui);

    },

    unselect: function (){
      this.element.removeClass('selected');
    this.element.parent().removeClass('selected');
    
      this.element.addClass('unselected');
      this.element.css({
        'border': 'none'
      });
      window.lindneo.toolbox.removeComponentFromSelection(this);
    },

    _deleting: function(){
      this.unselect();
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
      //console.log(propertyName);
      //console.log(propertyValue);
      return this._setPropertyofObject(propertyName,propertyValue) ;
    },
    _setPropertyofObject : function (propertyName,propertyValue){
    //console.log($('#'+this.options.component.id).slickWrap({ cutoff:propertyValue }));
    //console.log(propertyName);
    //console.log(propertyValue);
      switch(propertyName){ 
        case 'cutoff':
          $('#'+this.options.component.id).slickWrap({ cutoff:propertyValue });
        case 'rotate':
          this._rotate('', propertyValue);
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
          case 'zindex-table':
            switch (propertyValue){
              case 'top':
                this.setProperty ('z-index-table',  window.lindneo.toolbox.findHighestZIndexToSet('[component-instance="true"]',this.options.component.id ));
              break;
              case 'higher':
                this.setProperty ('z-index-table',window.lindneo.toolbox.findHigherZIndexToSet('[component-instance="true"]',this.options.component.id ) );
              break;
              case 'lower':
                this.setProperty ('z-index-table', window.lindneo.toolbox.findlowerZIndexToSet('[component-instance="true"]',this.options.component.id ) );
              break;
              case 'bottom':
                this.setProperty ('z-index-table', window.lindneo.toolbox.findlowestZIndexToSet('[component-instance="true"]',this.options.component.id ) );
              break;

            }

          break;
        case 'component_alignment':
            switch (propertyValue){
              case 'vertical_align_left':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentLeftToSet('[component-instance="true"]'));
              break;
              case 'vertical_align_center':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentCenterToSet('[component-instance="true"]'));
              break;
              case 'vertical_align_right':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentRightToSet('[component-instance="true"]'));
              break;
              case 'horizontal_align_top':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentTopToSet('[component-instance="true"]'));
              break;
              case 'horizontal_align_middle':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentMiddleToSet('[component-instance="true"]'));
              break;
              case 'horizontal_align_bottom':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentBottomToSet('[component-instance="true"]'));
              break;
              case 'vertical_align_gaps':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentVerticalGapsToSet('[component-instance="true"]'));
              break;
              case 'horizontal_align_gaps':
                this.setProperty ('position',  window.lindneo.toolbox.componentsAlignmentHorizontalGapsToSet('[component-instance="true"]'));
              break;
            }
          break;
        case 'z-index':
          this.options.component.data.self.css[propertyName]=propertyValue;
          //this.options.component.data.self.css['width']="auto";
          //this.options.component.data.self.css['height']="auto";
        break;
        case 'z-index-table':
          this.options.component.data.self.css['z-index']=propertyValue;
          this.options.component.data.self.css['width']="auto";
          this.options.component.data.self.css['height']="auto";
        break;
        default:
          
          this.getSettable().css[propertyName]=propertyValue;
          return this.getProperty(propertyName) ;
          break;
      }
    },
    setProperty : function (propertyName,propertyValue){
      this._setProperty(propertyName,propertyValue);
    },
    _setProperty : function (propertyName,propertyValue){
        //console.log(propertyName);
        //console.log(propertyValue);
        this.setPropertyofObject(propertyName,propertyValue);
        this.setFromData();
        if(propertyName != "component_alignment")
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
 