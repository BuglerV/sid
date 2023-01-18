<?php

/**
 * Класс для отправки запросов через cURL.
 */
class Curl{
    
    /**
     * Ресурс cURL.
     *
     * @var CurlHandle
     */
    private $ch;

    /**
     * Создает объект и производит начальную настройку.
     *
     * @param boolean $return
     */
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
    
    /**
     * Закрываем ресурс.
     */
    public function __destruct(){
        curl_close($this->ch);
    }
    
    /**
     * Установка дополнительный опций.
     *
     * @param string $name
     * @param mixed $value
     * @return \Curl
     */
    public function set($name, $value){
        curl_setopt($this->ch, $name, $value);

        return $this;
    }

    /**
     * Запускает запросто методом POST.
     *
     * @param boolean $url
     * @param array $fields
     * @return mixed
     */
    public function execPost($url = false, $fields = []) {
        $this->set(CURLOPT_POST, true);
        $this->set(CURLOPT_POSTFIELDS, http_build_query($fields));

        return $this->exec($url, $fields);
    }
    
    /**
     * Запускает запрос методом GET.
     *
     * @param boolean $url
     * @return mixed
     */
    public function exec($url = false){
        if($url) {
            $this->set(CURLOPT_URL, $url);
		}

        return curl_exec($this->ch);
    }
    
}