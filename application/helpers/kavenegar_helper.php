<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'third_party/vendor/autoload.php';

if ( ! function_exists('sendSms'))
{
    function sendSms ($mobile, $textMessage)
    {
        try{
            $api = new \Kavenegar\KavenegarApi("33584D58784576336A4B77616473746C594E4A5A416C61567A38417338727243794835725A78354C6344593D");
            $sender = "2000500666";
            // $message =  $this->input->post('text');
            $receptor = array($mobile);
            $result = $api->Send($sender,$receptor,$textMessage);
            if ($result)
            {
                // echo "1";
            }
        }
        catch(\Kavenegar\Exceptions\ApiException $e)
        {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            log_message('error',"sms errorMessage 1 = ". $e->errorMessage());
            // echo "0";
        }
        catch(\Kavenegar\Exceptions\HttpException $e)
        {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            log_message('error',"sms errorMessage 2 = ". $e->errorMessage());
            // echo "0";
        }
    }
}