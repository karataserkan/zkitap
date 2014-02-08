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
	<div class="col-sm-4">
		<img src="<?php echo $userProfileMeta->meta_value; ?>" height="100px" id="userImage" />
		<a class="btn" href="#box-cover" data-toggle="modal">Edit</a>
	</div>
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
            image_base64=dataURL;
            // place the image value in the text box
            //document.getElementById('User_data').value = dataURL;
        }

        //Bind a click to a button to capture an image from the video stream
        var el = document.getElementById("capture");
        el.addEventListener("click", captureImage, false);

    </script>