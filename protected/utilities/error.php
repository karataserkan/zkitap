<?php
class error {
    public  function __construct($domain=null,$explanation='Error', $arguments=null,$debug_vars=null ){
        $this->domain=$domain;
        $this->explanation=$explanation;
        $this->arguments=$arguments;
        $this->debug_vars=$debug_vars;
    }
} 