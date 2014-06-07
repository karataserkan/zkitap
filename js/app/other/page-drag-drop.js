$( document ).ready(function () {
  /*
  $("#editor_view_pane").click(function(e){
    var control = true;
    if(e.target.id != "current_page")
    {
      var children = $("#current_page").children();
      $.each(children, function(i,key){

        if($($($(key).children()[0]).children()[0]).attr("id") == e.target.id || $($(key).children()[0]).attr("id") == e.target.id){
          //console.log($($($(key).children()[0]).children()[0]).attr("id")+" - "+e.target.id);
          control = false;
        }
      
      });
      if(control){
        //console.log("deselect");
         $('.selected').trigger('unselect');
       }
    } 
  });
*/
  bookPagePreviews();

  


  var keydown_component = [];
  var count = 0;

  $("body").keydown(function(e)
        {
            
            if(e.which == 46 || e.which == 37 || e.which == 38 || e.which == 39 || e.which == 40){
              //console.log($('.selected'));
              //console.log($('.selected').length);
              keydown_component = $('.selected');
              count++;
              
            }

        });

  $("body").keyup(function(e)
        {
            //console.log(e.which);
            //console.log(e);
            //console.log(count);
            var moved = count * 3;
            //console.log(moved);
            //return;
            if(e.which == 46 && e.shiftKey){
              for(var i=1; i < keydown_component.length; i++){
                $.ajax({
                  url: "/page/getComponent/"+keydown_component[i].id
                }).done(function(result) {
                  //console.log(result);
                  var delete_component = window.lindneo.tlingit.responseFromJson(result);
                  delete_component.data = window.lindneo.tlingit.responseFromJson(delete_component.data);
                  //console.log(delete_component);
                  window.lindneo.tlingit.componentHasDeleted(delete_component, delete_component.id);
                  $('[id="'+delete_component.id+'"]').parent().not('#current_page').remove();
                  $('[id="'+delete_component.id+'"]').remove();
                });
                      console.log(i);
                      i++;
                
              };
              
            }
            //left
            if(e.which == 37){

              for(var i=1; i < keydown_component.length; i++){
                $.ajax({
                  url: "/page/getComponent/"+keydown_component[i].id
                }).done(function(result) {
                  //console.log(result);
                  var update_component = window.lindneo.tlingit.responseFromJson(result);
                  update_component.data = window.lindneo.tlingit.responseFromJson(update_component.data);
                  update_component.data.self.css.left = update_component.data.self.css.left.replace('px','');
                  update_component.data.self.css.left = update_component.data.self.css.left - moved;
                  update_component.data.self.css.left = update_component.data.self.css.left+'px';
                  console.log(update_component.data.self.css.left);
                  window.lindneo.tlingit.componentHasUpdated(update_component);
                  $('#'+update_component.id).parent().css('left',update_component.data.self.css.left);
                  
                });
                      console.log(i);
                      i++;
                
              };

            }
            //top
            if(e.which == 38){

              for(var i=1; i < keydown_component.length; i++){
                $.ajax({
                  url: "/page/getComponent/"+keydown_component[i].id
                }).done(function(result) {
                  //console.log(result);
                  var update_component = window.lindneo.tlingit.responseFromJson(result);
                  update_component.data = window.lindneo.tlingit.responseFromJson(update_component.data);
                  update_component.data.self.css.top = update_component.data.self.css.top.replace('px','');
                  update_component.data.self.css.top = update_component.data.self.css.top - moved;
                  update_component.data.self.css.top = update_component.data.self.css.top+'px';
                  console.log(update_component.data.self.css.top);
                  window.lindneo.tlingit.componentHasUpdated(update_component);
                  $('#'+update_component.id).parent().css('top',update_component.data.self.css.top);
                  
                });
                      console.log(i);
                      i++;
                
              };

            }
            //right
            if(e.which == 39){

              for(var i=1; i < keydown_component.length; i++){
                $.ajax({
                  url: "/page/getComponent/"+keydown_component[i].id
                }).done(function(result) {
                  //console.log(result);
                  var update_component = window.lindneo.tlingit.responseFromJson(result);
                  update_component.data = window.lindneo.tlingit.responseFromJson(update_component.data);
                  update_component.data.self.css.left = update_component.data.self.css.left.replace('px','');
                  update_component.data.self.css.left = parseInt(update_component.data.self.css.left,10) + moved;
                  update_component.data.self.css.left = update_component.data.self.css.left+'px';
                  console.log(update_component.data.self.css.left);
                  window.lindneo.tlingit.componentHasUpdated(update_component);
                  $('#'+update_component.id).parent().css('left',update_component.data.self.css.left);
                  
                });
                      console.log(i);
                      i++;
                
              };

            }
            //bottom
            if(e.which == 40){

              for(var i=1; i < keydown_component.length; i++){
                $.ajax({
                  url: "/page/getComponent/"+keydown_component[i].id
                }).done(function(result) {
                  //console.log(result);
                  var update_component = window.lindneo.tlingit.responseFromJson(result);
                  update_component.data = window.lindneo.tlingit.responseFromJson(update_component.data);
                  update_component.data.self.css.top = update_component.data.self.css.top.replace('px','');
                  update_component.data.self.css.top = parseInt(update_component.data.self.css.top,10) + moved;
                  update_component.data.self.css.top = update_component.data.self.css.top+'px';
                  console.log(update_component.data.self.css.top);
                  window.lindneo.tlingit.componentHasUpdated(update_component);
                  $('#'+update_component.id).parent().css('top',update_component.data.self.css.top);
                  
                });
                      console.log(i);
                      i++;
                
              };

            }

            keydown_component = [];
            count = 0;

        });

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
    //console.log(is_checked);
    if(is_checked == "on"){
      $('.hruler').width($('#current_page').width());
      $('.vbruler').height($('#current_page').height());
      var ruler=$('.ruler').empty();
      var ruler_h=$('.vruler').empty();

      len=Math.round(Number($('.hruler').width())/38.0);
      len_height=Math.round(Number($('.vbruler').height())/38.0);

      console.log("LEN:"+len);
      item = $(document.createElement("div"));
      item.css({'width':'38px','float':'left', 'border-right': '1px solid #000','text-align':'left','padding-left':'2px'});
          for (i = 0; i < len; i++) 
          {
              ruler.append(item.clone().text(i));
          }

      item = $(document.createElement("div"));
     
          for (i = 0; i < len_height; i++) 
          {
             item.css({'height':'38px', 'border-top': '1px solid #000','text-align':'center'});
            if(i==0){item.css({'border-top':'none'})}
              ruler_h.append(item.clone().text(i));
          }


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
    
    	
	
	//$(ui.helper).addClass('ul.component_holder li, nowDraggingParentComponent');
  var componentDragging;
    $( ".component" ).draggable({
	
	      start:function(){
          componentDragging=$(this);

        $(this).addClass('nowDraggingParentComponent', 100 );

		   // $(ui.helper).addClass('ul.component_holder li');
	},
      stop:function(){
       	$(this).removeClass('nowDraggingParentComponent', 100);
			
	 },
	
	 appendTo:'body',
     helper:function(){
      return $(this).clone().addClass('nowDraggingClonedComponent').css('width',$(this).width()+'px');
     },
     scroll: false,
	addClasses: false,
	 
	 });
	 


    $('#current_page').droppable({
	
	   tolerance: 'fit',
      drop: function (event, ui) {
        //create a component object from dom object
        //pass it to tlingit 
              
        switch( $(ui.helper).attr('ctype')) {
		
          
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
            window.lindneo.dataservice.galery_popup(event, ui);
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
          case 'page':
            createPageComponent( event, ui );
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
        "+j__("Görsel Ekle")+" \
        <div class='popup-close' id='image-add-dummy-close-button'>x</div> \
        </div> \
          <div class='gallery-inner-holder'> \
            <div style='clear:both'></div> \
            <div class='add-image-drag-area' id='dummy-dropzone'> </div> \
          </div> \
          <div>\
            <input type='text' name='width' id='width' placeholder='"+j__("Genişlik")+"' value=''>\
            <input type='text' name='height' id='height' placeholder='"+j__("Yükseklik")+"' value=''>\
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

    $( document ).on( "click","canvas.preview" ,function(event, ui) {
      console.log(event);
      console.log($('.'+event.toElement.parentElement.children[1].className).attr('bpageTeplateId'));

      $('.selected').trigger('unselect');
      
      if(event.toElement.parentElement.children[1].className[0] == 'p'){
          //console.log($(event.toElement.parentElement.children[2]).attr('book-id'));
              var book_id= $(event.toElement.parentElement.children[2]).attr('book-id');
              var pageTeplateId=$(event.toElement.parentElement.children[2]).attr('pageTeplateId');
              //var chapter_id=$(this).attr('chapter_id');
              var currentPageId=window.lindneo.currentPageId;
              var link="/page/create?book_id="+book_id+"&page_id="+currentPageId+"&pageTeplateId="+pageTeplateId;
              console.log(link);
              window.location.href = link;
            }
      window.lindneo.tsimshian.pageCreated();
      //get page id from parent li 
      var page_id = $(this).parent().attr('page_id') ;
      //sortPages();
      console.log(window.lindneo.tlingit.pages);
      //Load Page
      window.lindneo.tlingit.loadPage(page_id);

      //console.log(window.lindneo.currentPageId);

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
                //$('#current_page').css('background-image', 'url()');
                $('#current_page').css('background-image', 'url("'+page_background.result.replace(/\s/g, '')+'")');
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
      var control_value = 0;
      $.each(window.lindneo.book_users, function(index,key){
        console.log(key);
        if(key.username != window.lindneo.user.username)
          if(key.pageid == page_id){
            alert("Başka bir kullanıcı bu sayfada çalıştığından bu sayfayı silemezsiniz!...");
            control_value = 1;
          }
      });
      if(control_value == 1)
        return;
      //return;
      window.lindneo.tlingit.PageHasDeleted( page_id );
      //return;
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
            min: 100,
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
      if(pageNum==0) window.lindneo.tlingit.pages=[];
      pageNum++;
      console.log({"page_id": $(this).attr('page_id'), "page_num": pageNum});
      window.lindneo.tlingit.pages.push({"page_id": $(this).attr('page_id'), "page_num": pageNum});
      $(this).find('.page-number').html(pageNum);
      //console.log($(this).attr('page_id'));
      if($(this).attr('page_id') == $("#current_page").attr('page_id')){
        $("#current_page").find('.page_number').val(pageNum);
        var new_num = pageNum;
        var page_component_id = $("#current_page").find('.page_number').attr('id');

        console.log(page_component_id);
        $.ajax({
          url: "/page/getComponent/"+page_component_id
        }).done(function(result) {
          //console.log(result);
          var update_component = window.lindneo.tlingit.responseFromJson(result);
          var data = window.lindneo.tlingit.responseFromJson(update_component.data);
          data.textarea.val = new_num;
          update_component.data = data;
          console.log(update_component);
          window.lindneo.tlingit.componentHasUpdated(update_component);
        });
      }

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

  function bookPagePreviews(){

    $($(".panel-body")[3]).html("");

    $.ajax({
      type: "GET",
      url: window.location.origin + "/book/getPagesAndChapters/" + window.lindneo.currentBookId,
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      cache: false,
      success: function (result) {

          //console.log(result.chapters); 
          //console.log(result.pages); 
          var value = "";
          var page_NUM = 0; 
          $.each(result.chapters, function(index, key){
            var chapter_page = 0;
            //console.log(key);
            value += '<div class="chapter"  chapter_id="'+key.chapter_id+'">\
                            <div class="chapter-detail">\
                              <input type="text" class="chapter-title" placeholder='+j__("Bölüm adı")+' value="'+key.title+'">\
                              <a class="btn btn-danger  page-chapter-delete delete-chapter hidden-delete" style="float: right; margin-top: -23px;"><i class="icon-ok"></i></a>\
                              <a class="page-chapter-delete_control hidden-delete" style="float: right; margin-top: -23px;"><i class="icon-delete"></i><i class="icon-delete"></i></a>\
                            </div>\
                            <ul class="pages" >';
            //console.log(result.pages[key.chapter_id]);
            if(typeof result.pages[key.chapter_id] != "undefined"){
              $.each(result.pages[key.chapter_id], function(indexp, keyp){
                //console.log(page_NUM);
                //console.log(keyp);
                page_NUM++;
                var page_link = "/book/author/"+window.lindneo.currentBookId+'/'+result.pages[key.chapter_id][indexp];

                value += '<li class="page ' + (window.lindneo.currentPageId == keyp  ? "current_page": "") +'" chapter_id="' + key.chapter_id + '" page_id="' + keyp + '" >\
                            <a class="btn btn-danger page-chapter-delete delete-page hidden-delete "  style="top: 0px;right: 0px; position: absolute;"><i class="icon-delete"></i></a>\
                            <a id="page_'+page_NUM+'" href="/book/author/'+ window.lindneo.currentBookId +'/'+ keyp +'"/></a>\
                          </li>';
                chapter_page++;
              });
              value += '</ul></div>';
              //console.log(value);
            }
          });
          //value = $(value);
          //value.appendTo('.panel-body');
          //console.log(value);
          $($(".panel-body")[3]).html(value);
          
          $.each($($(".panel-body")[3]).find("li"), function(i, k){
            var j = i+1;
            $("#page_"+j).append('<span class="page-number">'+ j +'</span>');
          });
          $('.pages').sortable({ 
            distance: 15,
            connectWith: '.pages' , 
            axis:'y',
            stop: function( event,ui){
              sortPages();
            }  
          });

          var last_timeout;
          $('.pages .page').hover(
            function(){
              //console.log('hover started');
              var timeout;
              var page_thumb_item = $(this);

              //$(this).find('.page-chapter-delete').hide();
              timeout = setTimeout(function(){ 
                page_thumb_item.find('.page-chapter-delete').show();
                //console.log('hover-timeout');
                clearTimeout(timeout);
              },1000);

              setTimeout(function(){
                clearTimeout(timeout);
              },2000); 

              last_timeout = timeout;
              //console.log('hover-out');
              //setTimeout(function(){alert("OK");}, 3000);

          },  
          function(){
            //clearTimeout(my_timer);
            $(this).find('.page-chapter-delete').hide();
            if (last_timeout) clearTimeout(last_timeout);

          });
          $('.chapter-detail').hover(
            function(){
              console.log('hover started');
              var timeout;
              var page_thumb_item = $(this);

              //$(this).find('.page-chapter-delete').hide();
              timeout = setTimeout(function(){ 
                page_thumb_item.find('.page-chapter-delete').eq(0).show();
                console.log('hover-timeout');
                clearTimeout(timeout);
              },1000);

              setTimeout(function(){
                clearTimeout(timeout);
              },2000); 

              last_timeout = timeout;
              console.log('hover-out');
              //setTimeout(function(){alert("OK");}, 3000);

          },  
          function(){
            //clearTimeout(my_timer);
            $(this).find('.page-chapter-delete').hide();
            if (last_timeout) clearTimeout(last_timeout);

          });

          $('.delete-chapter').click(function(){

            var chapter_id=$(this).parent().parent().attr('chapter_id');
            
            $('.chapter[chapter_id="'+chapter_id+'"]').hide('slow', function(){  $('.chapter[chapter_id="'+chapter_id+'"]').remove();});
            window.lindneo.tlingit.ChapterHasDeleted( chapter_id );
            sortPages();

          });

          $('.chapter-title').change(function(){
              window.lindneo.tlingit.ChapterUpdated(
                $(this).parent().parent().attr('chapter_id'),
                $(this).val( ),
                $(this).parent().index() 
              );
          });

          $('.delete-page').click(function(){
      
            var delete_buttons = $('<i class="icon-delete"></i><i class="icon-delete"></i>');

            var page_id=$(this).parent().attr('page_id');
            var control_value = 0;
            $.each(window.lindneo.book_users, function(index,key){
              console.log(key);
              if(key.username != window.lindneo.user.username)
                if(key.pageid == page_id){
                  alert("Başka bir kullanıcı bu sayfada çalıştığından bu sayfayı silemezsiniz!...");
                  control_value = 1;
                }
            });
            if(control_value == 1)
              return;
            //return;
            window.lindneo.tlingit.PageHasDeleted( page_id );
            //return;
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
    

          window.lindneo.tlingit.loadAllPagesPreviews();
          $(window).bind("beforeunload", function() {
             window.lindneo.tlingit.updatePageCanvas(window.lindneo.currentPageId, function(){},false);
   
          });
        //console.log(value);
      }
    });
    

  }


  
