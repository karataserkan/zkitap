'use strict';

window.lindneo = window.lindneo || {};


window.lindneo.toolbox = (function(window, $, undefined){

  var that=this;
  var selectedComponents=[];
  var add_value=0;
  var is_copy=0;
  var  findHighestZIndexToSet = function (elem)
  {
    var elems = $(elem);
    var highest = 0;
    
    for (var i = 0; i < elems.length; i++)
    {
      var zindex=document.defaultView.getComputedStyle(elems[i],null).getPropertyValue("z-index");

        
      if ((zindex >= highest) && zindex<9000 && (zindex != 'auto'))
      {
        highest = zindex;
        
      }
    }
    //console.log(highest);
    return parseInt(highest)+1;
  };



  var  findHigherZIndexToSet = function (elem,id)
  {
    var elems = $(elem);
    var eleman= $('#'+id).parent();

    var zindexCompare= parseInt( $(eleman).css('z-index') );
    

    for (var i = 0; i < elems.length; i++)
    {
      var zindex=document.defaultView.getComputedStyle(elems[i],null).getPropertyValue("z-index");
      if (zindex != 'auto' && !(eleman[0] === elems[i]) ){

        zindex=parseInt(zindex);
        //console.log(zindex);

        if (( zindex>= zindexCompare) && zindex<9000)
        {
          //console.log(zindex);
          return parseInt(zindex)+1;
        }
      }
    }
    return parseInt(zindex);
  };

   
  var  findlowerZIndexToSet = function (elem,id)
  {
    var elems = $(elem);
    var eleman= $('#'+id).parent();
    var zindexCompare= parseInt( eleman.css('z-index') );

    for (var i = 0; i < elems.length; i++)
    {
      var zindex=document.defaultView.getComputedStyle(elems[i],null).getPropertyValue("z-index");
      if (zindex != 'auto' && !(eleman[0] === elems[i]) ){

        zindex=parseInt(zindex);
        //console.log(zindex);
        //console.log(zindexCompare);

        if (( zindex<= zindexCompare) && zindex>100)
        {
          return parseInt(zindex)-1;
        }
      }
    }
    return parseInt(zindex);
  };

  var  findlowestZIndexToSet = function (elem)
  {
    var elems = $(elem);
    var lowest = 9999;

    for (var i = 0; i < elems.length; i++)
    {

      var zindex=document.defaultView.getComputedStyle(elems[i],null).getPropertyValue("z-index");

      if ((zindex <= lowest) && zindex>100 &&  (zindex != 'auto'))
      {
        lowest = zindex;
        
      }
    }
    return parseInt(lowest)-1;
  };


  var _create = function () {
    

  };


  var getClipboardItems = function  (){
      //return this.selectedComponents;
      return JSON.parse( localStorage.getItem('clipboard') );
  }; 
  var clearClipboard = function () {
    return localStorage.removeItem('clipboard');
  }

  var setClipboardItems = function (newClipboard){
    return localStorage.setItem('clipboard', JSON.stringify( newClipboard ));
  };

  var selectionUpdated = function (){
      $('.toolbox').hide();
      //console.log('All Selecteds:');
      //console.log(this.selectedComponents);

      $.each(this.selectedComponents, function( key, component ) {
        //console.log('.toolbox.'+component.options.component.type+'-options, .toolbox.generic-options');
        $('.toolbox.'+component.options.component.type+'-options, .toolbox.generic-options').show();

        $('.toolbox .tool').unbind( "change" );
        $('.toolbox-btn').unbind( "click" );


        $('.toolbox .tool, .toolbox-btn').each(function (index) {
              var rel=$(this).attr('rel');
              
              var relValue = component.getProperty(rel);
              //console.log  ( relValue );
              if( relValue != null) { 
                // text select ve color icin
                $(this).not('radio').val(relValue);
                
                //checkbox ve radio icin
                $(this).prop('checked', ( $(this).attr('activeVal') == relValue ? true : false )); 
          

                //console.log  ( rel + ' is ' + relValue); 

              }

             if( $(this).hasClass('color') ){

                $(this).change(function(){
                  component.setProperty ( $(this).attr('rel') , $(this).val() );
                });

             } else if( $(this).hasClass('select') ){
                $(this).change(function(){
                  var str =  $(this).children("option:selected").val();

                  component.setProperty ( $(this).attr('rel') ,str  );
                });

             } else if( $(this).hasClass('checkbox') || $(this).hasClass('radio') ){
                $(this).change(function(){ 

                  var isChecked= $(this).is(':checked')    ; 
                  var newValue = ( isChecked == true ? $(this).attr('activeVal') : $(this).attr('passiveVal') );
                  //console.log($(this).attr('rel')+' is '+ newValue );
                  component.setProperty ( $(this).attr('rel') ,newValue  );

                });
               
             } else if($(this).hasClass('toolbox-btn')){
                $(this).click(function(){
                  component.setProperty ( $(this).attr('rel') ,$(this).attr('action')  );
                });

             }
        });
      });

     
     


  };



  var addComponentToSelection = function (component){
      
    var newObject = jQuery.extend(true, {}, component);

    this.selectedComponents=$.grep(this.selectedComponents, function (n,i){
      return (n.options.component.id !== newObject.options.component.id);  
    });
      
    this.selectedComponents.push(newObject);
    this.selectionUpdated();
        
      
  };

  var removeComponentFromSelection = function (component){
      this.selectedComponents=$.grep(this.selectedComponents, function (n,i){
        return (n.options.component.id !== component.options.component.id);  
      });
      this.selectionUpdated();
      console.log('remove selections....')
      //console.log(selectedComponents);

  };
  
  var deleteComponentFromSelection = function (component){
      this.selectedComponents=[];
      this.selectionUpdated();
      //console.log('delete selections....')
      //console.log(selectedComponents);

  };

  var undoSelectedItemsClipboard = function () {
      //console.log("undooooo");
      window.lindneo.nisga.undoComponent();
 
  };
  
  var redoSelectedItemsClipboard = function () {
      //console.log("undooooo");
      window.lindneo.nisga.redoComponent();
  };

  var lockSelectedItemsToClipboard = function () {
      var newClipboard=[];

      this.clearClipboard();      
      
      $.each(window.lindneo.toolbox.selectedComponents, function( key, component ) {
        console.log(component.options);
        $('#'+component.options.component.id).parent().draggable({ disabled: true });
        $('#'+component.options.component.id).droppable({ disabled: true });
        $('#'+component.options.component.id).selectable({ disabled: true });
        $('#'+component.options.component.id).sortable({ disabled: true });
        $('#'+component.options.component.id).resizable({ disabled: true });
        $('#'+component.options.component.id).attr('readonly','readonly');
        $('#delete-button-'+component.options.component.id).hide();
        if ($.type(component.options.component.data.lock) == "undefined") component.options.component.data.lock='';
        
        console.log(component.options.component);
        component.options.component.data.lock=window.lindneo.user;
        this._trigger('update', null, component.options.component );
        console.log(component.options.component);
        var newComponent =JSON.parse(JSON.stringify(component.options.component)); 
        //console.log(newComponent);
        this._trigger('update', null, component.options.component );
        newComponent.id= '';
        newComponent.page_id= '';
        
        newClipboard.push(newComponent);
      });
        //console.log(newClipboard);
        return this.setClipboardItems(newClipboard);
  };

  var unlockSelectedItemsToClipboard = function () {
      var newClipboard=[];

      this.clearClipboard();
      
      $.each(window.lindneo.toolbox.selectedComponents, function( key, component ) {
        console.log(component.options.component.data);
        if(component.options.component.data.lock!=''){
          if(component.options.component.data.lock.username==window.lindneo.user.username){
            $('#'+component.options.component.id).parent().draggable({ disabled: false });
            $('#'+component.options.component.id).droppable({ disabled: false });
            $('#'+component.options.component.id).selectable({ disabled: false });
            $('#'+component.options.component.id).sortable({ disabled: false });
            $('#'+component.options.component.id).resizable({ disabled: false });
            $('#'+component.options.component.id).removeAttr('readonly');
            component.options.component.data.lock='';
            console.log(component.options.component.data.lock);
            
            var newComponent =JSON.parse(JSON.stringify(component.options.component)); 
            //console.log(newComponent);
            this._trigger('update', null, component.options.component );
            newComponent.id= '';
            newComponent.page_id= '';
            
            newClipboard.push(newComponent);
          }
          else alert('Yetkili değilsiniz....');
        }
      });
        //console.log(newClipboard);
        return this.setClipboardItems(newClipboard);
  };

  var copySelectedItemsToClipboard = function (cut) {

        var newClipboard=[];

        this.clearClipboard();
        
        $.each(window.lindneo.toolbox.selectedComponents, function( key, component ) {
          //console.log(component.options.component);
          if(cut==true) window.lindneo.nisga.deleteComponent( component.options.component );
          
          var newComponent =JSON.parse(JSON.stringify(component.options.component)); 
          //console.log(newComponent);
          
          newComponent.id= '';
          newComponent.page_id= '';
          
          newClipboard.push(newComponent);
          
         
        });
        //console.log(newClipboard);
        return this.setClipboardItems(newClipboard);
 
  };


  var pasteClipboardItems = function () {
      var oldClipboard = this.getClipboardItems();
      var newClipboard=[];

      $.each(oldClipboard, function( key, component ) {
        component.data.self.css.top = (parseInt(component.data.self.css.top)+25 ) +"px";
        component.data.self.css.left = (parseInt(component.data.self.css.left)+25 ) +"px";

        newClipboard.push(component);
        
        window.lindneo.tlingit.componentHasCreated( component );
      });
      return this.setClipboardItems(newClipboard);
  };

  var load = function () {
    // creates toolbox

    var that=this;


     $('.toolbox').hide();
     
    $('#undo').click(function(){
      that.undoSelectedItemsClipboard();
    });
    
    $('#redo').click(function(){
      that.redoSelectedItemsClipboard();
    });
    
    $('#generic-disable').click(function(){
      that.lockSelectedItemsToClipboard();
    });

    $('#generic-undisable').click(function(){
      that.unlockSelectedItemsToClipboard();
    });

    $('#generic-cut').click(function(){
      that.copySelectedItemsToClipboard(true);
    });
 
    $('#generic-copy').click(function(){
      that.copySelectedItemsToClipboard(false);
    });

    $('#generic-paste').click(function(){
      that.pasteClipboardItems();
    });

  };

  var refresh = function ( component ) {

    if( component ) {
      // show only toolbox-items usable for selected component type
      switch( component.type() ) {
        case 'text':
          break;
        default:
          // show all toolbox items
      }
    } else {
      // show all toolbox items
    }
  };

  return {
    findHighestZIndexToSet: findHighestZIndexToSet,
    findHigherZIndexToSet: findHigherZIndexToSet,
    findlowerZIndexToSet: findlowerZIndexToSet,
    findlowestZIndexToSet: findlowestZIndexToSet,
    pasteClipboardItems: pasteClipboardItems,
    copySelectedItemsToClipboard: copySelectedItemsToClipboard,
    lockSelectedItemsToClipboard: lockSelectedItemsToClipboard,
    unlockSelectedItemsToClipboard: unlockSelectedItemsToClipboard,
    clearClipboard: clearClipboard,
    setClipboardItems: setClipboardItems,
    getClipboardItems: getClipboardItems,
    selectionUpdated: selectionUpdated,
    selectedComponents: selectedComponents,
    addComponentToSelection: addComponentToSelection,
    removeComponentFromSelection: removeComponentFromSelection,
    deleteComponentFromSelection: deleteComponentFromSelection,
    undoSelectedItemsClipboard: undoSelectedItemsClipboard,
    redoSelectedItemsClipboard: redoSelectedItemsClipboard,
    load: load,
    refresh: refresh
  };

})( window, jQuery );
