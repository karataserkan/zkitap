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

        var rtextmessage=$('<div  id="message_'+componentrtextid+'" contenteditable="true" style="width100%; height:100%; overflow:hidden;">'+this.options.component.data.rtextdiv.val+'</div>');
        rtextmessage.appendTo(this.element);
        var capture_selection= function(){
          localStorage.setItem("selection_text", window.getSelection().toString());
          //console.log(localStorage.getItem("selection_text"));
        }
        that.element.mouseup(capture_selection).keyup(capture_selection);


        justify_element(this.element[0]);
        that.element.on('focusout mouseup',function(event){
           
            

          justify_element(that.element[0]);
       
        });

        /*
        var keydownonTimeout;
        that.element.on('keydownz' ,function(event){

          if (event.keyCode<40) return;


          clearTimeout(keydownonTimeout);

            var sel = window.getSelection();
            var currentSel=sel.baseNode.parentElement;
            var currentpos=sel.focusOffset;
            

             keydownonTimeout=setTimeout(function(){ 
            
            console.log(sel);

            if(currentpos==0) return;
            
            var range = document.createRange();
            range.collapse(true);
            
            justify_element(that.element[0]);
            try{
               range.setStart(that.element[0], currentpos);
              }
            catch(e){
              range.setStart(that.element[0], that.element.text().length-1);
              
            }
            
          }, 1000);


        });
        */
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
        //return;
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
          case 'color':

            var content_text = '<span style="color: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            //localStorage.setItem("selection_text", '');

          break;
          case 'font-weight':

            var content_text = '<span style="font-weight: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            //localStorage.setItem("selection_text", '');

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
            //localStorage.setItem("selection_text", '');
             
          break;

          case 'font-family':
            //console.log('deneme');
            var content_text = '<span style="font-family: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            //localStorage.setItem("selection_text", '');
             
          break;

          case 'line-height':
            //console.log('deneme');
            var content_text = '<span style="line-height: '+propertyValue+';">'+localStorage.getItem("selection_text")+'</span>';
            $('#message_rtext'+this.options.component.id).html(this.options.component.data.rtextdiv.val.replace(localStorage.getItem("selection_text"), content_text));  
            that._change( $('#message_rtext'+this.options.component.id).html());
            //localStorage.setItem("selection_text", '');
             
          break;

          case 'fast-style': 
                //this.getSettable().attr[propertyName]=propertyValue;

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
                          {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'capitalize'},
                          {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}
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
                          {name:'line-height', val:'100%'}

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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
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
                            {name:'text-transform', val:(typeof result.text_transform != "undefined") ? result.text_transform :'none'},
                            {name:'line-height', val:(typeof result.line_height != "undefined") ? result.line_height+'%' :'100%'}

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
                            {name:'line-height', val:'100%'}
                             ];
                           };
                      });

                      
                       console.log(styles);
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
                  //localStorage.setItem("selection_text", '');
                
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