'use strict';

window.lindneo = window.lindneo || {};


window.lindneo.toolbox = (function(window, $, undefined){

  var that=this;
  var selectedComponents=[];



  var _create = function () {


  };


  var getClipboardItems = function  (){
    return JSON.parse( localStorage.getItem('clipboard') );
  };
  var setClipboardItems = function (newClipboard){
    return localStorage.setItem('clipboard', JSON.stringify( newClipboard ));
  };

  var selectionUpdated = function (){
      $('.toolbox').hide();
      console.log('All Selecteds:');
      console.log(this.selectedComponents);

      $.each(this.selectedComponents, function( key, component ) {
        //console.log('.toolbox.'+component.options.component.type+'-options, .toolbox.generic-options');
        $('.toolbox.'+component.options.component.type+'-options, .toolbox.generic-options').show();

        $('.toolbox .tool').unbind( "change" );


        $('.toolbox .tool').each(function (index) {
              var rel=$(this).attr('rel');
              console.log  ( rel );
              var relValue = component.getProperty(rel);
              if( relValue != null) { 
                // text select ve color icin
                $(this).not('radio').val(relValue);
                
                //checkbox ve radio icin
                $(this).prop('checked', ( $(this).attr('activeVal') == relValue ? true : false )); 
          

                console.log  ( rel + ' is ' + relValue); 

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
                  console.log($(this).attr('rel')+' is '+ newValue );
                  component.setProperty ( $(this).attr('rel') ,newValue  );

            



                });
               
             }






        });
      });

     
     


  };



  var addComponentToSelection = function (component){
      
      this.selectedComponents.push(component);
      this.selectionUpdated();
  };

  var removeComponentFromSelection = function (component){
      this.selectedComponents=$.grep(this.selectedComponents, function (n,i){
        return (n !== component);  
      });
      this.selectionUpdated();

  };



  var copySelectedItemsToClipboard = function (cut) {

        var newClipboard=[];
        this.setClipboardItems(newClipboard);

        $.each(window.lindneo.toolbox.selectedComponents, function( key, component ) {

          if(cut==true) window.lindneo.nisga.deleteComponent( component.options.component );
          
          var newComponent =JSON.parse(JSON.stringify(component.options.component)); 

          newComponent.id= '';
          newComponent.page_id= '';

          newClipboard.push(newComponent);

        });

        return this.setClipboardItems(newClipboard);
 
  };

  var pasteClipboardItems = function () {
      var oldClipboard = that.getClipboardItems();
      var newClipboard=[];

      $.each(oldClipboard, function( key, component ) {
        component.data.self.css.top = (parseInt(component.data.self.css.top)+25 ) +"px";
        component.data.self.css.left = (parseInt(component.data.self.css.left)+25 ) +"px";

        newClipboard.push(component);

        window.lindneo.tlingit.componentHasCreated( component );
      });
      return that.setClipboardItems(newClipboard);
  }

  var load = function () {
    // creates toolbox
    var that=this;

    $('.toolbox').hide();

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
    pasteClipboardItems: pasteClipboardItems,
    copySelectedItemsToClipboard: copySelectedItemsToClipboard,
    setClipboardItems: setClipboardItems,
    getClipboardItems: getClipboardItems,
    selectionUpdated: selectionUpdated,
    selectedComponents: selectedComponents,
    addComponentToSelection: addComponentToSelection,
    removeComponentFromSelection: removeComponentFromSelection,
    load: load,
    refresh: refresh
  };

})( window, jQuery );