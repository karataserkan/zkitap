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
        //console.log(this.element);

        console.log(this.options.component);
        
        this.element.focusout(function ( event, ui ){

          var el = event.target;
          // save
          that._change( el.innerHTML);
        })

        var rtextmessage=$('<div  id="message_'+componentrtextid+'" contenteditable="true">'+this.options.component.data.rtextdiv.val+'</div>');
        rtextmessage.appendTo(this.element);
        var capture_selection= function(){
          localStorage.setItem("selection_text", window.getSelection().toString());
          //console.log(localStorage.getItem("selection_text"));
        }
        that.element.mouseup(capture_selection).keyup(capture_selection);
        
        this._super({resizableParams:{handles:"e, s, se"}});
          
      },

      autoResize: function(){

          this.element.trigger('focus');
          //console.log("AutoResize");


      },

      getSettable : function (){
        //console.log(this.options.component.data.rtextdiv);
        return this.options.component.data.rtextdiv;
      },

      setPropertyofObject : function (propertyName,propertyValue){
        var that = this;
        
        //console.log(propertyName);
        //console.log(propertyValue);
        /*
        //console.log(localStorage.getItem("selection_text"));
        var content_text = '<b>'+localStorage.getItem("selection_text")+'</b>';
        
        $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));   
        console.log(this.options.component.data.rtextdiv.val);

        that._change( $('#message_rtext'+this.options.component.id).html());
        //
        return;
        //$( ".rtext-controllers div:contains('asdasdsa')" ).css( "text-decoration", "" );

        */

        switch (propertyName){
          case 'font-weight':

            var content_text = '<span style="font-weight: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            localStorage.setItem("selection_text", '');

          break;

          case 'font-style':

            var content_text = '<span style="font-style: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
             
          break;

          case 'text-decoration':

            var content_text = '<span style="text-decoration: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            //localStorage.setItem("selection_text", '');
             
          break;

          case 'font-size':
            
            var content_text = '<span style="font-size: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            localStorage.setItem("selection_text", '');
             
          break;

          case 'font-family':
            //console.log('deneme');
            var content_text = '<span style="font-family: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            localStorage.setItem("selection_text", '');
             
          break;

          case 'line-height':
            //console.log('deneme');
            var content_text = '<span style="line-height: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            localStorage.setItem("selection_text", '');
             
          break;

          case 'fast-style': 
                //this.getSettable().attr[propertyName]=propertyValue;

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
                  var style = "";
                  if(styles.length > 0)
                    $.each( styles , function(i,v) {
                          style = style + v.name +' : '+ v.val + '; ';
                      });
                  //console.log(style);
                  var content_text = '<span style="'+style+'">'+localStorage.getItem("selection_text")+'</span>';
                  $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
                  that._change( $('#message_rtext'+this.options.component.id).html());
                  localStorage.setItem("selection_text", '');
                
              break;

              default:

                return this._super(propertyName);

              break;

        }
                    
      },
      setProperty : function (propertyName,propertyValue){
        //console.log(propertyName);
        //console.log(propertyValue);
      
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

      _change: function ( content) {
        
        this.options.component.data.rtextdiv.val = content;

        this._super();
      }

    });
         
  }) (window, jQuery);
  
});

var html_tag_replace = function (str){
   //var content = str.replace('&lt;','<')
   //                 .replace('&gt;','>')
   //                 .replace('<div>','')
   //                 .replace('</div>','');
   while( str.indexOf('&lt;') > -1)
      {
        str = str.replace('&lt;', '<');
      }

    while( str.indexOf('&gt;') > -1)
      {
        str = str.replace('&gt;', '>');
      }

    while( str.indexOf('&amp;') > -1)
      {
        str = str.replace('&amp;', '&');
      }

    while( str.indexOf('<div>') > -1)
      {
        str = str.replace('<div>', '');
      }

    while( str.indexOf('</div>') > -1)
      {
        str = str.replace('</div>', '');
      }
      
      
   //console.log(str);
   return str;
};



  var createRtextComponent = function ( event, ui) {
//console.log('eklendi');

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