
 	$( document ).ready(function() {
    $('form').addClass('form-horizontal');
    
    $('#workspaces>div').on('click',function(){
        $('#workspaces>div>span>div>span').removeClass('checked');
        $(this).children().children().children().addClass('checked');
    });

    $('#templates>div').on('click',function(){
        $('#templates>div>span>div>span').removeClass('checked');
        $(this).children().children().children().addClass('checked');
    });

    $('#book_size>div').on('click',function(){
        $('#book_size>div>span>div>span').removeClass('checked');
        $(this).children().children().children().addClass('checked');

        var sizes=$(this).children().children().children().children().val();
        $.getJSON( "/book/getTemplates/"+sizes, function( data ) {
           var items = [];
           $.each( data, function( key, val ) {
             items.push('<div class="" id="uniform-templates_'+key+'"><span class=""><input class="uniform" id="templates_'+key+'" value="'+val.id+'" type="radio" name="templates"></span><label for="templates_'+key+'"><img src="'+val.thumbnail+'" width="150px" height="150px">'+val.title+'</label><br></div>');
             
           });
        $('#templates').html(items);         
          // $( "<ul/>", {
          //   "class": "my-new-list",
          //   html: items.join( "" )
          // }).appendTo( "body" );
         });

    });

	// $('span div span').on('click','[name="book_size"]',function(){
	// 	var sizes=$(this).val();
	// 	$.getJSON( "/book/getTemplates/"+sizes, function( data ) {
	// 	   var items = [];
	// 	   $.each( data, function( key, val ) {
	// 	     items.push('<div class="" id="uniform-templates_'+key+'"><span class=""><input class="uniform" id="templates_'+key+'" value="'+val.id+'" type="radio" name="templates"></span><label for="templates_'+key+'"><img src="'+val.thumbnail+'" width="150px" height="150px">'+val.title+'</label><br></div>');
		     
	// 	   });
	// 	$('#templates').html(items);		 
	// 	  // $( "<ul/>", {
	// 	  //   "class": "my-new-list",
	// 	  //   html: items.join( "" )
	// 	  // }).appendTo( "body" );
	// 	 });
	// });

	var BookCreateWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            var wizform = $('#FileForm');
			var alert_success = $('.alert-success', wizform);
            var alert_error = $('.alert-danger', wizform);
            
			/*-----------------------------------------------------------------------------------*/
			/*	Validate the form elements
			/*-----------------------------------------------------------------------------------*/
            wizform.validate({
                doNotHideMessage: true,
				errorClass: 'error-span',
                errorElement: 'span',
                rules: {
                    book_name:{
                        required: true
                    },
                    book_author:{
                        required: true
                    },
                    workspaces:{
                        required: true
                    },
                    book_type:{
                        required: true
                    },
                    // book_size:{
                    //     required: true
                    // },
                    // templates:{
                    //     required: true
                    // },                    
                },

                invalidHandler: function (event, validator) { 
                    alert_success.hide();
                    alert_error.show();
                },

                highlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); 
                },

                unhighlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-error'); 
                },

                success: function (label) {
                    if (label.attr("for") == "gender") { 
                        label.closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); 
                    } else { 
                        label.addClass('valid') 
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); 
                    }
                }
            });
            
            var data;
            var formDisplay = function(){
            };

           
            $('.epub_select').hide();
            $('.pdf_select').hide();

            /*-----------------------------------------------------------------------------------*/
            /*  Initialize Bootstrap Wizard
            /*-----------------------------------------------------------------------------------*/

            // $("span#book_type label").click(function(e){
            // 	var book_type=this.innerText;
            // 	console.log(book_type);
            // });



            $('#bookCreateWizard').find('.nextBtn').hide();
            $('#bookCreateWizard').bootstrapWizard({
                'nextSelector': '.nextBtn',
                'previousSelector': '.prevBtn',
                onNext: function (tab, navigation, index) {
                $('#bookCreateWizard').find('.nextBtn').show();
                    alert_success.hide();
                    alert_error.hide();
                    if (wizform.valid() == false) {
                        return false;
                    }

                    var total = navigation.find('li').length;
                    var epub=$('#uniform-book_type_0 span.checked');
                    var pdf=$('#uniform-book_type_1 span.checked');

                    var current = index + 1;
                    

                    // if (current==2) {
                        
                    //  // if (pdf.length) {
                    //  //  $('#bookCreateWizard').bootstrapWizard('remove', 2);
                    //  //  $('#bookCreateWizard').bootstrapWizard('remove', 3);
                    //  // }
                    //  // else if (epub.length) {
                    //  //  $('#bookCreateWizard').bootstrapWizard('remove', 5);
                    //  // };
                    // };

                    $('.stepHeader', $('#bookCreateWizard')).text('Step ' + (index + 1) + ' of ' + total);
                    jQuery('li', $('#bookCreateWizard')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }
                    if (current == 1) {
                        $('#bookCreateWizard').find('.prevBtn').hide();
                    } else {
                        $('#bookCreateWizard').find('.prevBtn').show();
                    }
                    if (current >= total) {
                        $('#bookCreateWizard').find('.nextBtn').hide();
                        $('#bookCreateWizard').find('.submitBtn').show();
                        formDisplay();
                    } else {
                        $('#bookCreateWizard').find('.nextBtn').show();
                        $('#bookCreateWizard').find('.submitBtn').hide();
                    }
                    if (index==1) {
                    	$('#bookCreateWizard').find('.prevBtn').hide();
                    };
                },
                onPrevious: function (tab, navigation, index) {
                    alert_success.hide();
                    alert_error.hide();
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    
                    // if (current==1) {
                    // 	$('.epub_select').hide();
                    // 	$('.pdf_select').hide();
                    // };

                    $('.stepHeader', $('#bookCreateWizard')).text('Step ' + (index + 1) + ' of ' + total);
                    jQuery('li', $('#bookCreateWizard')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }
                    if (current == 1) {
                        $('#bookCreateWizard').find('.prevBtn').hide();
                    } else {
                        $('#bookCreateWizard').find('.prevBtn').show();
                    }
                    if (current >= total) {
                        $('#bookCreateWizard').find('.nextBtn').hide();
                        $('#bookCreateWizard').find('.submitBtn').show();
                    } else {
                        $('#bookCreateWizard').find('.nextBtn').show();
                        $('#bookCreateWizard').find('.submitBtn').hide();
                    }
                    if (index==1) {
                    	$('#bookCreateWizard').find('.prevBtn').hide();
                    };
                },
				onTabClick: function (tab, navigation, index) {
                    bootbox.alert('On Tab click is disabled');
                    return false;
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#bookCreateWizard').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

			 $('#bookCreateWizard').bootstrapWizard({'tabClass': 'nav nav-pills'});

            $('#uniform-book_type_1 span').on('click', function() {
                $($('#uniform-book_type_1 span').children()[0]).find('input').attr('checked','checked');
				$('#bookCreateWizard').bootstrapWizard('remove', 2, false);
                $('.pdf_select').show();
				//$('#bookCreateWizard').bootstrapWizard('remove', 3, false);
				//$('#bookCreateWizard').bootstrapWizard('remove', 2, true);
				$('#bookCreateWizard').bootstrapWizard('display', 4);
                $('#bookCreateWizard').bootstrapWizard('show',1);
                $('#bookCreateWizard').find('.nextBtn').show();
            });
            $('#uniform-book_type_0 span').on('click', function() {
                $($('#uniform-book_type_0 span').children()[0]).find('input').attr('checked','checked');
                $('.epub_select').show();
                $('#bookCreateWizard').bootstrapWizard('remove', 4, true);
                $('#bookCreateWizard').bootstrapWizard('display', 3);
                $('#bookCreateWizard').bootstrapWizard('display', 2);
                $('#bookCreateWizard').bootstrapWizard('show',1);
                $('#bookCreateWizard').find('.nextBtn').show();
			});


            $('#bookCreateWizard').find('.prevBtn').hide();
            $('#templateCreate').click(function () {
                msg = Messenger().post({
                    message:"Eser oluşturuluyor. Lütfen Bekleyiniz",
                    type:"info",
                    showCloseButton: true,
                    hideAfter: 100
                });
                wizform.ajaxSubmit({
                	iframe: true,
                    url:'/book/createNewBook/',
                    success:function(response) {
                    		if (response) {
	                            msg.update({
	                                message: 'Eser oluşturma başarılı.',
	                                type: 'success',
	                                hideAfter: 5
	                            })
	                            console.log(response);
                             	window.location.href = '/book/author/'+response;
                    		}
                    		else{
                    			msg.update({
	                            message: 'Beklenmedik bir hata oluştu. Lütfen tekrar deneyin..',
	                            type: 'error',
	                            hideAfter: 5
	                        	})
                    		};
                    		
                        // bootbox.alert("Eser yayÄ±nlama baÅŸarÄ±lÄ±.",function(){
                        // });
                    },
                    error:function() { 
                        msg.update({
                            message: 'Beklenmedik bir hata oluştu. Lütfen tekrar deneyin.',
                            type: 'error',
                            hideAfter: 5
                        })
                        // bootbox.alert("Beklenmedik bir hata oluÅŸtu. LÃ¼tfen tekrar deneyin.");
                    },

                });
            }).hide();
            
        }
    };
}();    
$('#templateCreate').hide();
App.setPage("wizards_validations");  //Set current page
App.init(); //Initialise plugins and elements
BookCreateWizard.init();
});