'use strict';

// text component
// jquery ui widget extension
$(document).ready(function(){

  (function(window, $, undefined){

    $.widget( "lindneo.textComponent", $.lindneo.component, {

      options: {

      },
      
      _create: function() {

        if( this.options.component.data.textarea.val === '' ){
          this.options.component.data.textarea.val = '';
        }

        var that = this;
        
        this.element.change(function ( ui ){
          that._change( ui );
        })


        if (this.options.component.data.self.attr.componentType != 'side-text' )this.element.autogrow({element:this});
        else $(this.element).attr('title',j__("Yazı Kutusu Aracı"));
        

        justify_element(this.element[0]);
        
        
        this._super();
          
      },

      autoResize: function(){

          this.element.trigger('focus');
          //console.log("AutoResize");


      },

      getSettable : function (){
        return this.options.component.data.textarea;
      },

      setPropertyofObject : function (propertyName,propertyValue){
        var that = this;
        
        switch (propertyName){
            case 'fast-style': 
                this.getSettable().attr[propertyName]=propertyValue;

                  var styles=[];
                  //console.log(propertyValue);
                  
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
                        console.log(result);
                        
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
                  //console.log(styles);
                  //console.log(that);
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

            case 'text-align':           
                if(propertyValue=='justify'){
                  that.setProperty('text-justify','distribute');
                } else {
                  that.setProperty('text-justify','normal');
                }

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
            case 'text-justify':      
            

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


  var createTextComponent = function ( event, ui ,type) {

    var component = {
      'type' : 'text',
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
             'overflow': (type == 'text' ? 'visible' : 'hidden' )
          } , 
          'attr': {
            'placeholder': j__("Metin Kutusu"),
          },
          'val': ''
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