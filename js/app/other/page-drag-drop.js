$( document ).ready(function () {

  var termTemplate = "<span class='ui-autocomplete-term' style='display:inline-block'>%s</span>";
        
  function first_time(){
    /*
    $('#editor_view_pane, #header, #components, .styler_box, #chapters_pages_view')
      .attr('unselectable', 'on')
      .css('user-select', 'none')
      .on('selectstart', false);
    //disable in page draggin selection
    //$('#editor_view_pane').mousemove(function(event){event.stopImmediatePropagation();return false;});
  */
    $('#search').autocomplete({
      appendTo: "#page" ,
      minLength: 1, 
      autoFocus: true,
      source: function( request, response ) {
              $.ajax({
                url: "http://dev.lindneo.com/index.php?r=EditorActions/SearchOnBook",
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
              //console.log(response);
            },
      select: function( event, ui ) {
          //console.log('event       ');
          console.log(event);
          if (ui.item) {
              //console.log(ui.item);
              //window.location.href=event.currentTarget.baseURI;
            //$('#searchform').submit();
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
                    //console.log(result);
                    //console.log(str);
                    //console.log(acData.term);
                    console.log(me.html( me.text().replace(result, styledTerm) ));
                    me.html( me.text().replace(result, styledTerm) );
                });
        }

        

      });

    $('#search').bind("keyup keypress", function(e) {
        var code = e.keyCode || e.which; 
        if (code  == 13) {               
          e.preventDefault();
          $('#searchform').submit();
        }
      });
    
    
    $( ".component" ).draggable({
      //helper: "clone",
      revert: true, 

      snap: true
    });


                $('#current_page').droppable({
      tolerance: 'fit',
      drop: function (event, ui) {
                          //create a component object from dom object
                          //pass it to tlingit        

        /*
        //Dont add if on to other component
        if( $(event.toElement).attr('component-instance') ){
          return;
        }
        */
        switch( $(event.toElement).attr('ctype') ) {
          
          case 'text':
            createTextComponent( event, ui , $(event.toElement).attr('ctype'));
            break;
          case 'side-text':
            createTextComponent( event, ui , $(event.toElement).attr('ctype'));
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

          case 'link':
            createLinkComponent( event, ui  );
            break;
          case 'table':
            createTableComponent( event, ui  );
            break;

          default:
            break; 
        }

                   }
      ,
      accept:'.component'
    
    });
    if(document.getElementById("current_page")!= null){
      var el = document.getElementById("current_page");
      var FileBinary = '';

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
        var file = e.dataTransfer.files[0];
        var reader = new FileReader();
        var component = {};
        console.log(e);
        window.lindneo.dataservice.newComponentDropPage(e, reader, file);
      });
    };
    
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

      //ekaratas start
      //sayfa silindiğinde sayfaya ait olan çalışma alanını kaldırdım

      if (page_id==window.lindneo.currentPageId) {
        $('#current_page').hide().remove();

        var link=$("#chapters_pages_view > div:first-child > ul:first-child > li:first-child > a:nth-child(2)").attr('href');
        
        var page_id = $(".page:first-child").attr("page_id");
        
        var link='?r=book/author&bookId='+window.lindneo.currentBookId+'&page='+page_id;

        var slink='?r=chapter/create&book_id='+window.lindneo.currentBookId;

        if (link != "") {
          window.location.assign(link);
        }
        else
          window.location.assign(slink);


      };
      //ekaratas end

      $('.page[page_id="'+page_id+'"]').hide('slow', function(){  $('.page[page_id="'+page_id+'"]').remove();});
      sortPages();

    });

    $('#chapters_pages_view').sortable({
      axis:'y',
      stop: function(event,ui){
        sortPages();
        $('.chapter input').change();
      }
    });



    $('.pages').sortable({ 
      connectWith: '.pages' , 
      axis:'y',
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
    $(".chat_text_box_holder input").click(function(){
        e = jQuery.Event("keypress")
        e.keyCode = 13; //choose the one you want
        console.log (e);

        $(".chat_text_box_holder textarea").trigger(e);

    });

    function handleEnter(evt) {
      if (evt.keyCode == 13 ) {
          if (evt.shiftKey) {
              //pasteIntoInput(this, "\n");
          } else {
            evt.preventDefault();
            var text= $(evt.target);
            console.log(text);
            var line = text.val();
            if (line != '' ) {
            window.lindneo.tsimshian.chatSendMessage(line);
            text.val("");
            }
          }
      }

    }
    function pasteIntoInput(el, text) {
      el.focus();
      if (typeof el.selectionStart == "number"
              && typeof el.selectionEnd == "number") {
          var val = el.value;
          var selStart = el.selectionStart;
          el.value = val.slice(0, selStart) + text + val.slice(el.selectionEnd);
          el.selectionEnd = el.selectionStart = selStart + text.length;
      } else if (typeof document.selection != "undefined") {
          var textRange = document.selection.createRange();
          textRange.text = text;
          textRange.collapse(false);
          textRange.select();
      }
    }



    $(".chat_text_box_holder textarea").keydown(handleEnter).keypress(handleEnter);

    var chats = JSON.parse(localStorage.getItem("chat_"+window.lindneo.currentBookId ));
    
    if (chats.length > 20 ){
      chats= chats.slice( chats.length - 20 );
      localStorage.setItem("chat_"+window.lindneo.currentBookId , JSON.stringify(chats));
    }

    $.each (chats, function (i,val) {
      window.lindneo.nisga.ChatNewLine( val.line,val.user,false );
    });





        }


  $('.ruler, .vruler').hide(); 

  $('#general-options').change(function(){
    var value=$(this).val();
    
    $('.ruler, .vruler').hide();
    if( value.indexOf("cetvel") !== -1) {
      $('.ruler, .vruler').show();
    }



    

  });

  window.lindneo.tlingit.loadPage(window.lindneo.currentPageId);
  window.lindneo.toolbox.load();
  $('#current_page')
	.click(function(e){
		//console.log(e);
		if($(e.target).attr('id')=="current_page")
			$('.selected').trigger('unselect');	
	})
  	.dblclick(function(e){
		$('.selected').trigger('unselect');
		//window.lindneo.toolbox.deleteComponentFromSelection();
	});

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

