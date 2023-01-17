<?php

class Curl{
    
    private $ch;
    
    public function __construct($return = true){
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['GET / HTTP/1.1']);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);

        if($return) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		}
    }
    
    public function __destruct(){
        curl_close($this->ch);
    }
    
    public function set($name, $value){
        curl_setopt($this->ch, $name, $value);

        return $this;
    }

    public function info(){
        return curl_getinfo($this->ch);
    }
    
    public function error(){
        return curl_error($this->ch);
    }

    public function execPost($url = false, $fields = []) {
        $this->set(CURLOPT_POST, true);
        $this->set(CURLOPT_POSTFIELDS, http_build_query($fields));

        return $this->exec($url, $fields);
    }
    
    public function exec($url = false){
        if($url) {
            $this->set(CURLOPT_URL, $url);
		}

        return curl_exec($this->ch);
    }
    
}