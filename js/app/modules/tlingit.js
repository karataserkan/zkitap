
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
 
    //co-workers have created a new component.
    
    createComponent(component);

  };


  var componentPreviosVersions=[];
  var oldcomponent_id = '';
  var oldcomponent = '';
  var pages = [];
  var createComponent = function ( component, component_id ){
    // create component
    // server'a post et
    // co-worker'lara bildir
    oldcomponent_id = component_id;
    oldcomponent = component;
    console.log(component.data.self.css);
    if(component.data.self.css['z-index'] == "first"){
        
        var zindex = window.lindneo.toolbox.findHighestZIndexToSet('[component-instance="true"]', component.id );
        console.log(zindex);
        if(zindex == 1) zindex = 900;
        component.data.self.css['z-index'] = zindex;
        //console.log(component.data.self.css);
        
      }
    
    var fakeComponent = JSON.parse(JSON.stringify(component));
    
    delete fakeComponent["data"];

    window.lindneo.dataservice
      .send( 'AddComponent', 
        { 
          'pageId' : window.lindneo.currentPageId, 
          'attributes' : componentToJson(fakeComponent),
          'oldcomponent_id' : oldcomponent_id 
        },
        function (res) {
            var response = responseFromJson(res);
            
            if( response.result === null ) {
              alert('hata'); 
              return;
            }  
            
            response.result.component.data = component.data;


            componentHasUpdated (response.result.component);

            window.lindneo.nisga.createComponent( response.result.component, oldcomponent_id );
            window.lindneo.tsimshian.componentCreated( response.result.component );
            //loadPagesPreviews(response.result.component.page_id);

          },
        function(err){
          
      });


  };

/*
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
*/
  var componentHasUpdated = function ( component ) {
    //console.log(component);
    if( typeof  componentPreviosVersions[component.id] == "undefined"){
         

          console.log('firstUpdate');
        
    
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


    } else {
        
        var componentDiff = deepDiffMapper.map(component.data, componentPreviosVersions[component.id].data);
        console.log(componentDiff);
         window.lindneo.dataservice
          .send( 'UpdateMappedComponentData', 
            { 
              'componentId' : component.id, 
              'jsonProperties' : componentToJson(componentDiff) 
            },
            updateArrivalComponent,
            function(err){
              //console.log('error:' + err);
          });

    }
     componentPreviosVersions[component.id]= JSON.parse(JSON.stringify(component)); 
    window.lindneo.tsimshian.componentUpdated(component);
    
  };

  var updateArrivalComponent = function(res) {
    updatePageCanvas();
    //var response = responseFromJson(res);
    //console.log(response);
    //loadPagesPreviews(response.result.component.page_id);

  };

  var componentHasDeleted = function ( component, componentId ) {
    if(typeof componentId != 'undefined')
      oldcomponent_id = componentId;
    oldcomponent = component;
    //console.log(component);
    //console.log(component.id);
    //console.log(componentId);
    if(typeof component != 'undefined'){
      window.lindneo.dataservice
      .send( 'DeleteComponent', 
        { 
          'componentId' : component.id
        },
        deleteArrivalResult,
        function(err){
          console.log('error:' + err);
      });
    }
  };

  var deleteArrivalResult = function ( res ) {
    //console.log('deleteArrivalResult');
    if(res){
      var response = responseFromJson(res);
      //console.log(oldcomponent);
      //console.log(response.result);
      if(response.result){
        window.lindneo.nisga.destroyComponent(oldcomponent, response.result.delete);
        window.lindneo.tsimshian.componentDestroyed(response.result.delete);
      }
    }
    updatePageCanvas();
  };

  var loadComponents = function( res ) {

    //console.log("LOAD components");
    //console.log(window.lindneo.currentBookId);
    //console.log(res);
    var response = responseFromJson(res);
    var components = [];
    //console.log(response);
    if( response.result !== null ) {
      components = response.result.components;
    }
    //console.log( components );
    $.each(components, function(i, val){
      

      //console.log(val.page_id);
      if(val.type === "page"){
        //console.log(window.lindneo.tlingit.pages);
        $.each(window.lindneo.tlingit.pages, function(index, value){
          //console.log(value);
          //console.log(val);
          if(value.page_id == val.page_id){
            
            //console.log(val.type);
            //console.log(value.page_num);
            val.data.textarea.val = value.page_num;
            }
        });
      }
      window.lindneo.nisga.createComponent( val );
    });

    if (window.lindneo.highlightComponent!=''){
      $('#'+window.lindneo.highlightComponent).parent().css('border','1px solid red');
    }

  };

  var componentToJson = function (component){
    // build json of component
    //console.log(component);
    return JSON.stringify(component);
  };

  var responseFromJson = function (response){
      //console.log(response);
      //return eval("(" +response+ ")");
      if(response)
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
      var num = index + 1;
      //console.log(pageSlice.attributes[2].nodeValue);
      //var pages_num = {"page_id": $(this).attr('page_id'), "pane_num": pageNum};
      //window.lindneo.tlingit.pages.push(pages_num);
      //if(index == 0) {pages = []; console.log("adasdasdasd");} 
      pages.push({"page_id": pageSlice.attributes[2].nodeValue, "page_num": num});

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
      
      var component_previews = [];

      $.each(components,function(i,component){
        var page_slice= $('[page_id="'+component.page_id+'"]');
        var ratio = $('#current_page').width() / page_slice.width();
        
        var canvas=page_slice.children('.preview')[0];
        var context=canvas.getContext("2d");
        
          context.fillStyle = '#FFF';
          context.fillRect(0,0,canvas.width,canvas.height);
          canvas_reset[component.page_id]=true;
       


          switch (component.type){

            case 'image':
             
              var image=new Image();
              image.src = component.data.img.src;
              var y= parseInt( parseInt(component.data.self.css['top'] ) /ratio ) ;
              var x= parseInt( parseInt(component.data.self.css['left'] )  /ratio );
              var width= parseInt( parseInt(component.data.self.css['width'] )  /ratio );
              var height= parseInt( parseInt(component.data.self.css['height'] )  /ratio );

              image.onload= function(){
                context.drawImage(image,x,y,width,height );
                var componentPreview = {
                  'type' : 'image',
                  'image' : image,
                  'x' : x,
                  'y' : y,
                  'width' : width,
                  'height' : height
                };
                component_previews.push(componentPreview);
              }
              


              break;


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
                          if ( y - starty <= maxHeight ) {
                            context.fillText(sublines, x, y);
                            var componentPreview = {
                              'type' : 'text',
                              'text' : sublines,
                              'x' : x,
                              'y' : y
                            };
                            component_previews.push(componentPreview);
                          }
                          sublines = words[n] + ' ';
                          y += fontHeight;
                        }
                        else {
                          sublines = testLine;
                        }

                      } 

               
                  if ( y - starty  <= maxHeight ) {
                    context.fillText(sublines, x,y );
                    var componentPreview = {
                      'type' : 'text',
                      'text' : sublines,
                      'x' : x,
                      'y' : y
                    };
                    component_previews.push(componentPreview);
                  }

                  });
            
              break;

            

            default:
              
              break;

          }


      });

    //console.log(component_previews);


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

  var PageHasCreated = function (pageId){
    console.log("page created");
    bookPagePreviews();
   
  };


  var PageHasDeleted = function (pageId){
    console.log(pageId);
    window.lindneo.tsimshian.pageDestroyed( pageId );
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
    //var response = responseFromJson(response);
    //pass to nisga to destroy page
    //console.log(response);

  }; 
  var updatePageCanvas = function (page_id){
    GenerateCurrentPagePreview(page_id) ;
     
  }
  var GenerateCurrentPagePreview = function (page_id){
    html2canvas($('#current_page')[0], {
      onrendered: function(canvas) {
         
          var currentPagePreviewCanvas = $('.current_page canvas.preview')[0];
          var img = new Image();
          img.src = canvas.toDataURL();
     
            currentPagePreviewCanvas.getContext("2d").drawImage(img, 0, 0, currentPagePreviewCanvas.width, currentPagePreviewCanvas.height);
            window.lindneo.dataservice
            .send('DeletePage', 
              { 
                'pageId' : page_id,
                'data' : currentPagePreviewCanvas.toDataURL(),
              });

      }
    });
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
    PageHasCreated: PageHasCreated,
    DeletePage: DeletePage,
    DeleteChapter: DeleteChapter,
    pages: pages,
    componentPreviosVersions: componentPreviosVersions
  };

})( window, jQuery );



