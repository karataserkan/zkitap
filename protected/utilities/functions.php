<?php
class functions {  
    public static function get_random_string($length=44,$valid_chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")
    {
        // start with an empty random string
        $random_string = "";

        // count the number of chars in the valid chars string so we know how many choices we have
        $num_valid_chars = strlen($valid_chars);

        // repeat the steps until we've created a string of the right length
        for ($i = 0; $i < $length; $i++)
        {
            // pick a random number from 1 up to the number of valid chars
            $random_pick = mt_rand(1, $num_valid_chars);

            // take the random character out of the string of valid chars
            // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
            $random_char = $valid_chars[$random_pick-1];

            // add the randomly-chosen char onto the end of our string so far
            $random_string .= $random_char;
        }

        // return our finished random string
        return $random_string;
    }
    
    public static function new_id($length=44,$valid_chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"){
        $unique=true;

        while ( $unique) {
        $new_id=functions::get_random_string($length,$valid_chars);
        $unique=Yii::app()->db->createCommand()
        ->select('id')
        ->from('ids')
        ->where('id=:id', array(':id'=>$new_id))
        ->queryRow();
       
            
        }
       return $new_id;

    }
    
    public static function uuid($serverID=81)
    {
        $t=explode(" ",microtime());
        return sprintf( '%04x-%08s-%08s-%04s-%04x%04x',
            $serverID,
            functions::clientIPToHex(),
            substr("00000000".dechex($t[1]),-8),   // get 8HEX of unixtime
            substr("0000".dechex(round($t[0]*65536)),-4), // get 4HEX of microtime
            mt_rand(0,0xffff), mt_rand(0,0xffff));
    }

    public static function uuidDecode($uuid) {
        $rez=Array();
        $u=explode("-",$uuid);
        if(is_array($u)&&count($u)==5) {
            $rez=Array(
                'serverID'=>$u[0],
                'ip'=>functions::clientIPFromHex($u[1]),
                'unixtime'=>hexdec($u[2]),
                'micro'=>(hexdec($u[3])/65536)
            );
        }
        return $rez;
    }

    public static function clientIPToHex($ip="") {
        $hex="";
        if($ip=="") $ip=getEnv("REMOTE_ADDR");
        $part=explode('.', $ip);
        for ($i=0; $i<=count($part)-1; $i++) {
            $hex.=substr("0".dechex($part[$i]),-2);
        }
        return $hex;
    }

    public static function clientIPFromHex($hex) {
        $ip="";
        if(strlen($hex)==8) {
            $ip.=hexdec(substr($hex,0,2)).".";
            $ip.=hexdec(substr($hex,2,2)).".";
            $ip.=hexdec(substr($hex,4,2)).".";
            $ip.=hexdec(substr($hex,6,2));
        }
        return $ip;
    }
}
