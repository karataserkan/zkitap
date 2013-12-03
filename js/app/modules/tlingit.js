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

    //console.log( component );

    createComponent(component);

  };

  var createComponent = function ( component ){
    // create component
    // server'a post et
    // co-worker'lara bildir
    window.lindneo.dataservice
      .send( 'AddComponent', 
        { 
          'pageId' : window.lindneo.currentPageId, 
          'attributes' : componentToJson(component) 
        },
        newArrivalComponent,
        function(err){
          console.log('error:' + err);
      });
  };

  var newArrivalComponent = function (res) {
    var response = responseFromJson(res);

    if( response.result === null ) {
      alert('hata'); 
      return;
    } 
    
    window.lindneo.nisga.createComponent( response.result.component );
    window.lindneo.tsimshian.componentCreated( response.result.component );
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
          console.log('error:' + err);
      });
    
  };

  var updateArrivalComponent = function(res) {
    var response = responseFromJson(res);

    window.lindneo.tsimshian.componentUpdated(response.result.component);

  };

  var componentHasDeleted = function ( componentId ) {
    window.lindneo.dataservice
    .send( 'DeleteComponent', 
      { 
        'componentId' : componentId
      },
      deleteArrivalResult,
      function(err){
        console.log('error:' + err);
    });
  };

  var deleteArrivalResult = function ( res ) {
    var response = responseFromJson(res);

    window.lindneo.nisga.destroyComponent(response.result.delete);
    window.lindneo.tsimshian.componentDestroyed(response.result.delete);
  };

  var loadComponents = function( res ) {

    var response = responseFromJson(res);
    var components = [];
    
    if( response.result !== null ) {
      components = response.result.components;
    }

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
          console.log('error:' + err);
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
        console.log('error:' + err);
    });
  
  };

  var UpdatePage =function(response){
    var response = responseFromJson(response);
    //pass to nisga new chapter
    console.log(response);

  };

  var ChapterUpdated = function (chapterId, title, order){
    window.lindneo.dataservice
    .send( 'UpdateChapter', 
      { 
        'chapterId' : chapterId,
        'title' : title,
        'order' : order
      },
      UpdateChapter,
      function(err){
        console.log('error:' + err);
    });
  
  };

  var UpdateChapter =function(response){
    var response = responseFromJson(response);
    //pass to nisga new chapter
    console.log(response);

  };


  var ChapterHasDeleted = function (chapterId){
    window.lindneo.dataservice
    .send( 'DeleteChapter', 
      { 
        'chapterId' : chapterId,
      },
      DeleteChapter,
      function(err){
        console.log('error:' + err);
      });

   
  };

  var DeleteChapter =function(response){
    var response = responseFromJson(response);
    //pass to nisga to destroy chapter
    console.log(response);

  }; 


  var PageHasDeleted = function (pageId){
    window.lindneo.dataservice
    .send( 'DeletePage', 
      { 
        'pageId' : pageId,
      },
      DeletePage,
      function(err){
        console.log('error:' + err);
      });

   
  };

  var DeletePage =function(response){
    var response = responseFromJson(response);
    //pass to nisga to destroy page
    console.log(response);

  }; 





  return {
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