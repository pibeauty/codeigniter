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

class Restservice_model extends CI_Model
{
//@todo change integers with constants
    public const DENY_STATUS = 0;
    public const CREATED_STATUS = 1;

    public const ACCEPT_STATUS = 3;
    public const DELIVERED_STATUS = 4;
    public const QTY_CHANGE_STATUS = 5;
    public const CANCEL_STATUS = 6;

    public function customers($id = '')
    {

        $this->db->select('*');
        $this->db->from('geopos_customers');
        if ($id != '') {

            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_customer($id)
    {
        return $this->db->delete('geopos_customers', array('id' => $id));
    }

    public function products($id = '')
    {

        $this->db->select('*');
        $this->db->from('geopos_products');
        if ($id != '') {

            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function invoice($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.id', $id);
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $query = $this->db->get();
        $invoice = $query->row_array();
        $loc = location($invoice['loc']);
        $this->db->select('geopos_invoice_items.*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('geopos_invoice_items.tid', $id);
        $query = $this->db->get();
        $items = $query->result_array();
        return array(array('invoice' => $invoice, 'company' => $loc, 'items' => $items, 'currency' => currency($invoice['loc'])));
    }

    public function startMakeSalesOrder($data)
    {
        $data1 = array(
            'products_n_qty' => $data['products'],
            'buyer' => $data['buyer'],
            'status' => 1,
            'date' => date('Y-m-d H:i:s')
        );

        $this->db->insert('sales_order', $data1);
        $query = $this->db->query("SELECT * FROM date_data ORDER BY id DESC LIMIT 1");
//        $result = $query->result_array();
        $result = $query->row_array();
        $id = $result['id'];
        return $id;
    }

    public function addSaleOrder($data)
    {
        $buyer = serialize($data['buyer']);
        $products = serialize($data['products']);
        try{
        $data1 = array(
            'products_n_qty' => $products,
            'buyer' => $buyer,
            'status' => 1,
            'date' => date('Y-m-d H:i:s'),
            'external_number' => $data['purchase_id'],
            'order_id' => $data['order_id'],
        );

        $this->db->insert('sales_order', $data1);
        $query = $this->db->query("SELECT * FROM sales_order ORDER BY id DESC LIMIT 1");
//        $result = $query->result_array();
        $result = $query->row_array();
        $id = $result['id'];
        return $id;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function commitSalesOrder($id)
    {
        var_dump($id);exit;
        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.id', $id);
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');
        $query = $this->db->get();
        $invoice = $query->row_array();
        $loc = location($invoice['loc']);
        $this->db->select('geopos_invoice_items.*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('geopos_invoice_items.tid', $id);
        $query = $this->db->get();
        $items = $query->result_array();
        return array(array('invoice' => $invoice, 'company' => $loc, 'items' => $items, 'currency' => currency($invoice['loc'])));
    }

    public function ordersChange($id = ''){
        $this->db->select('`id`,`external_number`, `status`, `is_changed`,`products_n_qty`');
        $this->db->from('sales_order');
        $this->db->where('is_changed', 1);
        if ($id != '') {

            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getOrderSale($id){
        $this->db->select('*');
        $this->db->from('sales_order');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getOrderSaleByExt($id){
        $this->db->select('*');
        $this->db->from('sales_order');
        $this->db->where('external_number', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function orderDelivered($id){
        $this->db->set('status', 4);
        $this->db->where('id', $id);
        $respond = $this->db->update('sales_order');
        return $respond;
    }

    public function cancelOrder($id){
        $this->db->set('status', 6);
        $this->db->where('id', $id);
        $respond = $this->db->update('sales_order');
        return $respond;
    }

    public function updateIsChanged($id){
        $this->db->set('is_changed', 0);
        $this->db->where('id', $id);
        $respond = $this->db->update('sales_order');
        return $respond;
    }

    public function returnStock($data){
        $product_list = $data['product_list'];
        $qty = $data['qty'];
        $return_no = $data['return_no'];
        $all_data = json_encode($data);
        $products = json_encode($product_list);
        $quantities = json_encode($qty);
        $date = $data['created_at'];
        try {

        foreach ($product_list as $index => $product){
            $quantity = $qty[$index];
            $product_query = "UPDATE `geopos_products` SET qty = qty + ".$quantity." WHERE `product_code` = ". $product ." ";
            $this->db->query($product_query);
        }
            $sql_query = 'INSERT INTO `api_return_stock` (`id`, `return_no_external`, `return_data`, `return_items`, `return_qty`, `created_at`) 
                        VALUES (?, ?, ?, ?, ?, ?)';
            return $this->db->query($sql_query, array(NULL, $return_no, $all_data, $products, $quantities, $date));
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }


}