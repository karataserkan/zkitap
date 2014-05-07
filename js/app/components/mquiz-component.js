'use strict';

$(document).ready(function(){
  $.widget('lindneo.mquizComponent', $.lindneo.component, {
    
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
var multiple_count = 0;
var check_count = 0;
var question_answers = [];
var addRow = function(type){
  if(type == "multiple" ){
      var multiple_answer = $('<div><input class="form-control" id="mul_option'+multiple_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..." style="float: left; width: 230px; margin-right: 10px;"><i id="delete_'+multiple_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'multiple\','+multiple_count+');"></i><br><br></div>')
      multiple_answer.appendTo($('.quiz-inner'));
      multiple_count++;
      question_answers.push(multiple_answer);
    }
  else if(type == "checkbox" ){
      var check_answer = $('<div><input class="form-control" id="check_option'+check_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 230px; margin-right: 10px;"><i id="delete_'+check_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'checkbox\','+check_count+');"></i><br><br></div>')
      check_answer.appendTo($('.quiz-inner'));
      check_count++;
      question_answers.push(check_answer);
    }
};
var removeRow = function(type, row_number){
  console.log(row_number);
  if(type == "multiple" ){

    $(question_answers[row_number]).remove();
    
    question_answers.splice(row_number,1);
    console.log(question_answers);
    multiple_count--;
    console.log(multiple_count);
  }
  else if(type == "checkbox" ){
    $(question_answers[row_number]).remove();
    
    question_answers.splice(row_number,1);
    console.log(question_answers);
    check_count--;
    console.log(check_count);
  }
};
  var createMquizComponent = function ( event, ui, oldcomponent ) {
    multiple_count = 0;
    check_count = 0;
    question_answers = [];
    
    if(typeof oldcomponent == 'undefined'){
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
      var question = "Soru kökünü buraya yazınız.";
      var answers = [];
    }
    else{
      top = oldcomponent.data.self.css.top;
      left = oldcomponent.data.self.css.left;
      question = oldcomponent.data.question;
      answers = oldcomponent.data.options;
    };
    console.log("ededed");

      $("<div class='popup ui-draggable' id='pop-mquiz-popup' style='display: block; top:" + top  + "; left: " + left  + ";'> \
      <div class='popup-header'> \
        <i class='icon-m-quiz'></i> &nbsp;Quiz Ekle \
        <i id='create-mquiz-close-button' class='icon-close size-10 popup-close-button'></i> \
      </div> \
      <!-- popup content --> \
      <div class='gallery-inner-holder'> \
        <label for='quiz_type'> Soru Tipi: </label> \
        <select id='quiz_type' class='form-control'> \
          <option selected value=''>Lütfen Seçiniz</option> \
          <option value='text'>Yazı</option> \
          <option value='paragraph'>Paragraf</option> \
          <option value='multiple_choice'>Çoktan Seçmeli</option> \
          <option value='checkbox'>Çoklu Seçmeli</option> \
          <option value='scale'>Aralık</option> \
          <option value='grid'>Tablo</option> \
          <option value='date'>Tarih</option> \
        </select> \
        <label for='question'> Soru: </label> \
        <textarea class='form-control' id='question' rows='3' placeholder='Soru kökünü buraya yazınız...'></textarea>\
        <br /><br /> \
        <div class='quiz-inner'> \
        </div> \
        <a href='#' class='btn btn-info' id='add-quiz' >Ekle</a> \
      </div> \
      <!-- popup content--> \
    </div>").appendTo('body').draggable();
  /*
    // initialize options
    var n = $('#leading-option-count').val();
    $('#selection-options-container').empty();
    $('#leading-answer-selection').empty();  
    var appendedText = "";    
    var appendAnswerText = "";
    for(var i = 0; i < parseInt(n); i++ ){
      var answer = answers[i];
      if(typeof answer == 'undefined') answer = '';
      appendedText +=  (i + 1) + ". seçenek <textarea class='popup-choices-area' id='selection-option-index-" + i + "'>" + answer + "</textarea> <br>";

      appendAnswerText += (i === 0) ? "<option selected value='" + ( i + 1 ) + "'>"+ ( i + 1 ) +"</option>" : "<option value='" + ( i + 1 ) + "'>"+ ( i + 1 ) +"</option>";  
    }
    $('#selection-options-container').append(appendedText);
    $('#leading-answer-selection').append(appendAnswerText);      
*/
    // attach close event to close button
    $('#create-mquiz-close-button').click(function(){
      $('#pop-mquiz-popup').remove();  
      if ( $('#pop-mquiz-popup').length ){
        $('#pop-mquiz-popup').remove();  
      }
    });

    $('#quiz_type').change(function(e){
      console.log($(this).val());
      question_answers=[];
      if($(this).val() == "text"){
        $('.quiz-inner').html('');
        var answer_text = $("<input type='text' id='qtext' class='form-control' placeholder='Doğru cevapları | arasına yazınız...'><br>");
        answer_text.appendTo($('.quiz-inner'));
        question_answers.push(answer_text);
      }
      else if($(this).val() == "paragraph"){
        $('.quiz-inner').html('');
        var answer_paragraph = $("<textarea class='form-control' id='qparagraph' rows='3' placeholder='Cevabınızı buraya giriniz...'></textarea><br>")
        answer_paragraph.appendTo($('.quiz-inner'));
        question_answers.push(answer_paragraph);
      }
      else if($(this).val() == "multiple_choice"){
        
        $('.quiz-inner').html('');
        $("<a href='#' class='btn btn-info' onclick='addRow(\"multiple\");' >Cevap Ekle</a><br><br>").appendTo($('.quiz-inner'));
        var multiple_answer = $('<div><input class="form-control" id="mul_option'+multiple_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 230px; margin-right: 10px;"><i id="delete_'+multiple_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'multiple\','+multiple_count+');"></i><br><br></div>')
        multiple_answer.appendTo($('.quiz-inner'));
        multiple_count++;
        question_answers.push(multiple_answer);
      }
      else if($(this).val() == "checkbox"){
        $('.quiz-inner').html('');
        $("<a href='#' class='btn btn-info' onclick='addRow(\"checkbox\");' >Cevap Ekle</a><br><br>").appendTo($('.quiz-inner'));
        var check_answer = $('<div><input class="form-control" id="check_option'+check_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 230px; margin-right: 10px;"><i id="delete_'+check_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'checkbox\','+check_count+');"></i><br><br></div>')
        check_answer.appendTo($('.quiz-inner'));
        check_count++;
        question_answers.push(check_answer);
        
      }
      else if($(this).val() == "scale"){
        
      }
      else if($(this).val() == "grid"){
        
      }
      else if($(this).val() == "date"){
        
      }
      else
        $('.quiz-inner').html('');

    });

    // when option count change, reorganize options according to that value
    // warning! previouse option texts will be deleted.
    /*
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
  */
    $('#add-quiz').click(function(){
      if(typeof oldcomponent == 'undefined'){
        var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
        var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
        
      }
      else{
        top = oldcomponent.data.self.css.top;
        left = oldcomponent.data.self.css.left;
        window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
      };
      var quiz_type = $('#quiz_type').val();

      if(quiz_type == "text"){
        console.log(question_answers[0][0].value);
      }
      else if(quiz_type == "paragraph"){
        console.log(question_answers[0][0].value);
      }
      else if(quiz_type == "multiple_choice"){
        console.log(question_answers);
      }
      else if(quiz_type == "checkbox"){
        console.log(question_answers);
      }
        
      var component = {
        'type' : 'mquiz',
        'data': {
          'a': {
            'css': {

            },
            'text': 'Quiz Sorusu'
			
          },
          'quiz_type':quiz_type,
          'question_answers':question_answers,
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
/*
      var numberOfSelections = $('#leading-option-count').val();
      var correctAnswerIndex = parseInt($('#leading-answer-selection').val()) - 1;

      component.data['numberOfSelections'] = numberOfSelections;
      component.data['correctAnswerIndex'] = correctAnswerIndex;
      component.data['question'] = $('#question').val();
      component.data['options'] = [];
      for( var i = 0; i < parseInt( numberOfSelections ); i++ ) {
        component.data['options'][i] = $('#selection-option-index-' + i).val();
      }
  */
      $('#create-quiz-close-button').trigger('click');
      console.log(component);
      return;
      window.lindneo.tlingit.componentHasCreated( component );
    });


  };