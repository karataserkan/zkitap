'use strict';

$(document).ready(function(){
  $.widget('lindneo.tableComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;

  

      this._super();
      this.element.height(60);
  
    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});



 var createTableComponent = function (event,ui){

  $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Tablo Ekle \
    <div class='popup-close' id='table-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder' id='componentTableSelector'> \
      </div> \
      <div style='clear:both' > </div> \
    </div>").appendTo('body').draggable();

    var newTable = $("<table id='componentTableSelectorTable' class=''></table>");
    var newTbody = $("<tbody></tbody>");
    var TableSelectionDisplay = $("<div class='selections_display'></div>");
    var TableSelection = null;

    newTbody.appendTo(newTable);
    for ( var i = 0; i < 10; i++ ) {
      var newRow = $("<tr></tr>");
      newRow.appendTo(newTbody);
      for ( var k = 0; k < 10; k++ ) { 


        var newColumn = $("<td></td>");
        newColumn.appendTo(newRow);

        newColumn
          .click(function(){
            if (typeof TableSelection === null) return;
            var tableData = [];

              for ( var i = 0; i < TableSelection.rows; i++ ) {
                for ( var k = 0; k < TableSelection.columns; k++ ) { 
                  var newCellData = {
                    'attr': {
                      'val': '',
                      'class' : 'tableComponentCell'
                    },
                   'css' : {
                      'width':'20px',
                      'height': '20px' 
                    },
                    'format':'standart',
                    'function':''
                  };
                  tableData[i] = []
                  tableData[i][k]= newCellData;

                }
              }

            
            var component = {
              'type' : 'table',
              'data': {
                  'table': tableData,
                  'self': {
                    'css': {
                      'position':'absolute',
                      'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                      'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                      'width': 'auto',
                      'height': '60px',
                      'background-color': 'transparent',
                      'overflow': 'visible'
                    }
                  }
                
              }
            };
            

            window.lindneo.tlingit.componentHasCreated( component );
            $("#table-add-dummy-close-button").trigger('click');

                
          })
          .mouseover(function () {


            TableSelection = {
              'rows':$(this).parent().prevAll().length+1,
              'columns':$(this).prevAll().length+1
            };
            $('#componentTableSelectorTable td').removeClass('active');
            var selections_rows=newTbody.children('tr').slice(0,TableSelection.rows);
           
            $.each (selections_rows, function(row_index,row_element){
              var selections_columns = $(row_element).children('td').slice(0,TableSelection.columns);
              
               $.each (selections_columns, function(column_index,cell_element){
                $(cell_element).addClass('active');
               });
            });
            TableSelectionDisplay.text(TableSelection.rows + ' x ' +TableSelection.columns );


         


          })

          ;

      }


    }
    newTable.appendTo('#componentTableSelector');
    TableSelectionDisplay.appendTo('#componentTableSelector');




    $('#table-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });






      

      





  };