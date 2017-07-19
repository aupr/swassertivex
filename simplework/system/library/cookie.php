<?php
class Cookie
{
    private $path;
    private $domain;
    private $secure;
    private $httponly;

    public function __construct($path = "", $domain = "", $secure = false, $httponly = false)
    {
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httponly = $httponly;
    }

    public function get($key) {
        if (isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        }

        return false;
    }

    public function set($key, $value, $time = 3600) {
        setcookie($key, $value, time()+$time, '/'.$this->path, $this->domain, $this->secure, $this->httponly);
    }

    public function make($key, $value, $time = 0, $path="", $domain="", $secure=false, $httponly=true) {
        setcookie($key, $value, $time, $path, $domain, $secure, $httponly);
    }

    public function delete($key){
        setcookie($key, '', time() - 2692000, $this->path, $this->domain);
    }

    public function destroy($key, $path="", $bTime=2692000, $domain="") {
        setcookie($key, '', time()-$bTime, $path, $domain);
    }
}