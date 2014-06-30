'use strict';

// text component
// jquery ui widget extension
$(document).ready(function(){

  (function(window, $, undefined){

    $.widget( "lindneo.pageComponent", $.lindneo.component, {

      options: {

      },
      
      _create: function() {
        

        var that = this;
        
        this.element.change(function ( ui ){
          that._change( ui );
        });
        //console.log(this.options.component);
        if( this.options.component.data.textarea.val === '' ){
          var page_number = $('.pages li.page.current_page').index()+1;
          this.options.component.data.textarea.val = page_number;
          
        }

        this.element.css('text-align','center');

        this.element.autogrow({element:this});

        this._super();
        this.options.resizableParams['disabled']=true;  
      },

      getSettable : function (){
        return this.options.component.data.textarea;
      },

      setPropertyofObject : function (propertyName,propertyValue){
        var that = this;
        
        switch (propertyName){
            case 'text-align': 
            case 'font-size':           
            case 'font-family':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration':   
            case 'text-justify':   

                this.getSettable().css[propertyName]=propertyValue;
                //console.log(this.getSettable());
                var return_val;
                return this.getProperty(propertyName) ;
              
              break;
            
            default:
              return this._super(propertyName,propertyValue);
              break;
          }
      },
      setProperty : function (propertyName,propertyValue){
        //console.log(propertyName);
        //console.log(propertyValue);
      
        this._setProperty(propertyName,propertyValue);
        //this.autoResize();
      
      },

      getProperty : function (propertyName){

          switch (propertyName){
            case 'fast-style': 
                var default_val='';
                var return_val=this.getSettable().attr[propertyName];
                return ( return_val ? return_val : default_val );
              break;

            case 'font-size':           
            case 'font-type':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration': 
            case 'text-align':
            case 'text-justify':      
            

                switch (propertyName){
                  case 'text-align':
                    var default_val='center';
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
                  case 'text-justify':
                    var default_val='normal';
                    break;
                }

                var return_val=this.getSettable().css[propertyName];

                return ( return_val ? return_val : default_val );
              
              break;
            
            default:
              return this._super(propertyName);
              break;
          }

      },

      _change: function ( ui ) {

        this.options.component.data.textarea.val = $(ui.target).val();

        this._super();
      }

    });
         
  }) (window, jQuery);
  
});


  var createPageComponent = function ( event, ui ,type) {
    var page_number = $('.pages li.page.current_page').index()+1;
    console.log(page_number);

    var component = {
      'type' : 'page',
      'data': {
        'textarea':{
          'css' : {
            'width':'100%',
            'height':'100%',
            'margin': '0',
            'padding': '0px',
            'border': 'none 0px',
            'outline': 'none',
            'color' : '#000',
            'font-size' : '14px',
            'font-family' : 'Arial',
            'font-weight' : 'normal',
            'font-style' : 'normal',
            'text-decoration' : 'none',
            'background-color' : 'transparent',
            'z-index': '1000',
            'overflow': (type == 'text' ? 'visible' : 'hidden' )
          } , 
          'attr': {
            'placeholder': j__("Sayfa Numarası"),
          },
          'val': page_number
        },
        'lock':'',
        'self': {
          'css': {
            'overflow': 'visible',
            'position':'absolute',
            'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
            'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
            'width': '40px',
            'height': '40px',
            'opacity': '1',
            'z-index': 'first'

          },
          'attr' : {
            'fast-style':'',
            'componentType': type
          }
        }
      }
    };

    window.lindneo.tlingit.componentHasCreated(component);
  };