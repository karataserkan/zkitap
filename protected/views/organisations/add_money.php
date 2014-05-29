<?php
/* @var $this OrganisationsController */
/* @var $dataProvider CActiveDataProvider */


 ?>
<style type="text/css">
    
      #CreditCardFront span, #CreditCardFront strong { position: absolute; } #CreditCardFront span { color: #aaafb8; } #CreditCardFront strong { color: #8e8e8e; } .CardNumber { top: 90px; left: 15px; font-size: 20px; } .LastDate { left: 140px; top: 115px; font-size: 14px; } .UserName { top: 137px; left: 15px; font-size: 16px; font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; display: block; width: 205px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; } .focused { background-color: #fefbd9; } .CardLogo { position: absolute; left: 15px; top: 15px; display: none; } #CreditCardFront .CVCTxt { top: 65px; right: 20px; } 
</style>
 <script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements
$('#card_preview').css({'background-image': 'url(<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/card.jpg)', 'background-repeat': 'no-repeat'});
            $('#CreditCardBack').hide();
            $('.UserName').css('background-color','');
            $('.CardNumber').css('background-color','');
            $('.LastDate').css('background-color','');
            $('.CVCTxt').css('background-color','');
            $('#name').focus(function() {
              $('#CreditCardFront').show();
              $('#CreditCardBack').hide();
              $('#card_preview').css({'background-image': 'url(<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/card.jpg)', 'background-repeat': 'no-repeat'});
              $('.UserName').css('background-color','#fefbd9');
              $('.CardNumber').css('background-color','');
              $('.LastDate').css('background-color','');
              $('.CVCTxt').css('background-color','');
            });
            $('#cardnumber').focus(function() {
              $('#CreditCardFront').show();
              $('#CreditCardBack').hide();
              $('#card_preview').css({'background-image': 'url(<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/card.jpg)', 'background-repeat': 'no-repeat'});
              $('.UserName').css('background-color','');
              $('.CardNumber').css('background-color','#fefbd9');
              $('.LastDate').css('background-color','');
              $('.CVCTxt').css('background-color','');
            });
            $('#card_month').focus(function() {
                $('#CreditCardFront').show();
              $('#CreditCardBack').hide();
              $('#card_preview').css({'background-image': 'url(<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/card.jpg)', 'background-repeat': 'no-repeat'});
              $('.UserName').css('background-color','');
              $('.CardNumber').css('background-color','');
              $('.LastDate').css('background-color','#fefbd9');
              $('.CVCTxt').css('background-color','');
            });
            $('#card_year').focus(function() {
                $('#CreditCardFront').show();
              $('#CreditCardBack').hide();
              $('#card_preview').css({'background-image': 'url(<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/card.jpg)', 'background-repeat': 'no-repeat'});
              $('.UserName').css('background-color','');
              $('.CardNumber').css('background-color','');
              $('.LastDate').css('background-color','#fefbd9');
              $('.CVCTxt').css('background-color','');
            });

            $('#cvc').focus(function() {
              $('#CreditCardFront').hide();
              $('#CreditCardBack').show();
              $('.UserName').css('background-color','');
              $('.CardNumber').css('background-color','');
              $('.LastDate').css('background-color','');
              $('.CVCTxt').css('background-color','#fefbd9');
              $('#card_preview').css({'background-image': 'url(<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/cardback.jpg)', 'background-repeat': 'no-repeat'});
            });

            var month = "";
            var year = "";

            $('#card_month').change(function(){
                month = $(this).val();
            });

            $('#card_year').change(function(){
                year = $(this).val();
            });

            $('#add_balance').click(function() {
                var name=$('#name').val();
                var number=$('#cardnumber').val();
                number = number.replace(/\s/g, '');
                var ccv=$('#cvc').val();
                var num=0;
                var sum=0;
                for (var i = 0; i < number.length; i++) {
                  if ((i%2==0)) {
                    num=(number[i]*2);
                  }
                  else{
                    num=number[i];
                  }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
                  
                  if (num>9) {
                    num=1+(num-10);
                  }

                  sum+=parseInt(num);
                };
                
                if ((sum%10)==0) {
                  $('#cardnumber').css("color","green");
                  $.ajax({
                      type: "POST",
                      url: "/organisations/checkoutPlan/<?php echo $organisation?>",
                      data: {tutar:"<?php echo $tutar; ?>", plan_id: "<?php echo $plan_id; ?>", name: name, number: number, month:month, year:year,ccv:ccv}
                  })
                    .done(function( result ) {
                      console.log(result);
                      if(result){
                          
                      }
                  });
                }else{
                  $('#cardnumber').css("color","red");
                };

            });
  });

