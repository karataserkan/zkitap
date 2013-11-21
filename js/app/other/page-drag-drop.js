$( document ).ready(function () {

  var termTemplate = "<span class='ui-autocomplete-term'>%s</span>";
	
  var createQuizComponent = function ( event, ui ) {

    $("<div class='popup ui-draggable' id='pop-quiz-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
      <div class='popup-header'> \
        Quiz Ekle \
        <div class='popup-close' id='create-quiz-close-button'>x</div> \
      </div> \
      <!-- popup content --> \
      <div class='gallery-inner-holder'> \
        <label class='dropdown-label' id='leading'> \
          Şık Sayısı: \
          <select id='leading-option-count' class='radius'> \
            <option value='2'>2</option> \
            <option selected value='3'>3</option> \
            <option value='4'>4</option> \
            <option value='5'>5</option> \
          </select> \
        </label> \
        <br /> \
        <label class='dropdown-label' id='leading'> \
          Doğru Cevap: \
          <select id='leading-answer-selection' class='radius'> \
          </select> \
        </label> \
        <br /><br /> \
        <div class='quiz-inner'> \
          Soru kökü: \
          <form id='video-url'> \
            <textarea class='popup-text-area' id='question'>Soru kökünü buraya yazınız.</textarea><br> \
            <!--burası çoğalıp azalacak--> \
            <div id='selection-options-container'> \
            </div> \
          </form> \
        </div> \
        <a href='#' class='btn bck-light-green white radius' id='add-quiz' style='padding: 5px 30px;'>Ekle</a> \
      </div> \
      <!-- popup content--> \
    </div>").appendTo('body');
  
    // initialize options
    var n = $('#leading-option-count').val();
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

    // attach close event to close button
    $('#create-quiz-close-button').click(function(){
      $('#pop-quiz-popup').remove();  
      if ( $('#pop-quiz-popup').length ){
        $('#pop-quiz-popup').remove();  
      }
    });

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
      
      var component = {
        'type' : 'quiz',
        'data': {
          'a': {
            'css': {

            },
            'text': 'Quiz Click'
          },
          'self': {
            'css': {
              'position':'absolute',
              'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
              'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
              'width': '100px',
              'height': '20px'
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

  var createGaleryComponent = function (event,ui){


    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Galeri Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
      <ul id='galery-popup-images' style='width: 250px;'> \
      </ul> \
     <div style='clear:both' > </div> \
     <a id='pop-image-OK' class='btn white btn radius ' >Tamam</a>\
    </div> ").appendTo('body');
    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });

    $('#pop-image-OK').click(function (){

      var imgs=[];
        $('#galery-popup-images img').each(function( index ) {
          var img={
              'css' : {

                'height':'100%',
                'margin': '0',
                
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } , 
              'src': $( this ).attr('src')
            }
            imgs.push(img);

          console.log( index + ": " + $( this ).text() );
        });

        
       component = {
          'type' : 'galery',
          'data': {
            'ul':{
              'css': {
                'overflow':'hidden',
                'margin': '0',
                'padding': '0',
                'position': 'relative',
                'width': '100%',
                'height': '100%',
              },
            'imgs':imgs
            
         
            },
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '300px',
                'height': '200px',


                'background-color': 'transparent',
                

              }
            }
          }
        };

         window.lindneo.tlingit.componentHasCreated( component );
         $("#image-add-dummy-close-button").trigger('click');

    });


    var el = document.getElementById("dummy-dropzone");
    var imageBinary = '';

    el.addEventListener("dragenter", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("dragexit", function(e){
      e.stopPropagation();
      e.preventDefault();
    },false);

    el.addEventListener("dragover", function(e){
      e.stopPropagation ();
      e.preventDefault();
    }, false);

    el.addEventListener("drop", function(e){
      
      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};

      reader.onload = function (evt) {

        imageBinary = evt.target.result;        

        $('#galery-popup-images').append('<li style="height:60px; width:60px; margin:10px; border : 1px dashed #ccc; float:left;"><img style="height:100%;" src='+imageBinary+' /> \
          <a class="btn red white size-15 radius icon-delete galey-image-delete hidden-delete " style="margin-left: 38px;"></a> \
          </li>');
        $('#galery-popup-images').sortable({
          placeholder: "ui-state-highlight"
        });
        $('#galery-popup-images').disableSelection();
     

       
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  }


  var createImageComponent = function ( event, ui ) {

    $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
    <div class='popup-header'> \
    Görsel Ekle \
    <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
    </div> \
      <div class='gallery-inner-holder'> \
        <div style='clear:both'></div> \
        <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
      </div> \
    </div>").appendTo('body');

    $('#image-add-dummy-close-button').click(function(){

      $('#pop-image-popup').remove();  

      if ( $('#pop-image-popup').length ){
        $('#pop-image-popup').remove();  
      }

    });

    var el = document.getElementById("dummy-dropzone");
    var imageBinary = '';

    el.addEventListener("dragenter", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("dragexit", function(e){
      e.stopPropagation();
      e.preventDefault();
    },false);

    el.addEventListener("dragover", function(e){
      e.stopPropagation();
      e.preventDefault();
    }, false);

    el.addEventListener("drop", function(e){
      
      e.stopPropagation();
      e.preventDefault();

      var reader = new FileReader();
      var component = {};

      reader.onload = function (evt) {

        imageBinary = evt.target.result;        
        
        $("#image-add-dummy-close-button").trigger('click');

        component = {
          'type' : 'image',
          'data': {
            'img':{
              'css' : {
                'width':'100%',
                'height':'100%',
                'margin': '0',
                'padding': '0px',
                'border': 'none 0px',
                'outline': 'none',
                'background-color': 'transparent'
              } , 
              'src': imageBinary
            },
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '100px',
                'height': '20px',
                'background-color': 'transparent',
                'overflow': 'visible'
              }
            }
          }
        };

        window.lindneo.tlingit.componentHasCreated( component );
      };

      reader.readAsDataURL( e.dataTransfer.files[0] );

    }, false);

  };



  var createTextComponent = function ( event, ui ) {

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
            'outline': 'none'
          } , 
          'attr': {
            'asd': 'coadsad'
          },
          'val': 'some text'
        },
        'self': {
          'css': {
            'overflow':'visible',
            'position':'absolute',
            'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
            'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
            'width': '100px',
            'height': '20px'
          }
        }
      }
    };

    window.lindneo.tlingit.componentHasCreated(component);
  };


function first_time(){

    $('#search').autocomplete({
      appendTo: "#page" ,
      minLength: 2, 
      source: function( request, response ) {
              $.ajax({
                url: "http://ugur.dev.lindneo.com/index.php?r=EditorActions/SearchOnBook",
                dataType: "json",
                data: {
                  currentPageId: window.lindneo.currentPageId,
                  searchTerm:request.term 
                },
                success: function( data ) {
                  if (data.result==null) return;
                 
                  response( $.map( 
                    data.result.components, function( item ) {
                      // console.log(item.search);
                      var result={
                        label: item.search.similar_result,
                        value: item.id
                      };
                      
                      return result;
                    })
                  );
                }
              });
            },
      select: function( event, ui ) {
          if (ui.item) {
            $('#searchform').submit();
          }

          
        },   

        open: function(e,ui) {
            var
                acData = $(this).data('uiAutocomplete');
    
              

                
            acData
                .menu
                .element
                .find('a')
                .each(function() {
                    var me = $(this);
                    var str = me.text() ;
                    var patt1 = new RegExp(acData.term,'i');

                    var result = str.match(patt1);
                    var styledTerm = termTemplate.replace('%s', result);
                    console.log(result);
                    console.log(str);
                    console.log(acData.term);
                    me.html( me.text().replace(result, styledTerm) );
                });
        }



      });



    $( ".component" ).draggable({
     // helper: "clone",
      revert: "valid",
      snap: true
    });


		$('#current_page').droppable({
      tolerance: 'fit',
      drop: function (event, ui) {
			  //create a component object from dom object
			  //pass it to tlingit        

        if( $(event.toElement).attr('component-instance') ){
          return;
        }

        switch( $(event.toElement).attr('ctype') ) {

          case 'text':
            createTextComponent( event, ui );
            break;

          case 'image':
            createImageComponent( event, ui );
            break;

          case 'galery':
            createGaleryComponent( event, ui );
            break;
          case 'quiz':
            createQuizComponent( event, ui );
            break;
          default:

        }

	 	  }
      ,
      accept:'.component'
    
    });
    
    $('.chapter-title').change(function(){
        window.lindneo.tlingit.ChapterUpdated(
          $(this).parent().attr('chapter_id'),
          $(this).val( ),
          $(this).parent().index() 
        );
    });

    $('.delete-chapter').click(function(){
      var chapter_id=$(this).parent().attr('chapter_id');
      console.log(chapter_id);

      $('.chapter[chapter_id="'+chapter_id+'"]').hide('slow', function(){  $('.chapter[chapter_id="'+chapter_id+'"]').remove();});
      window.lindneo.tlingit.ChapterHasDeleted( chapter_id );
      sortPages();

    });

    $('.delete-page').click(function(){
      var page_id=$(this).parent().attr('page_id');

      window.lindneo.tlingit.PageHasDeleted( page_id );

      $('.page[page_id="'+page_id+'"]').hide('slow', function(){  $('.page[page_id="'+page_id+'"]').remove();});
      sortPages();

    });

    $('#chapters_pages_view').sortable({
      stop: function(event,ui){
        sortPages();
        $('.chapter input').change();
      }
    });



    $('.pages').sortable({ 
      connectWith: '.pages' , 
      stop: function( event,ui){
        sortPages();
      }  
    });

	 	$('#zoom-pane').slider({
	    value:100,
	    min: 25,
	    max: 500,
	    step: 25,
	    slide: function( event, ui ) {
	      $('#author_pane').css({'zoom': (ui.value / 100) });
	    }
	  });
	}



  first_time();

});

  function sortPages(){
    var pageNum=0;
    $('#chapters_pages_view .page').each(function(e){
      pageNum++;
      $(this).find('.page-number').html('s '+pageNum);
      if( $(this).attr('page_id')== window.lindneo.currentPageId){ 
        $(this).addClass('current_page');
      }
      window.lindneo.tlingit.PageUpdated(
          $(this).attr('page_id'),
          $(this).parent().parent().attr('chapter_id'),
          $(this).index()
        );

    });
  }
