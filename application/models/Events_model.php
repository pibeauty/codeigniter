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
        // MO in query moshkel dare, age ye time vasate roz por shode bashe, time haye ghably ro barnemigardone
        // MO query paying ke comment shode be khatere geopos_events.end > ? comment shode chon nemidonim in chiye
        // $sql = "SELECT  * FROM geopos_events WHERE (geopos_events.userid = ?) AND ((geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end > ? )) ORDER BY id DESC LIMIT 1";
        // return $this->db->query($sql, array($em_id,$start, $end,$e2))->result();
        $sql = "SELECT  * FROM geopos_events WHERE (geopos_events.userid = ?) AND (geopos_events.start BETWEEN ? AND ?) ORDER BY id DESC";
        return $this->db->query($sql, array($em_id,$start, $end))->result();

    }

    /* MO Check if employee is busy in selected hours */
    public function employeeHasEvent($start, $end, $emId)
    {
        $sql = "SELECT  * FROM geopos_events WHERE (geopos_events.userid = ?) AND ((geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end BETWEEN ? AND ?) OR (geopos_events.start <= ? AND geopos_events.end >= ?)) ORDER BY id DESC";
        $result = $this->db->query($sql, array($emId, $start, $end, $start, $end, $start, $end))->result();
        log_message('error',"query result = ". json_encode($result));
        return $result;
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
        // $factor_code=$this->generateRandomString();
        $data = array(
            'title' => $Cus['name'],
            'start' => $datetime,
            'end' => $datetimeend,
            'userid' => $userid,
            'customerid' => $customerid,
            'description' => $description,
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

    public function updateEvent($id, $title, $description, $color, $customerid)
    {
        $this->db->select('*');
        $this->db->from('geopos_customers');
        $this->db->where('id', $customerid);
        $query = $this->db->get();
        $cus= $query->row_array();
        
        $sql = "UPDATE geopos_events SET title = ?, description = ?, color = ?, customerid = ?, cus_name = ? WHERE id = ?";
        $this->db->query($sql, array($title, $description, $color, $customerid, $cus['name'], $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function updateFactor($factor_code,$payment_type){
        $sql = "UPDATE geopos_events SET payment_type = ? WHERE description = ?";
        $this->db->query($sql, array($payment_type, $factor_code));
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

    public function addReserve($data,$name,$mobile,$referrerCode){
        log_message('error',"referrerCode = ".$referrerCode);
        $this->db->select('*');
        $this->db->from($this->table_customers);
        $this->db->where('phone', $mobile);
        $query = $this->db->get();
        $valid = $query->row_array();
        $insert_id=1;
        $userFirstReserve = false;
        if (!$valid['phone']) {
            $this->load->model('customers_model', 'customers');
            $referrerCustomer = $this->customers->getCustomerByPicode($referrerCode);
            if ($referrerCustomer)
            {
                $referrerId = $referrerCustomer['id'];
            }
            else
            {
                $referrerId = null;
            }
            $post_data=array(
                'name' => $name,
                'phone' => $mobile,
                'moaaref' => $referrerId,
            );
            $this->db->insert($this->table_customers, $post_data);
            $insert_id = $this->db->insert_id();

            $temp_password = "pi".$mobile;
            $pass = password_hash($temp_password, PASSWORD_DEFAULT);
            $userData = array(
                'user_id' => 1,
                'status' => 'active',
                'is_deleted' => 0,
                'name' => $name,
                'password' => $pass,
                'user_type' => 'Member',
                'cid' => $insert_id,
                'lang' => 'english'
            );
            $this->db->insert('users', $userData);

            $userFirstReserve = true;
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
                'start' => $item->date_fromSET,
                'end' => $item->date_toSET,
                'service_id' => $item->service_id,
                'service_name' => $item->service_name,
                'userid' => $item->id,
                'customerid' => $insert_id,
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

        if ($userFirstReserve)
        {
            if ($referrerCustomer)
            {
                if ($price > 0)
                {
                    $amountToAddToCredit = $this->customers->calculateAmountToAddToCredit($price);
                    $this->customers->recharge($referrerCustomer['id'], $amountToAddToCredit);
                }
            }
            else
            {
                log_message('error','referrerCustomer not found with referrerCode = '.$referrerCode);
            }
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
        $this->load->model('Services_model', 'services');
        $subServiceIds = $this->services->getParentSubServiceIds($this->input->get('serviceId'));
        $this->db->select('*');
        $this->db->from('geopos_events');
        if ($this->input->get('start_date') && $this->input->get('end_date') && $this->input->get('serviceId')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_events.start) >=', datefordatabase($this->input->get('start_date')));
            $this->db->where('DATE(geopos_events.start) <=', datefordatabase($this->input->get('end_date')));
            $this->db->where_in('service_id', $subServiceIds);
        }
        // $this->db->group_by('description');
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