// Tlingit Tribe jQuery FrameWork for communitacions between Servers and Client Side
// Combines all events created by BackEnd, Co-Working and Client
// Triggers events accordingly and simultenously.
// Control layer for all events. All events here should be trigged to pass other controls by this class
'use strict';

// lindneo namespace
window.lindneo = window.lindneo || {};

// tlingit module
window.lindneo.tlingit = (function(window, $, undefined){

  var componentHasCreated = function (component){
 
    //co-workers have created a new component, fuck them all.
    
    createComponent(component);

  };
  var oldcomponent_id = '';
  var createComponent = function ( component, component_id ){
    // create component
    // server'a post et
    // co-worker'lara bildir
    oldcomponent_id = component_id;

    window.lindneo.dataservice
      .send( 'AddComponent', 
        { 
          'pageId' : window.lindneo.currentPageId, 
          'attributes' : componentToJson(component),
          'oldcomponent_id' : oldcomponent_id 
        },
        newArrivalComponent,
        function(err){
          //console.log('error:' + err);
      });
  };

  var newArrivalComponent = function (res) {
    var response = responseFromJson(res);
    
    if( response.result === null ) {
      alert('hata'); 
      return;
    } 
    
    window.lindneo.nisga.createComponent( response.result.component, oldcomponent_id );
    window.lindneo.tsimshian.componentCreated( response.result.component );
    loadPagesPreviews(response.result.component.page_id);
  };

  var componentHasUpdated = function ( component ) {

    window.lindneo.dataservice
      .send( 'UpdateWholeComponentData', 
        { 
          'componentId' : component.id, 
          'jsonProperties' : componentToJson(component) 
        },
        updateArrivalComponent,
        function(err){
          //console.log('error:' + err);
      });
    
  };

  var updateArrivalComponent = function(res) {
    var response = responseFromJson(res);
    window.lindneo.tsimshian.componentUpdated(response.result.component);
    loadPagesPreviews(response.result.component.page_id);

  };

  var componentHasDeleted = function ( componentId ) {
    oldcomponent_id = componentId;
    window.lindneo.dataservice
    .send( 'DeleteComponent', 
      { 
        'componentId' : componentId
      },
      deleteArrivalResult,
      function(err){
        //console.log('error:' + err);
    });
  };

  var deleteArrivalResult = function ( res ) {
    var response = responseFromJson(res);

    window.lindneo.nisga.destroyComponent(response.result.delete, oldcomponent_id);
    window.lindneo.tsimshian.componentDestroyed(response.result.delete);
  };

  var loadComponents = function( res ) {

    var response = responseFromJson(res);
    var components = [];
    
    if( response.result !== null ) {
      components = response.result.components;
    }
    //console.log( components );
    $.each(components, function(i, val){
          
      window.lindneo.nisga.createComponent( val );
    });

    if (window.lindneo.highlightComponent!=''){
      $('#'+window.lindneo.highlightComponent).parent().css('border','1px solid red');
    }

  };

  var componentToJson = function (component){
    // build json of component
    return JSON.stringify(component);
  };

  var responseFromJson = function (response){
    return JSON.parse(response);
  };

  var loadPage = function (pageId){

    $('#current_page').empty();
    window.lindneo.currentPageId=pageId;

    //page ile ilgili componentların hepsini serverdan çek.
    // hepsi için createComponent 

    // find current page id from somewhere
    window.lindneo.dataservice
      .send( 'GetPageComponents', 
        { 
          'pageId' : pageId
        },
        loadComponents,
        function(err){
          //console.log('error:' + err);
      });

      

  };

  var loadAllPagesPreviews = function (){
    $("li.page").each(function(index, pageSlice){
      //console.log(pageSlice);

      var pagePreview = $('<canvas class="preview"  height="90"  width="120"> </canvas>');
    
      $(pageSlice).children('.preview').remove();
      $(pageSlice).prepend(pagePreview);
      var canvas=$(pageSlice).children('.preview')[0];
      var context=canvas.getContext("2d");
     context.fillStyle = '#FFF';
      context.fillRect(0,0,canvas.width,canvas.height);
      //console.log('ddedededede');
      //$('.chapter .page').each(function(){
      //console.log($(this).attr('page_id'));
      

      $.ajax({
          type: "POST",
          url:'/page/getPdfThumbnail?pageId='+$(this).attr('page_id'),
        }).done(function(page_data){
          
          var page_background = JSON.parse(page_data);
          //console.log(page_background.result);
          if(page_background.result){
            /*var background_img = '<img src="'+page_background.result+'" id="canvas_'+$(this).attr('page_id')+'"  height="90" width="120" style="display:none"/>';
            $(pageSlice).prepend(background_img);
            var background = document.getElementById('canvas_'+$(this).attr('page_id'));
            context.drawImage(background, 120,90);*/
            var img = new Image();
            img.src = page_background.result;
            img.onload = function(){
              context.drawImage(img, 0, 0);
            };

          }
        });
      //});
    });
   $('.chapter .page').each(function(){
    //console.log($(this).attr('page_id'));
    loadPagesPreviews($(this).attr('page_id'));
    });
  };

  var loadPagesPreviews = function (pageId) {
        //console.log(components);
    
    var pageSlice=$('[page_id="'+pageId+'"]');
    if (pageSlice)
     window.lindneo.dataservice
      .send( 'GetPageComponents', 
        { 
          'pageId' : pageId
        },
        PreviewOfPage,  
        function(err){
          //console.log('error:' + err);
      });
  };

  var PreviewOfPage = function (response) {
//console.log(response);
    if ($.isEmptyObject(responseFromJson(response).result)) return false;

    var components= responseFromJson(response).result.components;

    $.each(components,function(i,component){
      var pageSlice=$('[page_id="'+component.page_id+'"]');
      var canvas=$(pageSlice).children('.preview')[0];
      var context=canvas.getContext("2d");
       context.fillStyle = '#FFF';
        context.fillRect(0,0,canvas.width,canvas.height);
       
      
    });


      var canvas_reset=[];
      //console.log(components);
      components=components.sort (function(a,b){
        //console.log(a.data);
        if (a.data.self.css['z-index'] > b.data.self.css['z-index']) return +1;
        return -1;
      });
      

      $.each(components,function(i,component){
        var page_slice= $('[page_id="'+component.page_id+'"]');
        var ratio = $('#current_page').width() / page_slice.width();
        
        var canvas=page_slice.children('.preview')[0];
        var context=canvas.getContext("2d");
        
          context.fillStyle = '#FFF';
          context.fillRect(0,0,canvas.width,canvas.height);
          canvas_reset[component.page_id]=true;
       


          switch (component.type){


            case 'text':



              var fontHeight=(parseInt(component.data.textarea.css['font-size'] ) /ratio );
              var lines = component.data.textarea.val.match(/[^\n]+(?:\r?\n|$)/g) ;
              var y= parseInt( parseInt(component.data.self.css['top'] ) /ratio ) ;
              var x= parseInt( parseInt(component.data.self.css['left'] )  /ratio );
              var starty=y;

              var maxWidth=parseInt( parseInt(component.data.self.css['width']  ) /ratio );
              var maxHeight=parseInt( parseInt(component.data.self.css['height']  ) /ratio );

              context.font= fontHeight + 'px Arial';
              context.fillStyle= component.data.textarea.css['color'];

              if ( $.type(lines) != "undefined")
              if ( lines != null)
              if (lines.length > 0)
              $.each(lines, function (lineNumber,line){
                  y += fontHeight;
                  var words = line.split(' ');
                  var sublines = '';
                  //console.log(y + ' ' +line) ;
                  for(var n = 0; n < words.length; n++) {

                    var testLine = sublines + words[n] + ' ';
                    var metrics = context.measureText(testLine);
                    var testWidth = metrics.width;

                    if (testWidth > maxWidth && n > 0 ) {
                      if ( y - starty <= maxHeight ) context.fillText(sublines, x, y);
                      sublines = words[n] + ' ';
                      y += fontHeight;
                    }
                    else {
                      sublines = testLine;
                    }

                  } 

           
              if ( y - starty  <= maxHeight ) context.fillText(sublines, x,y );

              })
              
             ;
            
              break;

            case 'image':
              var image=new Image();
              image.src = component.data.img.src;
              var y= parseInt( parseInt(component.data.self.css['top'] ) /ratio ) ;
              var x= parseInt( parseInt(component.data.self.css['left'] )  /ratio );
              var width= parseInt( parseInt(component.data.self.css['width'] )  /ratio );
              var height= parseInt( parseInt(component.data.self.css['height'] )  /ratio );

              image.onload= function(){
                context.drawImage(image,x,y,width,height );
              }
              



              break;

            default:
              
              break;

          }


      });

    };
 




  var snycServer = function (action,jsonComponent) {
    //ajax to Server
  };

  var snycCoworkers = function (action,jsonComponent) {
    //Socket API for Co-Working
  };


  var PageUpdated = function (pageId, chapterId, order){
    window.lindneo.dataservice
    .send( 'UpdatePage', 
      { 
        'pageId' : pageId,
        'chapterId' : chapterId,
        'order' : order
      },
      UpdatePage,
      function(err){
        //console.log('error:' + err);
    });
  
  };

  var UpdatePage =function(response){
    var response = responseFromJson(response);
    //pass to nisga new chapter
    //console.log(response);

  };

  var ChapterUpdated = function (chapterId, title, order){

//console.log(chapterId);
//console.log(title);
//console.log(order);

    window.lindneo.dataservice
    .send( 'UpdateChapter', 
      { 
        'chapterId' : chapterId,
        'title' : title,
        'order' : order
      },
      UpdateChapter,
      function(err){
        //console.log('error:' + err);
    });
  
  };

  var UpdateChapter =function(response){
    responseFromJson(response);
    //pass to nisga new chapter
    //console.log(response);

  };


  var ChapterHasDeleted = function (chapterId){
    window.lindneo.dataservice
    .send( 'DeleteChapter', 
      { 
        'chapterId' : chapterId,
      },
      DeleteChapter,
      function(err){
        //console.log('error:' + err);
      });

   
  };

  var DeleteChapter =function(response){
    var response = responseFromJson(response);
    //pass to nisga to destroy chapter
    //console.log(response);

  }; 


  var PageHasDeleted = function (pageId){
    window.lindneo.dataservice
    .send( 'DeletePage', 
      { 
        'pageId' : pageId,
      },
      DeletePage,
      function(err){
        //console.log('error:' + err);
      });

   
  };

  var DeletePage =function(response){
    var response = responseFromJson(response);
    //pass to nisga to destroy page
    //console.log(response);

  }; 





  return {
    loadAllPagesPreviews: loadAllPagesPreviews,
    loadPagesPreviews: loadPagesPreviews,
    responseFromJson: responseFromJson,
    componentToJson: componentToJson,
    UpdatePage: UpdatePage,
    PageUpdated: PageUpdated,
    createComponent: createComponent,
    componentHasCreated: componentHasCreated,
    componentHasUpdated: componentHasUpdated,
    componentHasDeleted: componentHasDeleted,
    ChapterUpdated: ChapterUpdated,
    UpdateChapter: UpdateChapter,
    loadPage: loadPage ,
    ChapterHasDeleted: ChapterHasDeleted,
    PageHasDeleted: PageHasDeleted,
    DeletePage: DeletePage,
    DeleteChapter: DeleteChapter
  };

})( window, jQuery );