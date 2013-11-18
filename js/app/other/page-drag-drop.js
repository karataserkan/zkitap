$( document ).ready(function () {


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
                'outline': 'none'
              } , 
              'src': imageBinary
            },
            'self': {
              'css': {
                'position':'absolute',
                'top': (ui.offset.top-$(event.target).offset().top ) + 'px',
                'left':  ( ui.offset.left-$(event.target).offset().left ) + 'px',
                'width': '200px',
                'height': '100px'
              }
            }
          }
        };

        //window.lindneo.tlingit.componentHasCreated( component );
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

    $( ".component" ).draggable({
     // helper: "clone",
      revert: "valid"
    });

		$('#current_page').droppable({
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

          default:

        }

	 	  }
    
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
      window.lindneo.tlingit.ChapterHasDeleted( chapter_id );
    });

    $('.delete-page').click(function(){
      var page_id=$(this).parent().attr('page_id');
          window.lindneo.tlingit.PageHasDeleted( page_id );
    });

    $('#chapters_pages_view').sortable({
      stop: function(event,ui){
        $('.chapter input').change();
      }
    });

    $('.pages').sortable({ connectWith: '.pages' , stop: function( event,ui){

      console.log(event.toElement);
      console.log('page_id: ' +$(event.toElement).attr('page_id'));
      console.log('new Chapter_id: ' +$(event.toElement).parent().parent().attr('chapter_id'));
      console.log('new order: ' +$(event.toElement).index());
      console.log(ui);
    }  });

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
