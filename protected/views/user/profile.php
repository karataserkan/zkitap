<script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- PAGE -->
<div id="content" class="col-lg-12">
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h3 class="content-title pull-left"><?php echo $user->name.' '.$user->surname; ?></h3>
		</div>
	</div>
</div>
<div class="row">

        <div class="myprofile_information_container">
        
        <div class="myprofile_picture_container">
        <div class="change_profile_picture"><a href="#" data-id="box-cover" data-toggle="modal" data-target="#box-cover"><i class="fa fa-edit"></i></a></div>
        <?php
            $avatarSrc=Yii::app()->request->baseUrl."/css/ui/img/avatars/profile.png";
            $userProfileMeta=UserMeta::model()->find('user_id=:user_id AND meta_key=:meta_key',array('user_id'=>Yii::app()->user->id,'meta_key'=>'profilePicture'));
            if ($userProfileMeta->meta_value) {
                $avatarSrc=$userProfileMeta->meta_value;
            }
        ?>
        <img src="<?php echo $avatarSrc; ?>" id="profile_img">
        </div>
        
        
        
        <div class="myprofile_information_part">
        
        <div class="myprofile_information_components">
        <p>Profilim</p>
        <span id="feedback"></span>
        <a href="#" class="btn btn-success" style="float:right" id="updateProfile">Değişiklikleri Kaydet</a>
        </div>
        
        <div class="myprofile_information_components">
        <p>İsim</p>
        <div class="myprofile_info_edit"><i class="fa fa-edit"></i> <form id="myprofile_info_edit"><input id="name" placeholder="<?php echo $user->name; ?>" /></form></div>
        </div>

        <div class="myprofile_information_components">
        <p>Soyisim</p>
        <div class="myprofile_info_edit"><i class="fa fa-edit"></i> <form id="myprofile_info_edit"><input id="surname" placeholder="<?php echo $user->surname; ?>" /></form></div>
        </div>
        
        <div class="myprofile_information_components">
        <p>E-Mail Adres</p>
        <div class="myprofile_info_edit"><i class="fa fa-edit"></i> <form id="myprofile_info_edit"><input id="email" placeholder="<?php echo $user->email; ?>" /></form></div>
        </div>
        
        
        <div class="myprofile_information_components">
        
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Şifreni Değiştir</a> </h3>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body"> 
                        <div><p>Eski Şifre:</p> <input name="LoginForm[password]" id="passwordEski" type="password"></div><br />
                        <div><p>Yeni Şifre:</p> <input name="LoginForm[password]" id="passwordYeni" type="password"></div><br />
                        <div> <p>Yine Şifre Tekrarı:</p> <input name="LoginForm[password]" id="passwordYeni2" type="password"></div>
                  </div>
                </div>
            </div>
        </div>
        
        </div>
        </div>
        <!-- end of myprofile_information_part -->



</div>
<!-- /PAGE HEADER -->
</div>
<!-- Picture BOX CONFIGURATION MODAL FORM-->
<div class="modal fade" id="box-cover" style="top:150px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e('Profil Resmi') ?></h4>
		</div>
		<div class="modal-body">
			<video id="video" style="width:200px; height:200px"></video>
			<br>
			<a id="capture" class="btn btn-success">Fotograf Çek</a>
			<input class="file-cover-up" name="logo" type="file" />
			<br><br>
			<img class="upload-cover-preview" id="upload-cover-preview">
			
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Kapat') ?></button>
		  <button type="button" id="coverSave" class="btn btn-primary"><?php _e('Kaydet') ?></button>
		</div>
	  </div>
	</div>
  </div>
<!-- /Picture BOX CONFIGURATION MODAL FORM-->
<script>
		var image_base64;
		var preview = $("#upload-cover-preview");
		
		$('#coverSave').click(function(){
			if (image_base64) {
				$.ajax({
						type: "POST",
                        data: { img: image_base64},
                        url:'/user/updatePhoto',
                }).done(function(hmtl){
                	$("#userImage").attr('src',image_base64);
                	$('#box-cover').modal('toggle');
                });
			};
		});

		$(".file").change(function(event){
		   var input = $(event.currentTarget);
		   var file = input[0].files[0];
		   var reader = new FileReader();
		   reader.onload = function(e){
		       image_base64 = e.target.result;
		       preview.attr('src',image_base64);
		   };
		   reader.readAsDataURL(file);
		  });
		$(".file-cover-up").change(function(event){
		   var input = $(event.currentTarget);
		   var file = input[0].files[0];
		   var reader = new FileReader();
		   reader.onload = function(e){
		       image_base64 = e.target.result;
		       preview.attr('src',image_base64);
		   };
		   reader.readAsDataURL(file);
		  });

        var video;
        var dataURL;

        //http://coderthoughts.blogspot.co.uk/2013/03/html5-video-fun.html - thanks :)
        function setup() {
            navigator.myGetMedia = (navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);
            navigator.myGetMedia({ video: true }, connect, error);
        }

        function connect(stream) {
            video = document.getElementById("video");
            video.src = window.URL ? window.URL.createObjectURL(stream) : stream;
            video.play();
        }

        function error(e) { console.log(e); }

        addEventListener("load", setup);

        function captureImage() {
            var canvas = document.createElement('canvas');
            canvas.id = 'hiddenCanvas';
            //$('#video').hide();
            //add canvas to the body element
           // document.body.appendChild(canvas);
            //add canvas to #canvasHolder
          //  document.getElementById('canvasHolder').value=canvas;
            var ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth/4;
            canvas.height = video.videoHeight/4;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            //save canvas image as data url
            dataURL = canvas.toDataURL();
            //set preview image src to dataURL
            document.getElementById('upload-cover-preview').src = dataURL;

            document.getElementById('profile_img').src = dataURL;
            image_base64=dataURL;
            // place the image value in the text box
            //document.getElementById('User_data').value = dataURL;
        }

        //Bind a click to a button to capture an image from the video stream
        var el = document.getElementById("capture");
        el.addEventListener("click", captureImage, false);

    </script>
    <script type="text/javascript">
        $('#updateProfile').click(function(){
            var name=$('#name').val();
            var surname=$('#surname').val();
            var email=$('#email').val();
            var passwordEski=$('#passwordEski').val();
            var passwordYeni=$('#passwordYeni').val();
            var passwordYeni2=$('#passwordYeni2').val();

            $.ajax({
                    type: "POST",
                    data: { name: name, surname: surname, email: email, passwordEski:passwordEski, passwordYeni:passwordYeni, passwordYeni2:passwordYeni2},
                    url:'/user/updateProfile',
            }).done(function(hmtl){
                $('#feedback').text(hmtl);
            });
        });
    </script>