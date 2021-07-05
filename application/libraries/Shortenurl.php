<?php

// Declare the class
class Shortenurl
{

    // Constructor
    function __construct()
    {
        $this->key = '';
    }

    function setkey($key)
    {

        $this->key = $key;
    }

    // Shorten a URL
    function shorten($url)
    {
        // Send information along
        $url_c= $url;

        $params=array('access_token'=>$this->key,'longUrl'=>$url_c);

        $url = 'https://api-ssl.bit.ly/v3/user/link_save?'. http_build_query($params);


        $result = json_decode($this->bitly_get_curl($url), true);

     //   print_r($result);

        return (string)$result['data']['link_save']['link'];
    }



    function bitly_get_curl($uri) {
        $output = "";
        return $output;
    }

}