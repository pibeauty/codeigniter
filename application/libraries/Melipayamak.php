<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/vendor/autoload.php';
use Melipayamak\MelipayamakApi;

class Melipayamak {

    public $CI;

    private $username;
    private $password;
    private $number;
    private $Melipayamak;

    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();
        $this->CI->config->load('melipayamak');
        $this->username = $this->CI->config->item('melipayamak_username');
        $this->password = $this->CI->config->item('melipayamak_password');
        $this->number = $this->CI->config->item('melipayamak_number');
        $this->Melipayamak = new MelipayamakApi($this->username,$this->password);
    }

    public function send ($phones, $textMessage)
    {
        try{
            $sms = $this->Melipayamak->sms('soap');
            $to = $phones;
            $from = $this->number;
            $text = $textMessage;
            $response = $sms->send($to,$from,$text);
            // $json = json_decode($response);
            // echo $json->Value; //RecId or Error Number 
            return '1';
        }catch(Exception $e){
            // echo $e->getMessage();
            return '0';
        }
    }
}