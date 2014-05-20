'use strict';

$(document).ready(function(){
  $.widget('lindneo.mquizComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
    


        console.log(this.element);
        console.log(that.options.component.data);

        $("<div  class='quiz-component' style=''> \
            <div class='question-text'></div> \
            <div class='question-options-container'></div> \
            <div style='margin-bottom:25px'> \
              <a href='#' class='btn bck-light-green white radius send' > Yanıtla </a> \
            </div> \
        </div>").appendTo(this.element);

        this.element.find('.question-text').text( that.options.component.data.question );
        if(that.options.component.data.quiz_type == "multiple_choice"){

          var n = that.options.component.data.question_answers.length;
        
          var appendText = "";
          for( var i = 0; i < n; i++ ){
            appendText += 
            "<div> \
              <input type='radio' value='" + i + "' name='question' /> \
              "+ that.options.component.data.question_answers[i] + " \
            </div>";
          }
  
          this.element.find('.question-options-container').append(appendText);
          var that = this;
          /*
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
                if (i==that.options.component.data.answer) color ='green';
                var newAnserBtn=$("<span style='border-radius: 50%;width:10px;height:10px;display: inline-block;background:"+color+"'></span>");
                $(this).find('input[type=radio]').remove();
                $(this).prepend(newAnserBtn);
                if (ind==i && that.options.component.data.answer==ind){
                  that.element.css('background','color');
                  $(this).prepend('+');
                } else if (ind==i && that.options.component.data.answer!=ind){
                  that.element.css('background','color');
                  $(this).prepend('x');
                }
  
                $(this).css('color',color);
              }); 
  
            }
  
  
          });*/
        }
        else if(that.options.component.data.quiz_type == "text"){

          var appendText = "<div id='uanswer'><input type='text' id='user_answer' class='form-control' placeholder='Cevabınızı buraya giriniz...' /></div>";
          this.element.find('.question-options-container').append(appendText);
          var that = this;
          /*
          this.element.find('.send').click(function(evt){
            if($('#user_answer').val() == that.options.component.data.answer){
              $('#uanswer').append($('<div style="color:green;">Tebrikler!...</div>'));
            }
            else{
             $('#uanswer').append($('<div style="color:red;">Üzgünüm Yanlış Cevap!...</div>')); 
            }
          });
          */

        }
        else if(that.options.component.data.quiz_type == "checkbox"){

          var n = that.options.component.data.question_answers.length;
        
          var appendText = "";
          for( var i = 0; i < n; i++ ){
            appendText += 
            "<div> \
              <input type='checkbox' value='" + i + "' name='question' /> \
              "+ that.options.component.data.question_answers[i] + " \
            </div>";
          }

          this.element.find('.question-options-container').append(appendText);
          var that = this;
          /*
          this.element.find('.send').click(function(evt){
  
            var ind = $('input[type=checkbox]:checked').val();
            
            if( ind === undefined ){
              alert('secilmemis');
            } else {
              var answer = {
                'selected-index': ind,
                'selected-option': that.options.component.data.options[ind]
              };
  
              
              that.element.find('.question-options-container div').each(function(i,element){
                var color = 'red';
                if (i==that.options.component.data.answer) color ='green';
                var newAnserBtn=$("<span style='border-radius: 50%;width:10px;height:10px;display: inline-block;background:"+color+"'></span>");
                $(this).find('input[type=radio]').remove();
                $(this).prepend(newAnserBtn);
                $.each( that.options.component.data.answer, function( key, value ) {

                  if (ind==i && value==ind){
                    that.element.css('background','color');
                    $(this).prepend('+');
                  } else if (ind==i && value!=ind){
                    that.element.css('background','color');
                    $(this).prepend('x');
                  }

                });
  
                $(this).css('color',color);
              }); 
  
            }
  
  
          });
        */

        }
      

      this._super({resizableParams:{handles:"e, s, se"}});
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
      var multiple_answer = $('<div><input type="radio" name="multipleradios" id="optionsRadios'+multiple_count+'" value="'+multiple_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="mul_option'+multiple_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+multiple_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'multiple\','+multiple_count+');"></i><br><br></div>');
      multiple_answer.appendTo($('.quiz-inner'));
      multiple_count++;
      question_answers.push(multiple_answer);
    }
  else if(type == "checkbox" ){
      var check_answer = $('<div><input type="checkbox" name="multichecks" id="inlineCheckbox'+check_count+'" value="'+check_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="check_option'+check_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+check_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'checkbox\','+check_count+');"></i><br><br></div>');
      check_answer.appendTo($('.quiz-inner'));
      check_count++;
      question_answers.push(check_answer);
    }
};
var removeRow = function(type, row_number){
  //console.log(row_number);
  //console.log(multiple_count);
  //console.log(type);
  if(type == "multiple" ){
  //console.log(question_answers[row_number]);
    $(question_answers[row_number]).remove();
    
    question_answers.splice(row_number,1);

    $.each( question_answers, function( key, value ) {
          
       $($(value).children()[1]).attr('id','mul_option'+key);
       $($(value).children()[2]).attr('onclick',"removeRow('multiple',"+key+");");
       
    });

    //console.log(question_answers);
    if(multiple_count > 0)
      multiple_count--;
    //console.log(multiple_count);
  }
  else if(type == "checkbox" ){
    $(question_answers[row_number]).remove();
    
    question_answers.splice(row_number,1);

    $.each( question_answers, function( key, value ) {
          
       $($(value).children()[1]).attr('id','check_option'+key);
       $($(value).children()[2]).attr('onclick',"removeRow('checkbox',"+key+");");
       
    });

    //console.log(question_answers);
    if(check_count > 0)
      check_count--;
    //console.log(check_count);
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
    
    var min_left = $("#current_page").offset().left;
    var min_top = $("#current_page").offset().top;
    var max_left = $("#current_page").width() + min_left;
    var max_top = $("#current_page").height() + min_top;
    
    var top=(event.pageY - 25);
    var left=(event.pageX-150);

    console.log(top);

    if(left < min_left)
      left = min_left;
    else if(left+220 > max_left)
      left = max_left - 220;

    if(top < min_top)
      top = min_top;
    else if(top+430 > max_top)
      top = max_top - 430;

console.log(top);

    top = top + "px";
    left = left + "px";

      $("<div class='popup ui-draggable' id='pop-mquiz-popup' style='display: block; top:" + top  + "; left: " + left  + "; width:300px;'> \
      <div class='popup-header'> \
        <i class='icon-m-quiz'></i> &nbsp;Soru Ekle \
        <i id='create-mquiz-close-button' class='icon-close size-10 popup-close-button'></i> \
      </div> \
      <!-- popup content --> \
      <div class='gallery-inner-holder' style='width:100%'> \
        <label for='quiz_type'> Soru Tipi: </label> \
        <select id='quiz_type' class='form-control'> \
          <option selected value=''>Lütfen Seçiniz</option> \
          <option value='text'>Yazı</option> \
          <option value='multiple_choice'>Çoktan Seçmeli</option> \
          <option value='checkbox'>Çoklu Seçmeli</option> \
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
        var answer_text = $("<input type='text' id='qtext' class='form-control' placeholder='Cevabınızı buraya giriniz...'><br>");
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
        var multiple_answer = $('<div><input type="radio" name="multipleradios" id="optionsRadios'+multiple_count+'" value="'+multiple_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="mul_option'+multiple_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+multiple_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'multiple\','+multiple_count+');"></i><br><br></div>');
        multiple_answer.appendTo($('.quiz-inner'));
        multiple_count++;
        question_answers.push(multiple_answer);
      }
      else if($(this).val() == "checkbox"){
        $('.quiz-inner').html('');
        $("<a href='#' class='btn btn-info' onclick='addRow(\"checkbox\");' >Cevap Ekle</a><br><br>").appendTo($('.quiz-inner'));
        var check_answer = $('<div><input type="checkbox" name="multichecks" id="inlineCheckbox'+check_count+'" value="'+check_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="check_option'+check_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+check_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'checkbox\','+check_count+');"></i><br><br></div>');
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
      var question = $('#question').val();
      var answer = '';
      var answers = [];

      if(quiz_type == "text"){
        console.log(question_answers[0][0].value);
        answer = question_answers[0][0].value;
        question_answers = answer;
      }
      else if(quiz_type == "paragraph"){
        console.log(question_answers[0][0].value);
        answer = question_answers[0][0].value;
      }
      else if(quiz_type == "multiple_choice"){
        console.log(question_answers.length);
        answer = $('input[name=multipleradios]:checked').val();

        $.each( question_answers, function( key, value ) {
          
             
            answers.push($($(value[0]).children()[1])[0].value);
             
          });
        
        question_answers = answers;
        console.log(question_answers);
        
        
      }
      else if(quiz_type == "checkbox"){
        console.log(question_answers);
        answer=[];
        $('input:checkbox[name=multichecks]:checked').each(function() 
          {
             //alert( $(this).val());
             answer.push($(this).val());
             
          });
        $.each( question_answers, function( key, value ) {
          
             
            answers.push($($(value[0]).children()[1])[0].value);
             
          });
        
        question_answers = answers;
        console.log(question_answers);
      }

      var component = {
        'type' : 'mquiz',
        'data': {
          'a': {
            'css': {

            },
            'text': 'Sorunuzu giriniz...'
			
          },
          'quiz_type':quiz_type,
          'question_answers':question_answers,
          'question':question,
          'answer':answer,
          'lock':'',
          'self': {
            'css': {
              'position':'absolute',
              'top': top ,
              'left':  left ,
              'zindex': 'first'
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
      $('#create-mquiz-close-button').trigger('click');
      console.log(component);
      
      window.lindneo.tlingit.componentHasCreated( component );
    });


  };