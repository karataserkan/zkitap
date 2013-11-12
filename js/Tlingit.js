// Tlingit Tribe jQuery FrameWork for communitacions between Servers and Client Side
// Combines all events created by BackEnd, Co-Working and Client
// Triggers events accordingly and simultenously.
// Control layer for all events. All events here should be trigged to pass other controls by this class
'use strict';
window.lindneo = window.lindneo || {};

window.lindneo.url = 'http://ugur.dev.lindneo.com/index.php';
window.currentPageId='Ip38yh5mNn2uzH6JTwmO29oI65Qy7c745YskdqualT85';

window.lindneo.tlingit = (function(window, $, undefined){

  var createComponent = function (component){
    // create component
    // server'a post et
    // co-worker'lara bildir
    //componentToJson(component);
    window.lindneo.dataservice.post( 'AddComponent', 
      
        { 'pageId' : window.currentPageId 
        , 'attributes' : componentToJson(component) }
      ,

     newArrivalComponent, function(err){
        console.log('error:' + err);
      });
  };

  var newArrivalComponent= function (res){
    var response=responseFromJson(res);
    if(response.result==null) alert('hata');
    
    window.lindneo.nisga.createComponent(response.result.component);
    

  }

  var componentHasCreated = function (component){

    console.log('component has created');
    //co-workers have created a new component, fuck them all.
    createComponent(component);
    //window.lindneo.nisga.createComponent(component);

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
  };

  var snycServer = function (action,jsonComponent) {
    //ajax to Server
  };

  var snycCoworkers = function (action,jsonComponent) {
    //Socket API for Co-Working
  };

  return {
    componentHasCreated: componentHasCreated
  };

})( window, jQuery );

window.lindneo.dataservice = (function($){
  var post = function(action, data, successCallback, failCallback){
    data.r='EditorActions' +'/' + action;

    $.ajax({
      'type': 'GET',
      'url': window.lindneo.url ,
      'data': data,
      //'dataType': 'json',      
      'success': successCallback,
      'error': failCallback
    });
  };

  return {
    post: post
  };

})(jQuery);