'use strict';

$(document).ready(function(){
  $.widget('lindneo.quizComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
      var anchor = $('<a></a>');
      anchor.attr('id', 'quiz-' + this.options.component.id );
      
      anchor.text( this.options.component.data.a.text );

      this.element.append( anchor );

      anchor.click(function(e){


        // open a window
        $("<div id='quiz-popup' style='position:absolute; top: " + ( e.pageY + 30 )+ "px; left: "+ e.pageX + "px; '> \
            <div id='question-text'></div> \
            <div id='question-options-container'></div> \
            <div> \
              <a id='send' href='#'>send</a> \
            </div> \
        </div>").appendTo('body');

        // set question text
        $('#question-text').text( that.options.component.data.question );
        var n = that.options.component.data.numberOfSelections;

        var appendText = "";
        for( var i = 0; i < n; i++ ){
          appendText += 
          "<div> \
            <input type='radio' value='" + i + "' name='question' /> \
            "+ that.options.component.data.options[i] + " \
          </div>";
        }
        $('#question-options-container').append(appendText);

        // prepare question options

        // click event
        $('#send').click(function(evt){

          var ind = $('input[type=radio]:checked').val();
          
          if( ind === undefined ){
            alert('secilmemis');
          } else {
            var answer = {
            'selected index': ind,
            'selected option': that.options.component.data.options[ind]
          };

          alert(JSON.stringify(answer));
  
          }

          $('#quiz-popup').remove();
          if( $('#quiz-popup').length ) {
            $('#quiz-popup').remove();
          }
        });

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