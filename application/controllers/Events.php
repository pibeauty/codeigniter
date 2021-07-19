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

class Events extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

       /* if (!$this->aauth->premission(6)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }*/
        $this->load->model('events_model');
        $this->li_a = 'misc';

    }


    public function index()
    {
        $this->load->view('fixed/header');
        $this->load->view('events/cal');
        $this->load->view('fixed/footer');


    }

    /*Get all Events */

    public function getEvents()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $result = $this->events_model->getEventsCal($start, $end);
        echo json_encode($result);
    }

    /*Get one Employee Events */

    public function getEventsCusUser()
    {
        $id=$this->input->get('id');
        $cusUser=$this->input->get('cusUser');
        $result = $this->events_model->getEventsCusUser($id,$cusUser);
        echo json_encode($result);
    }

    /*Add new event */
    public function addEvent()
    {
        $title = $this->input->post('title', true);
        $start = $this->input->post('start', true);
        $end = $this->input->post('end', true);
        $description = $this->input->post('description', true);
        $color = $this->input->post('color');

        $result = $this->events_model->addEvent($title, $start, $end, $description, $color);

    }
    /*Add new Appointment */
    public function addAppointment()
    {
        $title = "";//$this->input->post('title', true);
        $start = $this->input->post('datetime', true);
        $end = $this->input->post('datetimeend', true);
        $datetime = $this->input->post('datetime', true);
        $datetimeend = $this->input->post('datetimeend', true);
        $description = $this->input->post('description', true);
        $color = $this->input->post('color');
        $userid = $this->input->post('userid');
        $customerid = $this->input->post('customerid');
        $service_id = $this->input->post('service_id');
       $result = $this->events_model->addAppointment($title, $start, $end, $description, $color,$userid,$customerid,$datetime,$datetimeend,$service_id);

    }
    /*Update Event */
    public function updateEvent()
    {
        $title = $this->input->post('title', true);
        $id = $this->input->post('id');
        $description = $this->input->post('description', true);
        $color = $this->input->post('color');
        $customerid = $this->input->post('customerid');
        $result = $this->events_model->updateEvent($id, $title, $description, $color, $customerid);
        echo $result;
    }

    /*Delete Event*/
    public function deleteEvent()
    {
        $result = $this->events_model->deleteEvent();
        echo $result;
    }

    public function dragUpdateEvent()
    {

        $result = $this->events_model->dragUpdateEvent();
        echo $result;
    }

}