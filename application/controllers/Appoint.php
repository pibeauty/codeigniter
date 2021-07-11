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

class Appoint extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->library("jdf");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }
        $this->load->model('services_model', 'services');
        $this->load->model('dashboard_model');
        $this->load->model('tools_model');
        $this->load->model('customers_model', 'customers');
        $this->load->model('users_model', 'users');
        $this->load->model('employee_model', 'employee');
        $this->load->model('Events_model', 'events');
    }


    public function index()
    {//$id=0,$cusUser=0
        $id=$this->input->get('id');
        $cusUser=$this->input->get('cusUser');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' attendance ';
        $data['customers'] = $this->customers->get_datatables();
        //$data['users'] = $this->users->getAllUser();
        $data['employee'] = $this->employee->list_employee();
       /* if($id !=0 ){
            $data['getEventsURL'] ='events/getEventsCusUser/?id='.$id.'&cusUser='.$cusUser;
        }
        else{
            $data['getEventsURL'] ='events/getEvents';
        }*/
        if($this->aauth->get_user()->username=="admin"){
            $data['getEventsURL'] ='events/getEvents';
            $data['events'] = $this->events->eventList();
        }
        else{
            $data['getEventsURL'] ='events/getEventsCusUser/?id='.$this->aauth->get_user()->id.'&cusUser=1';
           $data['events'] = $this->events->eventListByuser($this->aauth->get_user()->id);
           // log_message('error',"------------------------------------ghjghacascsascj:". $this->aauth->get_user()->id);
        }




        $this->load->view('fixed/header', $head);
        $this->load->view('appoint/index',$data);
        $this->load->view('fixed/footer');

    }

    public function indexCC()
    {//$id=0,$cusUser=0
        $id=$this->input->get('id');
        $cusUser=$this->input->get('cusUser');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' attendance ';
        $data['customers'] = $this->customers->get_datatables();
        //$data['users'] = $this->users->getAllUser();
        $data['employee'] = $this->employee->list_employee();
       /* if($id !=0 ){
            $data['getEventsURL'] ='events/getEventsCusUser/?id='.$id.'&cusUser='.$cusUser;
        }
        else{
            $data['getEventsURL'] ='events/getEvents';
        }*/
        if($this->aauth->get_user()->username=="admin"){
            $data['getEventsURL'] ='events/getEvents';
        }
        else{
            $data['getEventsURL'] ='events/getEventsCusUser/?id='.$this->aauth->get_user()->id.'&cusUser=1';
           // log_message('error',"------------------------------------ghjghacascsascj:". $this->aauth->get_user()->id);
        }

        $data['events'] = $this->events->eventList2();
       // log_message('error',"------------------------------------ghjghacascsascj:". $id);
        $data['services'] = $this->services->serviceslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('appoint/indexCC',$data);
        $this->load->view('fixed/footer');

    }

    public function view()
    {
        $factor_code=$this->input->get('factor_code');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $head['usernm'] . ' attendance ';
        $data['event'] = $this->events->eventDetails($factor_code);

        $this->load->view('fixed/header', $head);
        $this->load->view('appoint/view',$data);
        $this->load->view('fixed/footer');
    }

    public function updateFactor(){
        $factor_code=$this->input->post('factor_code');
        $payment_type=$this->input->post('payment_type');
        $this->events->updateFactor($factor_code,$payment_type);

        echo json_encode(array('status' => 'Success', 'message' =>
            'Invoice Edited'));

    }

    function redirectPreviousPage()
    {
        if (isset($_SERVER['HTTP_REFERER']))
        {
            header('Location: '.$_SERVER['HTTP_REFERER']);}
        else {
            header('Location: http://'.$_SERVER['SERVER_NAME']);}
        exit;
    }
}