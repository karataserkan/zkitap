<?php
require_once('padCrypt.php');
require_once('AES_Encryption.php');

class Encryption
{
    const CYPHER = MCRYPT_RIJNDAEL_256;
    const MODE   = MCRYPT_MODE_CBC;
    const SALT    = "myverylovelysalthere";

    public function encrypt($key,$plaintext)
    {

        return openssl_encrypt($plaintext,'aes-256-cfb' , $key,$options=2,$iv=substr($key,0,16));
    }

    public function decrypt($key,$crypttext)
    {
        return openssl_decrypt($crypttext,'aes-256-cfb' , $key,$options=2,$iv=substr($key,0,16));   
    }

    public function salty($filepath){
        return substr(hash('sha256',$filepath.'myverylovelysalthere'),0,32);
    }

    public function encryptFile($filepath,$saveas=null){
        
        $key = self::salty( basename($filepath) );
        if(!$saveas){
            $saveas=$filepath;
        }
        $openFile = file_get_contents($filepath) ;
        if (!$openFile) return fasle;
        
        if ( file_put_contents( $saveas , self::encrypt($key, $openFile ) ) ){
            return true;
        } 
        return fasle;
    }

    public function encryptFolder($folder){
        $path = realpath($folder);

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach($objects as $name => $object){
            if (is_file($name)){
                self::encryptFile($name);
            }
        }
    }

    public function decryptFile($filepath){
        $key = self::salty( basename($filepath) );
        return  self::decrypt($key, file_get_contents($filepath));
    }
    



}

