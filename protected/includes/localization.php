<?php
/**

find . -type f -iname "*.php" > filelist && xgettext --keyword=__ --keyword=_e --from-code='UTF-8' --force-po --join-existing -n -i -o messages.po -p protected/locale/messages/en_US --files-from=filelist

 * Wrapper function for Yii::t()
 */
function __($string, $params = array(), $category = "") {
        return Yii::t($category, $string, $params);
}

function _e($string, $params = array(), $category = "") {
        echo __($string, $params , $category);
}