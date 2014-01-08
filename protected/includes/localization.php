<?php
/**

	find . -type f -iname "*.php" > filelist && xgettext --keyword=__ --keyword=_e --keyword=_en:1,2 --keyword=_n:1,2   --from-code='UTF-8' --force-po --join-existing -n -i -o messages.po -p protected/locale/messages/en_US --files-from=filelist

 * Wrapper function for Yii::t()
 */
function __($string, $params = null, $category = "") {
	
		if (is_array($params)) 
        	return vsprintf (Yii::t($category, $string),$params);
    	else
			return sprintf (Yii::t($category, $string),$params);
}

function _e($string, $params = null, $category = "") {
        echo __($string, $params , $category);
}


function _n($string_single,$string_plural, $number, $category = "") {
    if ($number != 1) return __($string_plural, array($number) , $category);
	return __($string_single, array($number), $category);
}

function _en($string_single,$string_plural, $number, $category = "") {
    echo _n($string_single,$string_plural, $number, $category = "");
}
