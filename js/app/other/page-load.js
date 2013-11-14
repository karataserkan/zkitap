$( document ).ready(function(){

  window.lindneo.tlingit.loadPage(window.lindneo.currentPageId);
  window.lindneo.toolbox.load();

  $('#current_page').dblclick(function(e){
    


    if( window.lindneo.currentComponentWidget ) {
      window.lindneo.currentComponentWidget.unselect();
      window.lindneo.currentComponentWidget = null;
    }
    
  });

});