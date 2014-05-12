'use strict';

$(document).ready(function(){
  $.widget('lindneo.tableComponent', $.lindneo.component, {
    
    options: {

    },


    _create: function(){

      var that = this;
      this._super();
      console.log($(this.element));
      $(this.element).resizable('destroy');

      var TableSelection = {};
      console.log(this.options.component);
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
          
          var newColumn = $("<td class='ExcelTableFormationCol col_"+i+"_"+k+"' rel ='"+i+","+k+"'></td>");
          
          
          newColumn
            .appendTo(newRow)
            .text(that.options.component.data.table[i][k].attr.val)
            .css(that.options.component.data.table[i][k].css)
            .resizable({
              'handles': "e, s",
              'start': function (event,ui){
              },
              'stop': function( event, ui ){

                that._cellResize(event, ui,$(this));
              },
              'resize':function(event,ui){
                window.lindneo.toolbox.makeMultiSelectionBox();
              }
            })
            .dblclick(function(e){
              e.stopPropagation();
              console.log(this);
              that.editableCell(this);

          })
          .mousedown(function (e) {
                that._selected(e,null);
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

      
      console.log(this.cells);
      
     newTable.appendTo(this.element);
    
     var parent_OBJ=($(that.element).parent());


     
      parent_OBJ.css('width','auto');
      parent_OBJ.css('height','auto');
      /*
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
  */
  


      newTable.click(function(){
        that.TableSelection = TableSelection;
        that.keyCapturing();
      });     
      this.table.focus();
    },

    _cellResize: function(event,ui,cell,row,column) {
      var row = cell.attr('rel').split(',')[0];
      var column = cell.attr('rel').split(',')[1];
      

      this.options.component.data.table[row][column].css.width = ui.size.width + "px";
      this.options.component.data.table[row][column].css.height = ui.size.height + "px";
   
      this._trigger('update', null, this.options.component );
      this._selected(event, ui);
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
      getSettable : function (one){
        if (typeof one == undefined || one < 1) one = false;
        else one = true;
        //if (typeof this.CellSelection == undefined )
          return this.options.component.data.table[0][0];

        //if (one) return this.CellSelection[0];
        //else
        return this.CellSelection;
      },
      
      selectionDOMCells: function (){
        var that = this;

        var selections_rows=that.tbody.children('tr').slice(TableSelection.start.rows,TableSelection.end.rows+1);
            $.each (selections_rows, function(row_index,row_element){
              var cell_row_index= row_index+TableSelection.start.rows;
              var selections_columns = $(row_element).children('td').slice(TableSelection.start.columns,TableSelection.end.columns+1);
              that.CellSelection.push(selections_columns);
            });

      },

      setPropertyOfCells: function (propertyName,propertyValue,node){


        var that = this;

        if (typeof that.TableSelection == "undefined") return false;

   

    
        



        for (var k=that.TableSelection.start.rows;k<=that.TableSelection.end.rows; k++ ) {
          
          for (var i=that.TableSelection.start.columns;i<=that.TableSelection.end.columns; i++ ) {
            that.options.component.data.table
              [k]
              [i]
              [node]
              [propertyName] = propertyValue;
              
              if( node == 'attr')
                this.cells[k][i].attr(propertyName,propertyValue);
              else if( node == 'css')
                this.cells[k][i].css(propertyName,propertyValue);
          }     

        }

      },

      getPropertyOfCells: function (propertyName,node){
        var that = this;
        if (typeof that.TableSelection == "undefined") return false;
        //console.log(that.TableSelection.start);
        //console.log(that.options.component.data.table);
        //console.log(that.options.component.data.table[that.TableSelection.start.rows]);
        //console.log(that.options.component.data.table[that.TableSelection.start.rows][that.TableSelection.start.columns]);
        if (typeof that.options.component.data.table
          [that.TableSelection.start.rows]
          [that.TableSelection.start.columns]
          [node] == "undefined") return null;

        var propertyValue = that.options.component.data.table
          [that.TableSelection.start.rows]
          [that.TableSelection.start.columns]
          [node]
          [propertyName];
        /*
        console.log(
          that.TableSelection.start.rows + " - " +
           that.TableSelection.start.columns + " - " +
          node + " - " +
          propertyName + " : " + 
          propertyValue
          );
        */
        if ( typeof propertyValue == "undefined") return null;
        return propertyValue;




      },

      setPropertyofObject : function (propertyName,propertyValue){
        var that = this;
        switch (propertyName){
            case 'fast-style': 
                this.setPropertyOfCells(propertyName,propertyValue,'attr')

                  var styles=[];

                  switch (propertyValue){
                    case 'h1':
                    var h1_style="";
                    var data= {
                        'book_id': window.lindneo.currentBookId,
                        'component':propertyValue 
                      };

                    $.ajax({
                      type: "POST",
                      async: false,
                      url: window.lindneo.url+"book/getFastStyle",
                      data: data
                    })
                    .done(function( result ) {
                        result=window.lindneo.tlingit.responseFromJson(result);
                        //console.log(line-height);
                        
                        if(result){
                          //console.log('1');
                          //(condition) ? true-value : false-value
                          styles=[
                          {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '36px'},
                          {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                          {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                          {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'bold'},
                          {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                          {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'capitalize'}
                           ];

                           
                        }
                        else{
                          //console.log('2');
                          styles=[
                          {name:'font-size', val:'36px'},
                          {name:'font-family', val:'Arial'},
                          {name:'text-decoration', val:'normal'},
                          {name:'font-weight', val:'bold'},
                          {name:'text-align', val:'left'},
                          {name:'text-transform', val:'capitalize'},

                           ];
                         };
                    });
                    console.log(styles);
                    break;
                    case 'h2':

                      var h2_style="";
                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '24px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'normal'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'24px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'normal'},
                            {name:'font-weight', val:'normal'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      console.log(styles);
                       break;
                    case 'h3':

                      var h3_style="";
                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '19px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'bold'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'19px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'normal'},
                            {name:'font-weight', val:'bold'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      
                       console.log(styles);
                       break;
                    case 'h4':

                      var h4_style="";
                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '17px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'normal'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'17px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'normal'},
                            {name:'font-weight', val:'bold'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      
                       console.log(styles);
                       break;
                    case 'h5':

                      var h5_style="";
                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '13px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'normal'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'13px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'normal'},
                            {name:'font-weight', val:'bold'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      
                       console.log(styles);
                       break;
                    case 'h6':

                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '10px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'normal'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'10px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'normal'},
                            {name:'font-weight', val:'bold'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      
                       console.log(styles);
                       break;
                    case 'p':

                      var p_style="";
                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '14px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'normal'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'normal'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'14px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'normal'},
                            {name:'font-weight', val:'normal'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      
                       console.log(styles);
                       break;
                    case 'blockqoute':

                      var blockqoute_style="";
                      var data= {
                          'book_id': window.lindneo.currentBookId,
                          'component':propertyValue 
                        };
                      $.ajax({
                        type: "POST",
                        async: false,
                        url: window.lindneo.url+"book/getFastStyle",
                        data: data
                      })
                      .done(function( result ) {
                          result=window.lindneo.tlingit.responseFromJson(result);
                          //console.log(result.font_size);
                          
                          if(result){
                            //console.log('a');
                            //(condition) ? true-value : false-value
                            styles=[
                            {name:'font-size', val:(typeof result.font_size != "undefined") ? result.font_size : '12px'},
                            {name:'font-family', val:(typeof result.font_family != "undefined") ? result.font_family : 'Arial'},
                            {name:'text-decoration', val:(typeof result.text_decoration != "undefined") ? result.text_decoration:'italic'},
                            {name:'font-weight', val:(typeof result.font_weight != "undefined") ? result.font_weight:'normal'},
                            {name:'text-align', val:(typeof result.text_align != "undefined") ? result.text_align:'left'},
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'}

                             ];

                             
                          }
                          else{
                            //console.log('b');
                            styles=[
                            {name:'font-size', val:'12px'},
                            {name:'font-family', val:'Arial'},
                            {name:'text-decoration', val:'italic'},
                            {name:'font-weight', val:'normal'},
                            {name:'text-align', val:'left'},
                            {name:'text-transform', val:'none'},
                             ];
                           };
                      });

                      
                       console.log(styles);
                       break;
                    default: 
                    console.log(styles);
                    
                      break;


                  }
                   $.each( styles , function(i,v) {
                        that.setProperty(v.name , v.val);
                    });


                return this.getPropertyOfCells(propertyName,'attr') ;
                
              break;

            case 'font-size':           
            case 'text-align':           
            case 'font-family':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration':   

                this.setPropertyOfCells(propertyName,propertyValue,'css');
                this.options.component.data.self.css['width']="auto";
                this.options.component.data.self.css['height']="auto";
                
                var return_val;
                return this.getPropertyOfCells(propertyName,'css') ;
              
              break;
            
            default:
              return this._super(propertyName,propertyValue);
              break;
          }
      },
      setProperty : function (propertyName,propertyValue){
        
        console.log(propertyName);
        /*console.log(this.options.component);
        console.log(this.TableSelection.end);
        console.log(this);
        return;
        */
        if(propertyName == 'delete_row')
          this.row_delete(this.options.component, this.TableSelection.end);
        else if(propertyName == 'delete_column')
          this.column_delete(this.options.component, this.TableSelection.end);
        else if(propertyName == 'add_row'){
          console.log("ADDROW BEGIN");
          console.log(this.TableSelection.end);
          console.log("ADDROW END");
          this.row_add(this, this.TableSelection.end);
        }
        else if(propertyName == 'add_column')
          this.column_add(this.options.component, this.TableSelection.end);
        else if(propertyName == 'zindex')
          this._setProperty("zindex-table",propertyValue);
        else
          this._setProperty(propertyName,propertyValue);
        
      },

      row_add: function(this_val, location){
        
        var newCellData = {
          'attr': {
            'val': '',
            'class' : 'tableComponentCell'
          },
         'css' : {
            'width':'100px',
            'height': '30px',            
            'color' : '#000',
            'font-size' : '14px',
            'font-family' : 'Arial',
            'font-weight' : 'normal',
            'font-style' : 'normal',
            'text-decoration' : 'none'
          },
          'format':'standart',
          'function':''
        };
        var component = this_val.options.component;
        var that = this_val;
        var old_cells = this.cells.splice((location.rows +1), (this.cells.length - location.rows -1));
        //return;
        var column_count = component.data.table[0].length;
        var array_last = component.data.table.splice((location.rows +1), (component.data.table.length - location.rows -1)) ;
       
        var new_row = [];
        var rel_row_value=location.rows+1;

        for ( var i = 0; i < column_count; i++ ) {

          new_row.push(newCellData);
          
        }
        //return;
        component.data.table.push(new_row);
        
        $.each( array_last, function( key, value ) {
          component.data.table.push(value);
        });
        
        //window.lindneo.tlingit.componentHasCreated( component );
        window.lindneo.tlingit.componentHasUpdated( component );
        window.lindneo.nisga.destroyComponent(component, component.id);
        window.lindneo.nisga.createComponent(component);


      },

      column_add: function(component, location){
        console.log(location.columns);
        console.log(component.data.table[0][0].css);
        console.log(component);
        //window.lindneo.tlingit.componentHasDeleted( component);
        var newCellData = {
          'attr': {
            'val': '',
            'class' : 'tableComponentCell'
          },
          'css' : '',
          'format':'standart',
          'function':''
        };

        var column_count = component.data.table[0].length;
        $.each( component.data.table, function( key, value ) {
          console.log(value);
          var new_row = [];
          var array_last = component.data.table[key].splice((location.columns +1), (column_count - location.columns -1)) ;
          newCellData.css = component.data.table[key][location.columns].css;
          component.data.table[key].push(newCellData);
          $('.col_'+key+'_'+location.columns).after('<td class="ExcelTableFormationCol ui-resizable active"  style="width: 100px; height: 30px; color: rgb(0, 0, 0); font-size: 14px; font-family: Arial; font-weight: normal; font-style: normal; text-decoration: none;">\
                        <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90; display: block;"></div>\
                        <div class="ui-resizable-handle ui-resizable-s" style="z-index: 90; display: block;"></div>\
                      </td>');
          $.each( array_last, function( key1, value1 ) {
          component.data.table[key].push(value1);
          });
        });
        console.log(component.data.table);
        //window.lindneo.tlingit.componentHasCreated( component );
        window.lindneo.tlingit.componentHasUpdated( component );
        window.lindneo.nisga.destroyComponent(component, component.id);
        window.lindneo.nisga.createComponent(component);
      },

      row_delete: function(component, location){
        /*
        console.log(location);
        console.log(component.data.table[location.rows]);
        window.lindneo.tlingit.componentHasDeleted( component);
        var remove_row = component.data.table[location.rows];

        component.data.table = $.grep(component.data.table, function(value) {
          return value != remove_row;
        });
        console.log(component.data.table);
        window.lindneo.tlingit.componentHasCreated( component );
        */
        var that = component;
        var old_cells = this.cells.splice((location.rows +1), (this.cells.length - location.rows -1));
        //return;
        var column_count = component.data.table[0].length;
        var array_last = component.data.table.splice((location.rows +1), (component.data.table.length - location.rows -1)) ;
        console.log(array_last);
        var rel_row_value=location.rows+1;

        var remove_row = component.data.table[location.rows];

        component.data.table = $.grep(component.data.table, function(value) {
          return value != remove_row;
        });
        console.log(component.data.table);
        $( '.col_'+ location.rows+'_0').parent().remove();

        for ( var i = 0; i < array_last.length ; i++ ) {
          var rel_val= location.rows+i+1;
          var new_rel_val = location.rows+i;
          console.log('rel_Val '+rel_val);
          console.log('new_rel_val '+new_rel_val);
         // for ( var j = 0; j < column_count; j++ ) {
          for ( var j = 0; j < column_count; j++ ) {
            $('.col_'+rel_val+'_'+j).attr('rel',new_rel_val+','+j);
            $('.col_'+rel_val+'_'+j).addClass( 'col_'+new_rel_val+'_'+j );
            $('.col_'+new_rel_val+'_'+j).removeClass( 'col_'+rel_val+'_'+j );
          }
        }
        $.each( array_last, function( key, value ) {
          component.data.table.push(value);
        });
        window.lindneo.tlingit.componentHasUpdated( component );
        window.lindneo.nisga.destroyComponent(component, component.id);
        window.lindneo.nisga.createComponent(component);

      },

      column_delete: function(component, location){
        /*
        console.log(location);
        console.log(component.data.table);
        window.lindneo.tlingit.componentHasDeleted( component);
        $.each( component.data.table, function( key, value ) {
          console.log(key);
          console.log(value);
          var remove_column = value[location.columns];
          component.data.table[key] = $.grep(component.data.table[key], function(value) {
          return value != remove_column;
          });
          console.log(value);
        });
        console.log(component.data.table);
        window.lindneo.tlingit.componentHasCreated( component );
        */
        //var array_last = []
        var column_count = component.data.table[0].length;
        $.each( component.data.table, function( key, value ) {
          console.log(value);
          $( '.col_'+ key+'_'+location.columns).remove();
          var array_last = component.data.table[key].splice((location.columns +1), (column_count - location.columns -1)) ;
          console.log(component.data.table[key]);
          var remove_column = value[location.columns];
          component.data.table[key] = $.grep(component.data.table[key], function(value) {
          return value != remove_column;
          });
          console.log(component.data.table[key]);
          for ( var i = 0; i < array_last.length ; i++ ) {
            var rel_val= location.columns+i+1;
            var new_rel_val = location.columns+i;
            console.log('rel_Val '+rel_val);
            console.log('new_rel_val '+new_rel_val);
           // for ( var j = 0; j < column_count; j++ ) {
            
              $('.col_'+key+'_'+rel_val).attr('rel',key+','+new_rel_val);
              $('.col_'+key+'_'+rel_val).addClass( 'col_'+key+'_'+new_rel_val );
              $('.col_'+key+'_'+new_rel_val).removeClass( 'col_'+key+'_'+rel_val );
            
          }
          $.each( array_last, function( key1, value1 ) {
            component.data.table[key].push(value1);
          });
            
          });
        window.lindneo.tlingit.componentHasUpdated( component );
        window.lindneo.nisga.destroyComponent(component, component.id);
        window.lindneo.nisga.createComponent(component);
      },

      getProperty : function (propertyName){

          switch (propertyName){
            case 'fast-style': 
                var default_val='';
                var return_val=this.getPropertyOfCells(propertyName,'attr');
                return ( return_val ? return_val : default_val );
              break;

            case 'font-size':           
            case 'font-type':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration': 
            case 'text-align':         
            

                switch (propertyName){
                  case 'text-align':
                    var default_val='left';
                    break;
                  case 'font-weight':
                    var default_val='normal';
                    break;
                  case 'font-style':
                    var default_val='normal';
                    break;
                  case 'text-decoration':
                    var default_val='none';
                    break;
                  case 'font-size':
                    var default_val='14px';
                    break;
                  case 'font-type':
                    var default_val='Arial';
                    break;
                  case 'color':
                    var default_val='#000';
                    break;
                }

                var return_val=this.getPropertyOfCells(propertyName,'css');

                return ( return_val ? return_val : default_val );
              
              break;
            
            default:
              return this._super(propertyName);
              break;
          }

      },
    editableCell: function  (cell){

      var that=this;
      that.cellEditing=true;
      console.log(cell);
      console.log(that);
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
      //console.log(that);
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
      //console.log(TableSelection);
      that.TableSelection=TableSelection;
      that.cellEditFinished();

      


      this.tbody.find('td')
        .removeClass('right')
        .removeClass('bottom')
        .removeClass('left')
        .removeClass('top');
            
              var selections_rows=that.tbody.children('tr').slice(TableSelection.start.rows,TableSelection.end.rows+1);
              //console.log(selections_rows);
           

            $.each (selections_rows, function(row_index,row_element){
              var cell_row_index= row_index+TableSelection.start.rows;
              var selections_columns = $(row_element).children('td').slice(TableSelection.start.columns,TableSelection.end.columns+1);
              that.CellSelection = selections_columns;


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
            console.log(this.cells);
            //console.log(this.cells[TableSelection.end.rows][TableSelection.end.columns]);
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
    <i id='table-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i> \
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
                      'width':'100px',
                      'height': '30px',            
                      'color' : '#000',
                      'font-size' : '14px',
                      'font-family' : 'Arial',
                      'font-weight' : 'normal',
                      'font-style' : 'normal',
                      'text-decoration' : 'none'
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
                  'lock':'',
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
            
            console.log(component);
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