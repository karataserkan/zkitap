// Tsimshian Tribe Library for Co-working
// Triggers Framework events and Coworking events
'use strict'; 

window.lindneo = window.lindneo || {};
 
// tsimshian module
tsimshian = (function(window, $, undefined){

  var socket;
  var myComponent='';
  var hereACounter = 0;
  var book_user_list = [];
  var tsimshian = this;
  var connect = function () {

    tsimshian.init(); 
    tsimshian.changePage(window.lindneo.currentPageId); 

  };
 
  var serverName = function (){ 
    return window.location.origin+":1881";
  }; 



  var componentUpdated = function (component) {    

    tsimshian.myComponent = component.id;
    //console.log('Sending');
    //console.log(tsimshian.myComponent);
    this.socket.emit('updateComponent', component);

  };

  var componentCreated = function (component) {    

          tsimshian.myComponent = component.id;
          this.socket.emit('newComponent', component);

  };

  var chatSendMessage = function (line){
    this.socket.emit('chatBroadcast', line);
  }

  var componentDestroyed = function(componentId){
    //console.log(componentId);
    this.socket.emit('destroyComponent', componentId);
  };

  var pageDestroyed = function(pageId){
    console.log(pageId);
    this.socket.emit('destroyPage', pageId);
  };

  var pageCreated = function(){
    console.log("page");
    window.lindneo.tsimshian.socket.emit('createPage');
  };

  var emitSelectedComponent = function ( component ) {

    tsimshian.myComponent = component.id();

    this.socket.emit( 'emitSelectedComponent',   component.id()  );
  };

 
  var changePage = function (pageId){
    var user={
      pageid:pageId,
      bookid:window.lindneo.currentBookId,
      name:window.lindneo.user.name,
      username:window.lindneo.user.username
    }
    
   
 
   
    tsimshian.socket.emit('changePage',user);
  };

  var init = function (serverName){

    if ( typeof io == 'undefined' ){
      alert (j__("Co-working System Error"));
      location.reload();
      return;

    }

    this.socket = io.connect(window.location.origin+":1881");
    this.socket.on('connection', function (data) {
      var user=tsimshian.getCurrentUser();
       this.socket.emit('changePage',user);

    });
  
        
  
       this.socket.on('newComponent', function(component){
          //console.log(component.id) ;
          //console.log(tsimshian.myComponent) ;
          window.lindneo.nisga.createComponent(component); 
       } );

 
       this.socket.on('destroyComponent', function(componentId){
        
          window.lindneo.nisga.destroyByIdComponent(componentId);
          
        
       } );

       this.socket.on('destroyPage', function(pageId){
          console.log(pageId);
          window.lindneo.nisga.destroyPage(pageId);
          sortPages();
          window.lindneo.tlingit.loadAllPagesPreviews();
        
       } );

       this.socket.on('createPage', function(){
          
          window.lindneo.tlingit.PageHasCreated();
        
       } );

       this.socket.on('updateComponent', function(component){
   
          window.lindneo.nisga.destroyByIdComponent(component.id);
          window.lindneo.nisga.createComponent(component);
  
       } );

      this.socket.on('emitSelectedComponent', function( select_item ) {
          var componentId=select_item.componentId;
          var activeUser=select_item.user;
          window.lindneo.nisga.setBgColorOfSelectedComponent( componentId,activeUser );
        
      });

      this.socket.on('chatBroadcast', function( response ) {
          var line=response.line;
          var activeUser=response.user;
          var chatsStored = localStorage.getItem("chat_"+window.lindneo.currentBookId);

          var chats = ( chatsStored != null ? JSON.parse(chatsStored) : [] );
          
          chats.push(response) ;
          localStorage.setItem("chat_"+window.lindneo.currentBookId , JSON.stringify(chats));

          window.lindneo.nisga.ChatNewLine( line,activeUser );
        
      });

      this.socket.on('disconnect', function() { 
        //console.log('disconnected');
        if (this.hereACounter++ < 3){
                  //console.log('retrying');
                  tsimshian.connect();
                }else {
                          //console.log('refreshing');
                          location.reload(); 
                }
                
      });

       

       this.socket.on('pagePreviewUpdate', function(pageid){
         window.lindneo.tlingit.loadPagesPreviews(pageid);

       });

       this.socket.on('userListUpdate', function(userList){
         //console.log(userList) ;
         
       });

       this.socket.on('userBookListUpdate', function(bookUserList){
        //console.log('dasdasd');
        var users = "";
        
        $('#onlineUsers').html('');
        if(bookUserList!=""){
                  book_user_list = {book_id: window.lindneo.currentBookId, users: bookUserList};
                }
                //console.log(bookUserList) ;
        window.lindneo.book_users = bookUserList;
         
        $.each( bookUserList, function( key, value ) {
          //console.log(value.username);
          
          window.lindneo.dataservice.send('ProfilePhoto', {'email': value.username}, function( response ) {
                    
                    //console.log(response);
                    var img_src = "";
                    if(response=="") img_src = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSI+PC9yZWN0Pjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+";
                    else img_src =response;
                    $('#onlineUsers').append('<img data-src="holder.js/140x140" class="img-rounded" title="'+value.name+'" src="'+img_src+'" style="width: 40px; height: 40px; margin-right:5px;">');          
                });
          
        });
         
       });
 

  }; 

  return {
    
    connect:connect,
    chatSendMessage:chatSendMessage,
    componentUpdated: componentUpdated,
    changePage: changePage,
    componentDestroyed: componentDestroyed,
    pageDestroyed: pageDestroyed,
    pageCreated: pageCreated,
    componentCreated: componentCreated,
    myComponent: myComponent,
    emitSelectedComponent: emitSelectedComponent,
    serverName: serverName,
    init: init
  };

})( window, jQuery );
