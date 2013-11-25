'use strict';

$(document).ready(function(){
  $.widget('lindneo.galeryComponent', $.lindneo.component, {
    
    options: {
      slideDur : 2000,
      fadeDur : 800 ,
      slideSelector : 'li', // selector for target elements
     
    }


    
    , 

    _create: function(){

     
     
      

      this._super();
      var that = this;

      //if( that.options.component.type=='galery')

      if( that.options.component.data.ul.imgs ) {
        var counter=0;
        var ul=$('<ul></ul>');
        console.log(that);  
        $.each (that.options.component.data.ul.imgs , function (index,value) {
          if(  value.src ) {
            counter++;
            var image= $('<img class="galery_component_image" style="display: block; margin: auto; min-width: 50%; min-height: 50%; " src="'+value.src+ '" />'); 
            var container=$('<li class="galery_component_li" style="float:left; position: absolute; width: 200%; height: 200%; left: -50%;'+ (counter==1 ? ''  : 'display:none;')+ '" ></li>');
            image.appendTo(container);
           
            container.appendTo(ul);
              
            


           
            //$(that).html(image);   
          }       
        });
        ul.addClass('galery_component_ul');
        that.element.parent().addClass('galery_component_wrap');
        ul.appendTo(that.element);
       // that.element.find('li').hide();
        that.element.first().show();

        $('<div style="clear:both"></div>').appendTo(that.element);

      }
    },


    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});