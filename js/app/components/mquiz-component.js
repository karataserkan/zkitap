'use strict';

$(document).ready(function(){
  $.widget('lindneo.mquizComponent', $.lindneo.component, {
    
    options: {

    },

    _create: function(){

      var that = this;
    


        //console.log(this.element);
        //console.log(that.options.component.data);

        $("<div  class='quiz-component' style=''> \
            <div class='question-text'></div> \
            <div class='question-options-container'></div> \
            <div style='margin-bottom:25px'> \
              <a href='#' class='btn bck-light-green white radius send' > "+j__("Yanıtla")+" </a> \
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

          var appendText = "<div id='uanswer'><input type='text' id='user_answer' class='form-control' placeholder='"+j__("Cevabınızı buraya giriniz...")+"' /></div>";
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
      var check_answer = $('<div><input type="checkbox" name="multichecks" id="inlineCheckbox'+check_count+'" value="'+check_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="check_option'+check_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+check_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'checkbox\','+check_count+');"></i><br><br></div><br>');
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

    var checkBoxAnswers = [];
    var questionWindowElement ;



    if(typeof oldcomponent == 'undefined'){
      var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
      var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
    }
    else
    {
      var top = oldcomponent.data.self.css.top;
      var left = oldcomponent.data.self.css.left;
    };
    
    var blank_selected = "selected"
    var text_selected = "";
    var radio_selected = "";
    var check_selected = "";

    var min_left = $("#current_page").offset().left;
    var min_top = $("#current_page").offset().top;
    var max_left = $("#current_page").width() + min_left;
    var max_top = $("#current_page").height() + min_top;
    var window_width = $( window ).width();
    var window_height = $( window ).height();

    if(max_top > window_height) max_top = window_height;
    if(max_left > window_width) max_top = window_width;
    
    var top=(event.pageY - 25);
    var left=(event.pageX-150);

    if(left < min_left)
      left = min_left;
    else if(left+220 > max_left)
      left = max_left - 220;

    if(top < min_top)
      top = min_top;
    else if(top+430 > max_top)
      top = max_top - 430;


    top = top + "px";
    left = left + "px";
    var multipleGroupName = "radioG"+$.now();

    var createNewAnswerLine = function(type,value,label,onDelete){
          switch (type){
            case "text":
              var check_answer = $('<div class="input-group">');

              var answerInput = $("<input type='text' class='form-control'>")
                .attr("placeholder", j__("Cevap giriniz...") )
                .val(label);
                check_answer.append(answerInput);

                check_answer.answerInput=answerInput;
                check_answer.answer_text = label;
                check_answer.answer_value = label;

                answerInput.change(function(){
                  check_answer.answer_text = $(this).val();
                  check_answer.answer_value = $(this).val();
                });

                var addOnDelete = $( '<span class="input-group-addon">')
                  .appendTo(check_answer);

                var answerDeleteBtn = $('<i class="icon-close size-10 popup-close-button"></i>')
                  .appendTo(addOnDelete);

                check_answer.answerDeleteBtn=answerDeleteBtn;

                answerDeleteBtn.click(function(){
                  check_answer.remove();
                  onDelete(type);
                });

                return check_answer;

              break;

            case "checkbox":
                var check_answer = $('<div class="input-group">');
                var addOnSpan = $("<span class='input-group-addon'>")
                  .appendTo(check_answer);
     
                var answerCheckBox = $('<input type="checkbox" name="multichecks" style="margin-right:10px;"/>')
                  .appendTo(addOnSpan);

                check_answer.answerCheckBox=answerCheckBox;

                check_answer.answer_text = label;
                check_answer.answer_value = value;

                var answerInput = $('<input class="form-control" type="text">')
                  .attr("placeholder", j__("Cevap giriniz...") )
                  .val(label);

                check_answer.answerInput=answerInput;
                check_answer.append(answerInput);

                var addOnDelete = $( '<span class="input-group-addon">')
                  .appendTo(check_answer);

                var answerDeleteBtn = $('<i class="icon-close size-10 popup-close-button"></i>')
                  .appendTo(addOnDelete);
                check_answer.answerDeleteBtn=answerDeleteBtn;
                
                if ( value ) {
                  answerCheckBox.prop('checked', true);
                  check_answer.answer_value=true;
                } else {
                  check_answer.answer_value=false;
                }

                answerCheckBox.click(function(){
                  check_answer.answer_value = $(this).is(':checked')  ;
                });

                answerInput.change(function(){
                  check_answer.answer_text = $(this).val();
                });

                answerDeleteBtn.click(function(){
                  check_answer.remove();
                  onDelete();
                });

                return check_answer;
              break;

          case "multiple_choice":
             var multipleRadioValue = "radioV"+$.now();
             var check_answer = $('<div class="input-group">');
                var addOnSpan = $("<span class='input-group-addon'>")
                  .appendTo(check_answer);
            
                var answerRadio = $('<input type="radio">')
                  .attr('name',multipleGroupName)
                  .attr('value',multipleRadioValue)
                  .appendTo(addOnSpan);

                check_answer.radioid=multipleRadioValue;
                check_answer.answerRadio=answerRadio;

                check_answer.answer_text = label;
                check_answer.answer_value = value;
                
                var answerInput = $('<input class="form-control" type="text">')
                  .attr("placeholder", j__("Cevap giriniz...") )
                  .val(label);

                check_answer.answerInput=answerInput;
                check_answer.append(answerInput);

                var addOnDelete = $( '<span class="input-group-addon">')
                  .appendTo(check_answer);

                var answerDeleteBtn = $('<i class="icon-close size-10 popup-close-button"></i>')
                  .appendTo(addOnDelete);
                check_answer.answerDeleteBtn=answerDeleteBtn;
                
                if ( value ) {
                  answerRadio.prop('checked', true);
                  check_answer.answer_value=true;
                } else {
                  check_answer.answer_value=false;
                }


                $( document ).on( "click",'input[name="'+ multipleGroupName +'"]',function(){
                  //alert("changed");
                  console.log(check_answer.radioid);
                  console.log($('input[name='+ multipleGroupName +']:radio:checked').val());
                  if( $('input[name='+ multipleGroupName +']:radio:checked').val() == check_answer.radioid)
                    check_answer.answer_value = true;
                  else
                    check_answer.answer_value = false;
                });

                answerInput.change(function(){
                  check_answer.answer_text = $(this).val();
                });

                answerDeleteBtn.click(function(){
                  check_answer.remove();
                  onDelete();
                });

                return check_answer;
              break;

          }
        };
    
    var answers = [];
    var question;
    var question_type;

    $('<div>').componentBuilder({
      top:top,
      left:left,
      title: j__("Soru Ekle"),
      btnTitle : j__("Ekle"), 
      beforeClose : function () {
        /* Warn about not saved work */
        /* Dont allow*/
        return confirm(j__("Yaptığınız değişiklikler kaydedilmeyecektir. Kapatmak istediğinize emin misiniz?"));
      },
      onBtnClick: function(){
        console.log(answers);


        var arrayCorrectAnswers=[];     
        var arrayAnswers=[];

        /* Controls Here */
        var correctAnswer = false;
        var emptyAnswer = true;
        var emptyQuestion = false;
        var componentAnswers = $()

        if(typeof question == "string" && question!=""){emptyQuestion=true;}
        
        $.each(answers,function(index,answer){
          
          //Convert to component store;
          arrayAnswers.push(answer.line.answer_text);

          if(answer.line.answer_value){
              arrayCorrectAnswers.push(index);
              correctAnswer=true;
          }

          if(typeof answer.line.answer_text != "string"){emptyAnswer=false;}
          if(answer.line.answer_text==""){emptyAnswer=false;}



        });
        if (!emptyQuestion){
          alert( j__("Soru metini boş olmamalı. Lütfen Soru kutusunu doldurduğunuza emin olunuz.") );
          return false;
        }
        else if (!emptyAnswer){
          alert( j__("Cevap metini boş olmamalı. Lütfen cevap kutularının hepsini doldurduğunuza emin olunuz.") );
          return false;
        }
        else if (!correctAnswer){
          alert( j__("Doğru cevabı seçmediniz. Lütfen bir cevabı doğru olarak işaretleyiniz.") );
          return false;
        } 


        var finalCorrectAnswers;
        var finalAnswers;
        switch(question_type){
          case "text":
            finalCorrectAnswers = arrayCorrectAnswers[0];
            finalAnswers = arrayAnswers[0];
            break;
          case "multiple_choice":
          case "checkbox":
            finalCorrectAnswers = arrayCorrectAnswers;
            finalAnswers = arrayAnswers;
          break;
        }

        if(typeof oldcomponent == 'undefined'){
          var top = (ui.offset.top-$(event.target).offset().top ) + 'px';
          var left = ( ui.offset.left-$(event.target).offset().left ) + 'px';
        }
        else
        {
          var top = oldcomponent.data.self.css.top;
          var left = oldcomponent.data.self.css.left;
          window.lindneo.tlingit.componentHasDeleted( oldcomponent, oldcomponent.id );
        };

        var component = {
          'type' : 'mquiz',
          'data': {
            'a': {
              'css': {
              },
              'text': j__("Sorunuzu giriniz...")  
            },
            'quiz_type':question_type,
            'question_answers':finalAnswers,
            'question':question,
            'answer':finalCorrectAnswers,
            'lock':'',
            'self': {
              'css': {
                'position':'absolute',
                'top': top ,
                'left':  left ,
                'z-index': 'first',
                'opacity':'1'
              }
            }
          }
        };

        window.lindneo.tlingit.componentHasCreated( component );

      },
      onComplete:function (ui){
        questionWindowElement = ui ;

        var quizTypes = [
          {val : "text", text: j__("Açık Uçlu") },
          {val : "multiple_choice", text: j__("Çoktan Seçmeli") },
          {val : "checkbox", text: j__("Çoklu Seçmeli") }
        ];

        var quizTypeSelector = $('<select>').appendTo(questionWindowElement);

        $(quizTypes).each(function() {
         quizTypeSelector.append($("<option>").attr('value',this.val).text(this.text));
        });

        var quizTypeSelectorLabel = $('<label>')
          .text(j__("Soru Tipi") + ":")
          .prependTo(questionWindowElement)
          .click(function(){ 
            quizTypeSelector.mousedown();
          });

  
        var questionTextArea = $("<textarea rows='3' >")
          .attr('placeholder',j__("Soru kökünü buraya yazınız"))
          .addClass("form-control")
          .appendTo(questionWindowElement)
          .change(function(){
            question = $(this).val();
          });

        var questionsArea = $("<div>").appendTo(questionWindowElement);

        var clearQuestions = function (type){
          addNewAnswerBtn.show();
          answers = [];
          questionsArea.empty();
          addNewAnswer(null,null);
        }

        quizTypeSelector.change(function (event){
          question_type = $(this).val()
          clearQuestions(question_type);
        });

        var quizFooter = $('<div>')
          .css({'padding':'20px 0'})
          .appendTo(questionWindowElement);

        var addNewAnswerBtn = $("<a class='btn btn-info'/>")
          .text(j__("+ Cevap"))
          .appendTo(quizFooter)
          .click(function(){
            addNewAnswer(null,null);
          });


        var addNewAnswer = function (value,label){
           var newAnswer = {} ;
           newAnswer.id= $.now();

           var onDeleted=function(type){
            $.each(answers,function(i,answer ){
              if (type=="text") addNewAnswerBtn.show();
              if ( newAnswer.id == answer.id){
                answers.splice(i,1);
                return false;
              }
            });
           };

           switch(question_type){
            case "text":
              addNewAnswerBtn.hide();
            case "multiple_choice":
            case "checkbox":
              var newLine = createNewAnswerLine(question_type,value,label,onDeleted);
              break;
           }

           newAnswer.line=newLine;
           newLine.appendTo(questionsArea);
           answers.push(newAnswer);  
        };

        /* Set required values here */
        
        if(typeof oldcomponent != 'undefined'){
          question_type = oldcomponent.data.quiz_type;
          quizTypeSelector.val(question_type);

          question = oldcomponent.data.question;
          questionTextArea.val(question);
          
             switch(question_type){
              case "text":
                  addNewAnswer(oldcomponent.data.question_answers,oldcomponent.data.question_answers);
              case "multiple_choice":
              case "checkbox":
                $.each(oldcomponent.data.question_answers,function(index,answer){
                  addNewAnswer( (oldcomponent.data.answer.indexOf(index) > -1 ? true :false) ,answer);
                });
                break;
             }
        }
        else {
          quizTypeSelector.change();
        }





      } 
    }).appendTo('body');


  return;






    if(typeof oldcomponent != 'undefined'){

    
      question_answers=[];
      if( $('#quiz_type').val() == "text"){
        $('.quiz-inner').html('');
        var answer_text = $("<input type='text' id='qtext' class='form-control' value='"+oldcomponent_answers+"' placeholder='"+j__("Cevabınızı buraya giriniz")+"...'><br>");
        answer_text.appendTo($('.quiz-inner'));
        question_answers.push(answer_text);
      }
      else if( $('#quiz_type').val() == "paragraph"){
        $('.quiz-inner').html('');
        var answer_paragraph = $("<textarea class='form-control' id='qparagraph' rows='3' placeholder='"+j__("Cevabınızı buraya giriniz")+"...'></textarea><br>")
        answer_paragraph.appendTo($('.quiz-inner'));
        question_answers.push(answer_paragraph);
      }
      else if( $('#quiz_type').val() == "multiple_choice"){
        
        $('.quiz-inner').html('');
        $("<a href='#' class='btn btn-info' onclick='addRow(\"multiple\");' >"+j__("Cevap Ekle")+"</a><br><br>").appendTo($('.quiz-inner'));
        $.each(oldcomponent_answers, function(i,key){
          var answer_selected = "";
          console.log(i+"--"+oldcomponent_answer);
          if(i == oldcomponent_answer) answer_selected="selected";
          console.log(answer_selected);
          var multiple_answer = $('<div>\
                                    <input type="radio" '+answer_selected+' name="multipleradios" id="optionsRadios'+multiple_count+'" value="'+multiple_count+'" style="float:left; margin-right:10px;">\
                                    <input class="form-control" id="mul_option'+multiple_count+'" type="text" value="'+key+'" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;">\
                                    <i id="delete_'+multiple_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'multiple\','+multiple_count+');"></i><br><br>\
                                  </div>');
          multiple_answer.appendTo($('.quiz-inner'));
          multiple_count++;
          question_answers.push(multiple_answer);
        });
        $('input:radio[name="multipleradios"]').filter('[value="'+oldcomponent_answer+'"]').attr('checked', true);
      }
      else if( $('#quiz_type').val() == "checkbox"){
        $('.quiz-inner').html('');
        


        $("<a href='#' class='btn btn-info'  >"+j__("Cevap Ekle")+"</a><br><br>")
          .appendTo($('.quiz-inner'))
          .click( function(){
            check_answer=createNewAnswerLine("checkbox", false, "");
            checkBoxAnswers.push(check_answer);
            check_answer.appendTo($('.quiz-inner'));
        });
        
        $.each(oldcomponent_answers, function(i,key){
          check_answer=createNewAnswerLine("checkbox", (oldcomponent_answer.indexOf(i) > -1 ? true : false), key);
          checkBoxAnswers.push(check_answer);
          check_answer.appendTo($('.quiz-inner'));
        });


        $.each(oldcomponent_answer, function(i,key){
           $('input:checkbox[name="multichecks"]').filter('[value="'+key+'"]').prop('checked', true);
        });
      }
      else if( $('#quiz_type').val() == "scale"){
        
      }
      else if( $('#quiz_type').val() == "grid"){
        
      }
      else if( $('#quiz_type').val() == "date"){
        
      }
      else
        $('.quiz-inner').html('');

   
    }

    $('#quiz_type').change(function(e){
      console.log($(this).val());
      question_answers=[];
      if($(this).val() == "text"){
        $('.quiz-inner').html('');
        var answer_text = $("<input type='text' id='qtext' class='form-control' placeholder='"+j__("Cevabınızı buraya giriniz")+"...'><br>");
        answer_text.appendTo($('.quiz-inner'));
        question_answers.push(answer_text);
      }
      else if($(this).val() == "paragraph"){
        $('.quiz-inner').html('');
        var answer_paragraph = $("<textarea class='form-control' id='qparagraph' rows='3' placeholder='"+j__("Cevabınızı buraya giriniz")+"...'></textarea><br>")
        answer_paragraph.appendTo($('.quiz-inner'));
        question_answers.push(answer_paragraph);
      }
      else if($(this).val() == "multiple_choice"){
        
        $('.quiz-inner').html('');
        $("<a href='#' class='btn btn-info' onclick='addRow(\"multiple\");' >"+j__("Cevap Ekle")+"</a><br><br>").appendTo($('.quiz-inner'));
        var multiple_answer = $('<div><input type="radio" name="multipleradios" id="optionsRadios'+multiple_count+'" value="'+multiple_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="mul_option'+multiple_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+multiple_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'multiple\','+multiple_count+');"></i><br><br></div>');
        multiple_answer.appendTo($('.quiz-inner'));
        multiple_count++;
        question_answers.push(multiple_answer);
      }
      else if($(this).val() == "checkbox"){
        $('.quiz-inner').html('');
        $("<a href='#' class='btn btn-info' onclick='addRow(\"checkbox\");' >"+j__("Cevap Ekle")+"</a><br><br>").appendTo($('.quiz-inner'));
        var check_answer = $('<div><input type="checkbox" name="multichecks" id="inlineCheckbox'+check_count+'" value="'+check_count+'" style="float:left; margin-right:10px;"><input class="form-control" id="check_option'+check_count+'" type="text" placeholder="Cevap seçeneklerini giriniz..."style="float: left; width: 200px; margin-right: 10px;"><i id="delete_'+check_count+'" class="icon-close size-10 popup-close-button" style="float:left;" onclick="removeRow(\'checkbox\','+check_count+');"></i><br><br></div><br>');
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


        if(typeof answer == "undefined"){
          alert("Doğru cevabı seçmediğiniz ekleme işlemi başarısız olmuştur.")
          return;
        }

        $.each( question_answers, function( key, value ) {
          
             
            answers.push($($(value[0]).children()[1])[0].value);
             
          });
        
        question_answers = answers;
        console.log(question_answers);
        
        
      }
      else if(quiz_type == "checkbox"){
        //console.log(question_answers);
        answer=[];
        $('input:checkbox[name=multichecks]:checked').each(function() 
          {
             //alert( $(this).val());
             var check = this;
             $('input:checkbox[name=multichecks]:not(:checked)').each(function(){
                //console.log(check);
                //console.log(this);
                if(check != this)
                  answer.push($(check).val());
             });
             //answer.push($(this).val());
          });
        //console.log(answer);
        //return;

        var fieldArray = [];
        $.each(answer, function(i, item){
          //console.log(item);
          //console.log($.inArray(item,fieldArray));
          if ($.inArray(item,fieldArray) < 0){
            //console.log("first");
            fieldArray.push(item);
          }
        });
        //console.log(fieldArray);
        answer = fieldArray;

        $.each( question_answers, function( key, value ) {
            var new_value = "";
            //console.log(value);
            //console.log($($(value[0]).children()[1])[0]);
            if(typeof $($(value[0]).children()[1])[0] == "undefined")
              new_value = value;
            else
              new_value = $($(value[0]).children()[1])[0].value;
            //console.log(new_value);

             answers.push(new_value);
          });
        
        question_answers = answers;
        //console.log(answer);
        //return;
        if(answer.length == 0){
          alert("Doğru cevapları seçmediğiniz ekleme işlemi başarısız olmuştur.")
          return;
        }
      }

      var component = {
        'type' : 'mquiz',
        'data': {
          'a': {
            'css': {
            },
            'text': j__("Sorunuzu giriniz...")	
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
              'z-index': 'first',
              'opacity':'1'
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
      //console.log(component);
      
      window.lindneo.tlingit.componentHasCreated( component );
    });


  };

  

