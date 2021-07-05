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

class Purchaseorder_model extends CI_Model
{

    const SCOPE = 'PO';

    const TABLE = 'purchase_order';

    const SUP_TABLE = 'application_users';

    const SENT_STATUS = 'SENT';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_supplier($role_id){
        $query = $this->db->select('*')->from(self::SUP_TABLE)->where('role_id >', $role_id)->get();
        $result = $query -> result_array();
        return $result;
    }

    public function get_supplier_by_id($role_id, $id){
        $query = $this->db->select('*')->from(self::SUP_TABLE)->where('id', $id)->where('role_id >', $role_id)->get();
        $result = $query -> result_array();
        return $result;
    }

    public function create_po($data){
        $products = $this -> products_data_to_json($data);
        $purchase_order_number = $this -> get_purchase_number();
        try {
            $po_data = array(
                'purchase_order_number' => $purchase_order_number,
                'creator_subuser' => $data['user_id'],
                'creator_user' => $data['app_user_id'],
                'supplier_user' => $data['supplier_user'],
                'supplier_subuser' => $data['supplier'],
                'products_json' => $products,
                'status' => self::SENT_STATUS,
            );
            $this->db->insert('purchase_order', $po_data);
            return $purchase_order_number;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update_po_image($src, $id){
        $this->db->set('picture_src', $src);
        $this->db->where('purchase_order_number', $id);
        $this->db->update(self::TABLE);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function check_orders($user){
        $this->db->select('*');
        $this->db->from(self::TABLE);
        $this->db->where('supplier_user', $user);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function check_orders_by_date($user, $fromDate, $toDate){
        $this->db->select('*');
        $this->db->from(self::TABLE);
        $this->db->where('supplier_user', $user);
        $this->db->where('created_at >=', $fromDate);
        $this->db->where('created_at <=', $toDate);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function view_order($user, $poNum){
        $this->db->select('*');
        $this->db->from(self::TABLE);
        $this->db->where('supplier_user', $user);
        $this->db->where('purchase_order_number', $poNum);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_purchase_number (){
//        $this -> load -> helper();
        $this->load->helper('hgappactions_helper');
        return create_action_number(self::SCOPE);
    }

    private function products_data_to_json($data)
    {
        $products = $data ['products'];
        $qty = $data ['qty'];
        $prices = $data ['prices'];
        $subtotals = $data ['subtotals'];
        $arr = [];
        $arr['products'] = $products;
        $arr['qty'] = $qty;
        $arr['prices'] = $prices;
        $arr['subtotals'] = $subtotals;
        return json_encode($arr);
    }

    private function json_data_to_products($data)
    {
        $prData = json_decode($data,true);
        return $prData;
    }


}