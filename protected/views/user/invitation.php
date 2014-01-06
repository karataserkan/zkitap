<?php 
if($newUser)
	echo $this->renderPartial('_invitation_form', array('model'=>$model));
else
	echo "İsteği kabul ettiniz. Anasayfaya giderek sisteme giriş yapabilirsiniz.";
?>