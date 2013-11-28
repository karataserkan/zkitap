$( document ).ready(function () {

  var termTemplate = "<span class='ui-autocomplete-term'>%s</span>";
	
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

          case 'sound':
            createSoundComponent( event, ui );
            break;

          case 'quiz':
            createQuizComponent( event, ui );
            break;

          case 'video':
            createVideoComponent( event, ui );
            break; 

          case 'popup':
            createPopupComponent( event, ui );
            break; 

          case 'grafik':
            createGraphComponent( event, ui  );
            break;

          case 'shape':
            createShapeComponent( event, ui  );
            break;

          default:
            break; 
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
