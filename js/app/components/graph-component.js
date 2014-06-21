'use strict';

$(document).ready(function(){
  $.widget('lindneo.graphComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
      this._super();
      
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
              'color' : value.color
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
          
          break;
        case 'bar-chart':


          var labels= [];
          var serie=[];

           
          $.each(this.options.component.data.series.datasets.data, function(p,value){
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
          console.log(barData);
          this.options.barOptions = {
                
          //Boolean - If we show the scale above the chart data     
          scaleOverlay : false,
          
          //Boolean - If we want to override with a hard coded scale
          scaleOverride : false,
          
          //** Required if scaleOverride is true **
          //Number - The number of steps in a hard coded scale
          scaleSteps : 1,
          //Number - The value jump in the hard coded scale
          scaleStepWidth : 1,
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

  if(typeof oldcomponent == 'undefined'){
    console.log('dene');
    var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
    var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    var graph_value = {};
  }
  else{

    top = oldcomponent.data.self.css.top;
    left = oldcomponent.data.self.css.left;
  };
  
    var letters= ["A","B","C","D","E","F","G","H","I","J","K"];
  
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

      var str ='';
      graphTypeLabel.find("option:selected").each(function() {
      str += $( this ).val() + "";
      });

     
      if(str=='pie-chart'){
       var valueables=[];


      $('.pie-chart-slice-holder').each(function(){
        if( typeof( $(this).find('.percent').val() ) != "undefined" ){

          var newPie = { 
            'color': $(this).find('.color').val(),
            'label': $(this).find('.label').val(),
            'value' : $(this).find('.percent').val()
          };
          valueables.push(newPie);

        }

      });
     
    }

    if(str=='bar-chart'){
      var seriesdata=[]
      $('.bar-chart-slice-holder').each(function(){
        if( typeof( $(this).find('.value').val() ) != "undefined" ){

          var newBar = { 
            'label': $(this).find('.label').val(),
            'value' : $(this).find('.value').val()
          };
          seriesdata.push(newBar);

        }


      });

     var valueables={
        'colors': { 
                    'background': propertyContentBackground.val(),
                    'stroke': propertyContentStroke.val(),
                  },
         'datasets' : {
                    'data': seriesdata
         }
         
      };

    }

    var graphType='';

    graphTypeLabel.find("option:selected").each(function() {
    graphType += $( this ).val() + "";
    });

     var  component = {
        'type' : 'grafik',
        'data': {
          'type': graphType,
          'series':  valueables ,
          'self': { 
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,
              'width': '300px', 
              'height': '150px',
              'background-color': 'transparent',
              'overflow': 'visible',
              'z-index': 'first',
              'opacity':'1'
            }
          }
        }
      };
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
              .change(function(){
                var str = "";
                var chart;
                var selected_item = graphTypeLabel.find("option:selected").val();
                var list_bar_chart=$("."+selected_item+"-slice-holder").find('.value');
                var list_pie_chart=$("."+selected_item+"-slice-holder").find('.percent');
        /*        chart=(list_bar_chart.length==0?list_pie_chart:list_bar_chart);
                chart=(list_pie_chart.length==0?list_bar_chart:list_pie_chart);*/
                if(list_bar_chart.length==0){
                  chart=list_pie_chart;
                }
                else
                {
                  chart=list_bar_chart; 
                }
                console.log(list_bar_chart);
                console.log(list_pie_chart);
                console.log(chart);
                for (var i = 0; i < chart.length; i++) {
                  if(selected_item=='bar-chart')
                  {
                    //$("#"+selected_item+"-"+i).val($('#pie-chart-'+i).val());
                    newBarRowValueInput.val(newPieRowValueInput.val());
                    
                  }
                  else
                  {
                    //$("#"+selected_item+"-"+i).val($('#bar-chart-'+i).val());
                    newPieRowValueInput.val(newBarRowValueInput.val());       
                  }
                }
                graphTypeLabel.find("option:selected").each(function() {
                  str += $( this ).val() + " ";
                  
                });
                $('.chart_prop').hide();
                console.log(str);
                $('.chart_prop.' + str ).show();
              })
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
              console.log("de");
              var str = "";
              graphDataCountSelect.find("option:selected" ).each(function() {
                str += $( this ).val() + " ";
              });
              var newlenght=parseInt(str);
              var current= $( '.chart_prop').first().children('.data-row').length;

              console.log(newlenght );
              console.log(current );

              if ( current  > newlenght ) {
                console.log ((current  - newlenght) + 'Silinecek');

                $('.chart_prop').each (function () {
                  $(this).children('.data-row').each(function (index) {
                    if(index > newlenght -1 ){
                      $(this).remove();     
                    }
                  });
                });

              } else 
              if ( current  < newlenght ) {
               
              console.log ((newlenght - current) +  ' tane Eklenecek ');
              for (var i= current ;i <  newlenght; i++){
              /*
                  var newPieRow= $("<div class='pie-chart-slice-holder slice-holder data-row'> \
                              "+(i+1)+". "+j__("Dilim")+" <br> \
                              "+j__("Değer")+":<input type='text' id='"+"pie-chart-"+i+"'class='chart-textbox radius grey-9 percent' value='"+(graph_values[i] != undefined ? graph_values[i]:(Math.floor((Math.random()*100)+1)))+"'><br> \
                              "+j__("Etiket")+"<input type='text' class='chart-textbox-wide radius grey-9 label' value='"+letters[i]+"'> \
                              <input type='color' class='color-picker-box radius color' value='"+ (graph_colors[i] != undefined ? graph_colors[i]:get_random_color())+"' placeholder='e.g. #bbbbbb'> \
                      </div> \
                      ");
                 var newBarRow= $("<div class='bar-chart-slice-holder slice-holder data-row'> \
                     "+(i+1)+". "+j__("sütun adı")+": \
                    <input type='text' class='chart-textbox-wide radius grey-9 label ' value='"+letters[i]+"'><br> \
                     "+(i+1)+". "+j__("sütun değeri")+":  \
                    <input type='text' id='"+"bar-chart-"+i+"' class='chart-textbox-wide radius grey-9 value ' value='"+(graph_values[i] != undefined ? graph_values[i]:Math.floor((Math.random()*100)+1))+"'><br> \
                  </div> \
                        ");
                 */
                 var newPieRow = $('<div>')
                  .addClass("pie-chart-slice-holder slice-holder data-row")
                  .text((i+1)+". "+j__("Dilim"))
                  .appendTo(propertyPieDiv);

                  $("<br>").appendTo(newPieRow);

                  var newPieRowValue = $('<span>')
                    .text(j__("Değer"))
                    .appendTo(newPieRow);

                  newPieRowValueInput = $('<input type="text">')
                    .addClass("chart-textbox radius grey-9 percent")
                    .attr("value",(graph_values[i] != undefined ? graph_values[i]:(Math.floor((Math.random()*100)+1))))
                    .appendTo(newPieRow);
                  $("<br>").appendTo(newPieRow);

                  var newPieRowLabel = $('<span>')
                    .text(j__("Etiket"))
                    .appendTo(newPieRow);

                  var newPieRowLabelInput = $('<input type="text">')
                    .addClass("chart-textbox-wide radius grey-9 label")
                    .attr("value",letters[i])
                    .appendTo(newPieRow);

                  var newPieRowColor = $('<input type="color">')
                    .addClass("color-picker-box radius color")
                    .val((graph_colors[i] != undefined ? graph_colors[i]:get_random_color()))
                    .attr("placeholder","e.g. #bbbbbb")
                    .appendTo(newPieRow);

                var newBarRow = $('<div>')
                .addClass("bar-chart-slice-holder slice-holder data-row")
                .appendTo(propertyDiv);

                  $("<br>").appendTo(newBarRow);

                  var newBarRowLabel = $('<span>')
                    .text((i+1)+". "+j__("sütun adı"))
                    .appendTo(newBarRow);

                  var newBarRowLabelInput = $('<input type="text">')
                    .addClass("chart-textbox-wide radius grey-9 label")
                    .attr("value",letters[i])
                    .appendTo(newBarRow);

                  $("<br>").appendTo(newBarRow);

                  var newBarRowValue = $('<span>')
                    .text((i+1)+". "+j__("sütun değeri"))
                    .appendTo(newBarRow);

                  newBarRowValueInput = $('<input type="text">')
                    .addClass("chart-textbox-wide radius grey-9 value")
                    .attr("value",(graph_values[i] != undefined ? graph_values[i]:Math.floor((Math.random()*100)+1)))
                    .appendTo(newBarRow);

                  
                  //newBarRow.appendTo( propertyDiv );
                  //newPieRow.appendTo( propertyPieDiv );
              
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

          var propertyDiv = $('<div>')
            .addClass("chart_prop bar-chart")
            .css("display","none")
            .appendTo(mainDiv);

            var propertyContentDiv = $('<div>')
              .addClass("bar-chart-slice-holder slice-holder")
              .text(j__("Arkaplan Rengi"))
              .appendTo(propertyDiv);

              propertyContentBackground = $('<input type="color">')
                .addClass("color-picker-box radius color")
                .val(color_for_barchart.background)
                .attr('placeholder',"#bbbbbb")
                .appendTo(propertyContentDiv);

              var propertyContentInput = $('<div>')
                .text(j__("Arkaplan Rengi"))
                .appendTo(propertyContentDiv);   

              propertyContentStroke = $('<input type="color">')
                .addClass("color-picker-box radius color")
                .val(color_for_barchart.stroke)
                .attr('placeholder',"#bbbbbb")
                .appendTo(propertyContentDiv); 
          
          var propertyPieDiv = $('<div>')
            .addClass("chart_prop pie-chart")
            .css("display","none")
            .appendTo(mainDiv);

      

      if(typeof oldcomponent !== 'undefined'){
        type_for_update=oldcomponent.data.type;
        length_for_update=(type_for_update=='bar-chart'?oldcomponent.data.series.datasets.data.length:oldcomponent.data.series.length);
        console.log("update");
        console.log(oldcomponent.data);
        console.log(length_for_update);

        console.log(graphDataCountSelect);
        console.log(graphTypeSelect);
        
        graphDataCountSelect.val(length_for_update);
        graphTypeSelect.val(type_for_update);
        
        var bar_chart_data;
        try{
            bar_chart_data=oldcomponent.data.series.datasets.data==undefined?oldcomponent.data.series:oldcomponent.data.series.datasets.data;
          }
          catch(err)
          {
            bar_chart_data=oldcomponent.data.series;
          }
        data_for_update=(type_for_update=='bar-chart'?bar_chart_data:oldcomponent.data.series);

        for(var data_key in data_for_update){
          if((data_for_update[data_key]).color!='undefined')
              graph_colors.push((data_for_update[data_key]).color);
              console.log(data_for_update[data_key]);
              graph_values.push((data_for_update[data_key]).value);
        }
        console.log(graph_colors);
        console.log(graph_values);

        graphTypeSelect.val(type_for_update);
        graphTypeSelect.change();
        graphDataCountSelect.change();

        if(oldcomponent.data.type == "pie-chart")
          propertyPieDiv.show();
        else if(oldcomponent.data.type == "pie-chart")
          propertyDiv.show();
      }
      else{
        graphDataCountSelect.change();
        graphTypeSelect.change();
        propertyPieDiv.show();
      }
    }

  }).appendTo('body');
};