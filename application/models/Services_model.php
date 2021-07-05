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


class Services_model extends CI_Model
{
    var $table = 'services';

    public function __construct()
    {
        parent::__construct();
    }


    public function getServices(){

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('parent_id', 0);

        $parent = $this->db->get();

        $categories = $parent->result();
        $i=0;
        foreach($categories as $main_cat){

            $categories[$i]->sub = $this->subServices($main_cat->id);
            $i++;
        }


        return $categories;
    }

    public function subServices($id){

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('parent_id', $id);

        $child = $this->db->get();
        $categories = $child->result();
        $i=0;
        foreach($categories as $sub_cat){

            $categories[$i]->sub = $this->subServices($sub_cat->id);
            $i++;
        }
        return $categories;
    }

    public function serviceslist()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('parent_id <>' ,0);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function details($acid)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $acid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function addnew($name,$settime,$parent_id,$price)
    {
        $data = array(
            'name' => $name,
            'settime' => $settime,
            'parent_id'=>$parent_id,
            'price'=>$price
        );
       // log_message('error',"------------------------------------ghjghacascsascj:add_new".$name);
        if ($this->db->insert($this->table, $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED'). "  <a href='".base_url('services')."' class='btn btn-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a> <a href='add' class='btn btn-info btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($acid, $name,$settime,$price)
    {

               $data = array(
            'name' => $name,
                   'settime' => $settime,
                   'price'=>$price
        );

        $this->db->set($data);
        $this->db->where('id', $acid);

        if ($this->db->update($this->table)) {
          echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


public function deleteService($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query->row_array()['parent_id'] ==0){

            $this->db->delete($this->table, array('parent_id' => $query->row_array()['id']));
            $this->db->delete($this->table, array('id' => $id));
            return true;
        }
        else{
            if ($this->db->delete($this->table, array('id' => $id))) {
                return true;
            } else {
                return false;
            }
        }



    }
}