//if( !$('#sidebar').hasClass('mini-menu')) $('#sidebar').addClass('mini-menu');
    </script>
 <div id="content" class="col-lg-12">
	<!-- PAGE HEADER-->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-header">
				<h3 class="content-title pull-left"><?php _e('Bakiye') ?></h3>
                
			</div>
		</div>
	</div>
	<!-- /PAGE HEADER -->
	<div class="row">


<div style="width:60px; float:left;">
        <!-- Kitap Bilgileri -->
              
            <div id="bookname" style="float:left; font-size:18px;"></div>
            <div id="bookprice" style="float:right;"></div><br><br>
      
      <!-- /Kitap Bilgileri -->
        </div>
        <div id="odeme_bilgileri">
          <div style="width:420px; float:left;">
                
              <!-- Kart Bilgileri -->
              
             
                    <input type="text" class="form-control" id="tutar" value="Çekilecek tutar: <?php echo $tutar; ?>$" disabled><br>
                    <input type="text" class="form-control" id="name" placeholder="Kart Üzerindeki Ad Soyad"><br>
                    <input type="text" class="form-control" id="cardnumber" placeholder="Kart Numarası" data-mask="9999 9999 9999 9999"><br>
                <div id="cardmonth">
                    <select class="form-control" id="card_month" style="float:left; width:100px;">
                        <option value="0">Ay</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div id="cardyear">
                    <select class="form-control" id="card_year" style="float:left; width:100px; margin-left:10px;">
                        <option value="0">Yıl</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
                        <option value="17">2017</option>
                        <option value="18">2018</option>
                        <option value="19">2019</option>
                        <option value="20">2020</option>
                        <option value="21">2021</option>
                        <option value="22">2022</option>
                        <option value="23">2023</option>
                        <option value="24">2024</option>
                        <option value="25">2025</option>
                        <option value="26">2026</option>
                        <option value="27">2027</option>
                        <option value="28">2028</option>
                        <option value="29">2029</option>
                        <option value="30">2030</option>
                    </select>
                </div>
                    <input type="text" class="form-control" id="cvc" placeholder="CVC" style="float:right; width:200px;">
                    <br>
                    <br>
                    <br>
                
                <div class="row">
                </div>
                <div class="row">
                  <button type="button" class="btn btn-success" id="add_balance">Satın Al</button>
                </div>
            
              <!-- /Kart Bilgileri -->
            </div>
            <div id="card_preview" style="width:320px; height:200px; margin-left:10px; float:left; position: relative;">
                <div class="Perspective">
                    <div id="CreditCardFront">
                        <span class="CardLogo"></span>
                        <span class="CardNumber">1234 5678 9000 0000</span>
                        <strong class="UserName">AD SOYAD</strong>
                        <span class="LastDate">AA/YY</span>
                        <span class="Cardype"></span>
                        <span class="CVCTxt" style="display: none;">CVC</span>
                    </div>
                    <div id="CreditCardBack" class="past">
                        <span class="CVCTxt" style="position: absolute;margin: 55px 150px;">CVC</span>
                        <div id="CVCInfo" style="display: none;">
                            <div class="InfoBubble ArrowT">
                                <div class="Arrow"></div>Kartınızın arkasındaki son 3 rakam
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br>
            </div>
 

	</div>
</div>
