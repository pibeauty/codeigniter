<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Uma Shankar. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@infinitywebinfo.com
 *  Website: https://www.infinitywebinfo.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://infinitywebinfo.com/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client;

class Sms Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugins_model', 'plugins');

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library('parser');

    }

    //todo section

    public function template()
    {

        $id = $this->input->post('invoiceid');
        $ttype = $this->input->post('ttype');
        if ($ttype == 'quote') {

            $invoice['tid'] = $id;
            $this->load->model('quote_model', 'quote');
            $invoice = $this->quote->quote_details($id);
            $validtoken = hash_hmac('ripemd160', 'q' . $id, $this->config->item('encryption_key'));

            $link = base_url('billing/quoteview?id=' . $id . '&token=' . $validtoken);
        } elseif ($ttype == 'purchase') {
            $invoice['tid'] = $id;
            $this->load->model('purchase_model', 'purchase');
            $invoice = $this->purchase->purchase_details($id);
            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));

            $link = base_url('billing/purchase?id=' . $id . '&token=' . $validtoken);
        } else {
            $invoice['tid'] = $id;

            $this->load->model('invoices_model', 'invoices');
            $invoice = $this->invoices->invoice_details($id);

            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));

            $link = base_url('billing/view?id=' . $id . '&token=' . $validtoken);
        }

        $sms_service = $this->plugins->universal_api(1);

        if ($sms_service['active']) {

            $this->load->library("Shortenurl");
            $this->shortenurl->setkey($sms_service['key1']);
            $link = $this->shortenurl->shorten($link);

        }

        $this->load->model('templates_model', 'templates');
        switch ($ttype) {
            case 'notification':
                $template = $this->templates->template_info(30);
                break;

            case 'reminder':
                $template = $this->templates->template_info(31);
                break;

            case 'refund':
                $template = $this->templates->template_info(32);
                break;


            case 'received':
                $template = $this->templates->template_info(33);
                break;

            case 'overdue':
                $template = $this->templates->template_info(34);
                break;


            case 'quote':
                $template = $this->templates->template_info(35);
                break;


            case 'purchase':
                $template = $this->templates->template_info(36);
                break;


        }

        $data = array(
            'BillNumber' => $invoice['tid'],
            'URL' => $link,
            'DueDate' => dateformat($invoice['invoiceduedate']),
            'Amount' => amountExchange($invoice['total'], $invoice['multi'])
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        echo json_encode(array('message' => $message));
    }


    public function send_sms()
    {
        /*
         * Define The SMS Gateway - Default Gateway is Twilio which can be configured via user interface
         * Other providers like 'TextLocal' need a manual configuration
         *   $gateway_code = 1;
         *  1 for twilio
         *  2 for TextLocal
         *  3 for Clockwork
         * 4 For Any Generic
         */
        #################################
        ########### SWITCH HERE###########
        $gateway_code = 1;
        ################################

        $mobile = $this->input->post('mobile');
        $text_message = $this->input->post('text_message');

        switch ($gateway_code) {
            case 1:
                $this->twilio($mobile, $text_message);
                break;
            case 2:
                $this->textlocal($mobile, $text_message);
                break;
            case 3:
                $this->clockwork($mobile, $text_message);
                break;
            case 4:
                $this->generic($mobile, $text_message);
                break;
            case 5:
                $this->msg91($mobile, $text_message);
                break;

			case 6:
				$this->bulk_sms($mobile, $text_message);
			break;
        }
    }


    private function twilio($mobile, $text_message)
    {
        require APPPATH . 'third_party/twilio-php-master/Twilio/autoload.php';

        $sms_service = $this->plugins->universal_api(2);


// Your Account SID and Auth Token from twilio.com/console
        $sid = $sms_service['key1'];
        $token = $sms_service['key2'];
        $client = new Client($sid, $token);


        $message = $client->messages->create(
        // the number you'd like to send the message to
            $mobile,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $sms_service['url'],
                // the body of the text message you'd like to send
                'body' => $text_message
            )
        );

        if ($message->sid) {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $message->status));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));
        }
    }


    private function textlocal($mobile, $text_message)
    {

        //code here

    }

    private function clockwork($mobile, $text_message)
    {
        //code here
    }


    private function generic($mobile, $text_message)
    {

        //code here

    }

    private function nexmo($mobile, $text_message)
    {
        //pending for release
    }

    private function msg91($mobile, $text_message)
    {
        //code here
    }

	public function bulk_sms($mobile, $text_message)
	{

		//code here
	}


}


