'use strict';

$(document).ready(function(){
  $.widget('lindneo.quizComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
    




        // open a window
        $("<div  class='quiz-component' style=''> \
            <div class='question-text'></div> \
            <div class='question-options-container'></div> \
            <div style='margin-bottom:25px'> \
              <a href='' class='btn bck-light-green white radius send' > Yanıtla </a> \
            </div> \
        </div>").appendTo(this.element);

        // set question text
        console.log(this.element);
        this.element.find('.question-text').text( that.options.component.data.question );
        var n = that.options.component.data.numberOfSelections;

        var appendText = "";
        for( var i = 0; i < n; i++ ){
          appendText += 
          "<div> \
            <input type='radio' value='" + i + "' name='question' /> \
            "+ that.options.component.data.options[i] + " \
          </div>";
        }


        this.element.find('.question-options-container').append(appendText);
        var that = this;
        
        // prepare question options

        // click event
        this.element.find('.send').click(function(evt){

          var ind = $('input[type=radio]:checked').val();
          
          if( ind === undefined ){
            alert('secilmemis');
          } else {
            var answer = {
              'selected-index': ind,
              'selected-option': that.options.component.data.options[ind]
            };

            
            that.element.find('.question-options-container div').each(function(i,element){
              var color = 'red';
              if (i==that.options.component.data.correctAnswerIndex) color ='green';
              var newAnserBtn=$("<span style='border-radius: 50%;width:10px;height:10px;display: inline-block;background:"+color+"'></span>");
              $(this).find('input[type=radio]').remove();
              $(this).prepend(newAnserBtn);
              if (ind==i && that.options.component.data.correctAnswerIndex==ind){
                that.element.css('background','color');
                $(this).prepend('+');
              } else if (ind==i && that.options.component.data.correctAnswerIndex!=ind){
                that.element.css('background','color');
                $(this).prepend('x');
              }

              $(this).css('color',color);
            }); 

          }


        });


      

      this._super();
    },

    field: function(key, value){
      
      this._super();

      // set
      this.options.component[key] = value;

    }
    
  });
});


  var createQuizComponent = function ( event, ui, oldcomponent ) {

    // when option count change, reorganize options according to that value
    // warning! previouse option texts will be deleted.
    
    $('#leading-option-count').change(function(e){
      var n = $(this).val();
      $('#selection-options-container').empty();
      $('#leading-answer-selection').empty();
      var appendedText = "";    
      var appendAnswerText = "";
      for(var i = 0; i < parseInt(n); i++ ){
        appendedText +=  (i + 1) + ". seçenek <textarea class='popup-choices-area' id='selection-option-index-" + i + "'></textarea> <br>";
        appendAnswerText += (i === 0) ? "<option selected value='" + ( i + 1 ) + "'>"+ ( i + 1 ) +"</option>" : "<option value='" + ( i + 1 ) + "'>"+ ( i + 1 ) +"</option>";
      }
      $('#selection-options-container').append(appendedText);
      $('#leading-answer-selection').append(appendAnswerText);
    });
  
    $('#add-quiz').click(function(){
      if(typeof oldcomponent == 'undefined'){
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
        
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent.id );
      };
        
      var component = {
        'type' : 'quiz',
        'data': {
          'a': {
            'css': {

            },
            'text': 'Quiz Sorusu'
			
          },
          'lock':'',
          'self': {
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,

            }
          }
        }
      };

      var numberOfSelections = $('#leading-option-count').val();
      var correctAnswerIndex = parseInt($('#leading-answer-selection').val()) - 1;

      component.data['numberOfSelections'] = numberOfSelections;
      component.data['correctAnswerIndex'] = correctAnswerIndex;
      component.data['question'] = $('#question').val();
      component.data['options'] = [];
      for( var i = 0; i < parseInt( numberOfSelections ); i++ ) {
        component.data['options'][i] = $('#selection-option-index-' + i).val();
      }
      $('#create-quiz-close-button').trigger('click');

      window.lindneo.tlingit.componentHasCreated( component );
    });


  };