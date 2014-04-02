'use strict';

// text component
// jquery ui widget extension
$(document).ready(function(){

  (function(window, $, undefined){

    $.widget( "lindneo.rtextComponent", $.lindneo.component, {

      options: {

      },
      
      _create: function() {

        if( this.options.component.data.rtextdiv.val === '' ){
          this.options.component.data.rtextdiv.val = '';
        }
        var componentrtextid='rtext'+this.options.component.id;
        var that = this;
        console.log(this.element);

        
        
        this.element.focusout(function ( event, ui ){
          console.log('deneme');

          var el = event.target;
          // save
          

          that._change( el,  ui);
        })

        var popupmessage=$('<div  id="message_'+componentrtextid+'" contenteditable="true">'+this.options.component.data.rtextdiv.val+'</div>');
        popupmessage.appendTo(this.element);
        
        
        this._super();
          
      },

      autoResize: function(){

          this.element.trigger('focus');
          console.log("AutoResize");


      },

      getSettable : function (){
        //console.log(this.options.component.data.rtextdiv);
        return this.options.component.data.rtextdiv;
      },

      setPropertyofObject : function (propertyName,propertyValue){
        var that = this;
        console.log(propertyName);
        console.log(propertyValue);
        ShowSelection(document.getElementById(that.options.component.id));
              
        return;
        switch (propertyName){
            case 'fast-style': 
                this.getSettable().attr[propertyName]=propertyValue;

                  var styles=[];

                  switch (propertyValue){
                    case 'h1':
                      styles=[
                      {name:'font-size', val:'46px'},
                      {name:'font-family', val:'Arial'},
                      {name:'text-decoration', val:'normal'},
                      {name:'font-weight', val:'bold'},
                      {name:'text-align', val:'left'},
                      {name:'text-transform', val:'capitalize'},

                       ];
                      break;
                    case 'h2':
                      styles=[
                      {name:'font-size', val:'30px'},
                      {name:'font-family', val:'Arial'},
                      {name:'text-decoration', val:'normal'},
                      {name:'font-weight', val:'normal'},
                      {name:'text-align', val:'left'},
                      {name:'text-transform', val:'none'},
                       ];
                       break;
                    case 'h3':
                      styles=[
                      {name:'font-size', val:'14px'},
                      {name:'font-family', val:'Arial'},
                      {name:'text-decoration', val:'normal'},
                      {name:'font-weight', val:'bold'},
                      {name:'text-align', val:'left'},
                      {name:'text-transform', val:'none'},
                       ];
                       break;
                    case 'p':
                      styles=[
                      {name:'font-size', val:'14px'},
                      {name:'font-family', val:'Arial'},
                      {name:'text-decoration', val:'normal'},
                      {name:'font-weight', val:'normal'},
                      {name:'text-align', val:'left'},
                      {name:'text-transform', val:'none'},
                       ];
                       break;
                    case 'blockqoute':
                      styles=[
                      {name:'font-size', val:'12px'},
                      {name:'font-family', val:'Arial'},
                      {name:'text-decoration', val:'italic'},
                      {name:'font-weight', val:'normal'},
                      {name:'text-align', val:'left'},
                      {name:'text-transform', val:'none'},
                       ];
                       break;
                    default: 
                    console.log(styles);
                    
                      break;


                  }
                  console.log(that);
                  if($('#'+this.options.component.id).selection() == ''){
                      $.each( styles , function(i,v) {
                        that.setProperty(v.name , v.val);
                      });
                    }
                    else{
                      var selection_text = $('#'+this.options.component.id).selection();
                      if(propertyValue == 'bold')
                      $('#'+this.options.component.id).selection('replace', {
                          text: selection_text,
                          caret: 'before'
                      });
                    }
                   $.each( styles , function(i,v) {
                        that.setProperty(v.name , v.val);
                    });
                   that.setProperty('contentEditable' , true);

                return this.getProperty(propertyName) ;
                
              break;

            case 'font-size':           
            case 'text-align':           
            case 'font-family':         
            case 'color':
            case 'font-weight':           
            case 'font-style':         
            case 'text-decoration':   

                this.getSettable().css[propertyName]=propertyValue;
                console.log(this.getSettable());
                var return_val;
                return this.getProperty(propertyName) ;
              
              break;
            
            default:
              return this._super(propertyName,propertyValue);
              break;
          }
      },
      setProperty : function (propertyName,propertyValue){
        console.log(propertyName);
        console.log(propertyValue);
      
        this._setProperty(propertyName,propertyValue);
        this.autoResize();
      
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

                var return_val=this.getSettable().css[propertyName];

                return ( return_val ? return_val : default_val );
              
              break;
            
            default:
              return this._super(propertyName);
              break;
          }

      },

      _change: function ( el , ui) {
        
        console.log(el);
        console.log(ui);
        console.log(el.innerHTML);
        this.options.component.data.rtextdiv.val = el.innerHTML;

        this._super();
      }

    });
         
  }) (window, jQuery);
  
});

var ShowSelection = function()
{
  
  var textComponent = document.getElementById('18nYbB5vJlHd3R0VYnzHvTSFvllfAcDESmp4hS5qJ183');
  var selectedText;
  // IE version
  if (document.selection != undefined)
  {
    textComponent.focus();
    var sel = document.selection.createRange();
    selectedText = sel.text;
  }
  // Mozilla version
  else if (textComponent.selectionStart != undefined)
  {
    var startPos = textComponent.selectionStart;
    var endPos = textComponent.selectionEnd;
    selectedText = textComponent.value.substring(startPos, endPos)
  }
  alert("You selected: " + selectedText);
    console.log(selectedText);
    return selectedText;

}


  var createRtextComponent = function ( event, ui) {
console.log('eklendi');

    var component = {
      'type' : 'rtext',
      'data': {
        'rtextdiv':{
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
            'background-color' : 'transparent'
          } , 
          'attr': {
            'placeholder':'Metin Kutusu',
          },
          'val': 'deneme yazıdır....'
        },
        'lock':'',
        'self': {
          'css': {
            'overflow': 'visible',
            'position':'absolute',
            'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
            'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
            'width': '400px',
            'height': '100px',
            'opacity': '1',
            'z-index': '1000'

          },
          'attr' : {
            'fast-style':''
          }
        }
      }
    };

    window.lindneo.tlingit.componentHasCreated(component);
  };