var deepDiffMapper = function() {
    return {
        VALUE_CREATED: 'created',
        VALUE_UPDATED: 'updated',
        VALUE_DELETED: 'deleted',
        VALUE_UNCHANGED: 'unchanged',
        map: function(obj1, obj2) {
            if (this.isFunction(obj1) || this.isFunction(obj2)) {
                throw 'Invalid argument. Function given, object expected.';
            }
            if (this.isValue(obj1) || this.isValue(obj2)) {
                return {mapped_type: this.compareValues(obj1, obj2), mapped_data: obj1 || obj2};
            }

            var diff = {};
            for (var key in obj1) {
                if (this.isFunction(obj1[key])) {
                    continue;
                }

                var value2 = undefined;
                if ('undefined' != typeof(obj2[key])) {
                    value2 = obj2[key];
                }

                var adding = this.map(obj1[key], value2);
                //if(adding.type != this.VALUE_UNCHANGED)
                  diff[key] = adding;
            }
            for (var key in obj2) {
                if (this.isFunction(obj2[key]) || ('undefined' != typeof(diff[key]))) {
                    continue;
                }

               
                var adding = this.map(undefined, obj2[key]);
                
                  diff[key] = adding;
            }
            for (var key in diff){
              if(diff[key].mapped_type == this.VALUE_UNCHANGED)
                delete diff[key];
            }
            return diff;

        },
        compareValues: function(value1, value2) {
            if (value1 === value2) {
                return this.VALUE_UNCHANGED;
            }
            if ('undefined' == typeof(value1)) {
                return this.VALUE_CREATED;
            }
            if ('undefined' == typeof(value2)) {
                return this.VALUE_DELETED;
            }

            return this.VALUE_UPDATED;
        },
        isFunction: function(obj) {
            return toString.apply(obj) === '[object Function]';
        },
        isArray: function(obj) {
            return toString.apply(obj) === '[object Array]';
        },
        isObject: function(obj) {
            return toString.apply(obj) === '[object Object]';
        },
        isValue: function(obj) {
            return !this.isObject(obj) && !this.isArray(obj);
        }
    }
}();
