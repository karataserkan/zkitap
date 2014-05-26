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

console.log(top);

    top = top + "px";
    left = left + "px";

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + top + "; left: " + left + ";'> \
        <div class='popup-header'> \
        <i class='icon-m-charts'></i> &nbsp;"+j__("Grafik Ekle")+" \
        <i id='graph-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i>\
		</div> \
          <div class='gallery-inner-holder'> \
            <div class='gallery-inner-holder'> \
         \
          <label class='dropdown-label' id='graph_leading'> \
                  Grafik Çeşidi:  \
                    <select id='Graph Type' class='radius'> \
                      <option value='pie-chart'> "+j__("Pasta")+"</option> \
                      <option value='bar-chart' >"+j__("Çubuk")+"</option> \
                    </select>  \
          </label> \
          <select id='verisayisi' class='radius'> \
                      <option value='1' >1</option> \
                      <option value='2' selected='selected' >2</option> \
                      <option value='3' >3</option> \
                      <option value='4' >4</option> \
                      <option value='5' >5</option> \
                      <option value='6' >6</option> \
                      <option value='7' >7</option> \
                      <option value='8' >8</option> \
                      <option value='9' >9</option> \
                    </select>  \
            <div id='bar-chart-properties' class='chart_prop bar-chart' style='display:none;'> \
              <div class='bar-chart-slice-holder slice-holder'> \
                "+j__("Arkaplan Rengi")+":  \
                <input type='color'  id='chart-bar-background' class='color-picker-box radius color' value='"+get_random_color()+"' placeholder='#bbbbbb'> <br> \
                Çubuk Rengi:  \
                 <input type='color' id='chart-bar-stroke' class='color-picker-box radius color' value='"+get_random_color()+"' placeholder='#bbbbbb'> <br> \
              </div> \
          </div> \
          <div id='pie-chart-properties' class='chart_prop pie-chart'> \
          </div> \
               \
          <a href='#' class='btn btn-info  ' id='pop-image-OK' style='padding: 5px 30px;'>"+j__("Ekle")+"</a> \
          </div> \
          </div> \
        </div>").appendTo('body').draggable();

      $('#graph-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });

      $('#verisayisi').change(function(){
    var str = "";
    $( "#verisayisi option:selected" ).each(function() {
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
      
          var newPieRow= $("<div class='pie-chart-slice-holder slice-holder data-row'> \
                      "+(i+1)+". "+j__("Dilim")+" <br> \
                      %<input type='text' class='chart-textbox radius grey-9 percent' value='"+Math.floor((Math.random()*100)+1)+"'><br> \
                      "+j__("Etiket")+"<input type='text' class='chart-textbox-wide radius grey-9 label' value='"+letters[i]+"'> \
                      <input type='color' class='color-picker-box radius color' value='"+ get_random_color()+"' placeholder='e.g. #bbbbbb'> \
              </div> \
              ");
         var newBarRow= $("<div class='bar-chart-slice-holder slice-holder data-row'> \
             "+(i+1)+". "+j__("sütun adı")+": \
            <input type='text' class='chart-textbox-wide radius grey-9 label ' value='"+letters[i]+"'><br> \
             "+(i+1)+". "+j__("sütun değeri")+":  \
            <input type='text' class='chart-textbox-wide radius grey-9 value ' value='"+Math.floor((Math.random()*100)+1)+"'><br> \
          </div> \
                ");
          newBarRow.appendTo( $('#bar-chart-properties') );
          newPieRow.appendTo( $('#pie-chart-properties') );
      
          }
        }
      });  

      $('#verisayisi').change();

      $('#graph_leading').change(function(){
        var str = "";
        $( "#graph_leading option:selected" ).each(function() {
          str += $( this ).val() + " ";
        });
        $('.chart_prop').hide();
        $('.chart_prop.' + str ).show();
      });

      console.log(oldcomponent);
  
  $('#pop-image-OK').click(function (){        
    if(typeof oldcomponent == 'undefined'){
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
    };

      var str ='';
      $( "#graph_leading option:selected" ).each(function() {
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
                      'background': $('#chart-bar-background').val(),
                      'stroke': $('#chart-bar-stroke').val(),
                    },
           'datasets' : {
                      'data': seriesdata
           }
           
        };

      }

      var graphType='';

      $( "#graph_leading option:selected" ).each(function() {
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
                'zindex': 'first'
              }
            }
          }
        };
        
         window.lindneo.tlingit.componentHasCreated( component );
        
        $("#graph-add-dummy-close-button").trigger('click');

    });


  };