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

class Events_model extends CI_Model
{

    var $table_customers = 'geopos_customers';

    /*Read the data from DB */
    public function getEventsByEmployeeId($start, $end,$em_id)
    {
        $e2=date('Y-m-d', strtotime($end. ' - 60 days'));
        $sql = "SELECT  * FROM geopos_events WHERE (geopos_events.userid = ?) AND ((geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end > ? )) ORDER BY id DESC LIMIT 1";
        return $this->db->query($sql, array($em_id,$start, $end,$e2))->result();

    }
    public function getEvents($start, $end)
    {


        $e2=date('Y-m-d', strtotime($end. ' - 60 days'));
        $sql = "SELECT  * FROM geopos_events WHERE (geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end > ? ) GROUP BY geopos_events.userid ORDER BY geopos_events.userid ASC ";
        return $this->db->query($sql, array($start, $end,$e2))->result();

    }

    public function getEventsCal($start, $end)
    {


        $this->db->select('*');
        $this->db->from('geopos_events');
        //$this->db->group_by('description');
        $this->db->order_by('id', 'desc');  # or desc

        $query = $this->db->get();
        return $query->result();

    /*    $e2=date('Y-m-d', strtotime($end. ' - 60 days'));
        $sql = "SELECT  * FROM geopos_events WHERE (geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end > ? )  ";

        return $this->db->query($sql, array($start, $end,$e2))->result();
*/
    }

    public function getEventsForReserve($date_from,$date_to,$service_id)
    {
      //  $e2=date('Y-m-d', strtotime($end. ' - 60 days'));
        $sql = "SELECT * FROM geopos_events WHERE (geopos_events.start BETWEEN ? AND ?) AND (geopos_events.service_id = ? ) ORDER BY geopos_events.start ASC";
        return $this->db->query($sql, array($date_from,$date_to,$service_id))->result();

      /* $e2=date('Y-m-d', strtotime($start. ' + 1 days'));
        $sql = "SELECT * FROM geopos_events WHERE (geopos_events.start <= ?) ORDER BY geopos_events.start ASC";
        return $this->db->query($sql, array($e2))->result();*/
    }
    /*Read the customer or user(employee) from DB */
    public function getEventsCusUser($id,$cusUser)
    {
        if($cusUser==0){
            $data = $this->db->get_where('geopos_events', array('customerid' => $id))->result();
        }
        else{
            $data = $this->db->get_where('geopos_events', array('userid' => $id))->result();
        }


        return $data;

    }
    /*Create new events */

    public function addEvent($title, $start, $end, $description, $color)
    {

        $data = array(
            'title' => $title,
            'start' => $start,
            'end' => $end,

            'description' => $description,
            'color' => $color
        );

        if ($this->db->insert('geopos_events', $data)) {
            return true;
        } else {
            return false;
        }
    }
    /*Create new Appointment */

    public function addAppointment($title, $start, $end, $description, $color,$userid,$customerid,$datetime,$datetimeend,$service_id)
    {
        $this->db->select('*');
        $this->db->from('services');
        $this->db->where('id', $service_id);
        $query = $this->db->get();
        $service_name= $query->row_array();

        $this->db->select('*');
        $this->db->from('geopos_customers');
        $this->db->where('id', $customerid);
        $query = $this->db->get();
        $Cus= $query->row_array();
        $factor_code=$this->generateRandomString();
        $data = array(
            'title' => $Cus['name'],
            'start' => $datetime,
            'end' => $datetimeend,
            'userid' => $userid,
            'customerid' => $customerid,
            'description' => $factor_code,
            'color' => $color,
            'cus_name' => $Cus['name'],
            'cus_mobile' => $Cus['phone'],
            'service_id' => $service_id,
            'service_name' =>$service_name['name']
        );

        if ($this->db->insert('geopos_events', $data)) {
            return true;
        } else {
            return false;
        }
    }
    /*Update  event */

    public function updateEvent($id, $title, $description, $color)
    {
        $sql = "UPDATE geopos_events SET title = ?, description = ?, color = ? WHERE id = ?";
        $this->db->query($sql, array($title, $description, $color, $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function updateFactor($factor_code,$how_pay){
        $sql = "UPDATE geopos_events SET how_pay = ? WHERE description = ?";
        $this->db->query($sql, array($how_pay, $factor_code));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /*Delete event */

    public function deleteEvent()
    {

        $sql = "DELETE FROM geopos_events WHERE id = ?";
        $this->db->query($sql, array($_GET['id']));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /*Update  event */

    public function dragUpdateEvent()
    {

        $sql = "UPDATE geopos_events SET  geopos_events.start = ? ,geopos_events.end = ?  WHERE id = ?";
        $this->db->query($sql, array($_POST['start'], $_POST['end'], $_POST['id']));
        return ($this->db->affected_rows() != 1) ? false : true;


    }

    public function addReserve($data,$name,$mobile){

        $this->db->select('*');
        $this->db->from($this->table_customers);
        $this->db->where('phone', $mobile);
        $query = $this->db->get();
        $valid = $query->row_array();
        $insert_id=1;
        if (!$valid['phone']) {
            $post_data=array(
                'name' => $name,
                'phone' => $mobile,
            );
            $this->db->insert($this->table_customers, $post_data);
            $insert_id = $this->db->insert_id();
        }
        else{
            $insert_id=$valid['id'];
        }
      /*  $data = array(
            'title' => $data $item->date_fromSET  $item->date_toSET
        );*/
        $factor_code=$this->generateRandomString();
        $price=0;
        foreach (json_decode($data) as $item){
            $price=$price+50000;
            $data = array(
                'userid' => $insert_id,
                'start' => $item->date_fromSET,
            'end' => $item->date_toSET,
                'service_id' => $item->service_id,
                'service_name' => $item->service_name,
            'cus_name' => $name,
                'cus_mobile' => $mobile,
                'description' => $factor_code,
                'title' => $name,
                'total_price' => $price,
                'pay_price' => $price,
            );
            $this->db->insert('geopos_events', $data);
            log_message('error',"------------------------------------ghjghacascsascj3:".json_encode($item));

        }

        //return $data;
        /*if ($this->db->insert('geopos_events', $data)) {
            return true;
        } else {
            return false;
        }*/

    }
    function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function eventList()
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->group_by('description');
        $this->db->order_by('id', 'desc');  # or desc

        $query = $this->db->get();
        return $query->result_array();
    }
    public function eventList2()
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        //$this->db->group_by('description');
        $this->db->order_by('id', 'desc');  # or desc

        $query = $this->db->get();
        return $query->result_array();
    }

    public function eventListByuser($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('userid',$id);
        $this->db->group_by('description');
        $this->db->order_by('id', 'desc');  # or desc

        $query = $this->db->get();
        return $query->result_array();
    }

    public function eventDetails($factor_code)
    {

        $this->db->select('*')
            ->from('geopos_events')
            ->join('geopos_employees', 'geopos_events.userid = geopos_employees.id', 'left')
            ->where('geopos_events.description', $factor_code);

        /*$this->db->select('*')
            ->from('geopos_events')
            ->join('geopos_employees', 'geopos_events.userid = geopos_employees.id')
            ->where('geopos_eventsdescription.', $factor_code);
*/
        $query = $this->db->get();

        return $query->result_array();
      /*  $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('description', $factor_code);
        $query = $this->db->get();
        return $query->result_array();*/
    }
}