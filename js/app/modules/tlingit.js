
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
     updatePageCanvas(window.lindneo.currentPageId, function(){
          $('#current_page').empty();
          window.lindneo.currentPageId=pageId;
          window.lindneo.dataservice
          .send( 'GetPageComponents', 
            { 
              'pageId' : pageId
            },
            loadComponents,
            function(err){
             
          });
     });



      

  };

  var loadAllPagesPreviews = function (){

    window.lindneo.dataservice
      .send( 'GetPagePreviewThumbnailsOfBook', 
        { 
          'bookId' : window.lindneo.currentBookId
        },
        function(res){

          var response = responseFromJson(res);
          res = "";

               $("li.page").each(function(index, pageSlice){
                  var num = index + 1;
                  //console.log(pageSlice.attributes[2].nodeValue);
                  //var pages_num = {"page_id": $(this).attr('page_id'), "pane_num": pageNum};
                  //window.lindneo.tlingit.pages.push(pages_num);
                  //if(index == 0) {pages = []; console.log("adasdasdasd");} 
                  pages.push({"page_id": pageSlice.attributes[2].nodeValue, "page_num": num});



                  var CCHeight = $('#current_page').height();
                  var CCWidth = $('#current_page').width();
                  var canvasHeight = parseInt( CCHeight * 120   / (  CCWidth ) ); 
                  var pagePreview = $('<canvas class="preview"  height="' +canvasHeight+ '"  width="120"> </canvas>');
                
                  $(pageSlice).children('.preview').remove();
                  $(pageSlice).prepend(pagePreview);
                  var canvas=$(pageSlice).children('.preview')[0];
                  var context=canvas.getContext("2d");
                  context.fillStyle = '#FFF';
                  context.fillRect(0,0,canvas.width,canvas.height);
                  var img = new Image();
                  img.src = response.result[$(this).attr('page_id')];
                  img.src = img.src.data;
                  img.onload = function(){
                    context.drawImage(img, 0, 0,canvas.width,canvas.height);
                  };

                });


        },  
        function(err){
          //console.log('error:' + err);
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
  var updatePageCanvas = function (page_id,callback,async) {
    if (typeof async == "undefined") async = true;
    if (typeof callback == "undefined") callback = function(){};
    GenerateCurrentPagePreview(page_id,callback,async) ;
     
  }
  var GenerateCurrentPagePreview = function (page_id,callback,async){
    if(typeof async == "undefined") async = true;
    html2canvas($('#current_page')[0], {
      onrendered: function(canvas) {
         
          var currentPagePreviewCanvas = $('li[page_id="'+page_id+'"] canvas.preview')[0];
          if (currentPagePreviewCanvas){
            var img = new Image();
            img.src = canvas.toDataURL();

            currentPagePreviewCanvas.getContext("2d").drawImage(img, 0, 0, currentPagePreviewCanvas.width, currentPagePreviewCanvas.height);

            window.lindneo.dataservice
            .send('UpdatePageData', 
              { 
                'pageId' : page_id,
                'data' : currentPagePreviewCanvas.toDataURL(),
              }, 
              function(){},
              function(){},
              async
              );
          }
          callback();

      }
    });
  };





  return {
    loadAllPagesPreviews: loadAllPagesPreviews,
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
    componentPreviosVersions: componentPreviosVersions,
    updatePageCanvas: updatePageCanvas
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
