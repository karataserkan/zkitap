// Nisga'a Tribe jQuery UI elements for Client Side
// Triggers Framework events and client events
'use strict';

// lindneo namespace
window.lindneo = window.lindneo || {};

// nisga module
window.lindneo.nisga = (function(window, $, undefined){

  var page_div_selector = '#current_page';
  var revision_array = {
                revisions: []
            };
  var comment_id_array = new Array();
  var array_revisions=[];
  var revision_id=0;
  var revision_value = 0;

  var ChatNewLine = function ( line,activeUser ){
    var lineHtml = $('<div class="chat_sent_message_holder " style ="border-left: 10px solid '+activeUser.color+';"> \
      <div class="chat_sent_message_user_name">'+activeUser.name+'</div> \
      <div class="chat_sent_message_text">'+line.replace(/\n/g, '<br />')+'</div> \
    </div>');
    $('.chat_sent_messages').append(lineHtml);
    $(".chat_sent_messages").animate({ scrollTop: $('.chat_sent_messages')[0].scrollHeight}, 100);
    $(".chat_window" ).show();

  }

 


  var createComponent = function( component ){
      //console.log(revision_value);
//    console.log(component);
    componentBuilder( component );  
    if(revision_value==0){
        revision_array.revisions.push({component_id: component.id, component: component, revision_date: $.now(), even_type: 'CREATE'});
        revision_id++;
    }
    else revision_value=0;
    
    //console.log(revision_array);
  };

  var componentBuilder = function( component ){
     
    switch( component.type ) {
      case 'text':
        textComponentBuilder( component );
        break;
      case 'image':
        imageComponentBuilder( component );
        break;
      case 'galery':
        galeryComponentBuilder( component );

      break; 
      case 'sound':
        soundComponentBuilder( component );
      break; 

        break;
      case 'quiz':
        quizComponentBuilder( component );
        break;

      case 'video':
        videoComponentBuilder( component );
        break;

      case 'popup':
        popupComponentBuilder( component );
        break;

      case 'grafik':
        graphComponentBuilder( component );
        break;

      case 'shape':
        shapeComponentBuilder( component );
        break;

      case 'link':
        linkComponentBuilder( component );
        break;



      default:
         // what can I do sometimes
         break;
    }
    
  }; 

  var undoComponent = function() {
        //console.log(revision_array[0].revisions[0].component_id);
        //console.log(revision_id);
        if(revision_id!=0){ //console.log(revision_array[revision_id-1].revisions[0].component);
            revision_id=revision_id-1;
            console.log(revision_id);
            console.log(revision_array.revisions.length);
            console.log(revision_array.revisions[revision_id].even_type);
            console.log(revision_array.revisions);
            revision_value=1;
           if(revision_array.revisions[revision_id].even_type=='CREATE'){
                if(revision_array.revisions[revision_id].component.type=='image'){
                    destroyComponent(revision_array.revisions[revision_id].component.id);
                    window.lindneo.tlingit.componentHasCreated(revision_array.revisions[revision_id-1].component)
                }
                else{
                destroyComponent(revision_array.revisions[revision_id].component.id);
                }
                //console.log(revision_array.revisions[revision_id].even_type);
                //console.log(revision_array);
                //console.log(revision_array);
                //console.log(revision_id);
            }
            if(revision_array.revisions[revision_id].even_type=='UPDATE'){
                //console.log(revision_array[revision_id-1].revisions[0].component);
                //console.log(revision_array[revision_id-2].revisions[0].component);
                var array_where = [];
                $.each(revision_array.revisions, function(index,value){ 
                    if (value.component_id == revision_array.revisions[revision_id].component.id && index<=revision_id)
                        array_where.push(value);
                }); 

                //var array_where = $.grep(revision_array.revisions, function(e){ return (e.component.id == revision_array.revisions[revision_id].component.id && e.indexOf('J')); }); 
                array_where.pop();
                console.log(array_where);
                destroyComponent(array_where[array_where.length-1].component.id);
                createComponent(array_where[array_where.length-1].component);
                window.lindneo.tlingit.componentHasUpdated(array_where[array_where.length-1].component);
                
                
                //revision_id--;
                //console.log(revision_array.revisions[revision_id].even_type);
                //console.log(revision_array);
                //console.log(revision_id);
                
            }
            if(revision_array.revisions[revision_id].even_type=='DELETE'){
                //window.lindneo.tlingit.componentHasCreated(revision_array.revisions[revision_id].component);
                createComponent(revision_array.revisions[revision_id].component);
                //console.log(revision_array.revisions[revision_id].even_type);
                //console.log(revision_array);
            }
        }
    }
    
    var redoComponent = function() {
        //console.log(revision_array.revisions[revision_id].component_id);
        console.log(revision_id);
        console.log(revision_id+' '+revision_array.revisions.length);
        console.log(revision_array.revisions[revision_id].even_type);
        console.log(revision_array);
        if(revision_id<revision_array.revisions.length){ //console.log(revision_array[revision_id-1].revisions[0].component);
            //revision_id=revision_id-1;
            //console.log(revision_id);
            //console.log(revision_array.revisions[revision_id].even_type);
            revision_value=1;
           if(revision_array.revisions[revision_id].even_type=='CREATE'){
               if(revision_array.revisions[revision_id].component.type=='image'){
                    destroyComponent(revision_array.revisions[revision_id].component.id);
                    window.lindneo.tlingit.componentHasCreated(revision_array.revisions[revision_id+1].component);
                }
                else{
                    createComponent(revision_array.revisions[revision_id].component);
                }
                //console.log(revision_array.revisions[revision_id].even_type);
                //console.log(revision_array);
                revision_array.revisions.pop();
                
            }
            if(revision_array.revisions[revision_id].even_type=='UPDATE'){
                //console.log(revision_value);
                //console.log(revision_array[revision_id-2].revisions[0].component);
                destroyComponent(revision_array.revisions[revision_id].component.id);
                createComponent(revision_array.revisions[revision_id].component);
                window.lindneo.tlingit.componentHasUpdated(revision_array.revisions[revision_id].component);
                
                //revision_id--;
                //console.log(revision_array.revisions[revision_id].even_type);
                //console.log(revision_array);
            }
            if(revision_array.revisions[revision_id].even_type=='DELETE'){
                destroyComponent(revision_array.revisions[revision_id].component.id);
                //console.log(revision_array.revisions[revision_id].even_type);
                //console.log(revision_array);
            }
          
          revision_id++;
        }
   }
   
   var updateRevisions = function() {
    if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
   }

  var destroyComponent = function ( componentId ) {
    //  console.log(componentId);
    $('[id="'+componentId+'"]').parent().not('#current_page').remove();
    $('[id="'+componentId+'"]').remove();
  };
  
  var ComponentDelete = function ( component ) {
    if(revision_value==0){
        revision_array.revisions.push({component_id: component.id, component: component, revision_date: $.now(), even_type: 'DELETE'});
        revision_id++;
      }
      else revision_value=0;
    //  console.log(componentId);
    $('[id="'+component.id+'"]').parent().not('#current_page').remove();
    $('[id="'+component.id+'"]').remove();
  };

  var deleteComponent = function ( component ) {
      if(revision_value==0){
        revision_array.revisions.push({component_id: component.id, component: component, revision_date: $.now(), even_type: 'DELETE'});
        revision_id++;
      }
      else revision_value=0;
//        console.log(revision_array);
    window.lindneo.toolbox.removeComponentFromSelection( $('#'+ component.id) );
    window.lindneo.tlingit.componentHasDeleted( component.id );

  };


  var shapeComponentBuilder = function( component ) {
    
    var element  = $('<canvas> </canvas>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .shapeComponent({
      'component': component,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );        
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };

  var graphComponentBuilder = function( component ) {
    
    var element  = $('<canvas> </canvas>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .graphComponent({
      'component': component,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };

  var textComponentBuilder = function( component ) {

    var element = $('<textarea></textarea>'); 

    element
    .appendTo( page_div_selector )
    .textComponent({
      'component': component,
      'update': function ( event, component ) {  
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: component, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      console.log(component);
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
        
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };

  var linkComponentBuilder = function ( component ) {
    
    
    var element  = $('<a class="link-component"></a>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .popupComponent({
      'component': component,
      'marker': 'http://dev.lindneo.com/css/linkmarker.png'  ,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };


  var popupComponentBuilder = function ( component ) {
    
    
    var element  = $('<div class="popup-controllers"> </div>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .popupComponent({
      'component': component,
      'marker': 'http://dev.lindneo.com/css/popupmarker.png'  ,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };



  var destroyChapter=function(chapter){
    $(".chapter[chapter_id='"+chapter+"']").remove();
  }; 


  
  var imageComponentBuilder = function ( component ) {
    
    var element = $('<img></img>');

    element
    .appendTo( page_div_selector )
    .imageComponent({
      'component': component,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };

  var videoComponentBuilder = function ( component ) {
    
    var element  = $('<div class="video-controllers"> </div>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .videoComponent({
      'component': component,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };





  var soundComponentBuilder = function ( component ) {
    var element  = $('<div class="sound-controllers"> </div>');
    var elementWrap=$('<div ></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .soundComponent({
      'component': component,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  }
  
  var galeryComponentBuilder = function ( component ) {
    

    var element  = $('<div class="some-gallery"> </div>');
    var elementWrap=$('<div ></div>');

    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .galeryComponent({
      'component': component,
      'update': function ( event, component ) {
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'});
                revision_id++;

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      },
      'selected': function (event, element) {
        window.lindneo.currentComponentWidget = element;
        window.lindneo.toolbox.refresh( element );
      }
    });

  };

  var quizComponentBuilder = function ( component ) {

    var element  = $('<div></div>');
    var elementWrap=$('<div></div>');
    elementWrap.appendTo( page_div_selector );

    element
    .appendTo( elementWrap )
    .quizComponent({
      'component': component,
      'update': function( event, component ){
        if(revision_value==0){
        var newObject = jQuery.extend(true, {}, component);
        revision_array.revisions.push({component_id: component.id, component: newObject, revision_date: $.now(), even_type: 'UPDATE'}); 
                revision_id++; 

      }
      else revision_value=0;
      //console.log(revision_array);
        window.lindneo.tlingit.componentHasUpdated( component );
      }, 
      'selected': function ( event, element_ ){
        window.lindneo.currentComponentWidget = element_;
        window.lindneo.toolbox.refresh( element_ );
      }
    });
  };

  var setBgColorOfSelectedComponent = function ( componentId ,activeUser){
    $('[id="' + componentId + '"]').css({
      'border': '1px solid #ccc',
      'border-color': activeUser.color
    });
//    console.log(activeUser.color);

    $('[color="' +activeUser.color+ '"]').parent().find('[component-instance="true"]').css( {'border': 'none'});
    $('[color="' +activeUser.color+ '"]').parent().children('.activeUser').remove();


    $('[id="' + componentId + '"]').parent().children('.activeUser').remove();
    var activeUserDOM=$('<span class="activeUser" style="position: absolute; top: -20px; right: -20px;color:'+activeUser.color+'; " color="'+activeUser.color+'">'+activeUser.name+'</span>');
 

    $('[id="' + componentId + '"]').parent().append(activeUserDOM); 

    

  };

  return {
    ChatNewLine: ChatNewLine,
    galeryComponentBuilder: galeryComponentBuilder,
    createComponent: createComponent,
    deleteComponent: deleteComponent,
    ComponentDelete: ComponentDelete,
    destroyChapter: destroyChapter,
    destroyComponent: destroyComponent,
    undoComponent: undoComponent,
    redoComponent: redoComponent,
    setBgColorOfSelectedComponent: setBgColorOfSelectedComponent
  };

})( window, jQuery );

