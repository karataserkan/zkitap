$( document ).ready(function () {

  $('.ruler, .vruler').hide(); 
/*
  $('#general-options').change(function(){
    var value=$(this).val();
    
    $('.ruler, .vruler').hide();
    if( value.indexOf("cetvel") !== -1) {
      $('.ruler, .vruler').show();
    }
  });

  
 $('#cetvelcheck').click(function () {
    console.log(this);
    var value=$(this).val();
    console.log(value);
    $('.ruler, .vruler').hide();
    if( value.indexOf("cetvel") !== -1) {
      $('.ruler, .vruler').show();
    }
  });
  */
  $(':checkbox').change(function() {
    var is_checked = $('input:checkbox[name=cetvel]:checked').val();
    console.log(is_checked);
    if(is_checked == "on"){
      console.log('deneme dene denem');
      $('.ruler, .vruler').show();
    }
    else 
      $('.ruler, .vruler').hide();
  });
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

    $('#group_btn').click(function(){
      //console.log($('.selected'));
      $('.selected').trigger('group',window.lindneo.randomString()); 
    });
    $('#ungroup_btn').click(function(){
      $('.selected').trigger('ungroup');
      $('.selected').trigger('unselect');
    });
    $('#searchn').autocomplete({
      appendTo: "#page" ,
      minLength: 3, 
      autoFocus: true,
      source: function( request, response ) {
                //console.log('request:'+request);
                //console.log('response:'+response);
                var data= {
                  'currentPageId': window.lindneo.currentPageId,
                  'searchTerm':request.term 
                };
                window.lindneo.dataservice.send('SearchOnBook',data,

                  function( data ) {
                    data=window.lindneo.tlingit.responseFromJson(data);

                    //console.log(data);
                    
                  if (data.result==null) return;
                 
                  response( $.map( 
                    data.result.components, function( item ) {
                      //console.log(item.search);
                      var result={
                        'label': item.search.similar_result,
                        'value': item.id
                      };
                      //console.log('REsult'+result);
                      return result;
                    })
                  );
                }



                  );
            },
      select: function( event, ui ) {

          //console.log(event);
          if (ui.item) {
            $('#searchform').submit();
          }

          
        },   

        open: function(e,ui) {
            var acData = $(this).data('uiAutocomplete');
    
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

                    //console.log(me.html( me.text().replace(result, styledTerm) ));
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
      revert: true, 
      snap: true
    });


    $('#current_page').droppable({
      tolerance: 'fit',
      drop: function (event, ui) {
        //create a component object from dom object
        //pass it to tlingit 
              
        switch( $(ui.helper).attr('ctype') ) {
          
          case 'text':
            createTextComponent( event, ui , $(event.toElement).attr('ctype'));
            break;
          case 'side-text':
            createTextComponent( event, ui , $(event.toElement).attr('ctype'));
            break;

          case 'image':
            window.lindneo.dataservice.image_popup(event, ui);
            break;

          case 'galery':
            createGaleryComponent( event, ui );
            break;

          case 'sound':
            createSoundComponent( event, ui );
            break;

          case 'quiz':
            window.lindneo.dataservice.quiz_popup(event, ui);
            break;

          case 'mquiz':
            createMquizComponent( event, ui  );
            break;

          case 'video':
            window.lindneo.dataservice.video_popup(event, ui);
            break; 

          case 'popup':
            window.lindneo.dataservice.popup_popup(event, ui);
            break; 

          case 'grafik':
            window.lindneo.dataservice.graph_popup(event, ui);
            break;

          case 'shape':
            createShapeComponent( event, ui  );
            break;

          case 'link':
            window.lindneo.dataservice.link_popup(event, ui);
            break;
          case 'table':
            createTableComponent( event, ui  );
            break;

          case 'html':
            createHtmlComponent( event, ui  );
            break;

          case 'wrap':
            window.lindneo.dataservice.wrap_popup(event, ui);
            break;

          case 'latex':
            window.lindneo.dataservice.latex_popup(event, ui);
            break;

          case 'slider':
            createSliderComponent( event, ui );
            break;

          case 'tag':
            createTagComponent( event, ui );
            break;

          case 'plink':
            createPlinkComponent( event, ui );
            break;

          case 'thumb':
            createThumbComponent( event, ui );
            break;

          case 'rtext':
            createRtextComponent( event, ui );
            break;

          default:
            break; 
        }

                   }
      ,
      accept:'.component'
    
    });

    function image_popup(event, ui, component){
      $("<div class='popup ui-draggable' id='pop-image-popup' style='display: block; top:" + (ui.offset.top-$(event.target).offset().top ) + "px; left: " + ( ui.offset.left-$(event.target).offset().left ) + "px;'> \
        <div class='popup-header'> \
        Görsel Ekle \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
          </div> \
          <div>\
            <input type='text' name='width' id='width' placeholder='Genişlik' value=''>\
            <input type='text' name='height' id='height' placeholder='Yükseklik' value=''>\
          </div> \
        </div>").appendTo('body').draggable();

        $('#image-add-dummy-close-button').click(function(){

        $('#pop-image-popup').remove();  

        if ( $('#pop-image-popup').length ){
          $('#pop-image-popup').remove();  
        }

      });
      //console.log(component);
      createImageComponent( event, ui, component );

    };

    if(document.getElementById("current_page")!= null){
      drop_image("current_page");
    };

    if(document.getElementById("collapseOne")!= null){
      drop_image("collapseOne");
    };

    if(document.getElementById("collapseThum")!= null){
      drop_image("collapseThum");
    };

    function drop_image(div_id){
      var el = document.getElementById(div_id);
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
        //console.log(reader);
        window.lindneo.dataservice.newComponentDropPage(div_id, e, reader, file);
      });
    };
    
    $('.chapter-title').change(function(){
        window.lindneo.tlingit.ChapterUpdated(
          $(this).parent().parent().attr('chapter_id'),
          $(this).val( ),
          $(this).parent().index() 
        );
    });

    $('.delete-chapter').click(function(){

      var chapter_id=$(this).parent().parent().attr('chapter_id');
      
      $('.chapter[chapter_id="'+chapter_id+'"]').hide('slow', function(){  $('.chapter[chapter_id="'+chapter_id+'"]').remove();});
      window.lindneo.tlingit.ChapterHasDeleted( chapter_id );
      sortPages();

    });

    $( document ).on( "click","canvas.preview" ,function() {

      //get page id from parent li 
      var page_id = $(this).parent().attr('page_id') ;

      //Load Page
      window.lindneo.tlingit.loadPage(page_id);


      //Remove Current Page
      $('.page').removeClass('current_page');

      //Add Red Current Page
      $(this).parent().addClass('current_page');
      $.ajax({
        type: "POST",
        url:'/page/getPdfData?pageId='+page_id,
      }).done(function(page_data){
        
        var page_background = JSON.parse(page_data);
        //console.log(page_background.result);
        if(page_background.result){
                $('#current_page').css('background-image', 'url()');
                $('#current_page').css('background-image', 'url("'+page_background.result+'")');
        }
        else{
          //console.log('bu ne');
          $('#current_page').css('background-image', 'url()');
          $('#current_page').css('background-color', 'white');
        }
      });
      

    });

    $( document ).on( "click","canvas.preview" ,function(event, ui) {
      console.log(event);
      console.log(event.toElement.parentElement.children[1].className);
      if(event.toElement.parentElement.children[1].className[0] == 'p')
        window.location.href = $('.'+event.toElement.parentElement.children[1].className).attr('href');
      //get page id from parent li 
      var page_id = $(this).parent().attr('page_id') ;

      //Load Page
      window.lindneo.tlingit.loadPage(page_id);


      //Remove Current Page
      $('.page').removeClass('current_page');

      //Add Red Current Page
      $(this).parent().addClass('current_page');
      $.ajax({
        type: "POST",
        url:'/page/getPdfData?pageId='+page_id,
      }).done(function(page_data){
        
        var page_background = JSON.parse(page_data);
        //console.log(page_background.result);
        if(page_background.result){
                $('#current_page').css('background-image', 'url()');
                $('#current_page').css('background-image', 'url("'+page_background.result+'")');
        }
        else{
          //console.log('bu ne');
          $('#current_page').css('background-image', 'url()');
          $('#current_page').css('background-color', 'white');
        }
      });
      

    });

    $('.delete-page').click(function(){
      var delete_buttons = $('<i class="icon-delete"></i><i class="icon-delete"></i>');

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
      distance: 15,
      axis:'y',
      stop: function(event,ui){
        sortPages();
        $('.chapter input').change();
      }
    });



    $('.pages').sortable({ 
      distance: 15,
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
        //console.log (e);

        $(".chat_text_box_holder textarea").trigger(e);

    });

    function handleEnter(evt) {
      if (evt.keyCode == 13 ) {
          if (evt.shiftKey) {
              //pasteIntoInput(this, "\n");
          } else {
            evt.preventDefault();
            var text= $(evt.target);
            //console.log(text);
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
    
    if ( chats !== null ){
          if (chats.length > 20 ){
            chats= chats.slice( chats.length - 20 );
            localStorage.setItem("chat_"+window.lindneo.currentBookId , JSON.stringify(chats));
          }
    
          $.each (chats, function (i,val) {
            window.lindneo.nisga.ChatNewLine( val.line,val.user,false );
          });
    
    }



        }




  window.lindneo.tlingit.loadPage(window.lindneo.currentPageId);
  
  //Load Previews
  window.lindneo.tlingit.loadAllPagesPreviews();
     
  window.lindneo.toolbox.load();
  $('#current_page')
	.click(function(e){
		////console.log(e);
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
    console.log("sort page");
    $('#chapters_pages_view .page').each(function(e){
      pageNum++;
      $(this).find('.page-number').html(pageNum);
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

