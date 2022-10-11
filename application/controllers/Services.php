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

class Services extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        $this->load->model('dashboard_model');
        $this->load->model('tools_model');
        $this->load->model('services_model', 'services');
    }


    public function index()
    {//$id=0,$cusUser=0
        $id=$this->input->get('id');
        $cusUser=$this->input->get('cusUser');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $head['title'] = ' services ';
        $data['services'] = $this->services->getServices();

        //log_message('error',"------------------------------------ghjghacascsascj:". $id);


        $this->load->view('fixed/header', $head);
        $this->load->view('services/index',$data);
        $this->load->view('fixed/footer');

    }

    public function add(){
        $head['title'] = "Add Service";
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-add');
        $this->load->view('fixed/footer');
    }
    public function add_new(){
      $name = $this->input->post('name');
        $settime = $this->input->post('settime');
        $parent_id = $this->input->post('parent_id');
        $price = $this->input->post('price');
        echo   $this->services->addnew($name,$settime,$parent_id,$price);
    }
    public function addsub(){
        $id = $this->input->get('id');
        $data['service'] = $this->services->details($id);
        $head['title'] = "Add sub Service";
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-addsub',$data);
        $this->load->view('fixed/footer');
    }
    public function edit(){
        $id = $this->input->get('id');
         $data['service'] = $this->services->details($id);
        $head['title'] = "Edit Service";
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-edit',$data);
        $this->load->view('fixed/footer');
    }
    public function update(){
        $name = $this->input->post('name');
        $settime = $this->input->post('settime');
        $id = $this->input->post('id');
        $price = $this->input->post('price');
        $revisit = $this->input->post('revisit');
        echo   $this->services->edit($id,$name,$settime,$price,$revisit);
    }

    public function delete(){
        $id = $this->input->get('id');
         $this->services->deleteService($id);
        $this->redirectPreviousPage();
       // print_r($idc);
        //log_message('error',"------------------------------------ghjghacascsascj:". $idc);
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

    public function createServicesSelectOption()
    {
        $services = $this->services->serviceslist();
        $html = "<select name='product_name[]' class='form-control select-box' style='width:100%'>";
        foreach ($services as $row) {
            $cid = $row['id'];
            $acn = $row['name'];
            $html .= "<option value='$acn'>$acn</option>";
        }
        $html .= "</select>";
        echo $html;
    }
}