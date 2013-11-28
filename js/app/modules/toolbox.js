'use strict';

window.lindneo = window.lindneo || {};


window.lindneo.toolbox = (function(window, $, undefined){

  var that=this;
  var selectedComponents=[];


  var _create = function () {


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




  var load = function () {
    // creates toolbox
     $('.toolbox').hide();
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
    selectionUpdated: selectionUpdated,
    selectedComponents: selectedComponents,
    addComponentToSelection: addComponentToSelection,
    removeComponentFromSelection: removeComponentFromSelection,
    load: load,
    refresh: refresh
  };

})( window, jQuery );