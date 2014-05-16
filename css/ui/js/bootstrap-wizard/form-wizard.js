var FormWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
			/*-----------------------------------------------------------------------------------*/
			/*	Show country list in Uniform style
			/*-----------------------------------------------------------------------------------*/
            $("#country_select").select2({
                placeholder: "Select your country"
            });

            var wizform = $('#wizForm');
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
                    contentTitle:{
                        required: true
                    },
                    contentType:{
                        required: true
                    },
                    contentExplanation:{
                        required: true
                    },
                    contentIsForSale:{
                        required: true
                    },
                    contentCurrency:{
                        required: true
                    },
                    contentPrice:{
                        number: true,
                       // required: true
                    },
                    // contentReaderGroup:{
                    //     required: true
                    // },
                    host:{
                        required: true
                    },

                    

                    card_cvc: {
						required: true,
                        digits: true,
                        minlength: 3,
                        maxlength: 3
                    },
                    
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
            $(".datepicker-fullscreen").pickadate({format:'dd/mm/yyyy'});
            $(".siraliDisplay").hide();
            var formDisplay = function(){
                $("p[data-display='contentTitle']").text($("[name='contentTitle']").val());
                $("p[data-display='contentExplanation']").text($("[name='contentExplanation']").val());
                
                var currency;
                var currencyCode= $("span.checked [name='contentCurrency']").val();
                if (currencyCode=='949') {
                    currency='TL';
                };
                if (currencyCode=='998') {
                    currency='Dollar';
                };
                if (currencyCode=='978') {
                    currency='Euro';
                };
                
                $("p[data-display='contentPrice']").text($("[name='contentPrice']").val()+' '+currency);
                // $("p[data-display='contentReaderGroup']").text($("[name='contentReaderGroup']").val());
                
                $("p[data-display='contentType']").text($("span.checked [name='contentType']").val());
                $("p[data-display='contentIsForSale']").text($("span.checked [name='contentIsForSale']").val());
                
                var hosts=$("span.checked [name='host[]']");
                var hostText= '';
                for (var i = 0; i < hosts.length; i++) {
                hostText +=$("label[for='"+$("span.checked [name='host[]']")[i].id+"']").html()+'<br>';
                };

                var acls=$("span.checked [name='acl[]']");
                var aclsText= '';
                for (var i = 0; i < acls.length; i++) {
                aclsText +=$("label[for='"+$("span.checked [name='acl[]']")[i].id+"']").html()+'<br>';
                };


                var categoriess2=$("span.checked [name='categoriesSirali[]']");
                var categoriesText2= '';
                $(".siraliDisplay").show();
                for (var i = 0; i < categoriess2.length; i++) {
                categoriesText2 +=$("label[for='"+$("span.checked [name='categoriesSirali[]']")[i].id+"']").html()+'<br>';
                };

                var categoriess=$("span.checked [name='categories[]']");
                var categoriesText= '';
                for (var i = 0; i < categoriess.length; i++) {
                categoriesText +=$("label[for='"+$("span.checked [name='categories[]']")[i].id+"']").html()+'<br>';
                };

                $("p[data-display='host']").html(hostText);
                $("p[data-display='contentAcl']").html(aclsText);
                $("p[data-display='categories']").html(categoriesText);
                $("p[data-display='categoriesSirali']").html(categoriesText2);

                //
                $("p[data-display='language']").text($("span.checked [name='language']").val());
                $("p[data-display='abstract']").text($("[name='abstract']").val());
                $("p[data-display='subject']").text($("[name='subject']").val());
                $("p[data-display='edition']").text($("[name='edition']").val());
                $("p[data-display='date']").text($("[name='date']").val());
                $("p[data-display='author']").text($("[name='author']").val());
                $("p[data-display='translator']").text($("[name='translator']").val());
                $("p[data-display='issn']").text($("[name='issn']").val());

                if ($("[name='tracking']").val()) {
                    $("p[data-display='tracking']").text('Girildi');
                }
                else
                {
                    $("p[data-display='tracking']").text('Girilmedi');
                }
                ;

                //var siraliNo=$(".siraliCheckbox").val();

                // if (siraliNo!=0) {
                //     $(".siraliDisplay").show();
                //     $("p[data-display='categoriesSirali']").text(siraliNo);
                // };
                    $("p[data-display='siraNo']").text($("[name='contentSiraliSiraNo']").val());
                    $("p[data-display='ciltNo']").text($("[name='contentSiraliCiltNo']").val());
            };

            /*-----------------------------------------------------------------------------------*/
            /*  Initialize Bootstrap Wizard
            /*-----------------------------------------------------------------------------------*/
            $('#formWizard').bootstrapWizard({
                'nextSelector': '.nextBtn',
                'previousSelector': '.prevBtn',
                onNext: function (tab, navigation, index) {
                    alert_success.hide();
                    alert_error.hide();
                    if (wizform.valid() == false) {
                        return false;
                    }

                    

                    var total = navigation.find('li').length;
                    var current = index + 1;
                    $('.stepHeader', $('#formWizard')).text('Step ' + (index + 1) + ' of ' + total);
                    jQuery('li', $('#formWizard')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }
                    if (current == 1) {
                        $('#formWizard').find('.prevBtn').hide();
                    } else {
                        $('#formWizard').find('.prevBtn').show();
                    }
                    if (current >= total) {
                        $('#formWizard').find('.nextBtn').hide();
                        $('#formWizard').find('.submitBtn').show();
                        formDisplay();
                    } else {
                        $('#formWizard').find('.nextBtn').show();
                        $('#formWizard').find('.submitBtn').hide();
                    }
                },
                onPrevious: function (tab, navigation, index) {
                    alert_success.hide();
                    alert_error.hide();
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    $('.stepHeader', $('#formWizard')).text('Step ' + (index + 1) + ' of ' + total);
                    jQuery('li', $('#formWizard')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }
                    if (current == 1) {
                        $('#formWizard').find('.prevBtn').hide();
                    } else {
                        $('#formWizard').find('.prevBtn').show();
                    }
                    if (current >= total) {
                        $('#formWizard').find('.nextBtn').hide();
                        $('#formWizard').find('.submitBtn').show();
                    } else {
                        $('#formWizard').find('.nextBtn').show();
                        $('#formWizard').find('.submitBtn').hide();
                    }
                },
				onTabClick: function (tab, navigation, index) {
                    bootbox.alert('On Tab click is disabled');
                    return false;
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#formWizard').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });
            $('#contentIsForSale_1').click(function(){
                if ($("span.checked [name='contentIsForSale']").val() == 'Free' ) {
                            $("[name='contentPrice']").parent().parent().hide();
                            $("[name='contentCurrency']").parent().parent().hide();

                        };
            });
            $('#contentIsForSale_0').click(function(){
                if ($("span.checked [name='contentIsForSale']").val() == 'Yes' ) {
                            $("[name='contentPrice']").parent().parent().show();
                            $("[name='contentCurrency']").parent().parent().show();

                        };
            });

            $('#siraliSiraNo').hide();
            $('#siraliCiltNo').hide();
            $('.siraliCheckbox').click(function(){
                if ($(".siraliCheckbox").is(':checked')) {
                    $('#siraliSiraNo').show();
                    $('#siraliCiltNo').show();
                }
                else
                {
                    $('#siraliSiraNo').hide();
                    $('#siraliCiltNo').hide();                    
                }
            });
            
            $('#detayRev').hide();
            var dr=0;
            $('.detayRevBtn').click(function(){
                dr++;
                $('.detayRevBtn>i').toggleClass('fa-arrow-circle-up',dr % 2 === 1);
                $('.detayRevBtn>i').toggleClass('fa-arrow-circle-down',dr % 2 === 0);
                if ((dr%2)==1) {
                    $('#detayRev').show("slow");
                    console.log($("[name='tracking']").val());
                }else
                {
                    $('#detayRev').hide("slow");
                }
                ;

            });

            $('#detailed').hide();
            var di=0;
            $('.detailBtn').click(function(){
                di++;
                $('.detailBtn>i').toggleClass('fa-arrow-circle-up',di % 2 === 1);
                $('.detailBtn>i').toggleClass('fa-arrow-circle-down',di % 2 === 0);
                if ((di%2)==1) {
                    $('#detailed').show("slow");
                }else
                {
                    $('#detailed').hide("slow");
                }
                ;

            });

            $('#formWizard').find('.prevBtn').hide();
            
            $('#formWizard #publishBk').click(function () {
                $('#formWizard').find('.submitBtn').hide();
                
               if ($("#rights").is(':checked')) {
                    
                msg = Messenger().post({
                    message:"Eser yayınlanıyor. Lütfen Bekleyiniz",
                    type:"info",
                    showCloseButton: true,
                    hideAfter: 100
                });
                wizform.ajaxSubmit({
                    url:'/editorActions/sendFileToCatalog/'+bookId,
                    success:function(response) {
                        var budgetError = response.search('budgetError');
                        console.log(budgetError);
                        if (budgetError==(-1)) {
                            msg.update({
                                message: 'Eser, yayınlama listesine eklendi.',
                                type: 'success',
                                hideAfter: 5

                            });
                            $('#publishedbookModal').addClass("in").show();

                        }else
                        {
                            msg.update({
                                message: 'Hesabınızda yeterli bakiye bulunmamaktadır.',
                                type: 'error',
                                hideAfter: 5
                            })
                            
                        }
                        // bootbox.alert("Eser yayınlama başarılı.",function(){
                        //     window.location.href = '/site/index';
                        // });
                    },
                    error:function() { 
                        msg.update({
                            message: 'Beklenmedik bir hata oluştu. Lütfen tekrar deneyin.',
                            type: 'error',
                            hideAfter: 5
                        })
                        // bootbox.alert("Beklenmedik bir hata oluştu. Lütfen tekrar deneyin.");
                    },

                });
                }else
                {
                    Messenger().post({
                        message:"Eser yayınlamadan önce Kullanıcı Sözleşmesini Kabul Ediyor olmanız gerekmektedir.",
                        type:"error",
                        showCloseButton: true
                    });
                    //bootbox.alert("Eser yayınlamadan önce Kullanıcı Sözleşmesini Kabul Ediyor olmanız gerekmektedir.");

                };
            }).hide();
        }
    };
}();