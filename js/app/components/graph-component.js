'use strict';

$(document).ready(function(){
  $.widget('lindneo.graphComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
      //that.resizable_resize = function (){console.log('oldu')};
      this._super();
      this.element[0].width = parseInt(this.options.component.data.self.css.width);
      this.element[0].height = parseInt(this.options.component.data.self.css.height);
      this.element.resizable( "option", "aspectRatio", true );
      

      this.options.context = this.element[0].getContext("2d");


      console.log(this.options.component.data.series)


      switch (this.options.component.data.type) {
        case 'pie-chart':
          
          var pieData = [];
          /*
           var pieData = [
            {
                value : 30,
                color : "#F38630",
                label : 'Sleep',
                labelColor : 'white',
                labelFontSize : '16'
            },
            ...
        ];
          */
          var labels= [];
          $.each(this.options.component.data.series, function(p,value){

            var aRow = {
              'value' : parseInt(value.value),
              'color' : value.color,
              'label' : value.label,
              'labelColor' : '#666',
              'labelAlign': 'right',
              'labelFontSize' : '12'
            };
            var aLabel = {
              'label' : value.label,
              'color' : value.color
            }
            labels.push(aLabel);
           console.log(aLabel);
           console.log(aRow);

            pieData.push(aRow);

          });
          this.options.pieData = pieData;
    
          this.options.pieGraph = new Chart(this.options.context).Pie(this.options.pieData);
          that.resizable_stop = function (width,height){
            that._create();
    
            that.options.pieGraph = new Chart(that.options.context).Pie(that.options.pieData);
          }
          
          break;
        case 'bar-chart':


          var labels= [];
          var serie=[];
          var max_value ;

           
          $.each(this.options.component.data.series.datasets.data, function(p,value){
            if (typeof max_value == "undefined") max_value = parseInt(value.value);
            if (max_value < parseInt(value.value) ) max_value=parseInt(value.value);
            console.log(max_value);
            serie.push( parseInt( value.value) ) ;
            labels.push(value.label);
          });

          var seriesdata = {
                fillColor : "rgba(" + hexToRgb(this.options.component.data.series.colors.background).r + "," +
                            hexToRgb(this.options.component.data.series.colors.background).g + "," +
                            hexToRgb(this.options.component.data.series.colors.background).b + ",0.5)",
                strokeColor : "rgba(" + hexToRgb(this.options.component.data.series.colors.stroke).r + "," +
                            hexToRgb(this.options.component.data.series.colors.stroke).g + "," +
                            hexToRgb(this.options.component.data.series.colors.stroke).b + ",1)",
                data : serie
            };

          var barData = {
             'labels' : labels,
              'datasets' : [seriesdata]
          };
          
          max_value = parseInt(max_value * 1.2);
          var Steppers = max_value.toString().length -2 ;
          if ( Steppers < 0) Steppers = 0;
          
          console.log(Steppers);
          
          max_value = parseInt( parseInt(max_value / Math.pow(10, Steppers) ) * Math.pow(10, Steppers) );





          console.log(max_value);
          this.options.barOptions = {
              //Boolean - If we show the scale above the chart data     
              scaleOverlay : false,
              
              //Boolean - If we want to override with a hard coded scale
              scaleOverride : true,
              
              //** Required if scaleOverride is true **
              //Number - The number of steps in a hard coded scale
              scaleSteps : 5,
              //Number - The value jump in the hard coded scale
              scaleStepWidth : parseInt(max_value/5),
              //Number - The scale starting value
              scaleStartValue : 0,

              //String - Colour of the scale line 
              scaleLineColor : "rgba(0,0,0,.1)",
              
              //Number - Pixel width of the scale line  
              scaleLineWidth : 1,

              //Boolean - Whether to show labels on the scale 
              scaleShowLabels : true,
              
              //Interpolated JS string - can access value
              scaleLabel : "<%=value%>",
              
              //String - Scale label font declaration for the scale label
              scaleFontFamily : "'Arial'",
              
              //Number - Scale label font size in pixels  
              scaleFontSize : 12,
              
              //String - Scale label font weight style  
              scaleFontStyle : "normal",
              
              //String - Scale label font colour  
              scaleFontColor : "#666",  
              
              ///Boolean - Whether grid lines are shown across the chart
              scaleShowGridLines : true,
              
              //String - Colour of the grid lines
              scaleGridLineColor : "rgba(0,0,0,.05)",
              
              //Number - Width of the grid lines
              scaleGridLineWidth : 1, 

              //Boolean - If there is a stroke on each bar  
              barShowStroke : true,
              
              //Number - Pixel width of the bar stroke  
              barStrokeWidth : 2,
              
              //Number - Spacing between each of the X value sets
              barValueSpacing : 5,
              
              //Number - Spacing between data sets within X values
              barDatasetSpacing : 1,
              
              //Boolean - Whether to animate the chart
              animation : true,

              //Number - Number of animation steps
              animationSteps : 60,
              
              //String - Animation easing effect
              animationEasing : "easeOutQuart",

              //Function - Fires when the animation is complete
              onAnimationComplete : null
          
        }
          this.options.barGraph = new Chart(this.options.context).Bar(barData,this.options.barOptions);
          that.resizable_stop = function (width,height){
            console.log(width + " " +height);
            this.element[0].width = parseInt(that.options.component.data.self.css.width);
            this.element[0].height = parseInt(that.options.component.data.self.css.height);
            
            that.options.barGraph = new Chart(that.options.context).Bar(barData,that.options.barOptions);
          }
          break;

        default:

          break;



      }
      
    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});

var get_random_color = function () {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
}
var hexToRgb  = function(hex) {
  console.log(hex);
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

var createGraphComponent = function ( event, ui, oldcomponent ) {

  var newBarRowValueInput;
  var newPieRowValueInput;
  var length_for_update=2;
  var graphTypeLabel;
  var propertyContentBackground;
  var propertyContentStroke;
  var graphDataCountSelect;
  var graphTypeSelect;
  var type_for_update;
  var data_for_update;
  var graph_colors=[];
  var graph_values=[];


  var letters= ["A","B","C","D","E","F","G","H","I","J","K"];
  
  if(typeof oldcomponent == 'undefined'){
    console.log('dene');
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    var graph_value = {};
  }

  var min_left = $("#current_page").offset().left;
  var min_top = $("#current_page").offset().top;
  var max_left = $("#current_page").width() + min_left;
  var max_top = $("#current_page").height() + min_top;
  var window_width = $( window ).width();
  var window_height = $( window ).height();

  if(max_top > window_height) max_top = window_height;
  if(max_left > window_width) max_top = window_width;
  
  var top=(event.pageY - 25);
  var left=(event.pageX-150);

  console.log(top);

  if(left < min_left)
    left = min_left;
  else if(left+310 > max_left)
    left = max_left - 310;

  if(top < min_top)
    top = min_top;
  else if(top+550 > max_top)
    top = max_top - 550;


  top = top + "px";
  left = left + "px";
     var color_for_barchart;

  if(typeof oldcomponent !== 'undefined'){
    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
  };
  
  try
  {
    color_for_barchart=oldcomponent.data.series.colors;
    if(typeof color_for_barchart =='undefined')
      throw true;
  }
  catch(err)
  {
    color_for_barchart=new Object();
    color_for_barchart.background=get_random_color();
    color_for_barchart.stroke=get_random_color();
  }

  var idPre = $.now();
  var chartType = "pie-chart" ;
  var rows = {};

  var size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
  };

  var RowCount ;
  var graphProperties = {
    pie: {},
    bar: {}
  };

  if(typeof oldcomponent !== 'undefined'){
    chartType = oldcomponent.data.type;
  };

  $('<div>').componentBuilder({

    top:top,
    left:left,
    title: j__("Grafik"),
    btnTitle : j__("Ekle"), 
    beforeClose : function () {
      /* Warn about not saved work */
      /* Dont allow if not confirmed */
      return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
    },
    onBtnClick: function(){


      var negativeControl = false;
      var labelControl = false;

      $.each(rows,function(index,item){
        if(item.value<0) {
          negativeControl=true;
          return false;
        }
        if(item.label=="" || typeof item.label == "undefined") {
          labelControl=true;
          return false;
        }
      });
      
      if (negativeControl) {
        alert (j__("Lütfen tüm veriler için pozitif bir tam sayı değeri giriniz."));
        return false;
      }
      if (labelControl) {
        alert (j__("Lütfen tüm veriler için bir etiket değeri giriniz."));
        return false;
      }
      var data = [];
      $.each(rows,function(index,item){
        data.push({
          label:item.label,
          value:item.value,
          color:item.color
        });
      });

      console.log(data);
      


      switch (chartType){
          case "pie-chart":
            var series=data;
          break;
          case "bar-chart":
            var series={
                'colors': { 
                            'background': propertyContentBackground.val(),
                            'stroke': propertyContentStroke.val(),
                          },
                 'datasets' : {
                            'data': data
                 }
                 
          };
          break;
      }



    


      var width = "300px";
      var height ="150px";
      if(typeof oldcomponent !== 'undefined'){

        width = oldcomponent.data.self.css.width;
        height =oldcomponent.data.self.css.height;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
      };   

     var component = {
        'type' : 'grafik',
        'data': {
          'type': chartType,
          'series':  series ,
          'self': { 
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,
              'width': width, 
              'height': height,
              'background-color': 'transparent',
              'overflow': 'visible',
              'z-index': 'first',
              'opacity':'1'
            }
          }
        }
      };

      console.log(oldcomponent);

      if(typeof oldcomponent !== 'undefined'){
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
      };
      window.lindneo.tlingit.componentHasCreated( component );

    },
    onComplete:function (ui){

      var mainDiv = $('<div>')
        .appendTo(ui);

           graphTypeLabel = $('<label>')
            .addClass("dropdown-label")
            .text(j__("Grafik Çeşidi"))
            .appendTo(mainDiv);

            graphTypeSelect = $('<select>')
              .addClass("radius")
              .appendTo(graphTypeLabel);

              var graphTypeOption = $('<option>')
                .attr("value","pie-chart")
                .text(j__("Pasta"))
                .appendTo(graphTypeSelect);

        var graphTypeOption = $('<option>')
                .attr("value","bar-chart")
                .text(j__("Çubuk"))
                .appendTo(graphTypeSelect);
                graphDataCountSelect = $('<select>')
            .addClass("radius")
            .change(function(){

              var RowSize = size(rows);
                console.log(RowSize);
              var that = this;
              var newLenght = $(this).val();
                console.log(newLenght);

              if(RowSize>newLenght){
                console.log('Silme');
                var counter = 0;
                console.log(rows);
                
                $.each(rows, function (index,item){
                  console.log(counter);
                  counter++;
                  if (counter>newLenght){
                        var silinecek = item.elements;
                        silinecek.remove();
                        delete rows[index];
                      }
                });
              }
              else if(RowSize<newLenght){
                for (var counter = RowSize; counter <$(that).val();counter++ ){

                  addNewLine();
                }
              }

            })
            .appendTo(mainDiv);

            var graphTypeOption1 = $('<option>')
              .attr("value","1")
              .text(1)
              .appendTo(graphDataCountSelect);
            var graphTypeOption2 = $('<option>')
              .attr("value","2")
              .attr("selected","selected")
              .text(2)
              .appendTo(graphDataCountSelect);
            var graphTypeOption3 = $('<option>')
              .attr("value","3")
              .text(3)
              .appendTo(graphDataCountSelect);
            var graphTypeOption4 = $('<option>')
              .attr("value","4")
              .text(4)
              .appendTo(graphDataCountSelect);
            var graphTypeOption5 = $('<option>')
              .attr("value","5")
              .text(5)
              .appendTo(graphDataCountSelect);
            var graphTypeOption6 = $('<option>')
              .attr("value","6")
              .text(6)
              .appendTo(graphDataCountSelect);
            var graphTypeOption7 = $('<option>')
              .attr("value","7")
              .text(7)
              .appendTo(graphDataCountSelect);
            var graphTypeOption8 = $('<option>')
              .attr("value","8")
              .text(8)
              .appendTo(graphDataCountSelect);
            var graphTypeOption9 = $('<option>')
              .attr("value","9")
              .text(9)
              .appendTo(graphDataCountSelect);

          var propertyBarDiv = $('<div>')
            .addClass("chart_prop")
            .css("display","none")
            .appendTo(mainDiv);

            var propertyContentDiv = $('<div>')
              .addClass("bar-chart-slice-holder slice-holder")
              .text(j__("Arkaplan Rengi:"))
              .appendTo(propertyBarDiv);

              propertyContentBackground = $('<input type="color">')
                .addClass("color-picker-box radius color")
                .attr('placeholder',"#bbbbbb")
                .change(function(){
                  graphProperties.bar.background=$(this).val();
                })
                .appendTo(propertyContentDiv);

              var propertyContentInput = $('<span>')
                .text(j__("Çizgi Rengi:"))
                .appendTo(propertyContentDiv);   

              propertyContentStroke = $('<input type="color">')
                .addClass("color-picker-box radius color")
                .change(function(){
                  graphProperties.bar.stroke=$(this).val();
                })
                .attr('placeholder',"#bbbbbb")
                .appendTo(propertyContentDiv); 
          
          var propertyPieDiv = $('<div>')
            .addClass("chart_prop pie-chart")
            .css("display","none")
            .appendTo(mainDiv);

          var getNewPieRow = function(item){
            var newPieRow = $('<div>')
                  .addClass("pie-chart-slice-holder slice-holder data-row")
                  .appendTo(propertyPieDiv);


                

                    var newPieRowLabel = $('<span>')
                      .text(j__("Etiket:"))
                      .appendTo(newPieRow);
                   

                    var newPieRowLabelInput = $('<input type="text">')
                      .addClass("chart-textbox-wide radius grey-9 data-label")
                      .val( item.label )
                      .change( function (){
                        item.label = $(this).val()
                      }).appendTo(newPieRow);

                    var newPieRowValue = $('<span>')
                      .text(j__("Değer:"))
                      .appendTo(newPieRow);
                    newPieRowValueInput = $('<input type="text">')
                      .addClass("chart-textbox radius grey-9 value")
                      .val( item.value )
                      .change( function (){
                        item.value = $(this).val()
                      })
                      .appendTo(newPieRow);
                   
                    
                    var newPieRowColorLbl = $('<label>')
                      .text(j__("Renk:"))
                       .appendTo(newPieRow);
                    var newPieRowColor = $('<input type="color">')
                      .addClass("color-picker-box radius color")
                      .val(item.color)
                      .attr("placeholder","e.g. #bbbbbb")
                      .change( function (){
                        item.color = $(this).val()
                      })
                      .appendTo(newPieRowColorLbl);

             return newPieRow;

          };

          var getNewBarRow = function(item){
            var newBarRow = $('<div>')
                .addClass("bar-chart-slice-holder slice-holder data-row")
                .appendTo(propertyBarDiv);

                  var newBarRowLabel = $('<span>')
                      .text(j__("Etiket:"))
                    .appendTo(newBarRow);

                  var newBarRowLabelInput = $('<input type="text">')
                    .addClass("chart-textbox-wide radius grey-9 data-label")
                    .val( item.label )
                    .change( function (){
                        item.label = $(this).val()
                      })
                    .appendTo(newBarRow);

                  var newBarRowValue = $('<span>')
                      .text(j__("Değer:"))
                    .appendTo(newBarRow);

                  newBarRowValueInput = $('<input type="text">')
                    .addClass("chart-textbox-wide radius grey-9 value")
                    .val( item.value )
                    .change( function (){
                        item.value = $(this).val()
                    })
                    .appendTo(newBarRow);

              return newBarRow;

          };

          var addNewLine = function (item){
            if (typeof item == "undefined" )
            var item = {
              value:Math.floor((Math.random()*100)+1),
              label:letters[size(rows)],
              color:get_random_color()
            };
           

            switch (chartType){
              case "pie-chart":
                item.elements = getNewPieRow(item);
              break;
              case "bar-chart":
                item.elements = getNewBarRow(item);
              break;


            }
            rows[$.now()]=item;
           console.log(rows);
          }

        graphTypeSelect.change(function(){


                chartType = $(this).val();
                var newItems = [];

                $.each( rows, function (index,item){
                  newItems.push(
                  {
                    value:item.value,
                    label:item.label,
                    color:item.color
                  });
                  item.elements.remove();
                  delete rows[index];
                });

                $.each(newItems,function (index,item){
                  addNewLine(item);
                });

                switch (chartType){
                  case "pie-chart":
                    ui.find('.chart_prop').hide();
                    propertyPieDiv.show();
                  break;
                  case "bar-chart":
                    ui.find('.chart_prop').hide();
                    propertyBarDiv.show();
                  break;
                }
              })

           
       if(typeof oldcomponent !== 'undefined'){
        var defaultValues ; 
        chartType =oldcomponent.data.type;
        graphTypeSelect.val(chartType);
        graphTypeSelect.change();
        $.each( rows, function (index,item){
                  newItems.push(
                  {
                    value:item.value,
                    label:item.label,
                    color:item.color
                  });
                  item.elements.remove();
                  delete rows[index];
                });
        switch (chartType){
          case "bar-chart":
           defaultValues = oldcomponent.data.series.datasets.data;
           propertyContentBackground.val(oldcomponent.data.series.colors.background);
           propertyContentStroke.val(oldcomponent.data.series.colors.stroke);
          break;
          case "pie-chart":
           defaultValues = oldcomponent.data.series;
          break;
        }

        graphDataCountSelect.val(defaultValues.length);
        
        $.each(defaultValues, function(index,value){
            addNewLine({
                    value:value.value,
                    label:value.label,
                    color:value.color
                  });
        });
      } else {
        graphTypeSelect.val(chartType);
        graphTypeSelect.change();
        graphDataCountSelect.val(2);
        graphDataCountSelect.change();
        propertyContentBackground.val(get_random_color());
        propertyContentStroke.val(get_random_color());
        
      }

      return ;
        
    }

  }).appendTo('body');
};
