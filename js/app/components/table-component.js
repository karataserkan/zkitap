'use strict';

$(document).ready(function(){
  $.widget('lindneo.tableComponent', $.lindneo.component, {
    
    options: {

    },


    _create: function(){

      var that = this;
      this._super();
      

      var TableSelection = {};

      var newTable = $("<table class='table-component-table'></table>");
      var newTbody = $("<tbody></tbody>");
      
      var tableData =  this.options.component.data.table;
      this.table=newTable;
      this.tbody=newTbody;
      this.cells=[];
      this.excelCursor = $("<div class='ExcelCursor'></div>");


      newTbody.appendTo(newTable);
      var onlyoneselected;
      var isMouseDown=false;
      $(document)
        .mouseup(function () {
          isMouseDown = false;
      });
      var isHighlighted;
      for ( var i = 0; i < tableData.length ; i++ ) {
        this.cells[i]=[];

        var newRow = $("<tr class='ExcelTableFormationRow'></tr>");
        newRow.appendTo(newTbody);

        for ( var k = 0; k< tableData[i].length; k++ ) { 
          
          var newColumn = $("<td class='ExcelTableFormationCol' rel ='"+i+","+k+"'></td>");
          
          
          newColumn
            .appendTo(newRow)
            .text(that.options.component.data.table[i][k].attr.val)
            .dblclick(function(e){
              e.stopPropagation();
              that.editableCell(this);

          })
          .mousedown(function (e) {
                if (e.target.localName == "textarea") return;
                
                isMouseDown=true;
                onlyoneselected = true;
                TableSelection = {
                  'start':{
                    'rows':$(this).parent().prevAll().length,
                    'columns':$(this).prevAll().length
                  },
                  'end':{
                    'rows':$(this).parent().prevAll().length,
                    'columns':$(this).prevAll().length
                  }
                };

                that.selectionUpdated(TableSelection);

                return false; // prevent text selection



              })
              .mouseover(function () {
          


                if (isMouseDown) {
                  onlyoneselected = false;
                  TableSelection.end={
                    'rows':$(this).parent().prevAll().length,
                    'columns':$(this).prevAll().length
                  };
                  that.selectionUpdated(TableSelection);
                  
                  $(this).toggleClass("highlighted", isHighlighted);
                }
              })
              .bind("selectstart", function () {
                return false;
              });


              that.cells[i][k]=newColumn;

        }

      }

      

      
     newTable.appendTo(this.element);
     // $(this.element).parent().resizable('destroy');
     var parent_OBJ=($(that.element).parent());


     
      parent_OBJ.css('width','auto');
      parent_OBJ.css('height','auto');
      
      var width=this.options.component.data.self.css.width;
      var height=this.options.component.data.self.css.height;

      width=width.substring(0,width.length-2);
      height=height.substring(0,height.length-2);

      this.table.attr('width',width);
      this.table.attr('height',height);

      newTable.resizable({
        'stop': function( event, ui ){
          that._resize(event, ui);
        }
      });


      newTable.click(function(){
        that.TableSelection = TableSelection;
        that.keyCapturing();
      });     
      this.table.focus();
    },

    keyCapturing: function (){
      var that = this;
      var TableSelection=that.TableSelection;
        $(document).unbind('keydown');
        $(document).on('keydown', function(ev){
          //left
          if(ev.keyCode === 37) {
            ev.preventDefault();
            TableSelection.start.columns= Math.max(TableSelection.start.columns-1,0);
            TableSelection.end=TableSelection.start;  
            that.selectionUpdated(TableSelection);
          } else 
          //upper
          if(ev.keyCode === 38) {
            ev.preventDefault();
            TableSelection.start.rows= Math.max(TableSelection.start.rows-1,0);
            TableSelection.end=TableSelection.start;  
            that.selectionUpdated(TableSelection);
          } else 
          // right
          if(ev.keyCode === 39) {
            ev.preventDefault();
            TableSelection.start.columns= Math.min(TableSelection.start.columns+1,that.options.component.data.table[TableSelection.start.rows].length-1);
            TableSelection.end=TableSelection.start;  
            that.selectionUpdated(TableSelection);
          } else 
          // down
          if(ev.keyCode === 40) {
              ev.preventDefault();
              TableSelection.start.rows= Math.min(TableSelection.start.rows+1,that.options.component.data.table.length-1);
              TableSelection.end=TableSelection.start;  
              that.selectionUpdated(TableSelection);
          }
          else 
            //typing
          {
            console.log(that.cellEditing );
            if(that.cellEditing != true){
              that.editableCell(that.cells[TableSelection.start.rows][TableSelection.start.columns]);
              $(document).unbind('keydown');
            }
          }
          
        });
    },

    editableCell: function  (cell){

      var that=this;
      that.cellEditing=true;

      var cell=$(cell);
      var value=that.options.component.data.table[$(cell).parent().prevAll().length][$(cell).prevAll().length].attr.val;

      var input = $("<textarea class='activeCellInput' style='width:100%;height:100%;padding:0px' ></textarea> ");
      cell
        .text('')
        ;




      that.cellEditFinished();
      that.activeCellInput=input;
      that.activeCell=cell;
    

      input
        .text(value)
        .autogrow({element:this})
        .appendTo(cell)
        .focus(function(){
          this.focus();this.select()
        })
        .focus()
        .keydown(function(e){
          console.log(e.keyCode);
          if(e.keyCode >= 37 && e.keyCode <= 40 ) {
            e.preventDefault();
            $(this).blur();
          } else if (e.keyCode == 9 ) {
            e.preventDefault();
          }
        })
        .focusout(function(){
          that.keyCapturing();
          that.cellEditFinished();
        });
        
    },

    cellEditFinished:function(){
      var that = this;
      that.cellEditing=false;

      var cell = that.activeCell
      var input = that.activeCellInput
      if (typeof input == "undefined") return;
      if (input.length == 0) return;
      that.options.component.data.table[$(cell).parent().prevAll().length][$(cell).prevAll().length].attr.val=input.val();
      cell.html(input.val().replace(/\n/g, '<br />'));
      that.keyCapturing();
      

      that._trigger('update', null, that.options.component );
    },

    selectionUpdated: function(selection){
      var that = this;
      
      var TableSelection = {
          'start':{
                    'rows':Math.min(selection.start.rows,selection.end.rows ),
                    'columns':Math.min(selection.start.columns,selection.end.columns )
          },
          'end':{
                    'rows':Math.max(selection.start.rows,selection.end.rows) ,
                    'columns':Math.max(selection.start.columns,selection.end.columns )
          }
      }
      that.TableSelection=TableSelection;
      that.cellEditFinished();

      


      this.tbody.find('td')
        .removeClass('right')
        .removeClass('bottom')
        .removeClass('left')
        .removeClass('top');
            
              var selections_rows=that.tbody.children('tr').slice(TableSelection.start.rows,TableSelection.end.rows+1);

           

            $.each (selections_rows, function(row_index,row_element){
              var cell_row_index= row_index+TableSelection.start.rows;
              var selections_columns = $(row_element).children('td').slice(TableSelection.start.columns,TableSelection.end.columns+1);
              

               $.each (selections_columns, function(column_index,cell_element){
                var cell_column_index=column_index+TableSelection.start.columns;
                //top lines
                
                if (cell_row_index==TableSelection.start.rows)                
                  $(cell_element).addClass('top');
                //left lines
                if (cell_column_index==TableSelection.start.columns)                
                  $(cell_element).addClass('left');
                //right lines
                if (cell_column_index==TableSelection.end.columns)                
                  $(cell_element).addClass('right');
                //bottom lines
                if (cell_row_index==TableSelection.end.rows)                
                  $(cell_element).addClass('bottom');
           
                $(cell_element).addClass('active');
               });


            });

            //add excel cursor
            
            this.excelCursor.remove();
            //this.excelCursor.dblclick(function(){$(this).parent().dblclick();});

            this.cells[TableSelection.end.rows][TableSelection.end.columns].prepend( this.excelCursor );





            
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
                tableData[i] = [];
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
                      'width': '100%',
                      'height': '100%',
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